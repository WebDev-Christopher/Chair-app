<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChairUpdateRequest extends FormRequest
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
            'id' => 'required',
            'user_id' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'body' => 'required',
            'image' => 'required',
            'new_image' => 'max:2048',
            'new_image.*' => 'mimes:jpg,png,jpeg,gif,svg'
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
            'id.required' => 'Chair must be selected',
            'user_id.required' => 'User must be logged in!',
            'name.required' => 'Chair name is required',
            'amount.required' => 'Chair price is required',
            'body.required' => 'Chair body text is required',
            'image.required' => 'Chair image is required',
        ];
    }
}
