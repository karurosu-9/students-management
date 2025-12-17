<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            // whenLoaded()はリレーション関係がロードされていた場合に出力する
            // コントローラー側で、Student::with('class', 'section')とされた時だけ紐づくデータを取得する
            // コントローラーで明示的にwith()を使用している場合やモデルクラスでprotected $with = []されている場合は出力するということ
            'class' => ClassesResource::make($this->whenLoaded('class')), // 最低限のJSON化
            'section' => SectionResource::make($this->whenLoaded('section')), // 最低限のJSON化
            'created_at' => $this->created_at->toFormattedDateString()
        ];
    }
}
