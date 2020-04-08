<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pegawai;
use Validator;
use Session;

class LoginController extends Controller
{
    public function index(){
      return view('log-in');
    }

    public function cek(Request $request){
      $this->validate($request,[
        'Email'=>'required',
        'Password'=>'required'
      ]);
      $proses = Pegawai::where('email',$request->Email)->where('password',$request->Password)->first();
      if($proses){

        Session::put('id_pegawai',$data->id_pegawai);
        Session::put('username',$data->username);
          Session::put('email',$data->email);
        Session::put('password',$data->password);
        Session::put('nama_pegawai',$data->nama_pegawai);
        Session::put('login_status',true);
        return redirect('dashboard');
      }else{
        Session::flash('pesan','Username dan Password tidak cocok');
        return redirect('loginn');
      }
    }
}
