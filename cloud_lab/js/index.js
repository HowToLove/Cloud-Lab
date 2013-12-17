$(document).ready(function () {

	$('.tab-a').click(function(){
		$('.tab-a').removeClass('active-a');
		$(this).addClass('active-a');

		var href=$(this).attr('href');
		var content=href+"-content";
		var logo=href+"-logo"

		$('.tab-logo').removeClass('active-logo hideprev hidenext');
		$(logo).prevAll().addClass('hideprev');
		$(logo).nextAll().addClass('hidenext');
		$(logo).addClass('active-logo');

		$('.tab').removeClass('show hideleft hideright');
		$(content).prevAll().addClass('hideleft');
		$(content).nextAll().addClass('hideright');
		$(content).addClass('show');

	});
	$('.subtab section a').mouseover(function(){
		$(this).find('.cover').css("display","none");
	});
	$('.subtab section a').mouseout(function(){
		$(this).find('.cover').css("display","inline-block");
	});

	$.ajaxSetup({timeout : 6000});
	// 登录ajax请求
	$('#btn-login').click(function() {
		// if(checkForm()) {
			$.ajax({
				type : "POST",
				url : "http://localhost/cloud_lab/main/login.php",
				data : {
					username : $("#username").val(),
					password : $("#password").val()
				},
				dataType : 'json',
				beforeSend: function(XMLHttpRequest){
				},
				success : function(data) {
					switch(data.loginStatus){
					case -1:
						break;
					case 0:
						alert("用户名不能为空！");
						break;
					case 1:
						alert("密码不能为空！");
						break;
					case 2:
						alert("登陆成功！");
						break;
					case 3:
						alert("用户名或密码错误！");
						break;
					}
				},
				complete: function(XMLHttpRequest, textStatus){
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status
						+ " " + textStatus);
				}
			});
			return false;
		// }
	});

	// 注册ajax请求
	$('#rbtn-register').click(function() {
		// if(checkForm()){
			$.ajax({
				type : "POST",
				url : "http://localhost/cloud_lab/main/register.php",
				data : {
					email : $("#remail").val(),
					username : $("#rusername").val(),
					password : $("#rpassword").val(),
					password_confrim : $("#rpassword-confirm").val(),
					idnumber : $("#ridnumber").val(),
					birthday : $("#rbirthday").val(),
					captcha : $("#rcaptcha").val()
				},
				dataType : 'text',
				beforeSend: function(XMLHttpRequest){
				},
				success : function(data) {
					if(data == "register success") {
						alert("注册成功！")
					}
				},
				complete: function(XMLHttpRequest, textStatus){
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status
						+ " " + textStatus);
				}
			});
			return false;
		// }
	});
});