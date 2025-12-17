<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListSectionsRequest;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(ListSectionsRequest $request)
    {
        // 生徒の登録画面でClassが選択され、選択されたClassに紐づくSectionだけをプルダウンに表示させるためのApi
        $sections = Section::where('class_id', $request->class_id)->get();

        return SectionResource::collection($sections);
    }
}
