$(document).ready(function(){
	$("#username").focus();
	
	flag = true;
	$("#log").submit(function(){
		//alert(1111);

		if($("#username").val()=="" && $("#password").val()=="")
		{
			$("#err_span").hide().addClass('err_border').html("Enter a valid username and password").fadeIn(300);
			flag = false;
		}
		else if($("#username").val()=="" || $("#password").val()=="")
		{
			$("#err_span").hide().addClass('err_border').html("Either username/password is incorrect").fadeIn(300);
			flag = false;
		}
		else if($("#username").val()!="" && $("#password").val()!="")
		{
			
			flag=true;
		}
		
		if(flag)
		{
			return true;
		}
		else
		{
			return false;
		}

			
	});


	$("#reset").click(function(){
		$("#err_span").html("");
		$("#err_span").removeClass("err_border");
	});
	
});