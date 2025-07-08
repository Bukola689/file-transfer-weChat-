<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class FileTransfer extends Model
{
    use HasFactory;

    protected $guarded = [];

     protected $fillable = [
        'user_id',
        'sender_email',
        'subject',
        'message',
        'password',
        'expires_at',
        'download_limit',
        'notify_on_download'
    ];

    protected $dates = ['expires_at'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($transfer) {
    //         $transfer->uuid = Str::uuid();
    //     });
    // }

     protected $casts = [
    'download_limit' => 'integer',
    ];

        protected static function boot()
    {
          parent::boot();

           static::creating(function ($model) {
           $model->uuid = (string) \Illuminate\Support\Str::uuid();
         });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function recipients()
    {
        return $this->hasMany(Recipient::class);
    }

    public function getTotalSizeAttribute()
    {
        return $this->files->sum('size');
    }

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    // public function hasReachedDownloadLimit()
    // {
    //     return $this->download_limit && $this->downloads->count() >= $this->download_limit;
    // }

  public function hasReachedDownloadLimit(): bool
{
    // No limit means unlimited downloads
    if (is_null($this->download_limit)) {
        return false;
    }

    // Use the relationship method, not property
    return $this->downloads()->count() >= $this->download_limit;
}

    public function canBeDownloaded()
    {
        return !$this->isExpired() && !$this->hasReachedDownloadLimit();
    }
}
