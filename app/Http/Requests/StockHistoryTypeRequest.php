<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockHistoryTypeRequest extends FormRequest
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
        return [
            'company_id' => [
                'required',
                Rule::unique('stock_history_types')->ignore($this->input('id', null))->where(function($query) {
                    $query->where('name', $this->input('name'));
                }),
            ],
            'name' => [
                'required',
                Rule::unique('stock_history_types')->ignore($this->input('id', null))->where(function($query) {
                    $query->where('company_id', $this->input('company_id'));
                }),
            ],
        ];
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
            'company_id' => '会社',
            'name' => '名称',
        ];
    }
}
