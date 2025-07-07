<?php

namespace App\Http\Controllers;

use App\Models\FileTransfer;
use App\Http\Requests\StoreFileTransferRequest;
use App\Http\Requests\UpdateFileTransferRequest;

class FileTransferController extends Controller
{
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
     * @param  \App\Http\Requests\StoreFileTransferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileTransferRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileTransfer  $fileTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(FileTransfer $fileTransfer)
    {
        //
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
    public function destroy(FileTransfer $fileTransfer)
    {
        //
    }
}
