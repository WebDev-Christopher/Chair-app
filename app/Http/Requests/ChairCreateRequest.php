<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChairCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'body' => 'required',
            'image' => 'required|image|max:2048',
            'image.*' => 'mimes:jpg,png,jpeg,gif,svg'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'User must be logged in!',
            'name.required' => 'Chair name is required',
            'amount.required' => 'Chair price is required',
            'body.required' => 'Chair body text is required',
            'image.required' => 'Chair image is required',
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'name' => 'capitalize'
        ];
    }
}
