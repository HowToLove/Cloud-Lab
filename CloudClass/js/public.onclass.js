//flags about canvas
var linetag=0
var recttag=0
/*full mask tabbed content*/
var fullindex=0;
var TabbedContent = {
	init: function() {	
		$(".mp-menu .mp-level .tab_item").mousedown(function() {

			TabbedContent.slideContent($(this),280,600);
			
		});
		$(".mp-menu ul li > a ").mousedown(function() {
			$(".mp-menu ul li > a").removeClass('function-act');
			$(".mp-menu ul li > a").removeClass('active');
			$(this).addClass('function-act');
			$(this).addClass('active');

		});
		
		$( window ).resize(function() {
			var sreenHeight = document.body.clientHeight;
			var initmargin=0;
			var sreenHeight= document.body.clientHeight;
			document.getElementById( "code_exp").style.height =sreenHeight+"px";
			document.getElementById( "video").style.height =sreenHeight+"px";
			document.getElementById( "stuquestion").style.height =sreenHeight+"px";
			document.getElementById( "taskeva").style.height =sreenHeight+"px";
			document.getElementById( "bookreq").style.height =sreenHeight+"px";
			$('.ppt_slide_content').css('height', sreenHeight+'px');
			TabbedContent.slideContent($(fullindex),0,0);
		});

	},
	
	slideContent: function(obj,delaytime,durationtime) {
		fullindex=obj;
		var margin = $(obj).parent().parent().parent().parent().find(".slide_content").height();
		margin = margin * ($(obj).prevAll().length-1 );
		margin = margin * -1;
		$(obj).parent().parent().parent().parent().find(".fullmask").stop(true, true).delay(delaytime).animate({marginTop: margin + "px"}, {duration: durationtime});
	}
}
/*nfull ppt tabbed content*/
var PPTTabbedContent = {
	init: function() {	
		$( window ).resize(function() {
			var sreenwidth = document.body.clientWidth;
			var initmargin=0;
			var sreenheight = document.body.clientHeight;
			$(".bb-item img").css("height",sreenheight+"px");

			if($(".ppt_tabslider").css("marginLeft")!=0+"px"){
				$(".ppt_tabslider").css("marginLeft",-sreenwidth+"px");
			}
		});
		$(document).delegate(".bt_fullsreen",'click', function() {
			PPTTabbedContent.slideToFull($(this));			
		});
		$(document).delegate(".bt_notfullsreen",'click', function() {
			PPTTabbedContent.slideToNotFull($(this));			
		});
	},
	

	slideToFull: function(obj) {
		$(".topmenu").removeClass("topmenu-to-show");
		$(".topmenu").addClass("topmenu-to-hide");
		$(".mp-menu-act").css("background","url(img/menuf.png) no-repeat");
		$("#code_exp .nav-tabs").css("margin-left",50+"px");
		$("#code_exp .nav-tabs").css("margin-top",10+"px");
		$("#taskeva .taskq").css("margin-top",0+"px");
		
		var margin = $(".ppt_slide_content").width();
		margin = margin * (1);
		margin = margin * -1;
		
		$(".ppt_tabslider").stop().animate({
			marginLeft: margin+ "px"
		}, {
			duration: 600
		});
	},
	slideToNotFull: function(obj) {
		$(".topmenu").addClass("topmenu-to-show");
		$(".topmenu").removeClass("topmenu-to-hide");
		$("#code_exp .nav-tabs").css("margin-left",10+"px");
		$("#code_exp .nav-tabs").css("margin-top",70+"px");
		$("#taskeva .taskq").css("margin-top",70+"px");
		$(".mp-menu-act").css("background","url(img/menu.png) no-repeat");
		var margin = $(".ppt_slide_content").width();
		margin = margin * (0);
		margin = margin * 1;
		
		$(".ppt_tabslider").stop().animate({
			marginLeft: margin+ "px"
		}, {
			duration: 600
		});
	}
}
/*nfull mask tabbed content*/
var nfullpptindex=0;
var NotFullScreenTabbedContent = {
	init: function() {	
		$( window ).resize(function() {
			var pptheight = $('.ppt_tabslider').height()-55;
			$(".nfull_tabbed_content").css("height",pptheight+"px"); 
			var pptwidth = $('.nfull_tabbed_content').height()*4/3;
			$(".nfull_slide_content").css("width",pptwidth+"px");  
			$(".pptm canvas").attr("width",pptwidth+"px");  
			$(".pptm canvas").attr("height",pptheight+"px"); 
			$('.pptm').css('width',pptwidth)
			$('.pptm').css('height',pptheight) 
			var sreenwidth = document.body.clientWidth;
			var nfullrwidth=sreenwidth-pptwidth-210;
			$(".nfullr").css("width",nfullrwidth+"px");
			$('.chat-body').css('height',pptheight-180)
			NotFullScreenTabbedContent.slideContent($(nfullpptindex),0);
		});

		$(document).delegate(".nfull_ppt_tabs .tab_item",'click', function() {
			//Added by zr
			recttag=0
			$('canvas').css('cursor','default')
			linetag=0
			$('canvas').css('cursor','default')
			//Added by zr end
			nfullpptindex=this;
			NotFullScreenTabbedContent.slideContent($(this),500);
			$(this).addClass('ppt-list-active')
			$(this).prevAll().removeClass('ppt-list-active')
			$(this).nextAll().removeClass('ppt-list-active')
			var id = $(this).attr('id').substring(9)
			var height = (id-2)*($('.nfull_ppt_tabs .tab_item').height()+5)
			$('.nfull_ppt_tabs').animate({scrollTop:height})

			//此处插入Ajax
			$.ajax({
				url: 'main/retrieveRemark.php',
				type: 'POST',
				dataType: 'json',
				data: {
					'classid' : classid,
					'charpter' : charpter,
					'lesson' : lesson,
					'pagenum' : id				
				},
				beforeSend: function(XMLHttpRequest) {},
				success: function(data) {
					console.log(data);
					$('.note-content p').html(data.remark)
				},
				complete: function(XMLHttpRequest, textStatus) {},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
				}
			})
			//sessionStorage.userName = $("#username").val();
			//sessionStorage.userType = data.userType;
			var myname =sessionStorage.userName		
			var mymessage = id

			//prepare json data
			var msg = {
				message: mymessage,
				name: sessionStorage.userName,		
				userType: sessionStorage.userType,//1 stands for the teacher and 2 stands for the student
				msgType: 'slidePPT',		
				classId:sessionStorage.classId
			};
			//convert and send data to server
			websocket.send(JSON.stringify(msg));
		});
$(document).delegate(".bt-to-ppt",'click', function() {

	$(".progress_bar").addClass("progress-to-hide");
	$(".mp-menu-act").css("margin-left",0+"px");
	$("#nav-left").css("margin-left",30+"px");
	$(".mp-menu ul li .function2").addClass('function-act');
	$(".mp-menu ul li .function2").addClass('active');
	$("#prepare-class").css("marginTop",55+"px");
});
$(document).delegate(".choose-to-ppt ul li",'click', function() {
	$(".progress_bar").addClass("progress-to-hide");
	$(".mp-menu-act").css("margin-left",0+"px");
	$("#nav-left").css("margin-left",30+"px");
	$(".mp-menu ul li .function2").addClass('function-act');
	$(".mp-menu ul li .function2").addClass('active');
	$("#prepare-class").css("marginTop",55+"px");

});
},

slideContent: function(obj,durationtime){

	var margin = $(obj).parent().parent().find(".nfull_slide_content").width();
	margin = margin * $(obj).prevAll().size();
	margin = margin * -1;

	$(obj).parent().parent().find(".nfull_tabslider").stop().animate({
		marginLeft: margin + "px"
	}, {
		duration: durationtime
	});
}
}

$(document).ready(function() {
	new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger' ) );
	var sreenheight = document.body.clientHeight;
	$(".bb-item img").css("height",sreenheight+"px");
	//Page.init();
	
	var sreenHeight= document.body.clientHeight;
	document.getElementById( "code_exp").style.height =sreenHeight+"px";
	document.getElementById( "video").style.height =sreenHeight+"px";
	document.getElementById( "stuquestion").style.height =sreenHeight+"px";
	document.getElementById( "taskeva").style.height =sreenHeight+"px";
	document.getElementById( "bookreq").style.height =sreenHeight+"px";
	$('.ppt_slide_content').css('height', sreenHeight+'px');
	TabbedContent.init();
	PPTTabbedContent.init();
	NotFullScreenTabbedContent.init();
	var pptheight = $('.ppt_tabslider').height()-55;
	var sreenwidth = document.body.clientWidth;
	$(".nfull_tabbed_content").css("height",pptheight+"px"); 
	var pptwidth = $('.nfull_tabbed_content').height()*4/3;
	var pptwidth1 = $('.nfull_tabbed_content').width()-190;
	var pptheight1 = pptwidth1*3/4;
	$(".nfull_slide_content").css("width",pptwidth+"px");  
	//$(".pptm").css("width",pptwidth+"px");deleted by zr

	// if(pptwidth1>pptwidth)
	// {


	// }
	// else{
	// //  $(".nfull_slide_content").css("width",pptwidth1+"px");  
	//   //$(".pptm").css("width",pptwidth1+"px"); 

	// }

	var nfullrwidth=sreenwidth-pptwidth-210;
	$(".nfullr").css("width",nfullrwidth+"px");
});
//Added by zr
$(document).ready(function(){
	$(".qinfo-body li").each(function(){
		if($(this).attr('id').substring(6)%3==1){
			$(this).css('background-color','#fff')
		}else if($(this).attr('id').substring(6)%3==2){
			$(this).css('background-color','#fffac2')
		}else{
			$(this).css('background-color','#f2f2ec')
		}
	})
	
	$('.qinfo-item-header').click(function(){
		var mythis = $(this)
		var parent = $(this).parent()
		mythis.next().toggle('normal');
		if(parent.attr('class')=='solved'){
			if(parent.css('box-shadow')=='none'){
				parent.css('box-shadow','6px 0 #97ce68 inset')
			}else{
				parent.css('box-shadow','none')
			}
		}else if(parent.attr('class')=='submitted'){
			if(parent.css('box-shadow')=='none'){
				parent.css('box-shadow','6px 0 #94846e inset')
			}else{
				parent.css('box-shadow','none')
			}
		}else{
			if(parent.css('box-shadow')=='none'){
				parent.css('box-shadow','6px 0 #95b4fa inset')
			}else{
				parent.css('box-shadow','none')
			}
			if(parent.attr('class')=='unsolved'){
				parent.removeClass('unsolved').addClass('solving')
			}else{
				parent.removeClass('solving').addClass('unsolved')
			}
		}
	})
	$('.qinfo-item-body button').click(function(){//数据应与后台交互
		$(this).parent().parent().removeClass('solving unsolved').addClass('solved').css('box-shadow','6px 0 #97ce68 inset')
		$(this).parent().html('<p class="qinfo-item-answer">这是回答xxxxxxxxxx</p>')
	})

	//讨论区ctrl+enter发送
	$('.chat-footer textarea').keydown(function(e){
		if(e.which == 13 && e.ctrlKey){
			$('.chat-footer button').click()
			$('.chat-footer textarea').val('')
		}
	})
})