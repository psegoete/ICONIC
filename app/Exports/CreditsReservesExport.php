<?php

namespace CreatyDev\Exports;

use CreatyDev\Domain\CreditsReserve;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CreditsReservesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    

    public function __construct($from,$to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    
    
    public function headings(): array
    {
        return [
            'First name',
            'Last name',
            'Date',
            'Credits', 
            'Price',
        ];
    }

    public function collection()
    {
        $data =  CreditsReserve::whereBetween('credits_reserves.updated_at', [$this->from, $this->to])->where([['credits_reserves.company_id', '=', checkDomain()], ['credits_reserves.status', '=', 1], ['credits_reserves.action', '=', 'tuning']])
        ->Join('users', 'users.id', '=', 'credits_reserves.user_id')
        ->select(
            'users.first_name as First name',
            'users.last_name as Last name',
            'credits_reserves.updated_at as Date',
            'credits_reserves.credits as Credits',
            DB::raw('CONCAT("R", credits_reserves.amount) AS Price'),
        )
        ->orderByRaw('credits_reserves.updated_at desc')
        ->get();
    
        return $data;
    }
    
}
