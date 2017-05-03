$(function() {
	var i = $('.add-answer p').size() + 1;
	$('.add-answer').click(function(){

		$('<p><label for="p_answers"><input type="text" id="p_scnt" size="30" name="answers[]" value="" placeholder="Input Answer" /></label> <a href="#" class="remScnt">Remove</a></p>').appendTo($('#div_opt'));
		i++;
		return false;
	});


	$('.remScnt').click(function() { 
		alert('pressed');
		if( i > 2 ) {
			$(this).parents('p').remove();
			i--;
		}
		return false;
	});
});