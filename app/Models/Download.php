<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $guarded = [];

     protected $fillable = [
        'transfer_id',
        'ip_address',
        'user_agent'
    ];

    public function transfer()
    {
        return $this->belongsTo(FileTransfer::class);
    }
}
