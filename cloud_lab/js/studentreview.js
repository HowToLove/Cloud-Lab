$(document).ready(function(){
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
				//console.log(data);
				for(i=0;i<data.length;i++){
					console.log(data[i])
				}
			},
			complete : function(XMLHttpRequest, textStatus) {},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				//alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus);
			}
		});
})