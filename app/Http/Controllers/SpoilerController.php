<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\MessageFormatter;

class SpoilerController extends Controller
{
    public function format(Request $request)
    {
        $formatter = new MessageFormatter;
        
        header('content-type: application/json');
        echo json_encode($formatter->format($request->get('text')));
        die;

        return response(json_encode($formatter->format($request->get('text'))))->header('content-type', 'application/json');
    }
}
