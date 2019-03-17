<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'location_id' => 'required',
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->input('id', null)),
            ],
        ];
        if ($this->method() !== 'PUT' && $this->method() !== 'PATCH') {
            $rules['password'] = 'required';
        }
        return $rules;
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required'=>':attributeを入力してください。',
            'unique'=>'この:attributeはすでに存在しています。',
            'email'=>':attributeの形式として正しくありません。',
        ];
    }

    /**
     * カスタムアトリビュート名
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'location_id'=>'拠点',
            'name'=>'名称',
            'email'=>'メールアドレス',
            'password'=>'パスワード',
        ];
    }
}
