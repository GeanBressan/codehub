<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::user()->id,
            'bio' => 'nullable|string|max:500',
            'cover_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'name.min' => 'O campo nome deve ter pelo menos 3 caracteres.',
            'username.required' => 'O campo nome de usuário é obrigatório.',
            'username.unique' => 'Este nome de usuário já está em uso.',
            'bio.max' => 'A biografia não pode ter mais de 500 caracteres.',
            'cover_path.image' => 'O arquivo deve ser uma imagem.',
            'cover_path.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif.',
            'cover_path.max' => 'A imagem não pode ter mais de 2MB.',
        ];
    }
}
