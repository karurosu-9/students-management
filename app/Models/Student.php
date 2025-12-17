<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;
use App\Models\Section;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['class_id', 'section_id', 'name', 'email'];

    // 生徒検索用スコープ
    public function scopeSearchCustomers($query, $input = null)
    {
        if(!empty($input)) {
            $query->where(function ($q) use ($input) { // where()をグルーピングしてwhere()の将来的な拡張対策
                $q->where('name','like', $input . '%')
                    ->orWhere('email', 'like', '%' . $input . '%');
            });
        };

        return $query;
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
