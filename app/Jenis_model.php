<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis_model extends Model
{
  protected $table="jenis";
  protected $primaryKey="id";
  protected $fillable = [
    'jenis',
  ];
}
