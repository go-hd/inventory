<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\UserInviteRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserRequest;
use App\Mail\UserInviteMail;
use App\User;
use App\UserInvite;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * ユーザーのインスタンス
     *
     * @var \App\User
     */
    private $user;
    /**
     * ユーザー招待のインスタンス
     *
     * @var \App\UserInvite
     */
    private $userInvite;
    /**
     * 会社のインスタンス
     *
     * @var \App\Company
     */
    private $company;

    /**
     * ユーザーコントローラーのインスタンスを作成
     *
     * @param  \App\User $user
     * @param  \App\UserInvite $userInvite
     * @param  \App\Company $company
     * @return void
     */
    public function __construct(User $user, UserInvite $userInvite, Company $company) {
        $this->user = $user;
        $this->userInvite = $userInvite;
        $this->company = $company;
    }

    /**
     * 一覧
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $company_id = $request->get('company_id', null);
        if (!is_null($company_id)) {
            $users = $this->user->whereHas('location', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            })->get();
        } else {
            $users = $this->user->all();
        }

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
        $data = $request->all();
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $user->update($data);
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

    /**
     * フロントからのバリデーション用
     *
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function validation(UserRequest $request) {
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * ユーザーの招待をする
     *
     * @param UserInviteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function invite(UserInviteRequest $request) {
        $company = $this->company->findOrFail($request->get('company_id'));
        $email = $request->get('email');
        $token = str_random(30);

        // 招待テーブル更新
        $this->userInvite->create([
            'company_id' => $company->id,
            'email' => $email,
            'token' => $token,
        ]);
        // 招待メールを送る
        Mail::to($email)
            ->send(new UserInviteMail($email, $token, $company));

        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
