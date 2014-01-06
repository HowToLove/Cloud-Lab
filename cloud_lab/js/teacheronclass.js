
/*full mask tabbed content*/
var TabbedContent = {
	init: function() {	
		$(".tab_item").mousedown(function() {

			TabbedContent.slideContent($(this));
			
		});
		$(".mp-menu ul li > a ").mousedown( function() {
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
document.getElementById( "taskeva").style.height =sreenHeight+"px";
document.getElementById( "bookreq").style.height =sreenHeight+"px";
$('.ppt_slide_content').css('height', sreenHeight+'px');
	if($(".fullmask").css("marginTop")!=0+"px")
	{
	
	 $(".fullmask").css("marginTop",-sreenHeight+"px");
	}
});
	
	},
	
	slideContent: function(obj) {
		
		var margin = $(obj).parent().parent().parent().parent().find(".slide_content").height();
		margin = margin * ($(obj).prevAll().length-1 );
		margin = margin * -1;
		$(obj).parent().parent().parent().parent().find(".fullmask").stop(true, true).delay(280).animate({marginTop: margin + "px"}, {duration: 600});
		
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

	if($(".ppt_tabslider").css("marginLeft")!=0+"px")
	{
	
	 $(".ppt_tabslider").css("marginLeft",-sreenwidth+"px");
	}
});
		$(".bt_fullsreen").live('click', function() {

			PPTTabbedContent.slideToFull($(this));
			
		});
		$(".bt_notfullsreen").live('click', function() {

			PPTTabbedContent.slideToNotFull($(this));
			
		});
	},
	

	slideToFull: function(obj) {
	$(".topmenu").removeClass("topmenu-to-show");
	$(".topmenu").addClass("topmenu-to-hide");
		$(".mp-menu-act").css("background","url(img/menuf.png) no-repeat");
		
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
		
		$(".mp-menu-act").css("background","url(img/menu.png) no-repeat");
		var margin = $(obj).parent().parent().parent().parent().parent().find(".ppt_slide_content").width();
		margin = margin * (0);
		margin = margin * 1;
		
		$(obj).parent().parent().parent().parent().find(".ppt_tabslider").stop().animate({
			marginLeft: margin+ "px"
		}, {
			duration: 600
		});
	}
}
/*nfull mask tabbed content*/
var NotFullScreenTabbedContent = {
	init: function() {	
$( window ).resize(function() {
var pptheight = $('.ppt_tabslider').height()-55;
$(".nfull_tabbed_content").css("height",pptheight+"px"); 
   var pptwidth = $('.nfull_tabbed_content').height()*4/3;
 $(".nfull_slide_content").css("width",pptwidth+"px");  
	$(".pptm").css("width",pptwidth+"px");  
	var sreenwidth = document.body.clientWidth;
	var nfullrwidth=sreenwidth-pptwidth-210;
	$(".nfullr").css("width",nfullrwidth+"px");  
	
});
	
		$(".nfull_ppt_tabs .tab_item").live('click', function() {
			NotFullScreenTabbedContent.slideContent($(this));
		});
		$(".bt-to-ppt").live('click', function() {
	     	
			$(".progress_bar").addClass("progress-to-hide");
			$(".mp-menu-act").css("display","block");
		});
		$(".choose-to-ppt ul li").live('click', function() {
	     	
			$(".progress_bar").addClass("progress-to-hide");
			$(".mp-menu-act").css("display","block");
			
		});
	},
	
	slideContent: function(obj){
		
		var margin = $(obj).parent().parent().find(".nfull_slide_content").width();
		margin = margin * $(obj).prevAll().size();
		margin = margin * -1;
		
		$(obj).parent().parent().find(".nfull_tabslider").stop().animate({
			marginLeft: margin + "px"
		}, {
			duration: 500
		});
	}
}

$(document).ready(function() {
var sreenHeight= document.body.clientHeight;
document.getElementById( "code_exp").style.height =sreenHeight+"px";
document.getElementById( "video").style.height =sreenHeight+"px";
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
	$(".nfull_slide_content").css("width",pptwidth+"px");  
	$(".pptm").css("width",pptwidth+"px");  
	 var nfullrwidth=sreenwidth-pptwidth-210;
	$(".nfullr").css("width",nfullrwidth+"px");  
});