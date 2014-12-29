
$(document).ready(function()
{
	$('#password').keyup(function()
	{
		$('#password_str').html(password_validator($('#password').val()))
	})	
	
	function password_validator(password){
		
		var strength = 0
		
		//if the password length is less than 6, return message.
		if (password.length < 5) { 
			$('#password_str').removeClass()
			$('#password_str').addClass('short')
			return 'Too short!' 
		}
		
		//if length is 8 characters or more
		if (password.length > 7) strength += 1
		
		//if password contains both lower and uppercase characters
		if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1
		
		//if it has numbers and characters
		if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  strength += 1 
		
		//if it has one special character
		if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))  strength += 1
		
		//if it has two special characters
		if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
		
		//if value is less than 2
		if (strength < 2){
			$('#password_str').removeClass()
			$('#password_str').addClass('weak')
			return 'Weak'			
		} else if (strength == 2){
			$('#password_str').removeClass()
			$('#password_str').addClass('good')
			return 'Good'		
		} else
		{
			$('#password_str').removeClass()
			$('#password_str').addClass('strong')
			return 'Strong'
		}
	}
});