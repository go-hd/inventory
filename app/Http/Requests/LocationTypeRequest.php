<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class LocationTypeRequest extends FormRequest
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
            'company_id' => [
                'required',
				Rule::unique('location_types')->ignore($this->route('location_type'))
					->where(function(Builder $query) {
						$query->where('name', $this->input('name'));
					}),
            ],
            'name' => [
                'required',
				Rule::unique('location_types')->ignore($this->route('location_type'))
					->where(function(Builder $query) {
						$query->where('company_id', $this->input('company_id'));
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
