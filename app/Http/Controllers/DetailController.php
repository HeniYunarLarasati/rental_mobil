<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi_model;
use App\Detail_model;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class DetailController extends Controller
{
  //Detail transaksi_model

  public function store(Request $req)
  {
    if(Auth::user()->level=="petugas"){
    $validator = Validator::make($req->all(),
    [
      'id_transaksi' => 'required',
      'id_mobil' => 'required',
      'qty' => 'required',
      'subtotal' => 'required',
    ]);
    if($validator->fails()){
      return Response()->json($validator->errors());
    }
    $subtotal=DB::table('jenis')->where('id',$req->id_jenis)->first();
    $sub=$subtotal->harga_per_kilo*$req->qty;
    $simpan = DetailTrans_model::create([
      'id_trans' => $req->id_trans,
      'id_jenis' => $req->id_jenis,
      'qty' => $req->qty,
      'subtotal' => $sub,

    ]);
    return Response()->json(['status'=> 'Data detail berhasil dimasukkan']);
  } else {
      return Response()->json(['status'=> 'Data detail gagal dimasukkan, anda bukan admin']);
    }
  }

  public function tampil($tgl1, $tgl2){
      $trans = DB::table('transaksi')->join('pelanggan','pelanggan.id','transaksi.id_pelanggan')
              ->where('tgl_transaksi','>=',$tgl1)
              ->where('tgl_transaksi','<=',$tgl2)
              ->select('transaksi.id','tgl_transaksi','nama', 'alamat', 'telp', 'tgl_selesai')
              ->get();

      $datatrans=array();
      $no=0;
      foreach ($trans as $t){
        $datatrans[$no]['tgl_transaksi']=$t->tgl_transaksi;
        $datatrans[$no]['nama_pelanggan']=$t->nama;
        $datatrans[$no]['alamat']=$t->alamat;
        $datatrans[$no]['telepon']=$t->telp;
        $datatrans[$no]['tgl_jadi']=$t->tgl_selesai;

      $grand=DB::table('detail_trans')
      ->where('id_trans',$t->id)->groupBy("id_trans")
      ->select(DB::raw('sum(subtotal)as grandtotal'))
      ->first();

      $datatrans[$no]['grandtotal']=$grand->grandtotal;
      $detail=DB::table('detail_trans')->join('jenis_cuci','jenis_cuci.id','detail_trans.id_jenis')
      ->where('id_trans',$t->id)
      ->select('nama_jenis','harga_per_kilo','qty', 'subtotal')
      ->get();

      $datatrans[$no]['detail']=$detail;
      }
      return response()->json($datatrans);
    }

    public function update($id,Request $req)
    {
      if(Auth::user()->level=="petugas"){
      $validator=Validator::make($req->all(),
      [
        'id_trans' => 'required',
        'id_jenis' => 'required',
        'qty' => 'required'
      ]);
      if($validator->fails()){
        return Response()->json($validator->errors());
      }
      $subtotal=DB::table('jenis_cuci')->where('id',$req->id_jenis)->first();
      $sub=$subtotal->harga_per_kilo*$req->qty;
      $ubah=DetailTrans_model::where('id',$id)->update([
        'id_trans' => $req->id_trans,
        'id_jenis' => $req->id_jenis,
        'qty' => $req->qty,
        'subtotal' => $sub,
      ]);
        return Response()->json([
                                 'message'=>'Data tiket berhasil diubah']);
      } else {
        return Response()->json([
                                 'message'=>'Data tiket gagal diubah, anda bukan admin']);
      }
    }

public function delete($id)
{
  if(Auth::user()->level=="admin"){
  $hapus=DetailTrans_model::where('id',$id)->delete();
    return Response()->json([
                             'message'=>'Data detail berhasil dihapus']);
  } else {
    return Response()->json([
                             'message'=>'Data detail gagal dihapus, anda bukan admin']);
  }

}
}
