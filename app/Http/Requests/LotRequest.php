<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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
                'alpha_num',
                'size:12',
                Rule::unique('lots')->ignore($this->input('id', null)),
            ],
            'name' => 'required',
            'jan_code' => [
                'required',
                'digits:13',
                Rule::unique('lots')->ignore($this->input('id', null))
                    ->where(function(Builder $query) {
                        $query->where('ordered_at', $this->input('ordered_at'));
                    }),
            ],
            'expiration_date' => 'date',
            'ordered_at' => [
                'required',
                'date',
                Rule::unique('lots')->ignore($this->input('id', null))
                    ->where(function(Builder $query) {
                        $query->where('jan_code', $this->input('jan_code'));
                    }),
            ],
        ];
    }

    /**
     * バリデーション失敗時
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return void
     * @throw HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json($validator->errors()->toArray(), 422)
        );
    }
}
