$(document).ready(function () {
	var height = $('.tab.show').height()+50;
	$('#tab-container').height(height);

	//主Tab切换
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
		height = $(content).height()+50;
		$('#tab-container').height(height);


	});

	//图片灰色和彩色切换
	$('.subtab-a').mouseover(function(){
		$(this).find('.cover').css("display","none");
	});

	$('.subtab-a').mouseout(function(){
		$(this).find('.cover').css("display","inline-block");
	});

	//Subtab切换（课程列表与课程详情之间）
	$('.subtab-a').click(function(){
		var href = $(this).attr('href');
		var parent = $(this).parents('.subtab');
		var info = href + '-info';
		parent.removeClass('show').addClass('hideright');
		parent.prev().removeClass('hideleft').addClass('show');

		$(info).addClass('show');
		$(info).prevAll().addClass('hideleft');
		$(info).nextAll().addClass('hideright');

		if($(info).prevAll().length==0){
			$('.btn-prev').css('opacity','.2');
		}
		if($(info).nextAll().length==0){
			$('.btn-next').css('opacity','.2');
		}

		height=$(info).height()+50;
		$('.subtab-container').height(height);
	});

	$('.btn-close').click(function(){
		var parent = $(this).parents('.subtab');
		parent.addClass('hideleft').removeClass('show');
		parent.next().addClass('show').removeClass('hideright');
		$('.btn-prev').css('opacity','1');
		$('.btn-next').css('opacity','1');
		$('.images').removeClass('hideright').removeClass('hideleft').removeClass('show');
	});

	//课程详情之间切换
	$('.btn-next').click(function(){
		var ithis=$('.images.show');
		
		if(ithis.nextAll().length==0){
			$('.btn-next').css('opacity','.2');
		}
		else{
			$('.btn-prev').css('opacity','1');
			$('.btn-next').css('opacity','1');
			$(ithis).addClass('hideleft').removeClass('show');
			$(ithis).next().addClass('show').removeClass('hideright');
			forbidbtn();
		}
	});
	$('.btn-prev').click(function(){
		var ithis=$('.images.show');
		if(ithis.prevAll().length==0){
		}
		else{
			$('.btn-prev').css('opacity','1');
			$('.btn-next').css('opacity','1');
			$(ithis).addClass('hideright').removeClass('show');
			$(ithis).prev().addClass('show').removeClass('hideleft');
			forbidbtn();
		}
	});

	//登录注册切换
	$('#btn-register').click(function(){
		$('#form-login').removeClass('show').addClass('hideleft');
		$('#form-register').removeClass('hideright').addClass('show');
	})
	$('#rbtn-back').click(function(){
		$('#form-login').removeClass('hideleft').addClass('show');
		$('#form-register').removeClass('show').addClass('hideright');
	})

	//判断左右箭头是否为灰
	function forbidbtn(){
		var ithis=$('.images.show');
		if(ithis.prevAll().length==0){
			$('.btn-prev').css('opacity','.2');
		}
		if(ithis.nextAll().length==0){
			$('.btn-next').css('opacity','.2');
		}
	}

	//AJAX请求
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