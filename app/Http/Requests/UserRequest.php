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
            'user.location_id' => 'required',
            'user.name' => 'required',
            'user.email' => 'required|email|unique:users,email,,,deleted_at,NULL',
            'user.password' => 'required'
        ];
        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules['user.email'] = ['required', 'email', Rule::unique('users','email')->whereNull('deleted_at')->ignore($this->id)];
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
            'required'=>':attributeは必須項目です。',
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
            'user.location_id'=>'拠点',
            'user.name'=>'ユーザー名',
            'user.email'=>'メールアドレス',
            'user.password'=>'パスワード'
        ];
    }
}
