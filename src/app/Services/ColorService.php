<?php

namespace App\Services;

use App\Models\Color;
use App\Models\ColorGroup;
use App\Models\ColorRelation;
use Exception;

class ColorService
{
    public function listColor(): array
    {
        return Color::all()->toArray();
    }

    public function addColor(array $data): Color
    {
        if (Color::where('colorCode', $data['colorCode'])->exists()) {
            throw new Exception("Existe el mismo colorCode");
        }

        if (!ColorGroup::where('colorGroupCode', $data['colorGroup'])->exists()) {
            throw new Exception("El colorGroupCode no existe");
        }

        $color = Color::create($data);

        ColorRelation::create([
            'colorGroupCode' => $data['colorGroup'],
            'colorCode' => $data['colorCode'],
        ]);

        return $color;
    }

    public function editColor(string $colorCode, array $data): Color
    {
        $color = Color::find($colorCode);

        if (!$color) {
            throw new Exception("Este colorCode no existe");
        }

        if (isset($data['colorGroup']) &&
            !ColorGroup::where('colorGroupCode', $data['colorGroup'])->exists()) {
            throw new Exception("El colorGroupCode no existe");
        }

        $color->update($data);

        if (isset($data['colorGroup'])) {

            ColorRelation::where('colorCode', $colorCode)->delete();

            ColorRelation::create([
                'colorGroupCode' => $data['colorGroup'],
                'colorCode' => $colorCode,
            ]);
        }

        return $color;
    }

    public function delColor(string $colorCode): void
    {
        $color = Color::find($colorCode);

        if (!$color) {
            throw new Exception("Este colorCode no existe");
        }

        ColorRelation::where('colorCode', $colorCode)->delete();

        $color->delete();
    }
}
