$(document).ready(function(){
      $(".show-answer").click(function(){
            $(this).next().toggle("normal");
            ($(this).html()=='查看答案') ? ($(this).html('隐藏答案')) : ($(this).html('查看答案'));
      });
      $('.exer-list label').click(function(){
            var checkmark = $(this).find('.checkmark');
            checkmark.width()==0 ? checkmark.animate({width:"22px"}) : checkmark.animate({width:"0px"});
      })
});