$(document).ready(function(){
	$('#position').change(function(){
		if($(this).val() === 'OSA'){
			$('#student_id').val('OSA Admin').prop('disabled', true);
		} else {
			$('#student_id').val('').removeAttr('disabled');
		}
	})

	$('#form').submit(function(){
		$('#student_id').removeAttr('disabled');
	})
});