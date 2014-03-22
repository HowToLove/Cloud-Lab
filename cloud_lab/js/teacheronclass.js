//about canvas added by zr
$(document).ready(function(){
	var canvas,context
	var marginLeft,pageNum
	$('#draw-line').click(function(){
		if(linetag){
			linetag=0
			recttag=0
			$('canvas').css('cursor','default')
			$('#draw-line').css('opacity',0.5)
			$('#draw-rect').css('opacity',0.5)
		}else{
			linetag=1
			recttag=0
			$('canvas').css('cursor','url("img/pen.cur"),pointer')
			$('#draw-line').css('opacity',1)
			$('#draw-rect').css('opacity',0.5)
		}
		//获取当前PPT的页数
		marginLeft = -parseInt($('.nfull_tabslider').css('margin-left'))
		pageNum = marginLeft/($('.nfull_slide_content').width()) + 1
		canvas = document.getElementById('canvas-'+pageNum)
		context = canvas.getContext("2d")
	})

	$('#draw-rect').click(function(){
		if(recttag){
			recttag=0
			linetag=0
			$('canvas').css('cursor','default')
			$('#draw-line').css('opacity',0.5)
			$('#draw-rect').css('opacity',0.5)
		}else{
			recttag=1
			linetag=0
			$('canvas').css('cursor','url("img/cross.cur"),crosshair')
			$('#draw-line').css('opacity',0.5)
			$('#draw-rect').css('opacity',1)
		}
		//获取当前PPT的页数
		marginLeft = -parseInt($('.nfull_tabslider').css('margin-left'))
		pageNum = marginLeft/($('.nfull_slide_content').width()) + 1
		canvas = document.getElementById('canvas-'+pageNum)
		context = canvas.getContext("2d")
	})

	var startx,starty,endx,endy
	var pstartx,pstarty,pendx,pendy

	$('canvas').live('mousedown',function(e){
		startx = e.pageX - 190
		starty = e.pageY - 55
	})
	$('canvas').live('mouseup',function(e){
		endx = e.pageX - 190
		endy = e.pageY - 55
		if(recttag){
			draw_rect()
		}
		if(linetag){
			draw_line()
		}
	})
	function draw_line(){
		context.strokeStyle = "red"
		context.lineJoin = "round"
		context.lineWidth = 10
		context.beginPath()
		context.moveTo(startx, starty)
		context.lineTo(endx, endy);
		context.closePath();
		context.stroke();
		ptrans1()
	}
	function draw_rect(){
		context.strokeStyle = "red"
		context.lineJoin = "round"
		context.lineWidth = 10
		context.strokeRect(startx,starty,endx-startx,endy-starty);
		ptrans2()
	}
	function ptrans1(){		
		pstartx = startx/$('canvas').width()
		pstarty = starty/$('canvas').height()
		pendx = endx/$('canvas').width()
		pendy = endy/$('canvas').height()

		var mymessage = pageNum+" "+pstartx+" "+pstarty+" "+pendx+" "+pendy;
		var msg = {
			message: mymessage,
			name: sessionStorage.userName,		
			userType: sessionStorage.userType,//1 stands for the teacher and 2 stands for the student
			msgType: 'drawLine',		
			classId:sessionStorage.classId
		};
		//convert and send data to server
		websocket.send(JSON.stringify(msg));
	}
	function ptrans2(){		
		pstartx = startx/$('canvas').width()
		pstarty = starty/$('canvas').height()
		pendx = endx/$('canvas').width()
		pendy = endy/$('canvas').height()
		
		var mymessage = pageNum+" "+pstartx+" "+pstarty+" "+pendx+" "+pendy;
		var msg = {
			message: mymessage,
			name: sessionStorage.userName,		
			userType: sessionStorage.userType,//1 stands for the teacher and 2 stands for the student
			msgType: 'drawRect',		
			classId:sessionStorage.classId
		};
		//convert and send data to server
		websocket.send(JSON.stringify(msg));
	}

	//讨论区高度
	var pptheight = $('.ppt_tabslider').height()-55;	
	$('.chat-body').css('height',pptheight-480)

	$('.chat-footer button').click(function(){
		var content = $('.chat-footer textarea').val()
		if(content.length!=0){
			var newchat = '<li class="teacher ego"><div class="head"></div><div class="chat-content"><span>'+content+'</span><div class="arrow"></div></div></li>'
			$('.chat-body-list').append(newchat)
			$('.chat-footer textarea').val('')
			var height = $('.chat-body-list').height()-$('.chat-body').height()+10
			$('.chat-body').animate({scrollTop:height})

			var msg = {
				message: content,
				name: sessionStorage.userName,		
			userType: sessionStorage.userType,//1 stands for the teacher and 2 stands for the student
			msgType: 'onlineQuestion',		
			classId:sessionStorage.classId
		};
		console.log("teacher message:"+msg);
		//convert and send data to server
		websocket.send(JSON.stringify(msg));

	}
})
})