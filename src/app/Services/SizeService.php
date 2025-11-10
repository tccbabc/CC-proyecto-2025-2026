<?php

namespace App\Services;

use App\Models\Size;
use App\Models\SizeGroup;
use App\Models\SizeRelation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Exception;
class SizeService
{

    public function listSize(): array
    {

        return Size::all()->toArray();
    }
    public function addSize(array $data): Size
    {


        if (Size::where('sizeCode', $data['sizeCode'])->exists()) {
            throw new Exception("Existe el mismo sizeCode");
        }

        if (!SizeGroup::where('sizeGroupCode', $data['sizeGroup'])->exists()) {
            throw new Exception("El sizeGroupCode no existe");
        }

        $size = Size::create($data);

        SizeRelation::create([
            'sizeGroupCode' => $data['sizeGroup'],
            'sizeCode' => $data['sizeCode'],
        ]);

        return $size;
    }

    public function editSize(string $sizeCode, array $data): Size
    {

        $size = Size::find($sizeCode);

        if (!$size) {
            throw new Exception("Este sizeCode no existe");
        }

        if (isset($data['sizeGroup']) &&
            !SizeGroup::where('sizeGroupCode', $data['sizeGroup'])->exists()) {
            throw new Exception("El sizeGroupCode no existe");
        }

        $size->update($data);

        if (isset($data['sizeGroup'])) {

            SizeRelation::where('sizeCode', $sizeCode)->delete();

            SizeRelation::create([
                'sizeGroupCode' => $data['sizeGroup'],
                'sizeCode' => $sizeCode,
            ]);
        }

        return $size;
    }

    public function delSize(string $sizeCode): void
    {
        $size = Size::find($sizeCode);

        if (!$size) {
            throw new Exception("Este sizeCode no existe");
        }

        SizeRelation::where('sizeCode', $sizeCode)->delete();

        $size->delete();
    }

}
