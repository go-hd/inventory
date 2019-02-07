<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryHistoryRequest extends FormRequest
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
            'deliveryHistory.product_stock_id' => 'required',
            'deliveryHistory.location_id' => 'required',
            'deliveryHistory.quantity' => 'required|numeric',
            'deliveryHistory.delivery_at' => 'required|date'
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
            'deliveryHistory.product_stock_id'=>'商品在庫',
            'deliveryHistory.location_id'=>'拠点',
            'deliveryHistory.quantity'=>'数量',
            'deliveryHistory.delivery_at'=>'納品日'
        ];
    }
}
