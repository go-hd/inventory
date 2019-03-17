<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'lot_number' => [
                'required',
                'regex:/^[a-z\d]{12}$/',
                Rule::unique('lots')->ignore($this->input('id', null)),
            ],
            'name' => 'required',
            'jan_code' => [
                'required',
                'regex:/^[+-]?\d+{13}$/',
                Rule::unique('lots')->ignore($this->input('id', null))->where(function($query) {
                    $query->where('ordered_at', $this->input('ordered_at'));
                }),
            ],
            'expiration_date' => 'date',
            'ordered_at' => [
                'required',
                'date',
                Rule::unique('lots')->ignore($this->input('id', null))->where(function($query) {
                    $query->where('jan_code', $this->input('jan_code'));
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
            'date'=>':attributeには日付を入力してください。',
            'regex'=>':attributeの形式として正しくありません。',
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
            'lot_number' => 'ロットナンバー',
            'name' => '名称',
            'jan_code' => 'JANコード',
            'expiration_date' => '賞味期限',
            'ordered_at' => '発注日',
        ];
    }
}
