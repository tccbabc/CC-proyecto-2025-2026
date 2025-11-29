<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $primaryKey = 'colorCode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'colorCode',
        'colorName',
        'colorGroup',
        'colorStatus',
    ];

    public static function addColor(array $data): self
    {
        return self::create($data);
    }

    public function editColor(array $data): bool
    {
        return $this->update($data);
    }

    public function delColor(): ?bool
    {
        return $this->delete();
    }

    public function setStatus(bool $status): bool
    {
        $this->colorStatus = $status;
        return $this->save();
    }
}

