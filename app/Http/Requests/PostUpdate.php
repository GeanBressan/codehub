<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdate extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'cover_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|in:draft,published,archived',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'description.max' => 'A descrição não pode ter mais de 255 caracteres.',
            'content.required' => 'O conteúdo é obrigatório.',
            'category_id.required' => 'A categoria é obrigatória.',
            'tags.array' => 'As tags devem ser um array.',
            'cover_path.image' => 'A imagem deve ser uma imagem válida.',
            'cover_path.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif.',
            'cover_path.max' => 'A imagem não pode ter mais de 2MB.',
            'status.in' => 'O status deve ser "Rascunho", "Arquivado" ou "Publicado".',
        ];
    }
}
