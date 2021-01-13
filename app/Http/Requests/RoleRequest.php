<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $id = $this->route()->parameters('role');
        return [
            'role' => 'required|unique:roles,name,' . $id['role']. 'id|min:3|max:20',
            'permissions' => 'required|exists:permissions,id'
        ];
    }
}
