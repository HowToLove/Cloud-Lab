$(document).ready(function(){
      $(document).delegate('.indicator-hide','click',function(){
            setTimeout(function(){
                  $('#carousel-indicators-pc').slideUp()
                  changeheight()
            },800)
      })
      $(document).delegate('.indicator-show','click',function(){
            setTimeout(function(){
                  $('#carousel-indicators-pc').slideDown()
            },800)
      })
      function changeheight(){
            var height = $(window).height() - $('#carousel-indicators-pc').height() - 60
            $('#ppt .tab-content').height(height)

            var width = $('#show-ppt-middle').height() / 3 * 4
            $('#show-ppt-middle').width(width)
            $('#show-ppt-middle li').width(width)

            var rwidth = $('#show-ppt').width() - $('#show-ppt-left').width() - $('#show-ppt-middle').width() - 15
            $('#show-ppt-right').width(rwidth)
      }
})