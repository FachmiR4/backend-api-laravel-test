<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tbl_anggota';
    protected $fillable = [
        'name',
        'email',
        'no_hp',
        'alamat'
    ];
}
