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
            'shipping_id' => 'required',
            'recieving_id' => 'required',
            'location_id' => 'required',
            'quantity' => [
                'required',
                'integer',
            ]
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
            'integer'=>':attributeには整数を入力してください。',
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
            'shipping_id' => '出庫在庫履歴',
            'recieving_id' => '入庫在庫履歴',
            'location_id' => '相手拠点',
            'quantity' => '移動個数'
        ];
    }
}
