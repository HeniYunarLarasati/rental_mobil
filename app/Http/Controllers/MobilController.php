<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mobil_model;
use Illuminate\Support\Facades\Validator;
use Auth;

class MobilController extends Controller
{
  // CREATE
  public function store(Request $req)
  {
    if(Auth::user()->level=="admin"){
    $validator = Validator::make($req->all(),
    [
      'id_jenis' => 'required',
      'merk' => 'required',
      'plat' => 'required',
      'kondisi' => 'required',
      'keterangan' => 'required',
    ]);
    if($validator->fails()){
      return Response()->json($validator->errors());
    }
    $simpan = Mobil_model::create([
      'id_jenis' => $req->id_jenis,
      'merk' => $req->merk,
      'plat' => $req->plat,
      'kondisi' => $req->kondisi,
      'keterangan' => $req->keterangan,
    ]);
    return Response()->json(['status'=> 'Data mobil berhasil dimasukkan']);
  } else {
      return Response()->json(['status'=> 'Data mobil gagal dimasukkan,
                                          anda bukan admin']);
    }
  }

  //READ
  public function tampil(){
    if(Auth::user()->level=="admin"){
  $datas = Mobil_model::get();
  $count = $datas->count();
  $jenis = array();
  $status = 1;
  foreach ($datas as $dt_sw){
    $jenis[] = array(
      'id' => $dt_sw->id,
      'id_jenis' => $dt_sw->id_jenis,
      'merk' => $dt_sw->merk,
      'plat' => $dt_sw->plat,
      'kondisi' => $dt_sw->kondisi,
      'keterangan' => $dt_sw->keterangan,
      'created_at' => $dt_sw->created_at,
      'updated_at' => $dt_sw->updated_at,
    );
  }
  return Response()->json(compact('count','jenis'));
} else {
  return Response()->json(['status'=> 'Gabisa, kamu bukan admin :(']);
}
}

// UPDATE
public function update($id,Request $req)
{
  if(Auth::user()->level=="admin"){
  $validator=Validator::make($req->all(),
  [
    'id_jenis' => 'required',
    'merk' => 'required',
    'plat' => 'required',
    'kondisi' => 'required',
    'keterangan' => 'required',
  ]);
  if($validator->fails()){
    return Response()->json($validator->errors());
  }
  $ubah=Mobil_model::where('id',$id)->update([
    'id_jenis' => $req->id_jenis,
    'merk' => $req->merk,
    'plat' => $req->plat,
    'kondisi' => $req->kondisi,
    'keterangan' => $req->keterangan,
  ]);
    return Response()->json([
                             'message'=>'Data mobil berhasil diubah']);
  } else {
    return Response()->json([
                             'message'=>'Data mobil gagal diubah,
                             anda bukan admin']);
  }
}

//DELETE
public function delete($id)
{
  if(Auth::user()->level=="admin"){
  $hapus=Mobil_model::where('id',$id)->delete();
    return Response()->json([
                             'message'=>'Data mobil berhasil dihapus']);
  } else {
    return Response()->json([
                             'message'=>'Data mobil gagal dihapus,
                             anda bukan admin']);
  }

}
}
