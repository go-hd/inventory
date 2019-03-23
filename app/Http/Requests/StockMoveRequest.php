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
}
