
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

        var bSelected = false;

        $('#selectAll').click(function(){
            if(bSelected === false) {
                $('.tbd').prop('checked', 'checked');
                bSelected = true;
            } else {
                $('.tbd').prop('checked', '');
                bSelected = false;
            }
        })

// alert('wew');

