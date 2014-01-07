var classes;
var urls, videos, remarks;
var classid, classname, imgurl, charpter, coursename, lesson, description, studentsnum, percent;
$(function() {
	// 请求ppt、remark、video节点
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
			createppts();
		},
		complete: function(XMLHttpRequest, textStatus) {},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
		}
	});

	// 提交本页ppt备注
	$(document).on("click", "", function() {
		$.ajax({
			url: 'main/prepareclass.php',
			type: 'POST',
			dataType: 'json',
			data: {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'url' : url,
				'remark' : remark,
				'action' : 'commitRemark'
			},
			beforeSend: function(XMLHttpRequest) {},
			success: function(data) {
				if(data.status == 'success') {

				}
			},
			complete: function(XMLHttpRequest, textStatus) {},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
	});

	// 请求题目
	$(document).on("click", "", function() {
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
	$(document).on("click", "", function() {
		$.ajax({
			url: 'main/prepareclass.php',
			type: 'POST',
			dataType: 'json',
			data: {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'action' : 'homework',
				'questionid' :
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
	
	// 生成ppt
	function createppts() {
		$('#ppt-list').empty();
		$('#ppt-content').empty();
		for(var i=0;i<urls.length;i++) {
			var snapppt = 
				"<li><img src="+urls[i]+"></li>"
			$('#ppt-list').append(snapppt);
			$('#ppt-content').append(normalppt);
			console.log()
		}
	}
});