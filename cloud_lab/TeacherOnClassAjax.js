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
					"<div class='class-list' style='text-align:left'>\
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
							<div class='progress-cover' style='width:"+percent+"%'></div>\
							<p>"+percent+"%</p>\
						</div>\
					</div>"
				$("#classes-container").append(classdiv);
			}
		},
		complete : function(XMLHttpRequest, textStatus) {},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
		}
	});

	// 点击课程名时请求
	$("#classes_h").live('click', function() {
		classid = $(this).attr('data-classid');
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
	$('.start-lesson').live('click', function() {
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
	$('.bt-to-ppt').live('click', function() {
		classid = $(this).attr('data-classid');
		charpter = $(this).prevAll('p').attr('data-charpter');
		lesson = $(this).prevAll('p').attr('data-lesson');
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
				alert(data.url);
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
				"<div class='tab_item tab_item"+(i+1)+"'></div>"
			$('.nfull_ppt_tabs').append(snapppt);

			var normalppt = 
				"<div class='pptm'>\
					<img src=main/"+urls[i]+" class='pptm_img'>\
				</div>"
			$('.nfull_tabslider').append(normalppt);

			var fullppt =
				"<div class='bb-item' id='item"+(i+1)+"'>\
					<img src=main/"+urls[i]+">\
				</div>"
			$('#bb-bookblock').append(fullppt);
		}
		$.getScript("js/jquery.jscrollpane.min.js");
		$.getScript("js/jquerypp.custom.js");
		$.getScript("js/jquery.bookblock.js");
		$.getScript("js/page.js");
	}
});