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
      
})