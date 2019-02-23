<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;

class UserController extends Controller
{
    /**
     * @var \App\Models\User
     */
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * 一覧
     * @return ResponseFactory
     */
    public function index()
    {
        $users = $this->user->all();
        return response()->json($users, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * @param  int $id
     * @return ResponseFactory
     */
    public function show($id)
    {
        $user = $this->user->findOrFail($id);
        return response()->json($user, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * @param  UserRequest $request
     * @return ResponseFactory
     */
    public function store(UserRequest $request)
    {
        $this->user->create($request->get('user'));
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * @param  int $id
     * @param  UserRequest $request
     * @return ResponseFactory
     */
    public function update($id, UserRequest $request)
    {
        $user = $this->user->findOrFail($id);
        $user->update($request->get('user'));
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * @param  int $id
     * @param  UserRequest $request
     * @return ResponseFactory
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = $this->user->findOrFail($id);
        $user->delete();
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
