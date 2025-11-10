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
        $sizes = $this->service->listSize();
        return response()->json($sizes);
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
            return response()->json($size, 201);

        } catch (Exception $e) {
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
            return response()->json($size);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delSize($sizeCode)
    {
        try {
            $this->service->delSize($sizeCode);
            return response()->json(['message' => 'Deleted successfully']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
