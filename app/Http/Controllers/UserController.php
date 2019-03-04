<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;

class UserController extends Controller
{
    /**
     * ユーザーのインスタンス
     *
     * @var \App\User
     */
    private $user;

    /**
     * ユーザーコントローラーのインスタンスを作成
     *
     * @param  \App\User $user
     * @return void
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->user->all();

        return response()->json($users, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = $this->user->findOrFail($id);

        return response()->json($user, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $this->user->create($request->all());
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UserRequest $request)
    {
        $user = $this->user->findOrFail($id);
        $user->update($request->all());
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
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
