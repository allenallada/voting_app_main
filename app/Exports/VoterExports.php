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
    			'id' => $value->id, 
    			'qr_code' => $value->qr_code, 
    			'name' => $value->name, 
    			'qr_code_student_id' => $value->qr_code_student_id, 
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
            'Database Id',
            'Name',
            'QR no',
            'Student Id',
            'Has Voted',
        ];
    }
}