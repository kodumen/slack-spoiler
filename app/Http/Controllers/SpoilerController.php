<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpoilerController extends Controller
{
    public function format(Request $request)
    {
        var_dump($request->all());
    }
}
