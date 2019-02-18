<?php	
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Voter;

class VoterExports implements FromCollection, WithHeadings
{
	public function collection()
    {
    	$voters = Voter::all();
    	$export = [['']];

    	foreach ($voters as $key => $value) {
    		array_push($export, [
                'no' => $key + 1, 
    			'qr_code' => $value->qr_code, 
    			'has_voted' => $value->has_voted === 1? 'voted' : 'not voted',
    		]);
    	}

    	$exportCol = collect(
			$export
		);

		return $exportCol;
    }

    public function headings(): array
    {
        return [
            'No.',
            'QR Code',
            'Has Voted',
        ];
    }
}