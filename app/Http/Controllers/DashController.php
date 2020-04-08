<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashController extends Controller
{
  public function index(){
    return view('dashboard');
  }

  public function __construct(){
    $this->middleware('cek_login');
  }
}
