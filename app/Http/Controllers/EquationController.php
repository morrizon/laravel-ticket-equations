<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquationController extends Controller
{
    public function generate(Request $request)
    {
        $this->validate($request, [
            'ticket' => 'required|regex:/^\d{6}$/',
        ]);

        $equations = $this->equationsFromTicket($request->ticket);
        return view('equation', compact('equations'));
    }

    private function equationsFromTicket($ticket)
    {
        return [
            $this->equationFromResult((int)substr($ticket, 0, 2)),
            $this->equationFromResult((int)substr($ticket, 2, 2)),
            $this->equationFromResult((int)substr($ticket, 4, 2)),
        ];
    }

    private function equationFromResult($result)
    {
        return '('
            . $this->rational()
            . ' '
            . $this->operation()
            . ' '
            . $this->rational()
            . ')'
            . $this->mulOrDiv()
            . $this->rational()
            . ' '
            . $this->operation()
            . ' '
            . '('
            . $this->rational()
            . ' '
            . $this->operation()
            . ' '
            . $this->rational()
            . ')'
            . $this->mulOrDiv()
            . $this->rational();
    }

    private function natural()
    {
        return (string)rand(1,99);
    }

    private function rational()
    {
        $a = $this->natural();
        $b = $this->natural();
        $rational = $a % $b ? "$a/$b" : (string)($a/$b);
        return rand(0, 1) ? $rational : "(-$rational)";
    }

    private function operation()
    {
        $operations = [
            '+',
            '-',
            '*',
            ':',
        ];
        return $operations[rand(0,3)];
    }

    private function sumOrSub()
    {
        rand(0,1) ? '+' : '-';
    }

    private function mulOrDiv()
    {
        rand(0,1) ? '*' : ':';
    }
}
