<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockHistoryRequest extends FormRequest
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
            'location_id' => 'required',
            'lot_id' => 'required',
            'stock_history_type_id' => 'required',
            'quantity' => 'required'
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
            'required'=>':attributeは必須項目です。'
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
            'location_id' => '拠点',
            'lot_id' => 'ロット',
            'stock_history_type_id' => '在庫履歴種別',
            'quantity' => '数量'
        ];
    }
}
