<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jenis_model;
use Illuminate\Support\Facades\Validator;
use Auth;

class JenisController extends Controller
{
  // CREATE
  public function store(Request $req)
  {
    if(Auth::user()->level=="admin"){
    $validator = Validator::make($req->all(),
    [
      'jenis' => 'required',
    ]);
    if($validator->fails()){
      return Response()->json($validator->errors());
    }
    $simpan = Jenis_model::create([
      'jenis' => $req->jenis,
    ]);
    return Response()->json(['status'=> 'Data jenis berhasil dimasukkan']);
  } else {
      return Response()->json(['status'=> 'Data jenis gagal dimasukkan, anda bukan admin']);
    }
  }

  //READ
  public function tampil(){
    if(Auth::user()->level=="admin"){
  $datas = Jenis_model::get();
  $count = $datas->count();
  $jenis = array();
  $status = 1;
  foreach ($datas as $dt_sw){
    $jenis[] = array(
      'id' => $dt_sw->id,
      'jenis' => $dt_sw->jenis,
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
    'jenis' => 'required',
  ]);
  if($validator->fails()){
    return Response()->json($validator->errors());
  }
  $ubah=Jenis_model::where('id',$id)->update([
    'jenis' => $req->jenis,
  ]);
    return Response()->json([
                             'message'=>'Data jenis berhasil diubah']);
  } else {
    return Response()->json([
                             'message'=>'Data jenis gagal diubah, anda bukan admin']);
  }
}

//DELETE
public function delete($id)
{
  if(Auth::user()->level=="admin"){
  $hapus=Jenis_model::where('id',$id)->delete();
    return Response()->json([
                             'message'=>'Data jenis berhasil dihapus']);
  } else {
    return Response()->json([
                             'message'=>'Data jenis gagal dihapus, anda bukan admin']);
  }

}
}
