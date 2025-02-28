<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\FromCollection;

class TicketExport implements FromView
{
    public $tickets;

    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    public function view(): View
    {
        return view('exports.reports', [
            'tickets' => $this->tickets
        ]);
    }

    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     // $drawing->setName('Company Logo');
    //     // $drawing->setDescription('This is my company logo');
    //     $drawing->setPath(public_path('/assets/images/big/rs.png')); // Path to your logo
    //     $drawing->setHeight(50);
    //     $drawing->setCoordinates('A1'); // Place logo at A1 cell

    //     return $drawing;
    // }

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return $this->tickets;
    // }
}
