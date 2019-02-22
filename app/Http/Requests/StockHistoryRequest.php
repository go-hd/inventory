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
            'stockHistory.location_id' => 'required',
            'stockHistory.lot_id' => 'required',
            'stockHistory.stock_history_type_id' => 'required',
            'stockHistory.quantity' => 'required'
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
            'stockHistory.location_id' => '拠点',
            'stockHistory.lot_id' => 'ロット',
            'stockHistory.stock_history_type_id' => '在庫履歴種別',
            'stockHistory.quantity' => '数量'
        ];
    }
}
