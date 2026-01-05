<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PermissionResource;

class RoleResource extends JsonResource
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
            'title' => $this->title,
            // whenLoaded()は『$role->permissions』のように、リレーション関係がロードされていた場合に出力する
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
        ];
    }
}
