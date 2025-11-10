<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeGroup extends Model
{
    use HasFactory;

    protected $primaryKey = 'sizeGroupCode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sizeGroupCode',
        'sizeGroupName',
        'sizeGroupStatus',
    ];

    public static function addSizeGroup(array $data): self
    {
        return self::create($data);
    }

    public function editSizeGroup(array $data): bool
    {
        return $this->update($data);
    }


    public function delSizeGroup(): ?bool
    {
        return $this->delete();
    }


    public function setStatus(bool $status): bool
    {
        $this->sizeGroupStatus = $status;
        return $this->save();
    }


    // la relacion entre sizeGroup y size es 1 : n
    public function sizes()
    {
        return $this->hasMany(SizeRelation::class, 'sizeGroupCode', 'sizeGroupCode');
    }
}
