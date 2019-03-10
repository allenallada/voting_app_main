
function validateMyForm(smsg){
	r = confirm(smsg);
	if(r === true){
		return true
	}
	return false;
}


$('#deleteSelectedBtn').click(function(){
	if($('.tbd:checked').length === 0) {
		return alert('No voters selected!');
	}
	$('#deleteSelected').submit();
});

// alert('wew');

