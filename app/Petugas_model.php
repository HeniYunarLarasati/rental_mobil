<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petugas_model extends Model
{
  protected $table="petugas";
  protected $primaryKey="id";
  protected $fillable = ['nama_petugas','telp','username','password','level'];
}
