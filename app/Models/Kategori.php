<?php

namespace App\Models;
use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $guarded = [];

    public function tiket(): HasMany
    {
        return $this->hasMany(Tiket::class);
    }


    public function subkategori(): HasMany
    {
        return $this->hasMany(SubKategori::class, 'kategori_id');
    }

}
