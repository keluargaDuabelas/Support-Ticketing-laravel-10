<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $guarded = [];

    // public function tiket(): BelongsTo
    // {
    //     return $this->belongsTo(Tiket::class, 'tiket_id');
    // }
    // public function tiket(): BelongsTo
    // {
    //     return $this->belongsTo(Tiket::class);

    // }
    public function responses()
    {
        return $this->hasMany(Response::class, 'comment_id', 'id');
    }
    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
