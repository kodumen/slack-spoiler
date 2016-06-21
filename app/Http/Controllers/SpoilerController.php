<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\MessageFormatter;

class SpoilerController extends Controller
{
    public function format(Request $request)
    {
        $formatter = new MessageFormatter;
        
        return response($formatter->format($request->get('text')))
            ->header('Content-type', 'text/plain');
    }
}
