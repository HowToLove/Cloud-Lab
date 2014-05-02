var classes;
var urls, videos;
var classid, classname, imgurl, charpter, coursename, lesson, description, studentsnum, percent;
$(function() {

	// 当页面准备好时请求
	$.ajax({
		type : 'GET',
		url : 'main/classofteacher.php',
		timeout : 6000,
		dataType : 'json',
		beforeSend : function(XMLHttpRequest) {},
		success : function(data) {
			classes = data.classes;
			$("#classes-container").empty();
			for(var i=0; i<classes.length; i++) {
				classid = classes[i].classid;
				classname = classes[i].coursename;
				imgurl = classes[i].imgurl;
				coursename = classes[i].coursename;
				charpter = classes[i].progress.charpter;
				lesson = classes[i].progress.lesson;
				description = classes[i].description;
				studentsnum = classes[i].studentsnum;
				percent = classes[i].progress.percent;
				var classdiv = 
				"<div class='fixedtextalign'>\
				<div class='class-list' style='text-align:left'>\
				<div class='class-list-left'>\
				<div class='class-img'><img src=main/"+imgurl+">\
				<div class='arrow-right'></div>\
				</div>\
				<a href='#prepare-class' data-slide='next' data-toggle='tab'>\
				<h3 class='underline textadjust' id='classes_h' data-classid='"+classid+"'>"+coursename+"</h3>\
				</a>\
				<p style='color:#000' data-charpter="+charpter+" data-lesson="+lesson+">已上至第"+charpter+"章第"+lesson+"节</p>\
				<a class='button-blue indicator-hide bt-to-ppt' href='#prepare-class' role='button' data-toggle='tab' data-slide-to='2' data-classid='"+classid+"'>立即上课</a>\
				</div>\
				<div class='class-list-right'>\
				<div class='class-questions'>\
				<p>未解答疑问</p>\
				<span>1</span>\
				<div class='arrow-bottom'></div>\
				</div>\
				<p class='underline'>"+description+"</p>\
				<p>上课人数："+studentsnum+"人</p>\
				</div>\
				<div class='class-progress'>\
				<div class='progress-cover' style='width:"+Math.round(percent*100)+"%'></div>\
				<p>"+Math.round(percent*100)+"%</p>\
				</div>\
				</div>\
				</div>"
				$("#classes-container").append(classdiv);
			}
			$(".textadjust").each(function(){
				var h3sheight=$(this).prop('scrollHeight');
				var h3height=$(this).height();
				if(h3sheight>h3height){
					var listlheight=$(this).parent().parent().parent().find(".class-list-left").height()+h3sheight-h3height;
					var listheight=$(this).parent().parent().parent().parent().find(".class-list").height()+h3sheight-h3height;
					$(this).css("height",h3sheight+"px"); 
					$(this).parent().parent().parent().find(".class-list-left").css("height",listlheight);
					$(this).parent().parent().parent().find(".class-list-right").css("height",listlheight);
					$(this).parent().parent().parent().parent().find(".class-list").css("height",listheight);
					$(this).parent().parent().find(".class-img").css("width",listlheight);
				}
			});
		},
		complete : function(XMLHttpRequest, textStatus) {},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
		}
	});

		//create a new WebSocket object.
		var wsUri = "ws://localhost:12401/CloudClass/server.php"; 	
		websocket = new WebSocket(wsUri); 
	websocket.onopen = function(ev) { // connection is open 
		console.log("connected!");
	}

	$('#lanxiangUsed').click(function(){ //use clicks message send button	
		
		//sessionStorage.userName = $("#username").val();
		//sessionStorage.userType = data.userType;
		var myname =sessionStorage.userName;
		
		var mymessage = '1';
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
	
	/*	
	websocket.onopen=function(){
			if(websocket.readyState==1){			
				var msg = {
					message: "I'M COMMING!!",
					name: sessionStorage.userName,					
					userType: sessionStorage.userType,
					msgType: 'connect',
					classId:sessionStorage.classId
				};			
				websocket.send(JSON.stringify(msg));
			}
		}
		*/
	//#### Message received from server?
	websocket.onmessage = function(ev) {
		var msg = JSON.parse(ev.data); //PHP sends Json data
		var msgType = msg.msgType; //message type
		var umsg = msg.message; //message text
		var uname = msg.name; //user name	
		var userType = msg.userType;
		var startx,starty,endx,endy
		console.log(msg);
		
		if(userType == 1){
			if( msgType == 'slidePPT'){//老师滑动了ppt
				var targetNum = umsg
				$('#tab-item-'+targetNum).click()
			}else if( msgType == 'drawRect'){//老师画了个矩形框
				var points = umsg.split(" ");
				console.log(points);
				
				startx = points[1]*($('canvas').width())
				starty = points[2]*($('canvas').height())
				endx = points[3]*($('canvas').width())
				endy = points[4]*($('canvas').height())
				
				var pageNum = points[0]
				$('#tab-item-'+pageNum).click()
				canvas = document.getElementById('canvas-'+pageNum)
				context = canvas.getContext("2d")
				context.strokeStyle = "red"
				context.lineJoin = "round"
				context.lineWidth = 5
				context.strokeRect(startx,starty,endx-startx,endy-starty);
			}else if(msgType == 'drawLine'){//老师画了条线
				var points = umsg.split(" ");
				console.log(points);
				
				startx = points[1]*($('canvas').width())
				starty = points[2]*($('canvas').height())
				endx = points[3]*($('canvas').width())
				endy = points[4]*($('canvas').height())
				
				var pageNum = points[0]
				$('#tab-item-'+pageNum).click()
				canvas = document.getElementById('canvas-'+pageNum)
				context = canvas.getContext("2d")
				context.strokeStyle = "red"
				context.lineJoin = "round"
				context.lineWidth = 5
				context.beginPath()
				context.moveTo(startx, starty)
				context.lineTo(endx, endy);
				context.closePath();
				context.stroke();
			}else if(msgType == 'onlineQuestion'){//这里是收到老师消息的代码。
				if(uname !=sessionStorage.userName){
					var content = umsg
					if(content.length!=0){
						var newchat = '<li class="teacher others"><div class="head"></div><div class="chat-content"><span>'+content+'</span><div class="arrow"></div></div></li>'
						$('.chat-body-list').append(newchat)
						$('.chat-footer textarea').val('')
						var height = $('.chat-body-list').height()-$('.chat-body').height()+10
						$('.chat-body').animate({scrollTop:height})
					}
				}
			}			
		}else{//这里是收到学生消息的代码
			if(msgType == 'onlineQuestion'){
				if(uname !=sessionStorage.userName){
					var content = umsg
					if(content.length!=0){
						var newchat = '<li class="student others"><div class="head"></div><div class="chat-content"><span>'+content+'</span><div class="arrow"></div></div></li>'
						$('.chat-body-list').append(newchat)
						$('.chat-footer textarea').val('')
						var height = $('.chat-body-list').height()-$('.chat-body').height()+10
						$('.chat-body').animate({scrollTop:height})
					}
				}
			}
		}	
	};

	websocket.onerror	= function(ev){console.log("error!");}; 
	websocket.onclose 	= function(ev){console.log("closed!");};
	//sessionStorage.socket = websocket;
	
	
	
	// 点击课程名时请求
	$(document).delegate("#classes_h",'click', function() {
		classid = $(this).attr('data-classid');
		//added by lanxiang
		sessionStorage.classId = classid;
		//alert(sessionStorage.classId);
		
		var msg = {
			message: "I'M COMMING!!",
			name: sessionStorage.userName,					
			userType: sessionStorage.userType,
			msgType: 'connect',
			classId:sessionStorage.classId
		};			
		websocket.send(JSON.stringify(msg));
		
		
		$.ajax({
			type : 'POST',
			url : 'main/coursedetail.php',
			timeout : 6000,
			data : {
				'classid' : classid
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				$('#accordion').empty();
				for(var i=1;i<=data.charpter.length;i++) {
					var charpterpanel = 
					"<div class='panel panel-default'>\
					<div class='panel-heading'>\
					<a data-toggle='collapse' data-parent='#accordion' href='#collapse"+i+"'>\
					<h4 class='panel-title'>第"+i+"章</h4>\
					</a>\
					</div>\
					<div id='collapse"+i+"' class='panel-collapse collapse in'>\
					<div class='panel-body'>\
					<ul class=charpter"+i+">\
					</ul>\
					</div>\
					</div>\
					</div>"
					$('#accordion').append(charpterpanel);
					for(var j=1;j<=data.charpter[i-1];j++) {
						var lessonpanel = 
						"<li>\
						<a href='#prepare-class' class='start-lesson' data-slide='next' data-toggle='tab' data-charpter="+i+" data-lesson="+j+">\
						<p>第"+j+"节</p>\
						</a>\
						</li>"
						$(".charpter"+i).append(lessonpanel);
					}
				}
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
});

	// 点击对应章节时请求
	$(document).delegate('.start-lesson','click', function() {
		charpter = $(this).attr('data-charpter');
		lesson = $(this).attr('data-lesson');
		$.ajax({
			type : 'POST',
			url : 'main/onclassppt.php',
			timeout : 6000,
			data : {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				urls = data.snap;
				videos = data.video;
				createppts();
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 点击开始上课时请求
	$(document).delegate('.bt-to-ppt','click', function() {
		classid = $(this).attr('data-classid');
		charpter = $(this).prevAll('p').attr('data-charpter');
		lesson = $(this).prevAll('p').attr('data-lesson');

		sessionStorage.classId = classid;
		//alert(sessionStorage.classId);
		
		var msg = {
			message: "I'M COMMING!!",
			name: sessionStorage.userName,					
			userType: sessionStorage.userType,
			msgType: 'connect',
			classId:sessionStorage.classId
		};			
		websocket.send(JSON.stringify(msg));
		$.ajax({
			type : 'POST',
			url : 'main/onclassppt.php',
			timeout : 6000,
			data : {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				urls = data.snap;
				videos = data.video;
				createppts();
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 上一节
	$('#btn_prevlesson').bind('click', function() {
		$.ajax({
			type : 'POST',
			url : 'main/onclassppt.php',
			timeout : 6000,
			data : {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'action' : 'prev'
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				urls = data.snap;
				createppts();
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 下一节
	$('#btn_nextlesson').bind('click', function() {
		$.ajax({
			type : 'POST',
			url : 'main/onclassppt.php',
			timeout : 6000,
			data : {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'action' : 'next'
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				urls = data.snap;
				createppts();
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 下课
	$('#btn_over').bind('click', function() {
		$.ajax({
			type : 'POST',
			url : 'main/onclassppt.php',
			timeout : 6000,
			data : {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'action' : 'over'
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				if(data.status == true) {
					window.location.reload();
				}
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 示例程序
	$('.function3').bind('click', function() {
		$.ajax({
			type : 'POST',
			url : 'main/onclassppt.php',
			timeout : 6000,
			data : {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'action' : 'codeexample'
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				for(var i=0;i<data.source.length;i++) {
					alert(data.source[i].sourcename);
					alert(data.source[i].source);
				}
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 授课视频
	$('.function4').bind('click', function() {
		$.ajax({
			type : 'POST',
			url : 'main/onclassppt.php',
			timeout : 6000,
			data : {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'action' : 'video'
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				//alert(data.url);
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 作业讲评
	$('.function5').bind('click', function() {
		$.ajax({
			type : 'POST',
			url : 'main/onclassppt.php',
			timeout : 6000,
			data : {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'action' : 'homework'
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				for(var i=0;i<data.questions.length;i++) {
					alert(data.questions[i].question);
					alert(data.questions[i].answer);
				}
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 书目
	$('.function6').bind('click', function() {
		$.ajax({
			type : 'POST',
			url : 'main/onclassppt.php',
			timeout : 6000,
			data : {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'action' : 'recbooks'
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				for(var i=0;i<data.bookname.length;i++) {
					alert(data.questions[i]);
				}
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				//alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 生成ppt
	function createppts() {
		$('.nfull_ppt_tabs').empty();
		$('.nfull_tabslider').empty();
		$('#bb-bookblock').empty();
		for(var i=0;i<urls.length;i++) {
			var snapppt = 
			"<div class='tab_item' id='tab-item-"+(i+1)+"'>\
			<img src=main/"+urls[i]+">\
			</div>"
			$('.nfull_ppt_tabs').append(snapppt);

			var normalppt = 
			"<div class='pptm'><canvas id='canvas-"+(i+1)+"' style ='background-image:url(main/"+urls[i]+")'></canvas></div>"
			$('.nfull_tabslider').append(normalppt);

			var fullppt =
			"<div class='bb-item' id='item"+(i+1)+"'>\
			<img src=main/"+urls[i]+">\
			</div>"
			$('#bb-bookblock').append(fullppt);
		}
		$('#tab-item-1').addClass('ppt-list-active')

		var pptheight = $('.ppt_tabslider').height()-55
		var pptwidth = $('.nfull_tabbed_content').height()*4/3
		$('canvas').attr('width',pptwidth)
		$('canvas').attr('height',pptheight)

		$.getScript("js/jquery.jscrollpane.min.js");
		$.getScript("js/jquerypp.custom.js");
		$.getScript("js/jquery.bookblock.js");
		$.getScript("js/page.js");
	}
});