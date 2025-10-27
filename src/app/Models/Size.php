<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = [
        'sizeCode',
        'sizeName',
        'sizeGroup',
        'sizeStatus',
    ];

    public static function addSize(array $data): self
    {
        return self::create($data);
    }

    public function editSize(array $data): bool
    {
        return $this->update($data);
    }

    public function delSize(): ?bool
    {
        return $this->delete();
    }

    public function setStatus(bool $status): bool
    {
        $this->sizeStatus = $status;
        return $this->save();
    }
}
