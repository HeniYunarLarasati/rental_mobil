<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mobil_model extends Model
{
  protected $table="mobil";
  protected $primaryKey="id";
  protected $fillable = [
    'id_jenis', 'merk', 'plat', 'kondisi', 'keterangan', 
  ];
}
