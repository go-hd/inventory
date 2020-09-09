<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserVerificationRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Repositories\UserVerification\UserVerificationRepositoryInterface as UserVerificationRepository;

class UserVerificationController extends Controller
{
    /**
     * ユーザー認証情報のインスタンス
     *
     * @var UserVerificationRepository
     */
    private $userVerificationRepository;

    /**
     * ユーザーコントローラーのインスタンスを作成
     *
     * @param  UserVerificationRepository $userVerificationRepository
     * @return void
     */
    public function __construct(UserVerificationRepository $userVerificationRepository) {
        $this->userVerificationRepository = $userVerificationRepository;
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\UserVerificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserVerificationRequest $request)
    {
        $this->userVerificationRepository->store($request->all());
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function verify(Request $request) {

        // 対象のユーザーを取得
        $userVerification = $this->userVerificationRepository->getByToken($request->get('token'), $request->get('email'));

        // 対象のユーザーがいない場合
        if (!$userVerification) {
            throw new HttpResponseException(
                response()->json([], 422)
            );
        }

        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
