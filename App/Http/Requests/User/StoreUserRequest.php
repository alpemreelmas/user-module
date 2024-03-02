<?php

namespace Modules\User\App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can("user_create");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
           "name" => ["required","string",Rule::unique("users","name")],
           "email" => ["required","email",Rule::unique("users","email")],
           "password" => ["required","string","min:8"],
           "roles" => ["required","array"],
           "roles.*" => ["required","string",Rule::exists("roles","name")],
        ];
    }
}
