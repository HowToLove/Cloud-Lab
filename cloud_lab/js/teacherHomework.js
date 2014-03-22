$(document).ready(function(){
      $('.indicator-hide,#accordion li a').click(function(){
            setTimeout(function(){
                  $('#carousel-indicators-pc').slideUp()
            },500)
      })
      $('.button-stanswer').click(function(){
            $(this).parents('li').find('.stanswer').toggle('normal')
      })
      $('.button-comment').click(function(){
            $(this).parents('li').find('.comment').toggle('normal')
      })
      $('.stanswer .close').click(function(){
            $(this).parents('li').find('.stanswer').hide('normal')
      })
      $('.comment .close').click(function(){
            $(this).parents('li').find('.comment').hide('normal')
      })
      $('.backshow').click(function(){
            $('.back').fadeIn('slow')
      })
      $('.back').click(function(){
            $('.back').fadeOut('slow')
      })
      $('.marknow,#accordion li a').click(function(){
            setTimeout(function(){
                  $('.student-list').animate({right:"0"},'slow') 
            },500)
      })
      $('.studentli-hide').click(function(){
            $('.student-list').animate({right:"-100%"},'slow') 
      })
      $('.stuli-arrow.up').click(function(){
            var mt=parseInt($('.student-list ul').css('margin-top'))
            if(mt<0){
                  $('.student-list ul').animate({marginTop:'+=65'})
            }
      })
      $('.stuli-arrow.down').click(function(){
            var mt=parseInt($('.student-list ul').css('margin-top'))
            if(mt>($('.stuli').height()-$('.student-list ul').height())){
                  $('.student-list ul').animate({marginTop:'-=65'})
            }
      })
      
})
$(document).ready(function(){
      $('tbody').css('display','none');
var obj = document.getElementsByClassName("question-block"); 
      if(obj)
      {
     $('#bt_show_answer').css('display','inline-block');
      }
      $('#bt_show_answer').click(function(){
            $('tbody').css('display','block');
      })
})