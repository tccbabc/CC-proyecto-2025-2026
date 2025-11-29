<?php

namespace App\Services;

use App\Models\Color;
use App\Models\ColorGroup;
use App\Models\ColorRelation;
use Exception;

class ColorGroupService
{
    public function listColorGroup(): array
    {
        return ColorGroup::all()->toArray();
    }

    public function addColorGroup(array $data): ColorGroup
    {
        if (ColorGroup::where('colorGroupCode', $data['colorGroupCode'])->exists()) {
            throw new Exception("Existe el mismo colorGroupCode");
        }

        return ColorGroup::create($data);
    }

    public function editColorGroup(string $colorGroupCode, array $data): ColorGroup
    {
        $group = ColorGroup::find($colorGroupCode);

        if (!$group) {
            throw new Exception("Este colorGroupCode no existe");
        }

        $group->update($data);
        return $group;
    }

    public function delColorGroup(string $colorGroupCode): void
    {
        $group = ColorGroup::find($colorGroupCode);

        if (!$group) {
            throw new Exception("Este colorGroupCode no existe");
        }

        ColorRelation::where('colorGroupCode', $colorGroupCode)->delete();

        $group->delete();
    }

    public function appendColor(string $colorGroupCode, string $colorCode): void
    {
        $group = ColorGroup::find($colorGroupCode);
        if (!$group) {
            throw new Exception("El colorGroupCode no existe");
        }

        $color = Color::find($colorCode);
        if (!$color) {
            throw new Exception("El colorCode no existe");
        }

        if ($color->colorStatus != 1 && $color->colorStatus != true) {
            throw new Exception("El colorCode no está activo (status != 1)");
        }

        $exists = ColorRelation::where('colorGroupCode', $colorGroupCode)
            ->where('colorCode', $colorCode)
            ->exists();

        if ($exists) {
            throw new Exception("Ya existe la relación entre este color y el grupo");
        }

        ColorRelation::create([
            'colorGroupCode' => $colorGroupCode,
            'colorCode' => $colorCode,
        ]);
    }

    public function removeColor(string $colorGroupCode, string $colorCode): void
    {
        if (!ColorGroup::where('colorGroupCode', $colorGroupCode)->exists()) {
            throw new Exception("El colorGroupCode no existe");
        }

        if (!Color::where('colorCode', $colorCode)->exists()) {
            throw new Exception("El colorCode no existe");
        }

        $relation = ColorRelation::where('colorGroupCode', $colorGroupCode)
            ->where('colorCode', $colorCode)
            ->first();

        if (!$relation) {
            throw new Exception("No existe relación entre este color y el grupo");
        }

        $relation->delete();
    }
}

