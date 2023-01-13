<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TicketExport implements FromCollection
{
    public $tickets;

    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->tickets;
    }
}
