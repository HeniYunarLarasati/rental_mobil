<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penyewa_model extends Model
{
  protected $table="penyewa";
  protected $primaryKey="id";
  protected $fillable = [
    'nama', 'no_ktp', 'alamat', 'telp', 
  ];
}
