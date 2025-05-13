<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestDonasi;

class OwnerOrganisasi extends Controller
{
    public function index()
    {
        $request_donasis = RequestDonasi::all();
        return view('owner.ownerrequest_donasi', compact('request_donasis'));
    }
}
