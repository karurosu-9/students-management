<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ListSectionsRequest extends FormRequest
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
            'class_id' => ['required', 'exists:classes,id'] // [exists:classes,id]はclassesに存在するidかをチェックしている
        ];
    }

    public function attributes()
    {
        return [
            'class_id' => 'クラス',
        ];
    }

    public function messages()
    {
        return [
            // クラスのエラー文
            'class_id.required' => ':attributeが選択されていません。',
            'class_id.exists' => '存在しない:attributeが選択されています',
        ];
    }
}
