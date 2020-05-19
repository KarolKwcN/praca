<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repair;
class NaprawaController extends Controller
{
    public function getNaprawa($slug, $slugi, $slugii, $id, $slugi_name)
    {
        $repair = Repair::where('id', $id)->firstOrFail();
      

        return view('naprawa.naprawa', compact('repair'));
    }
}
