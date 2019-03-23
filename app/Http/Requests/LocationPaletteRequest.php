<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocationPaletteRequest extends FormRequest
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
            'location_id' => [
                'required',
                Rule::unique('location_palette')->ignore($this->input('id', null))->where(function($query) {
                    $query->where('palette_id', $this->input('palette_id'));
                }),
            ],
            'palette_id' => [
                'required',
                Rule::unique('location_palette')->ignore($this->input('id', null))->where(function($query) {
                    $query->where('location_id', $this->input('location_id'));
                }),
            ],
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
            'unique'=>'この:attributeはすでに存在しています。',
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
            'palette_id' => 'パレット',
        ];
    }
}
