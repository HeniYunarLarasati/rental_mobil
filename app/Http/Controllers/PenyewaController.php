<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penyewa_model;
use Illuminate\Support\Facades\Validator;
use Auth;

class PenyewaController extends Controller
{
  // CREATE
  public function store(Request $req)
  {
    if(Auth::user()->level=="admin"){
    $validator = Validator::make($req->all(),
    [
      'nama' => 'required',
      'no_ktp' => 'required',
      'alamat' => 'required',
      'telp' => 'required'
    ]);
    if($validator->fails()){
      return Response()->json($validator->errors());
    }
    $simpan = Penyewa_model::create([
      'nama' => $req->nama,
      'no_ktp' => $req->no_ktp,
      'alamat' => $req->alamat,
      'telp' => $req->telp,

    ]);
    return Response()->json(['status'=> 'Data penyewa berhasil dimasukkan']);
  } else {
      return Response()->json(['status'=> 'Data penyewa gagal dimasukkan, anda bukan admin']);
    }
  }

  //READ
  public function tampil(){
    if(Auth::user()->level=="admin"){
  $datas = Penyewa_model::get();
  $count = $datas->count();
  $penyewa = array();
  $status = 1;
  foreach ($datas as $dt_sw){
    $penyewa[] = array(
      'id' => $dt_sw->id,
      'nama' => $dt_sw->nama,
      'no_ktp' => $dt_sw->no_ktp,
      'alamat' => $dt_sw->alamat,
      'telp' => $dt_sw->telp,
      'created_at' => $dt_sw->created_at,
      'updated_at' => $dt_sw->updated_at,
    );
  }
  return Response()->json(compact('count','penyewa'));
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
    'nama' => 'required',
    'no_ktp' => 'required',
    'alamat' => 'required',
    'telp' => 'required',
  ]);
  if($validator->fails()){
    return Response()->json($validator->errors());
  }
  $ubah=Penyewa_model::where('id',$id)->update([
    'nama' => $req->nama,
    'no_ktp' => $req->no_ktp,
    'alamat' => $req->alamat,
    'telp' => $req->telp,
  ]);
    return Response()->json([
                             'message'=>'Data penyewa berhasil diubah']);
  } else {
    return Response()->json([
                             'message'=>'Data penyewa gagal diubah, anda bukan admin']);
  }
}

//DELETE
public function delete($id)
{
  if(Auth::user()->level=="admin"){
  $hapus=Penyewa_model::where('id',$id)->delete();
    return Response()->json([
                             'message'=>'Data penyewa berhasil dihapus']);
  } else {
    return Response()->json([
                             'message'=>'Data penyewa gagal dihapus, anda bukan admin']);
  }

}
}
