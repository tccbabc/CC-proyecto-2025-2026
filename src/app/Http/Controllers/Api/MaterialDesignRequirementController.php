<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MaterialDesignRequirementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class MaterialDesignRequirementController extends Controller
{
    protected $service;

    public function __construct(MaterialDesignRequirementService $service)
    {
        $this->service = $service;
    }

    public function listMaterialDesignRequirement()
    {
        try {
            $items = $this->service->listMaterialDesignRequirement();
            Log::channel('api')->info('material-design-requirements.list', ['count' => count($items)]);
            Log::channel('elk')->info('material-design-requirements.list', ['count' => count($items)]);
            return response()->json($items);

        } catch (Exception $e) {
            Log::channel('api')->error('material-design-requirements.list_failed', [
                'error' => $e->getMessage()
            ]);
            Log::channel('elk')->error('material-design-requirements.list_failed', [
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function addMaterialDesignRequirement(Request $request)
    {
        try {
            $validated = $request->validate([
                'colorCode' => 'required|string',
                'colorGroupCode' => 'required|string',
                'sizeCode' => 'required|string',
                'sizeGroupCode' => 'required|string',
                'status' => 'boolean',
                'providerCode' => 'nullable|string',
                'providerName' => 'nullable|string',
            ]);

            $item = $this->service->addMaterialDesignRequirement($validated);

            Log::channel('api')->info('material-design-requirements.add', [
                'id' => $item->id,
            ]);
            Log::channel('elk')->info('material-design-requirements.add', [
                'id' => $item->id,
            ]);

            return response()->json($item, 201);

        } catch (Exception $e) {
            Log::channel('api')->error('material-design-requirements.add_failed', [
                'error' => $e->getMessage()
            ]);
            Log::channel('elk')->error('material-design-requirements.add_failed', [
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function editMaterialDesignRequirement(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'colorCode' => 'string',
                'colorGroupCode' => 'string',
                'sizeCode' => 'string',
                'sizeGroupCode' => 'string',
                'status' => 'boolean',
                'providerCode' => 'nullable|string',
                'providerName' => 'nullable|string',
            ]);

            $item = $this->service->editMaterialDesignRequirement($id, $validated);

            Log::channel('api')->info('material-design-requirements.edit', [
                'id' => $item->id
            ]);
            Log::channel('elk')->info('material-design-requirements.edit', [
                'id' => $item->id
            ]);

            return response()->json($item);

        } catch (Exception $e) {
            Log::channel('api')->error('material-design-requirements.edit_failed', [
                'error' => $e->getMessage()
            ]);
            Log::channel('elk')->error('material-design-requirements.edit_failed', [
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delMaterialDesignRequirement(int $id)
    {
        try {
            $this->service->delMaterialDesignRequirement($id);

            Log::channel('api')->warning('material-design-requirements.delete', [
                'id' => $id
            ]);
            Log::channel('elk')->warning('material-design-requirements.delete', [
                'id' => $id
            ]);

            return response()->json(['message' => 'Deleted successfully']);

        } catch (Exception $e) {
            Log::channel('api')->error('material-design-requirements.delete_failed', [
                'error' => $e->getMessage()
            ]);
            Log::channel('elk')->error('material-design-requirements.delete_failed', [
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}

