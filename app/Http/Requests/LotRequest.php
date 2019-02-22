<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LotRequest extends FormRequest
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
            'lot.location_id' => 'required',
            'lot.brand_id' => 'required',
            'lot.name' => 'required',
            'lot.lot_number' => 'required',
            'lot.jan_code' => 'required'
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
            'lot.location_id' => '拠点',
            'lot.brand_id' => 'ブランド',
            'lot.name' => '名称',
            'lot.lot_number' => 'ロットナンバー',
            'lot.jan_code' => 'JANコード'
        ];
    }
}
