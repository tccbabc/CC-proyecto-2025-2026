<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDesignRequirement extends Model
{
    use HasFactory;

    protected $table = 'material_design_requirements';

    protected $fillable = [
        'colorCode',
        'colorGroupCode',
        'sizeCode',
        'sizeGroupCode',
        'status',
        'providerCode',
        'providerName',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
