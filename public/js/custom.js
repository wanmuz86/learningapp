$(function() {
	var i = $('assignment p').size() + 1;
$('.addassignment').click(function(){
	  $('<p><label for="p_questions"><input type="text" id="p_scnt" size="20" name="p_scnt_' + i +'" value="" placeholder="Input Value" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(assignment);
                i++;
                return false;
});
});