<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ColorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ColorController extends Controller
{
    protected $service;

    public function __construct(ColorService $service)
    {
        $this->service = $service;
    }

    public function listColor()
    {
        try {
            $colors = $this->service->listColor();
            Log::channel('api')->info('colors.list', ['count' => count($colors)]);
            Log::channel('elk')->info('colors.list', ['count' => count($colors)]);
            return response()->json($colors);
        } catch (Exception $e) {
            Log::channel('api')->error('colors.list_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('colors.list_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function addColor(Request $request)
    {
        try {
            $validated = $request->validate([
                'colorCode' => 'required|string',
                'colorName' => 'required|string',
                'colorGroup' => 'required|string',
                'colorStatus' => 'boolean'
            ]);

            $color = $this->service->addColor($validated);

            Log::channel('api')->info('colors.add', [
                'colorCode' => $color->colorCode,
                'colorGroup' => $color->colorGroup
            ]);

            Log::channel('elk')->info('colors.add', [
                'colorCode' => $color->colorCode,
                'colorGroup' => $color->colorGroup
            ]);

            return response()->json($color, 201);

        } catch (Exception $e) {
            Log::channel('api')->error('colors.add_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('colors.add_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function editColor(Request $request, $colorCode)
    {
        try {
            $validated = $request->validate([
                'colorName' => 'required|string',
                'colorGroup' => 'required|string',
                'colorStatus' => 'boolean'
            ]);

            $color = $this->service->editColor($colorCode, $validated);
            Log::channel('api')->info('colors.edit', ['colorCode' => $color->colorCode]);
            Log::channel('elk')->info('colors.edit', ['colorCode' => $color->colorCode]);
            return response()->json($color);

        } catch (Exception $e) {
            Log::channel('api')->error('colors.edit_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('colors.edit_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delColor($colorCode)
    {
        try {
            $this->service->delColor($colorCode);
            Log::channel('api')->warning('colors.delete', ['colorCode' => $colorCode]);
            Log::channel('elk')->warning('colors.delete', ['colorCode' => $colorCode]);
            return response()->json(['message' => 'Deleted successfully']);

        } catch (Exception $e) {
            Log::channel('api')->error('colors.delete_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('colors.delete_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
