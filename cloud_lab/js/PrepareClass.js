$(document).ready(function(){
  $('canvas').each(function(){
      var text = $(this).text();
      var process = text.substring(0, text.length-1);

      var canvas = this;
      var context = canvas.getContext('2d');
      context.clearRect(0, 0, 100, 100);
      //画进度
      var start=Math.PI*2*(75/100);
      context.beginPath();
      context.moveTo(45, 45);
      context.arc(45, 45, 45, start,start+Math.PI*2*(process/100), false);
      context.closePath();
      context.fillStyle = '#3d9df5';
      context.fill();

      //画遮罩圆
      context.beginPath();
      context.moveTo(45, 45);
      context.arc(45, 45, 35, 0, Math.PI * 2, true);
      context.closePath();
      context.fillStyle = '#eee';
      context.fill();

      context.beginPath();
      context.moveTo(45, 45);
      context.arc(45, 45, 30, 0, Math.PI * 2, true);
      context.closePath();
      context.fillStyle = '#71cce8';
      context.fill();

      context.beginPath();
      context.moveTo(45, 45);
      context.arc(45, 45, 25, 0, Math.PI * 2, true);
      context.closePath();
      context.fillStyle = '#eee';
      context.fill();

      context.font = "16pt 微软雅黑";
      context.fillStyle = '#333';
      context.textAlign = 'center';
      context.textBaseline = 'middle';
      context.moveTo(45, 45);
      context.fillText(text, 45, 45);
});
$(".exer-list button").click(function(){
      $(this).parent().find("p").toggle("normal");
});

});