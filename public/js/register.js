$(document).ready(function(){
	let currentValue = "";
	$('#position').change(function(){
		if($(this).val() === 'OSA'){
			$('#student_id').prev().text('University Position');
			$('#student_id').val('OSA Admin').prop('disabled', true);
			currentValue = $(this).val();
		} else {
			if(currentValue === 'OSA'){
				$('#student_id').val('').removeAttr('disabled');
			} else {
				$('#student_id').removeAttr('disabled');
			}
			$('#student_id').prev().text('Student Number');
		}
	})

	$('#form').submit(function(){
		$('#student_id').removeAttr('disabled');
	})
});