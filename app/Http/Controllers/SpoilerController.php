<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\MessageFormatter;

class SpoilerController extends Controller
{
    public function format(Request $request)
    {
        return response()->json(['text' => 'HELLO']);

        $formatter = new MessageFormatter;
        
        return response()->json(
            $formatter->format($request->get('text'))
        );
    }
}
