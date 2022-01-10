<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';
    protected $fillable = [
        'id',
        'nama',
        'jenis_kelamin',
        'tgl_lahir',
        'alamat'
    ];
    public $incrementing = false;

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_karyawan', 'id');
    }
}
