<?php

namespace App\Http\Controllers;

use App\Pengaturan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function votingHmj()
    {
        $cek = Pengaturan::isVotingSedangBerlangsung() || Pengaturan::isVotingTelahBerlangsung();
        return view('admin.public.votinghmj', [
            'cek' => $cek
        ]);
    }
}
