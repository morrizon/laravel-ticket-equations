<?php

namespace App\Commands;

class CreateEquations
{
    private $numberOfTicket;

    public function __construct($numberOfTicket)
    {
        $this->numberOfTicket = $numberOfTicket;
    }

    public function getNumberOfTicket()
    {
        return $this->numberOfTicket;
    }
}

