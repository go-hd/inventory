<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserInviteRequest extends FormRequest
{
    /**
     * ユーザーがこのリクエストの権限を持っているかを判断する
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * リクエストに適用するバリデーションルールを取得
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => [
                'required',
                'email',
                Rule::unique('users'),
            ],
        ];
        return $rules;
    }

	/**
	 * バリデーション失敗時
	 *
	 * @param \Illuminate\Contracts\Validation\Validator $validator
	 *
	 * @return void
	 * @throw HttpResponseException
	 */
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(
			response()->json($validator->errors()->toArray(), 422)
		);
	}
}
