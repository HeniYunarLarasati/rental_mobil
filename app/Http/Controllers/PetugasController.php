<?php

namespace App\Http\Controllers;

use App\User;
use App\Petugas_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;

class PetugasController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required|string|max:255',
            'telp' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:petugas',
            'password' => 'required|string|min:6|confirmed',
            'level' => 'required|string|max:255',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'nama_petugas' => $request->get('nama_petugas'),
            'telp' => $request->get('telp'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'level' => $request->get('level'),

        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function tampil(){
      if(Auth::user()->level=="admin"){
    $datas = Petugas_model::get();
    $count = $datas->count();
    $film = array();
    $status = 1;
    foreach ($datas as $dt_sw){
      $film[] = array(
        'id' => $dt_sw->id,
        'nama_petugas' => $dt_sw->nama_petugas,
        'telp' => $dt_sw->telp,
        'username' => $dt_sw->username,
        'password' => $dt_sw->password,
        'level' => $dt_sw->level,
        'created_at' => $dt_sw->created_at,
        'updated_at' => $dt_sw->updated_at,
      );
    }
    return Response()->json(compact('count','film'));
  } else {
    return Response()->json(['status'=> 'Gabisa, kamu bukan admin :(']);
  }
  }

  public function update($id,Request $req)
  {
    if(Auth::user()->level=="admin"){
    $validator=Validator::make($req->all(),
    [
      'nama_petugas' => 'required',
      'telp' => 'required',
      'username' => 'required',
      'password' => 'required',
      'level' => 'required',
    ]);
    if($validator->fails()){
      return Response()->json($validator->errors());
    }
    $ubah=Petugas_model::where('id',$id)->update([
      'nama_petugas' => $req->nama_petugas,
      'telp' => $req->telp,
      'username' => $req->username,
      'password' => $req->password,
      'level' => $req->level,
    ]);
      return Response()->json([
                               'message'=>'Data petugas berhasil diubah']);
    } else {
      return Response()->json([
                               'message'=>'Data petugas gagal diubah, anda bukan admin']);
    }
  }

  public function delete($id)
  {
    if(Auth::user()->level=="admin"){
    $hapus=Petugas_model::where('id',$id)->delete();
      return Response()->json([
                               'message'=>'Data petugas berhasil dihapus']);
    } else {
      return Response()->json([
                               'message'=>'Data petugas gagal dihapus, anda bukan admin']);
    }

  }
}
