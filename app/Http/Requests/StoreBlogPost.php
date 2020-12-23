<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
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
            'title' => 'required|max:255',
            'description' => 'required',
            'tags' => 'required',
            'posted_by' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'description.required' => 'A description is required',
            'posted_by.required' => 'A posted_by is required',
        ];
    }


}
