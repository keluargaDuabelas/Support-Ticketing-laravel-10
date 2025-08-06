<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;

class Tiket extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($tiket) {
            // Otomatis tambahkan data ke tabel comment
            Comment::create([
                'description' => $tiket->description, // Ambil dari field Tiket
                'upload' => $tiket->upload,           // Ambil dari field Tiket
                'tiket_id' => $tiket->id,             // Ambil ID Tiket yang baru dibuat
            ]);
        });
        static::updated(function ($tiket) {
            Log::info('Tiket diperbarui: ' . $tiket->id);

            $comment = Comment::where('tiket_id', $tiket->id)->first();

            if ($comment) {
                Log::info('Comment ditemukan dan diperbarui: ' . $comment->id);
                $comment->update([
                    'description' => $tiket->description,
                    'upload' => $tiket->upload,
                ]);
            } else {
                Log::info('Comment tidak ditemukan, membuat baru...');
                Comment::create([
                    'description' => $tiket->description,
                    'upload' => $tiket->upload,
                    'tiket_id' => $tiket->id,
                ]);
            }
        });


    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function subkategori(): BelongsTo
    {
        return $this->belongsTo(SubKategori::class, 'sub_kategori_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_id'); // Perbaiki 'comment_id' menjadi 'tiket_id'
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
    // public function comment(): HasOne
    // {
    //     return $this->hasOne(Comment::class, 'tiket_id');
    // }

//     public function comments(): HasMany
// {
//     return $this->hasMany(Comment::class, 'tiket_id');
// }

    public static function generateNomor()
    {
        $date = date('Ymd'); // Format TahunBulanTanggal
        $lastRecord = self::where('nomor', 'like', "{$date}%")->latest('nomor')->first();

        // Ambil nomor urut terakhir (4 digit terakhir)
        $lastNumber = $lastRecord ? intval(substr($lastRecord->nomor, -4)) : 0;

        // Tambahkan 1 ke nomor urut terakhir
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Gabungkan tanggal dan nomor urut
        return "{$date}{$newNumber}";
    }

}
