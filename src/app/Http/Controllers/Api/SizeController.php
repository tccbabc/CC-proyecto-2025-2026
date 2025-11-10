<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SizeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class SizeController extends Controller
{
    protected $service;

    public function __construct(SizeService $service)
    {
        $this->service = $service;
    }

    public function listSize()
    {
        try {
            $sizes = $this->service->listSize();
            Log::channel('api')->info('sizes.list', ['count' => count($sizes)]);
            return response()->json($sizes);
        } catch (Exception $e) {
            Log::channel('api')->error('sizes.list_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function addSize(Request $request)
    {
        try {
            $validated = $request->validate([
                'sizeCode' => 'required|string|max:50',
                'sizeName' => 'required|string|max:100',
                'sizeGroup' => 'required|string|max:100',
                'sizeStatus' => 'boolean'
            ]);

            $size = $this->service->addSize($validated);

            Log::channel('api')->info('sizes.add', [
                'sizeCode' => $size->sizeCode,
                'sizeGroup' => $size->sizeGroup
            ]);

            return response()->json($size, 201);

        } catch (Exception $e) {
            Log::channel('api')->error('sizes.add_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function editSize(Request $request, $sizeCode)
    {
        try {
            $validated = $request->validate([
                'sizeName' => 'required|string|max:100',
                'sizeGroup' => 'required|string|max:100',
                'sizeStatus' => 'boolean'
            ]);

            $size = $this->service->editSize($sizeCode, $validated);
            Log::channel('api')->info('sizes.edit', ['sizeCode' => $size->sizeCode]);
            return response()->json($size);

        } catch (Exception $e) {
            Log::channel('api')->error('sizes.edit_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delSize($sizeCode)
    {
        try {
            $this->service->delSize($sizeCode);
            Log::channel('api')->warning('sizes.delete', ['sizeCode' => $sizeCode]);
            return response()->json(['message' => 'Deleted successfully']);

        } catch (Exception $e) {
            Log::channel('api')->error('sizes.delete_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
