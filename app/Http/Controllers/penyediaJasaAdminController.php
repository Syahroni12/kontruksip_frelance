<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class penyediaJasaAdminController extends Controller
{
    public function index() {
        return view('admin.penyedia_jasa.index');
    }
}
