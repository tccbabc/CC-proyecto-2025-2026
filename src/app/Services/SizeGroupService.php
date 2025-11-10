<?php

namespace App\Services;

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

}
