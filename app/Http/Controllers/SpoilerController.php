<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\MessageFormatter;

class SpoilerController extends Controller
{
    public function format(Request $request)
    {
        $formatter = new MessageFormatter;
        
        return response(json_encode($formatter->format($request->get('text'), JSON_PRETTY_PRINT)))
            ->header('Content-type', 'application/json');
    }
}
