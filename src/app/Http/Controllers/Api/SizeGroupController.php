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
        try {
            $groups = $this->service->listSizeGroup();
            Log::channel('api')->info('size-groups.list', ['count' => count($groups)]);
            Log::channel('elk')->info('size-groups.list', ['count' => count($groups)]);
            return response()->json($groups);
        } catch (Exception $e) {
            Log::channel('api')->error('size-groups.list_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('size-groups.list_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function addSizeGroup(Request $request)
    {
        try {
            $validated = $request->validate([
                'sizeGroupCode' => 'required|string',
                'sizeGroupName' => 'required|string',
                'sizeGroupStatus' => 'boolean',
            ]);

            $group = $this->service->addSizeGroup($validated);
            Log::channel('api')->info('size-groups.add', ['sizeGroupCode' => $group->sizeGroupCode]);
            Log::channel('elk')->info('size-groups.add', ['sizeGroupCode' => $group->sizeGroupCode]);
            return response()->json($group, 201);
        } catch (Exception $e) {
            Log::channel('api')->error('size-groups.add_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('size-groups.add_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function editSizeGroup(Request $request, $sizeGroupCode)
    {
        try {
            $validated = $request->validate([
                'sizeGroupName' => 'required|string',
                'sizeGroupStatus' => 'boolean',
            ]);

            $group = $this->service->editSizeGroup($sizeGroupCode, $validated);
            Log::channel('api')->info('size-groups.edit', ['sizeGroupCode' => $group->sizeGroupCode]);
            Log::channel('elk')->info('size-groups.edit', ['sizeGroupCode' => $group->sizeGroupCode]);
            return response()->json($group);

        } catch (Exception $e) {
            Log::channel('api')->error('size-groups.edit_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('size-groups.edit_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delSizeGroup($sizeGroupCode)
    {
        try {
            $this->service->delSizeGroup($sizeGroupCode);
            Log::channel('api')->warning('size-groups.delete', ['sizeGroupCode' => $sizeGroupCode]);
            Log::channel('elk')->warning('size-groups.delete', ['sizeGroupCode' => $sizeGroupCode]);
            return response()->json(['message' => 'Deleted successfully']);

        } catch (Exception $e) {
            Log::channel('api')->error('size-groups.delete_failed', ['error' => $e->getMessage()]);
            Log::channel('elk')->error('size-groups.delete_failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function appendSize(string $sizeGroupCode, string $sizeCode)
    {
        try {
            $this->service->appendSize($sizeGroupCode, $sizeCode);
            Log::channel('api')->info('size-groups.appendSize', [
                'sizeGroupCode' => $sizeGroupCode,
                'sizeCode' => $sizeCode
            ]);
            Log::channel('elk')->info('size-groups.appendSize', [
                'sizeGroupCode' => $sizeGroupCode,
                'sizeCode' => $sizeCode
            ]);
            return response()->json(['message' => 'Size agregado correctamente al grupo']);
        } catch (Exception $e) {
            Log::channel('api')->error('size-groups.appendSize_failed', [
                'sizeGroupCode' => $sizeGroupCode,
                'sizeCode' => $sizeCode,
                'error' => $e->getMessage()
            ]);
            Log::channel('elk')->error('size-groups.appendSize_failed', [
                'sizeGroupCode' => $sizeGroupCode,
                'sizeCode' => $sizeCode,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function removeSize(string $sizeGroupCode, string $sizeCode)
    {
        try {
            $this->service->removeSize($sizeGroupCode, $sizeCode);
            Log::channel('api')->warning('size-groups.removeSize', [
                'sizeGroupCode' => $sizeGroupCode,
                'sizeCode' => $sizeCode
            ]);
            Log::channel('elk')->warning('size-groups.removeSize', [
                'sizeGroupCode' => $sizeGroupCode,
                'sizeCode' => $sizeCode
            ]);
            return response()->json(['message' => 'Size eliminado del grupo correctamente']);
        } catch (Exception $e) {
            Log::channel('api')->error('size-groups.removeSize_failed', [
                'sizeGroupCode' => $sizeGroupCode,
                'sizeCode' => $sizeCode,
                'error' => $e->getMessage()
            ]);
            Log::channel('elk')->error('size-groups.removeSize_failed', [
                'sizeGroupCode' => $sizeGroupCode,
                'sizeCode' => $sizeCode,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}
