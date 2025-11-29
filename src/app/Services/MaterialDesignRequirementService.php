<?php

namespace App\Services;

use App\Models\MaterialDesignRequirement;
use App\Models\Color;
use App\Models\ColorGroup;
use App\Models\ColorRelation;
use App\Models\Size;
use App\Models\SizeGroup;
use App\Models\SizeRelation;
use Exception;

class MaterialDesignRequirementService
{
    public function listMaterialDesignRequirement(): array
    {
        return MaterialDesignRequirement::all()->toArray();
    }

    public function addMaterialDesignRequirement(array $data): MaterialDesignRequirement
    {
        // Validar existencia de colorCode
        if (!Color::where('colorCode', $data['colorCode'])->exists()) {
            throw new Exception("El colorCode no existe");
        }

        // Validar existencia de colorGroupCode
        if (!ColorGroup::where('colorGroupCode', $data['colorGroupCode'])->exists()) {
            throw new Exception("El colorGroupCode no existe");
        }

        // Validar relación colorCode - colorGroupCode
        $colorMatch = ColorRelation::where('colorCode', $data['colorCode'])
            ->where('colorGroupCode', $data['colorGroupCode'])
            ->exists();

        if (!$colorMatch) {
            throw new Exception("El colorCode no pertenece al colorGroupCode");
        }

        // Validar existencia de sizeCode
        if (!Size::where('sizeCode', $data['sizeCode'])->exists()) {
            throw new Exception("El sizeCode no existe");
        }

        // Validar existencia de sizeGroupCode
        if (!SizeGroup::where('sizeGroupCode', $data['sizeGroupCode'])->exists()) {
            throw new Exception("El sizeGroupCode no existe");
        }

        // Validar relación sizeCode - sizeGroupCode
        $sizeMatch = SizeRelation::where('sizeCode', $data['sizeCode'])
            ->where('sizeGroupCode', $data['sizeGroupCode'])
            ->exists();

        if (!$sizeMatch) {
            throw new Exception("El sizeCode no pertenece al sizeGroupCode");
        }

        return MaterialDesignRequirement::create($data);
    }

    public function editMaterialDesignRequirement(int $id, array $data): MaterialDesignRequirement
    {
        $item = MaterialDesignRequirement::find($id);

        if (!$item) {
            throw new Exception("Este ID no existe");
        }

        // --- Validaciones opcionales (solo si los campos vienen en $data) ---

        if (isset($data['colorCode'])) {
            if (!Color::where('colorCode', $data['colorCode'])->exists()) {
                throw new Exception("El colorCode no existe");
            }
        }

        if (isset($data['colorGroupCode'])) {
            if (!ColorGroup::where('colorGroupCode', $data['colorGroupCode'])->exists()) {
                throw new Exception("El colorGroupCode no existe");
            }
        }

        // Validación de relación colorCode-colorGroupCode
        if (isset($data['colorCode']) || isset($data['colorGroupCode'])) {

            $colorCode = $data['colorCode'] ?? $item->colorCode;
            $colorGroupCode = $data['colorGroupCode'] ?? $item->colorGroupCode;

            $colorMatch = ColorRelation::where('colorCode', $colorCode)
                ->where('colorGroupCode', $colorGroupCode)
                ->exists();

            if (!$colorMatch) {
                throw new Exception("El colorCode no pertenece al colorGroupCode");
            }
        }

        // Validación sizeCode
        if (isset($data['sizeCode'])) {
            if (!Size::where('sizeCode', $data['sizeCode'])->exists()) {
                throw new Exception("El sizeCode no existe");
            }
        }

        if (isset($data['sizeGroupCode'])) {
            if (!SizeGroup::where('sizeGroupCode', $data['sizeGroupCode'])->exists()) {
                throw new Exception("El sizeGroupCode no existe");
            }
        }

        // Validación de relación sizeCode-sizeGroupCode
        if (isset($data['sizeCode']) || isset($data['sizeGroupCode'])) {

            $sizeCode = $data['sizeCode'] ?? $item->sizeCode;
            $sizeGroupCode = $data['sizeGroupCode'] ?? $item->sizeGroupCode;

            $sizeMatch = SizeRelation::where('sizeCode', $sizeCode)
                ->where('sizeGroupCode', $sizeGroupCode)
                ->exists();

            if (!$sizeMatch) {
                throw new Exception("El sizeCode no pertenece al sizeGroupCode");
            }
        }

        $item->update($data);
        return $item;
    }

    public function delMaterialDesignRequirement(int $id): void
    {
        $item = MaterialDesignRequirement::find($id);

        if (!$item) {
            throw new Exception("Este ID no existe");
        }

        $item->delete();
    }
}

