<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderHistoryRequest extends FormRequest
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
            'orderHistory.product_stock_id' => 'required',
            'orderHistory.location_id' => 'required',
            'orderHistory.quantity' => 'required|numeric',
            'orderHistory.order_at' => 'required|date'
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
            'required'=>':attributeは必須項目です。',
            'numeric' => ':attributeは数値で入力してください。',
            'date' => ':attributeは日付で入力してください。'
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
            'orderHistory.product_stock_id'=>'商品在庫',
            'orderHistory.location_id'=>'拠点',
            'orderHistory.quantity'=>'数量',
            'orderHistory.order_at'=>'発注日'
        ];
    }
}
