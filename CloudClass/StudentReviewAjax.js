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
				<a class='button-blue indicator-hide bt-to-ppt' href='#prepare-class' role='button' data-toggle='tab' data-slide-to='2' data-classid='"+classid+"'>立即复习</a>\
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

	// 点击课程名时请求
	$(document).delegate("#classes_h",'click', function() {
		classid = $(this).attr('data-classid');
		//added by lanxiang
		sessionStorage.classId = classid;
		//alert(sessionStorage.classId);
		
		// var msg = {
		// 	message: "I'M COMMING!!",
		// 	name: sessionStorage.userName,					
		// 	userType: sessionStorage.userType,
		// 	msgType: 'connect',
		// 	classId:sessionStorage.classId
		// };			
		// websocket.send(JSON.stringify(msg));		
		
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
		})
	})

	// 点击开始上课时请求
	$(document).delegate('.bt-to-ppt','click', function() {
		classid = $(this).attr('data-classid');
		charpter = $(this).prevAll('p').attr('data-charpter');
		lesson = $(this).prevAll('p').attr('data-lesson');

		sessionStorage.classId = classid;
		//alert(sessionStorage.classId);

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
		})
	})

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
		})
	})

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
		})
	})

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
		})
	})

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
		})
	})

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
				//$('#video source').attr('src',data.url)
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		})
	})

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
		})
	})

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
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
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


		var canvas,context
		var pageNum,content
		var pleft,ptop
		var startx,starty,endx,endy
		var pstartx,pstarty,pendx,pendy
		$.ajax({
			type : 'POST',
			url : 'main/studentReview.php',
			timeout : 6000,
			data : {
				'classid' : 3,
				'charpter' : 1,
				'lesson' : 1
			},
			dataType : 'json',
			beforeSend : function(XMLHttpRequest) {},
			success : function(data) {
				for(i=0;i<data.length;i++){
					console.log(data[i])
					pageNum = data[i].pageNum
					content = data[i].content
					pleft = data[i].pleft
					ptop = data[i].ptop
					pstartx = data[i].pstartx
					pstarty = data[i].pstarty
					pendx = data[i].pendx
					pendy = data[i].pendy
					canvas = document.getElementById('canvas-'+pageNum)
					context = canvas.getContext("2d")
					ptrans1()
					draw_line()
					var newnotesign = '<div class="notesign" id="'+i+'" title="'+content+'" style="top:'+ptop*100+'%;left:'+pleft*100+'%"></div>'
					$('#canvas-'+pageNum).parent().append(newnotesign)
				}
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
		function draw_line(){
			context.strokeStyle = "black"
			context.lineJoin = "round"
			context.lineWidth = 5
			context.beginPath()
			context.moveTo(startx, starty)
			context.lineTo(endx, endy);
			context.closePath();
			context.stroke();
		}
		function ptrans1(){		
			startx = pstartx*$('canvas').width()
			starty = pstarty*$('canvas').height()
			endx = pendx*$('canvas').width()
			endy = pendy*$('canvas').height()
		}
		$.getScript("js/jquery.jscrollpane.min.js");
		$.getScript("js/jquerypp.custom.js");
		$.getScript("js/jquery.bookblock.js");
		$.getScript("js/page.js");
	}
});