$(document).ready(function(){
	var noteflag=0
	var canvas,context
	var marginLeft,pageNum
	var startx,starty,endx,endy
	var pstartx,pstarty,pendx,pendy
	$('#take-note').click(function(){
		if(noteflag){
			noteflag=0
			$('canvas').css('cursor','default')
		}else{
			noteflag=1
			$('canvas').css('cursor','url("img/pen.cur"),pointer')
		}
		marginLeft = -parseInt($('.nfull_tabslider').css('margin-left'))
		pageNum = marginLeft/($('.nfull_slide_content').width()) + 1
		canvas = document.getElementById('canvas-'+pageNum)
		context = canvas.getContext("2d")
	})
	$(document).delegate('canvas','mousedown',function(e){
		startx = e.pageX - 190
		starty = e.pageY - 55
	})
	$(document).delegate('canvas','mouseup',function(e){
		endx = e.pageX - 190
		endy = e.pageY - 55
		if(noteflag){
			draw_line()
			take_note()
			noteflag=0
			$('canvas').css('cursor','default')
		}
	})
	function draw_line(){
		context.strokeStyle = "black"
		context.lineJoin = "round"
		context.lineWidth = 5
		context.beginPath()
		context.moveTo(startx, starty)
		context.lineTo(endx, endy);
		context.closePath();
		context.stroke();
		ptrans1()
	}
	function ptrans1(){		
		pstartx = startx/$('canvas').width()
		pstarty = starty/$('canvas').height()
		pendx = endx/$('canvas').width()
		pendy = endy/$('canvas').height()
	}
	var notecount = 0
	function take_note(){
		notecount++
		var newnote = '<textarea class="note" id="note-'+notecount+'" style="top:'+pendy*100+'%;left:'+pendx*100+'%"></textarea>'
		$('#canvas-'+pageNum).parent().append(newnote)
		$('.note').focus()
	}
	$(document).delegate('.note','blur',function(){//每次blur都要保存笔记内容对应相应的id
		var content = $(this).val()
		var id = 'sign-'+$(this).attr('id')
		var left = parseInt($(this).css('left'))+5
		var top = parseInt($(this).css('top'))-18
		var pleft = left/$('canvas').width()
		var ptop = top/$('canvas').height()
		if($('#'+id).length==0){//如果元素不存在则创建元素
			var newnotesign = '<div class="notesign" id="'+id+'" title="'+content+'" style="top:'+ptop*100+'%;left:'+pleft*100+'%"></div>'
			$(this).parent().append(newnotesign)
		}else{//如果元素存在则直接改变内容
			$('#'+id).attr('title',content).show('normal')
		}
		$(this).hide('normal');
		var insert_id =$(this).attr("insert_id");
		if(insert_id==null){
			insert_id = -1;
		}
		
		//added by lanxiang
		var mythis = $(this);
		$.ajax({
			type : 'POST',
			url : 'main/studentOnClass.php',
			timeout : 6000,
			data : {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'pleft' : pleft,
				'ptop' : ptop,
				'content' : content,
				'pagenum':pageNum,
				'isInsert':insert_id,
				'pstartx' : pstartx,
				'pstarty' : pstarty,
				'pendx' : pendx,
				'pendy' : pendy
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				if(data.insert_id!=-1){
					mythis.attr('insert-id', data.insert_id);
				}
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		})
	});
	//
	$(document).delegate('.notesign','click',function(){
		var id = $(this).attr('id').substring(5)
		$('#'+id).show('normal').focus()
		$(this).hide('normal')
	})

	$('.chat-footer button').click(function(){
		var content = $('.chat-footer textarea').val()
		if(content.length!=0){
			var newchat = '<li class="student ego"><div class="head"></div><div class="chat-content"><span>'+content+'</span><div class="arrow"></div></div></li>'
			$('.chat-body-list').append(newchat)
			$('.chat-footer textarea').val('')
			var height = $('.chat-body-list').height()-$('.chat-body').height()+10
			$('.chat-body').animate({scrollTop:height})
			$('.ego .chat-content').css('width',$('.nfullr').width()-118)
			var msg = {
			message: content,
			name: sessionStorage.userName,		
			userType: sessionStorage.userType,//1 stands for the teacher and 2 stands for the student
			msgType: 'onlineQuestion',		
			classId:sessionStorage.classId
		};
		//convert and send data to server
		websocket.send(JSON.stringify(msg));

		}
	})
	//讨论区高度
	var pptheight = $('.ppt_tabslider').height()-55;	
	$('.chat-body').css('height',pptheight-250)
	$('.ego .chat-content').css('width',$('.nfullr').width()-118)
	$( window ).resize(function(){
		var pptheight = $('.ppt_tabslider').height()-55;	
		$('.chat-body').css('height',pptheight-250)
		$('.ego .chat-content').css('width',$('.nfullr').width()-118)
		var height = $('.chat-body-list').height()-$('.chat-body').height()+10
		$('.chat-body').animate({scrollTop:height})
	})
})