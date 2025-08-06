<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;

class Response extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    // protected $guarded = [];
    protected $fillable = ['comment_id', 'message', 'username', 'upload', 'user_id'];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }

}
