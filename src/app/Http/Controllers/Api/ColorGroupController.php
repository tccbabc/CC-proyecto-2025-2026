<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ColorGroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ColorGroupController extends Controller
{
    protected $service;

    public function __construct(ColorGroupService $service)
    {
        $this->service = $service;
    }

    public function listColorGroup()
    {
        try {
            $groups = $this->service->listColorGroup();
            Log::channel('api')->info('color-groups.list', ['count' => count($groups)]);
            Log::channel('elk')->info('color-groups.list', ['count' => count($groups)]);
            return response()->json($groups);
        } catch (Exception $e) {
            Log::channel('api')->error('color-groups.list_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('color-groups.list_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function addColorGroup(Request $request)
    {
        try {
            $validated = $request->validate([
                'colorGroupCode' => 'required|string',
                'colorGroupName' => 'required|string',
                'colorGroupStatus' => 'boolean',
            ]);

            $group = $this->service->addColorGroup($validated);
            Log::channel('api')->info('color-groups.add', ['colorGroupCode' => $group->colorGroupCode]);
            Log::channel('elk')->info('color-groups.add', ['colorGroupCode' => $group->colorGroupCode]);
            return response()->json($group, 201);

        } catch (Exception $e) {
            Log::channel('api')->error('color-groups.add_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('color-groups.add_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function editColorGroup(Request $request, $colorGroupCode)
    {
        try {
            $validated = $request->validate([
                'colorGroupName' => 'required|string',
                'colorGroupStatus' => 'boolean',
            ]);

            $group = $this->service->editColorGroup($colorGroupCode, $validated);
            Log::channel('api')->info('color-groups.edit', ['colorGroupCode' => $group->colorGroupCode]);
            Log::channel('elk')->info('color-groups.edit', ['colorGroupCode' => $group->colorGroupCode]);
            return response()->json($group);

        } catch (Exception $e) {
            Log::channel('api')->error('color-groups.edit_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('color-groups.edit_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delColorGroup($colorGroupCode)
    {
        try {
            $this->service->delColorGroup($colorGroupCode);
            Log::channel('api')->warning('color-groups.delete', ['colorGroupCode' => $colorGroupCode]);
            Log::channel('elk')->warning('color-groups.delete', ['colorGroupCode' => $colorGroupCode]);
            return response()->json(['message' => 'Deleted successfully']);

        } catch (Exception $e) {
            Log::channel('api')->error('color-groups.delete_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('color-groups.delete_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function appendColor(string $colorGroupCode, string $colorCode)
    {
        try {
            $this->service->appendColor($colorGroupCode, $colorCode);
            Log::channel('api')->info('color-groups.appendColor', [
                'colorGroupCode' => $colorGroupCode,
                'colorCode' => $colorCode
            ]);
            Log::channel('elk')->info('color-groups.appendColor', [
                'colorGroupCode' => $colorGroupCode,
                'colorCode' => $colorCode
            ]);
            return response()->json(['message' => 'Color agregado correctamente al grupo']);

        } catch (Exception $e) {
            Log::channel('api')->error('color-groups.appendColor_failed', [
                'colorGroupCode' => $colorGroupCode,
                'colorCode' => $colorCode,
                'error' => $e->getMessage()
            ]);
            Log::channel('elk')->error('color-groups.appendColor_failed', [
                'colorGroupCode' => $colorGroupCode,
                'colorCode' => $colorCode,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function removeColor(string $colorGroupCode, string $colorCode)
    {
        try {
            $this->service->removeColor($colorGroupCode, $colorCode);
            Log::channel('api')->warning('color-groups.removeColor', [
                'colorGroupCode' => $colorGroupCode,
                'colorCode' => $colorCode
            ]);
            Log::channel('elk')->warning('color-groups.removeColor', [
                'colorGroupCode' => $colorGroupCode,
                'colorCode' => $colorCode
            ]);
            return response()->json(['message' => 'Color eliminado del grupo correctamente']);

        } catch (Exception $e) {
            Log::channel('api')->error('color-groups.removeColor_failed', [
                'colorGroupCode' => $colorGroupCode,
                'colorCode' => $colorCode,
                'error' => $e->getMessage()
            ]);
            Log::channel('elk')->error('color-groups.removeColor_failed', [
                'colorGroupCode' => $colorGroupCode,
                'colorCode' => $colorCode,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
