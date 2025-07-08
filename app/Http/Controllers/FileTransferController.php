<?php

namespace App\Http\Controllers;

use App\Models\FileTransfer;
use App\Services\FileTransferService;
use App\Services\Notification\TNotificationService;
use App\Http\Requests\StoreFileTransferRequest;
use App\Http\Resources\FileTransferResource;
use App\Http\Requests\UpdateFileTransferRequest;

class FileTransferController extends Controller
{
    protected $transferService;
    protected $notificationService;

    public function __construct(
        FileTransferService $transferService
        //NotificationService $notificationService
    ) 
    {
        $this->transferService = $transferService;
        //$this->notificationService = $notificationService;
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $transfers = FileTransfer::query()->latest()->paginate(10);
       // return response()->json($transfers);

         return FileTransferResource::collection($transfers);
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
     * @param  \App\Http\Requests\StoreFileTransferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileTransferRequest $request)
    {
         $transfer = $this->transferService->createTransfer(
            $request->validated(),
            $request->file('files'),
        );

       // $this->notificationService->sendTransferNotifications($transfer);

        return response()->json([
             'uuid' => $transfer->uuid,
             'subject' => $transfer->subject,
             'expires_at' => $transfer->expires_at,
             'files' => $transfer->files,
        ], 201);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileTransfer  $fileTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(FileTransfer $fileTransfer, $uuid)
    {
         $transfer = FileTransfer::where('uuid', $uuid)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return response()->json($transfer->load('files', 'recipients'));

       // return FileTransferResource::collection($transfer->mapInto('files', 'recipients'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileTransfer  $fileTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(FileTransfer $fileTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFileTransferRequest  $request
     * @param  \App\Models\FileTransfer  $fileTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileTransferRequest $request, FileTransfer $fileTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileTransfer  $fileTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileTransfer $fileTransfer, $uuid)
    {
         $transfer = FileTransfer::where('uuid', $uuid)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->transferService->deleteTransfer($transfer);

        return response()->json(['message' => 'Transfer deleted successfully']);
    }
}
