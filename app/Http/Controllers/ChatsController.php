<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function halamanchatcustomer()
    {

        // return view('chats');
        $chat = Transaksi::with(['chat', 'pengguna','detailTransaksi'])->get();
        return view('chatscustomer', compact('chat'));
    }
}
