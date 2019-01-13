$('.confirmPassword').on('submit', function(event){
	if (confirm("Are you sure you want to delete?")) {
  		return true;
	} else {
		event.preventDefault();
		return false;
	}
});