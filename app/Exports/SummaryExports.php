<?php	
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Candidate;
use App\PartyList;

class SummaryExports implements FromCollection, WithHeadings
// class SummaryExports implements \Maatwebsite\Excel\Concerns\FromCollection, WithHeadings,
{
	// public function collection()
	// {
	// 	$summary = [];
	// 	// use Exportable;

	// 	// array_push($summary, 'President Candidate Summary');
	// 	$PCandidates =  Candidate::withCount('vote')->where('position', 'President')->orderBy('vote_count', 'desc')->get();

	// 	foreach ($PCandidates  as $value) {
	// 		array_push($summary, [
	// 			"id" => $value->id,
	// 		     "student_id" => $value->student_id,
	// 		     "name" => $value->name,
	// 		     "partylist_id" => $value->partylist_id,
	// 		     "section" => $value->section,
	// 		     "position" => $value->position,
	// 		     "vote_count" => $value->vote_count,
	// 		]);
	// 	}
	// 	// dd($summary);
	// 	// // $PCandidates s
	// 	return collect([
	// 		$summary
	// 	]);
	// }
	public function collection()
    {
    	$summary = [['']];

		$PCandidates =  Candidate::withCount('vote')->where('position', 'President')->orderBy('vote_count', 'desc')->get();
		$VCandidates =  Candidate::withCount('vote')->where('position', 'Vice President')->orderBy('vote_count', 'desc')->get();
		$SCandidates =  Candidate::withCount('vote')->where('position', 'Secretary')->orderBy('vote_count', 'desc')->get();

		foreach ($PCandidates  as $value) {
			$partylistName = $value->partylist_id === 0 ? "Independent" : PartyList::find($value->partylist_id)->first()->name;
			// print_r($partylistName );
			array_push($summary, [
				"id" => $value->id,
			    "student_id" => $value->student_id,
			    "name" => $value->name,
			    "partylist_id" => $partylistName,
			    "section" => $value->section,
			    "position" => $value->position,
			    "vote_count" =>  $value->vote_count === 0 ? '0' : $value->vote_count,
			]);
		}

		array_push($summary, ['']);

		foreach ($VCandidates  as $value) {
			$partylistName = $value->partylist_id === 0 ? "Independent" : PartyList::find($value->partylist_id)->first()->name;
			array_push($summary, [
				"id" => $value->id,
			    "student_id" => $value->student_id,
			    "name" => $value->name,
			    "partylist_id" => $partylistName,
			    "section" => $value->section,
			    "position" => $value->position,
			    "vote_count" => $value->vote_count === 0 ? '0' : $value->vote_count,
			]);
		}

		array_push($summary, ['']);
		
		foreach ($SCandidates  as $value) {
			$partylistName = $value->partylist_id === 0 ? "Independent" : PartyList::find($value->partylist_id)->first()->name;
			array_push($summary, [
				"id" => $value->id,
			    "student_id" => $value->student_id,
			    "name" => $value->name,
			    "partylist_id" => $partylistName,
			    "section" => $value->section,
			    "position" => $value->position,
			    "vote_count" =>  $value->vote_count === 0 ? '0' : $value->vote_count,
			]);
		}

		$summaryCol = collect(
			$summary
		);

		return $summaryCol;
    }

    public function headings(): array
    {
        return [
            'Database Id',
            'Student Id',
            'Name',
            'PartyList',
            'Section',
            'Position',
            'Vote Count',
        ];
    }
}