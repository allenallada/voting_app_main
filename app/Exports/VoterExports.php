<?php	
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
// use App\Candidate;
use App\Voter;

// use App\PartyList;

class VoterExports implements FromCollection, WithHeadings
{
	public function collection()
    {
    	$voters = Voter::all();
    	$export = [['']];

    	foreach ($voters as $value) {
    		array_push($export, [
    			'id' => $value->id, 
    			'qr_code' => $value->qr_code, 
    			'name' => $value->name, 
    			'qr_code_id' => $value->qr_code_id, 
    			'qr_code_student_id' => $value->qr_code_student_id, 
    			'has_voted' => $value->has_voted === 1? 'voted' : 'not voted',
    			'mac_address' => $value->mac_address
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
            'Database Id',
            'QR Code',
            'Name',
            'QR no',
            'Student Id',
            'Has Voted',
            'Mac Address',
        ];
    }
}