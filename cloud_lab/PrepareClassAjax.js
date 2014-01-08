var classes;
var urls, videos, remarks;
var classid, classname, imgurl, charpter, coursename, lesson, description, studentsnum, percent, pageid;
classid = 1;
charpter = 1;
lesson = 1;
var video = document.getElementById("pptvideo");
$(function() {

	// 请求课程
	$.ajax({
		type : 'GET',
		url : 'main/prepareclass.php',
		timeout : 6000,
		dataType : 'json',
		beforeSend : function(XMLHttpRequest) {},
		success : function(data) {
			$("#class_container").empty();
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
					"<div class='class-list'>\
						<div class='class-list-left'>\
							<div class='class-img'><img src="+imgurl+"><div class='arrow-right'></div>\
							</div>\
							<a href='#prepare-class' data-slide='next' data-toggle='tab'>\
								<h3 class='underline class_h' data-classid='"+classid+"'>"+coursename+"</h3>\
							</a>\
							<p data-charpter="+charpter+" data-lesson="+lesson+">已备至第"+charpter+"章第"+lesson+"节</p>\
							<a class='button-blue indicator-hide start_now' href='#prepare-class' role='button' data-toggle='tab' data-slide-to='3'>立即准备PPT</a>\
						</div>\
						<div class='class-list-right'>\
							<div class='class-questions'>\
								<p>未解答提问</p><span>1</span>\
								<div class='arrow-bottom'></div>\
							</div>\
							<p class='underline'>"+description+"</p>\
							<p>上课人数："+studentsnum+"人</p>\
						</div>\
						<div>\
							<div class='progress-cover' style='width:"+percent+"%'></div>\
							<p>"+percent+"%</p>\
						</div>\
					</div>"
				$("#class_container").append(classdiv);
			}
		},
		complete : function(XMLHttpRequest, textStatus) {},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
		}
	});

	// 点击课程名时
	$(document).on("click", ".class_h", function() {
		classid = $(this).attr('data-classid');
		$.ajax({
			type : 'POST',
			url : 'main/prepareclass.php',
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
								<a href='#prepare-class' class='start_lesson' data-slide='next' data-toggle='tab' data-charpter="+i+" data-lesson="+j+">\
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

	// 点击对应章节时
	$(document).on("click", ".start_lesson", function() {
		charpter = $(this).attr('data-charpter');
		lesson = $(this).attr('data-lesson');
		getPRVs();
	});

	// 点击立即备课时
	$(document).on("click", ".start_now", function() {
		classid = $(this).prevAll('h3').attr('data-classid');
		charpter = $(this).prevAll('p').attr('data-charpter');
		lesson = $(this).prevAll('p').attr('data-lesson');
		getPRVs();
	});

	// 请求ppt、remark、video节点
	function getPRVs() {
		$.ajax({
			url: 'main/prepareclass.php',
			type: 'POST',
			dataType: 'json',
			data: {
				"classid" : classid,
				"charpter" : charpter,
				"lesson" : lesson,
				"action" : "getPPTandRemark"
			},
			beforeSend: function(XMLHttpRequest) {},
			success: function(data) {
				urls = data.snap;
				videos = data.video;
				remarks = data.remark;
				createPPTs();
			},
			complete: function(XMLHttpRequest, textStatus) {},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	}

	// 生成PPT
	function createPPTs() {
		// ppt
		$('#ppt-list').empty();
		$('#ppt-content').empty();
		for(var i=0;i<urls.length;i++) {
			var snapppt =
				"<li id='ppt-list-"+(i+1)+"''>\
					<a class='snapppt' data-pptid='"+(i+1)+"' href='#ppt-list-"+(i+1)+"'>\
					<img src="+urls[i]+">\
				</li>"
			var normalppt = 
				"<li><img src="+urls[i]+"></li>"
			$('#ppt-list').append(snapppt);
			$('#ppt-content').append(normalppt);
		}
	}

	// 点击相应snapppt
	$(document).on("click", ".snapppt", function() {
		pptid = $(this).attr("data-pptid");
		$('#classnote').empty();
		var classnote = 
			"<p>本页PPT备注</p>\
        	<form>\
              	<textarea class='form-control' id='txt_remark'>"+remarks[pptid]+"</textarea>\
              	<input type='button' id='btn_saveremark' value='保存' class='btn btn-primary'>\
              	<input type='reset' value='重置' class='btn btn-success'>\
            </form>"
        $('#classnote').append(classnote);
        video.currentTime = videos[pptid];
	});

	// 提交本页ppt备注
	$(document).on("click", "#btn_saveremark", function() {
		$.ajax({
			url: 'main/prepareclass.php',
			type: 'POST',
			dataType: 'json',
			data: {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'pagenum' : pptid,
				'remark' : $("#txt_remark").text(),
				'action' : 'commitRemark'
			},
			beforeSend: function(XMLHttpRequest) {},
			success: function(data) {
				if(data.status == 'success') {
					alert("save success");
				}
			},
			complete: function(XMLHttpRequest, textStatus) {},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 请求题目
	$(document).on("click", "1", function() {
		$.ajax({
			url: 'main/prepareclass.php',
			type: 'POST',
			dataType: 'json',
			data: {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'action' : 'homeworklist'
			},
			beforeSend: function(XMLHttpRequest) {},
			success: function(data) {
			},
			complete: function(XMLHttpRequest, textStatus) {},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 布置作业
	$(document).on("click", "1", function() {
		$.ajax({
			url: 'main/prepareclass.php',
			type: 'POST',
			dataType: 'json',
			data: {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'action' : 'homework',
				'questionid' : "",
				'deadline' : ""
			},
			beforeSend: function(XMLHttpRequest) {},
			success: function(data) {
			},
			complete: function(XMLHttpRequest, textStatus) {},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	

	// 暂停、开始视频
	$("#pptvideo").click(function() {
		if(video.paused) {
			video.play();
		} else {
			video.pause();
		}
	});
	// $("#btn_prepare").click(function() {
	// 	video.currentTime = 200;
	// 	console.log(video.currentTime);
	// });
	// $("#btn_onclass").click(function() {
	// 	video.currentTime = 200;
	// });
	// $("#btn_lab").click(function() {
	// 	video.currentTime = 400;
	// });
	// $("#btn_homework").click(function() {
	// 	video.currentTime = 500;
	// });
});