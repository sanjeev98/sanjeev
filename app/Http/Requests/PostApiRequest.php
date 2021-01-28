<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiPostRequest;

class PostApiRequest extends ApiPostRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:posts|min:3|max:255',
            'description' => 'required|min:10|max:255',
            'tags' => 'unique:posts|min:10|max:255',
            'files' => 'mimes:jpeg,jpg,png'
        ];
    }
}
