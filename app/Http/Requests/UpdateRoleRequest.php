<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255']
        ];
    }

    public function attributes()
    {
        return [
            'title' => '権限名'
        ];
    }

    public function messages()
    {
        return [
            // 権限のエラー文
            'title.required' => ':attributeが入力されていません。',
            'title.string' => ':ttributeは文字以外を入力しないでください。',
            'title.max' => ':attributeは255文字以内で入力してください。'
        ];
    }
}
