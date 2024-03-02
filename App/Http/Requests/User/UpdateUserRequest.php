<?php

namespace Modules\User\App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            "name" => ["required","string","max:255",Rule::unique("users","name")->ignore($this->user->id)],
            "email" => ["required","email","max:255",Rule::unique("users","email")->ignore($this->user->id)],
            "password" => ["nullable","string","max:255","min:8"],
            "roles" => ["required","array"],
            "roles.*" => ["required","string",Rule::exists("roles","name")],
        ];
    }
}
