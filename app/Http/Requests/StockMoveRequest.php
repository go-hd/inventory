<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockMoveRequest extends FormRequest
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
            'stockMove.shipping_id' => 'required',
            'stockMove.recieving_id' => 'required',
            'stockMove.location_id' => 'required',
            'stockMove.quantity' => 'required'
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
            'stockMove.shipping_id' => '出庫拠点',
            'stockMove.recieving_id' => '入庫拠点',
            'stockMove.location_id' => '相手拠点',
            'stockMove.quantity' => '移動個数'
        ];
    }
}
