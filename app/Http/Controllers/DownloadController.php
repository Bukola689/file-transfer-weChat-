<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Http\Requests\DownloadAuthRequest;
use App\Models\FileTransfer;
use App\Services\DownloadService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\FileTransferService;
use App\Http\Requests\StoreDownloadRequest;
use App\Http\Requests\UpdateDownloadRequest;

class DownloadController extends Controller
{ 
    protected $downloadService;
    protected $transferService;

    public function __construct(
        DownloadService $downloadService,
        FileTransferService $transferService
    ) {
        $this->downloadService = $downloadService;
        $this->transferService = $transferService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDownloadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDownloadRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Download $download, $uuid)
    {

        if (!$uuid) {
        return response()->json(['error' => 'UUID is required'], 400);
    }

    //$transfer = $this->transferService->findByUuid($uuid);

       $transfer = FileTransfer::where('uuid', $uuid)->first();

        if (!$transfer) {
        throw new \Illuminate\Database\Eloquent\ModelNotFoundException(
            "No file transfer found with UUID: {$uuid}"
        );

    }

    // if ($transfer->password) {
    //     return response()->json([
    //         'requires_password' => true,
    //         'transfer_uuid' => $transfer->uuid
    //     ]);
    // }

    return $this->downloadService->handleDownload($transfer, [
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'recipient_email' => $request->query('recipient')
    ]);

    }

    public function authenticate(StoreDownloadRequest $request, $uuid)
    {
        //$transfer = $this->transferService->findByUuid($uuid);

        $transfer = FileTransfer::where('uuid', $uuid)->first();

        if (!$transfer) {
        throw new \Illuminate\Database\Eloquent\ModelNotFoundException(
            "No file transfer found with UUID: {$uuid}"
        );
    }
        
        if (!$this->transferService->verifyPassword($transfer, $request->password)) {
            return response()->json(['error' => 'Invalid password'], 401);
        }

        return $this->downloadService->handleDownload($transfer, [
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'recipient_email' => request()->query('recipient')
        ]);
    }

    public function files($uuid)
    {
        $transfer = $this->transferService->findByUuid($uuid);
        
        return response()->json([
            'transfer' => $transfer,
            'files' => $transfer->files
        ]);
    }
 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function edit(Download $download)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDownloadRequest  $request
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDownloadRequest $request, Download $download)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function destroy(Download $download)
    {
        //
    }
}
