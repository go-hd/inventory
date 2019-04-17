<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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
				Rule::unique('location_palette')->ignore($this->route('location_palette'))
					->where(function(Builder $query) {
						$query->where('palette_id', $this->input('palette_id'));
					}),
            ],
            'palette_id' => [
                'required',
				Rule::unique('location_palette')->ignore($this->route('location_palette'))
					->where(function(Builder $query) {
						$query->where('location_id', $this->input('location_id'));
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
