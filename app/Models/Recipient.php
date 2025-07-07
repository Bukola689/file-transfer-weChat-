<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $guarded = [];

     protected $fillable = [
        'transfer_id',
        'email',
        'has_downloaded'
    ];

    public function transfer()
    {
        return $this->belongsTo(FileTransfer::class);
    }
}
