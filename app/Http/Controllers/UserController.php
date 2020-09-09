<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInviteRequest;
use App\Http\Requests\UserRequest;
use App\Mail\UserInviteMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Repositories\User\UserRepositoryInterface as UserRepository;
use App\Repositories\UserInvite\UserInviteRepositoryInterface as UserInviteRepository;
use App\Repositories\Company\CompanyRepositoryInterface as CompanyRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var userInviteRepository
     */
    private $userInviteRepository;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * ユーザーコントローラーのインスタンスを作成
     *
     * @param  UserRepository $userRepository
     * @param  userInviteRepository $userInviteRepository
     * @param  CompanyRepository $companyRepository
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        userInviteRepository $userInviteRepository,
        CompanyRepository $companyRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userInviteRepository = $userInviteRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * 一覧
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->getList($request->all());

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
        $user = $this->userRepository->getOne($id);

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
        $this->userRepository->store($request->all());
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
        $data = $request->all();
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $this->userRepository->update($id, $data);
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
        $this->userRepository->destroy($id);
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
        $company = $this->companyRepository->getOne($request->get('company_id'));
        $email = $request->get('email');
        $token = str_random(30);

        // 招待テーブル更新
        $this->userInviteRepository->store([
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
