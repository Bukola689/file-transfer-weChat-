<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileTransfer;
use App\Services\FileTransferService;
use Illuminate\Http\Request;

class TransferController extends Controller
{
     protected $transferService;

    public function __construct(FileTransferService $transferService)
    {
        $this->middleware('admin');
        $this->transferService = $transferService;
    }

    public function index()
    {
        $transfers = $this->transferService->getAllTransfersPaginated(20);
        return response()->json($transfers);
    }

    public function show($uuid)
    {
        $transfer = $this->transferService->findByUuidWithRelations($uuid, [
            'user', 'files', 'downloads', 'recipients'
        ]);
        
        return response()->json($transfer);
    }

    public function destroy($uuid)
    {
        $transfer = $this->transferService->findByUuid($uuid);
        $this->transferService->deleteTransfer($transfer);

        return response()->json(['message' => 'Transfer deleted successfully']);
    }

}
