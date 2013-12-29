$(document).ready(function(){
      $(".show-answer").click(function(){
            $(this).next().toggle("normal");
            ($(this).html()=='查看答案') ? ($(this).html('隐藏答案')) : ($(this).html('查看答案'));
      });
});