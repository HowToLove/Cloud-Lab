(function($){
    $.fn.animatescroll = function(options) {
        
        // fetches options
        var opts = $.extend({},$.fn.animatescroll.defaults,options);
                
        if(opts.element == "html,body") {
            // Get the distance of particular id or class from top
            var offset = this.offset().top-60;
        
            // Scroll the page to the desired position
            $(opts.element).stop().animate({ scrollTop: offset - opts.padding}, opts.scrollSpeed, opts.easing);
        }
        else {
            // Scroll the element to the desired position
            $(opts.element).stop().animate({ scrollTop: this.offset().top - this.parent().offset().top + this.parent().scrollTop() - opts.padding}, opts.scrollSpeed, opts.easing);
        }
    };
    // default options
    $.fn.animatescroll.defaults = {        
        scrollSpeed:800,
        padding:0,
        element:"html,body"
    };   
    
}(jQuery));

$(window).bind("scroll",function() {  
var count=0;
$(".step-nav a").css("visibility","hidden");
$( ".step-content ol li .list-icon" ).css( "visibility", "visible" );
 $( ".step-content ol li" ).each(function( index, element ) {

count=$(element).prevAll().size();
var topPos = element.offsetTop+27-count*32;
if ($(document).scrollTop() > topPos) {
var temp=count;  
          $( ".step-nav a" ).each(function( index, element ) {
    // element == this
        $( element ).css( "visibility", "visible" );
		
		if(count==0)
		 return false;
		 count--;
    })
$( ".step-content ol li .list-icon" ).each(function( index, element ) {
		  $( element ).css( "visibility", "hidden" );
		
		if(temp==0)
		 return false;
		 temp--;
		})
    } 
	})
}) ;