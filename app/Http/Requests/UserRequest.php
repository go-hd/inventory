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
            'email' => 'required|email|unique:users,email',
        ];
        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules['email'] = ['required', 'email', Rule::unique('users','email')->ignore($this->id)];
        } else {
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
            'location_id'=>'拠点',
            'name'=>'ユーザー名',
            'email'=>'メールアドレス',
            'password'=>'パスワード'
        ];
    }
}
