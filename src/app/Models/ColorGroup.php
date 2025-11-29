<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorGroup extends Model
{
    use HasFactory;

    protected $primaryKey = 'colorGroupCode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'colorGroupCode',
        'colorGroupName',
        'colorGroupStatus',
    ];

    public static function addColorGroup(array $data): self
    {
        return self::create($data);
    }

    public function editColorGroup(array $data): bool
    {
        return $this->update($data);
    }

    public function delColorGroup(): ?bool
    {
        return $this->delete();
    }

    public function setStatus(bool $status): bool
    {
        $this->colorGroupStatus = $status;
        return $this->save();
    }

    // la relación entre colorGroup y color es 1 : n
    public function colors()
    {
        return $this->hasMany(ColorRelation::class, 'colorGroupCode', 'colorGroupCode');
    }
}

