<?php

namespace Modules\User\App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can("user_update");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required","string","max:255",Rule::unique("roles","name")->ignore($this->role->id)],
            "permissions" => ["required","array"],
            "permissions.*" => ["required",Rule::exists("permissions","name")],
        ];
    }
}
