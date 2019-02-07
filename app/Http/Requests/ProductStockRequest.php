<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStockRequest extends FormRequest
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
            'productStock.product_id' => 'required',
            'productStock.location_id' => 'required',
            'productStock.expiration_date' => 'required|date',
            'productStock.quantity' => 'numeric'
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
            'productStock.product_id'=>'商品',
            'productStock.location_id'=>'拠点',
            'productStock.expiration_date'=>'賞味期限',
            'productStock.quantity'=>'数量'
        ];
    }
}
