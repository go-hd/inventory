<?php

namespace App\Http\Controllers;

use App\UserVerification;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    /**
     * ユーザー認証情報のインスタンス
     *
     * @var \App\User
     */
    private $userVerification;

    /**
     * ユーザーコントローラーのインスタンスを作成
     *
     * @param  \App\UserVerification $userVerification
     * @return void
     */
    public function __construct(UserVerification $userVerification) {
        $this->userVerification = $userVerification;
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\UserVerificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserVerification $request)
    {
        $this->userVerification->create($request->all());
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function verify(Request $request) {

        $email = $request->get('email');
        // 対象のユーザーを取得
        $userVerification = $this->userVerification->query()
            ->where('token', $request->get('token'))
            ->whereNull('is_verified')
            ->where('email', $email)->first();

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
