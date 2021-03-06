<?php

namespace App\Commands;

use Brick\Math\BigRational as Rational;

class CreateEquationsHandler
{
    const OP_PLUS = '+';
    const OP_MINUS = '-';
    const OP_MULT = '·';
    const OP_DIV = ':';
    private $operations = [
        '+' => 'plus',
        '-' => 'minus',
        '·' => 'multipliedBy',
        ':' => 'dividedBy',
    ];

    private $tickets;

    public function __invoke(CreateEquations $command)
    {
        return $this->equationsFromTicket($this->tickets()[$command->getNumberOfTicket()]);
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
        $equation1 = $this->randomEquation();
        $op = $this->sumOrSub();
        $equation2 = $this->randomEquation();

        // $y + $x = $result
        // $y = $equation1 $op $equation2
        // return -> $y + $x
        $operation = $this->operations[$op];
        $resultEquation1 = $this->resolvRandomEquation($equation1);
        $resultEquation2 = $this->resolvRandomEquation($equation2);
        $y = $resultEquation1->$operation($resultEquation2);
        $x = Rational::of($result)->minus($y)->simplified();

        $eq1 = $this->randomEquationToString($equation1);
        $eq2 = $this->randomEquationToString($equation2);

        return //"$result => " .
            ""
            . "<span data-toggle=\"tooltip\" data-placement=\"top\" title=\"$resultEquation1\" class=\"random-equation\">$eq1</span>"
            . " $op "
            . "<span data-toggle=\"tooltip\" data-placement=\"top\" title=\"$resultEquation2\" class=\"random-equation\">$eq2</span>"
            . " + $x";
    }

    /**
     * Equation ((a op1 b) op2 c) where [a, op1, b, op2, c]
     * Example:
     * ((1/2 - 3) : 3/2) -> [1/2, '-', 3, ':', 3/2]
     */
    private function randomEquation()
    {
        return [
            $this->rational(),
            $this->randomOperation(),
            $this->rational(),
            $this->mulOrDiv(),
            $this->rational(),
        ];
    }

    private function resolvRandomEquation($randomEquation)
    {
        $a = $randomEquation[0];
        $op1 = $this->operations[$randomEquation[1]];
        $b = $randomEquation[2];
        $op2 = $this->operations[$randomEquation[3]];
        $c = $randomEquation[4];
        return $a->$op1($b)->$op2($c)->simplified();
    }

    private function randomEquationToString($randomEquation)
    {
        $a = $randomEquation[0];
        $op1 = $randomEquation[1];
        $b = $randomEquation[2];
        $op2 = $randomEquation[3];
        $c = $randomEquation[4];
        return "($a $op1 $b) $op2 $c";
    }

    private function natural()
    {
        return (string)rand(1,10);
    }

    private function rational()
    {
        $a = $this->natural();
        $b = $this->natural();
        $sign = rand(0,1) ? self::OP_PLUS : self::OP_MINUS;
        return Rational::of(rand(0, 1) ? "$sign$a" : "$sign$a/$b")->simplified();
    }

    private function randomOperation()
    {
        return array_keys($this->operations)[rand(0,3)];
    }

    private function sumOrSub()
    {
        return rand(0,1) ? self::OP_PLUS : self::OP_MINUS;
    }

    private function mulOrDiv()
    {
        return rand(0,1) ? self::OP_MULT : self::OP_DIV;
    }

    public function tickets()
    {
        if (is_null($this->tickets)) {
            $page = exec("bash ../bin/tickets.sh");
            $matches = [];
            preg_match_all('/\["id"\] = "\d{6}"/', $page, $matches);
            $this->tickets = array_map(function($match) {
                return preg_replace('/.*= "|"$/', '', $match);
            }, $matches[0]);
        }
        return $this->tickets;
    }
}
