<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function PHPUnit\Framework\isEmpty;

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
        $roleId = $this->route()->parameters('role');
        if (!$roleId) {
            $roleId['role'] = '';
        }
        return [
            'role' => 'required|unique:roles,name,' . $roleId['role'] . 'id|min:3|max:20',
            'permissions' => 'required|exists:permissions,id'
        ];
    }
}
