<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'colorGroupCode',
        'colorCode',
    ];

    public function group()
    {
        return $this->belongsTo(ColorGroup::class, 'colorGroupCode', 'colorGroupCode');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'colorCode', 'colorCode');
    }
}

