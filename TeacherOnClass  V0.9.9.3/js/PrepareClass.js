$(document).ready(function(){
      $(".exer-list button").click(function(){
            $(this).parent().find("p").toggle("normal");
      });
});