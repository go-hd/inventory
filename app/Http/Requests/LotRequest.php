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
            'location_id' => 'required',
            'brand_id' => 'required',
            'name' => 'required',
            'lot_number' => 'required',
            'jan_code' => 'required'
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
            'brand_id' => 'ブランド',
            'name' => '名称',
            'lot_number' => 'ロットナンバー',
            'jan_code' => 'JANコード'
        ];
    }
}
