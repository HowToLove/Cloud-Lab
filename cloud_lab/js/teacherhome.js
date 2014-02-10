window.onload = function(){
	$(".canvas").each(function(index, element) {
	var ctx = element.getContext("2d");
	var W = element.width;
	var H = element.height;
	var deg=0,new_deg=0,dif=0;
	var loop,re_loop;
	var text,text_w;
	var progress=0.5;
		function init(){
		ctx.clearRect(0,0,W,H);
		ctx.beginPath();
		ctx.strokeStyle="#b0b0b0";
		ctx.lineWidth=20;
		ctx.arc(W/2,H/2,80,0,Math.PI*2,false);
		ctx.stroke();
		
		var r = deg*Math.PI/180;
		ctx.beginPath();
		ctx.strokeStyle = "lightgreen";
		ctx.lineWidth=21;
		ctx.arc(W/2,H/2,80,0-270*Math.PI/180,r-270*Math.PI/180,false);
		ctx.stroke();
		
		ctx.fillStyle="#707070";
		ctx.font="30px abc";
		text = Math.floor(deg/360*100)+"%";
		text_w = ctx.measureText(text).width;
		ctx.fillText(text,W/2 - text_w/2,H/2+15);
	}
	function draw(){
		new_deg = 360*progress+1;
		dif = new_deg-deg;
		loop = setInterval(to,1000/dif);
	}
	function to(){
		if(deg == new_deg){
			clearInterval(loop);
		}
		if(deg<new_deg){
			deg++;
		}else{
			deg--;
		}
		init();
	}
	draw();
	});

	//re_loop = setInterval(draw,2000);
	$(document).on("click", "#btn_onclass", function() {
		window.location.href="TeacherOnClass.html";
	});

	$(document).on("click", "#btn_prepare", function() {
		window.location.href="PrepareClass.html";
	});
}