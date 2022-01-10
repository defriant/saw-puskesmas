<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $fillable = [
        'id',
        'nama',
        'bobot'
    ];
    public $incrementing = false;

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_kriteria', 'id');
    }
}
