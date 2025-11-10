<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SizeGroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class SizeGroupController extends Controller
{
    protected $service;

    public function __construct(SizeGroupService $service)
    {
        $this->service = $service;
    }

    public function listSizeGroup()
    {
        $groups = $this->service->listSizeGroup();
        return response()->json($groups);
    }

    public function addSizeGroup(Request $request)
    {
        try {
            $validated = $request->validate([
                'sizeGroupCode' => 'required|string|max:50',
                'sizeGroupName' => 'required|string|max:100',
                'sizeGroupStatus' => 'boolean',
            ]);

            $group = $this->service->addSizeGroup($validated);
            return response()->json($group, 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function editSizeGroup(Request $request, $sizeGroupCode)
    {
        try {
            $validated = $request->validate([
                'sizeGroupName' => 'required|string|max:100',
                'sizeGroupStatus' => 'boolean',
            ]);

            $group = $this->service->editSizeGroup($sizeGroupCode, $validated);
            return response()->json($group);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delSizeGroup($sizeGroupCode)
    {
        try {
            $this->service->delSizeGroup($sizeGroupCode);
            return response()->json(['message' => 'Deleted successfully']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}
