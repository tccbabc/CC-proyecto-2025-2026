<?php

namespace App\Services;

use App\Models\Size;
use App\Models\SizeGroup;
use App\Models\SizeRelation;
use Exception;


class SizeGroupService
{

    public function listSizeGroup(): array
    {
        return SizeGroup::all()->toArray();
    }
    public function addSizeGroup(array $data): SizeGroup
    {
        if (SizeGroup::where('sizeGroupCode', $data['sizeGroupCode'])->exists()) {
            throw new Exception("Existe el mismo sizeGroupCode");
        }

        return SizeGroup::create($data);
    }

    public function editSizeGroup(string $sizeGroupCode, array $data): SizeGroup
    {
        $group = SizeGroup::find($sizeGroupCode);

        if (!$group) {
            throw new Exception("Este sizeGroupCode no existe");
        }
        $group->update($data);
        return $group;
    }

    public function delSizeGroup(string $sizeGroupCode): void
    {
        $group = SizeGroup::find($sizeGroupCode);

        if (!$group) {
            throw new Exception("Este sizeGroupCode no existe");
        }

        SizeRelation::where('sizeGroupCode', $sizeGroupCode)->delete();

        $group->delete();
    }

    public function appendSize(string $sizeGroupCode, string $sizeCode): void
    {
        $group = SizeGroup::find($sizeGroupCode);
        if (!$group) {
            throw new Exception("El sizeGroupCode no existe");
        }

        $size = Size::find($sizeCode);
        if (!$size) {
            throw new Exception("El sizeCode no existe");
        }

        if ($size->sizeStatus != 1 && $size->sizeStatus != true) {
            throw new Exception("El sizeCode no está activo (status != 1)");
        }

        $exists = SizeRelation::where('sizeGroupCode', $sizeGroupCode)
            ->where('sizeCode', $sizeCode)
            ->exists();

        if ($exists) {
            throw new Exception("Ya existe la relación entre este size y el grupo");
        }

        SizeRelation::create([
            'sizeGroupCode' => $sizeGroupCode,
            'sizeCode' => $sizeCode,
        ]);
    }

    public function removeSize(string $sizeGroupCode, string $sizeCode): void
    {
        if (!SizeGroup::where('sizeGroupCode', $sizeGroupCode)->exists()) {
            throw new Exception("El sizeGroupCode no existe");
        }

        if (!Size::where('sizeCode', $sizeCode)->exists()) {
            throw new Exception("El sizeCode no existe");
        }

        $relation = SizeRelation::where('sizeGroupCode', $sizeGroupCode)
            ->where('sizeCode', $sizeCode)
            ->first();

        if (!$relation) {
            throw new Exception("No existe relación entre este size y el grupo");
        }

        $relation->delete();
    }

}
