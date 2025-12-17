<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'class_id' => ['required', 'exists:classes,id'], // [exists:テーブル名,カラム名]はtableに存在するclumnの値があるかどうかをチェックしている
            'section_id' => ['required', 'exists:sections,id'], // [exists:テーブル名,カラム名]はtableに存在するclumnの値があるかどうかをチェックしている
        ];
    }

    public function attributes()
    {
        return [
            'name' => '生徒名',
            'email' => 'メールアドレス',
            'class_id' => 'クラス',
            'section_id' => 'セクション'
        ];
    }

    public function messages()
    {
        return [
            // 生徒のエラー文
            'name.required' => ':attributeが入力されていません。',
            'name.string' => ':ttributeは文字以外を入力しないでください。',
            'name.max' => ':attributeは255文字以内で入力してください。',

            // メールアドレスのエラー文
            'email.required' => ':attributeが入力されていません。',
            'email.email' => ':ttributeはメールアドレスの形式で入力してください。',
            'email.max' => ':attributeは255文字以内で入力してください。',

            // クラスのエラー文
            'class_id.required' => ':attributeが選択されていません。',
            'class_id.exists' => '選択した:attributeは存在しません。',

            // セクションのエラー文
            'section_id.required' => ':attributeが選択されていません。',
            'section_id.exists' => '選択した:attributeは存在しません。',
        ];
    }
}
