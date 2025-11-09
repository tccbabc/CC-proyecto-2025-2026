<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'sizeGroupCode',
        'sizeCode',
    ];

    public function group()
    {
        return $this->belongsTo(SizeGroup::class, 'sizeGroupCode', 'sizeGroupCode');
    }


    public function size()
    {
        return $this->belongsTo(Size::class, 'sizeCode', 'sizeCode');
    }
}
