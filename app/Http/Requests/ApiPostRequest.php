<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;
use Throwable;

class ApiPostRequest extends FormRequest
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
            //
        ];
    }

    public function failedValidation(Validator $validator)
    {

        $route_name = Route::currentRouteName();
        $message = $validator->getMessageBag()->toArray();
        $rule = $validator->failed();
        $errors = [];
        foreach ($message as $error_name => $error_message) {
            $attribute = array_keys($rule[$error_name]);
            $errors = [
                'code' => $route_name . '-' . $error_name . '-' . $attribute[0],
                'message' => $error_message
            ];
        }
        $response = [
            "status" => "Validation Failed",
            "errors" => $errors
        ];
        throw new HttpResponseException(response()->json($response, 422));
    }

}
