<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\MessageFormatter;
use GuzzleHttp\Client;

class SpoilerController extends Controller
{
    public function format(Request $request)
    {
        $formatter = new MessageFormatter;
        $message = $formatter->format($request->get('text'));

        $client = new Client();
        $client->request('POST', $request->get('response_url'), ['json' => $message]);

        // return response(json_encode($formatter->format($request->get('text'))))->header('content-type', 'application/json');
        return ''
    }
}
