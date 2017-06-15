<?php

namespace App\Http\Controllers;

use App\Commands\CreateEquations;
use App\Commands\CreateEquationsHandler;
use Illuminate\Http\Request;

class EquationController extends Controller
{
    public function index(CreateEquationsHandler $createEquationsHandler)
    {
        return view('selectTicket', ['numberOfTickets' => count($createEquationsHandler->tickets())]);
    }

    public function generate(Request $request, CreateEquationsHandler $createEquationsHandler)
    {
        $max = count($createEquationsHandler->tickets());

        $this->validate($request, [
            'ticket' => "required|integer|min:1|max:$max",
        ]);

        $command = new CreateEquations($request->ticket - 1);

        return view('equation', [
            'equations' => $createEquationsHandler($command),
            'ticket' => $request->ticket,
        ]);
    }

}
