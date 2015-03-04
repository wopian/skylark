/*$(function() {
    $("img.lazy").lazyload({
        //threshold : 200,
        skip_invisible : false,
        effect : "fadeIn"
    });
});
*/

$(function(){


  $('img').each(function(){

    var img = $(this);

     img.error(function(){
      img.attr({"data-src": "holder.js/490x710/auto/text:Missing Cover"});
        Holder.run({});
      });

  })
});

$(function() {
    $("img.lazy").lazyload({
        event : "sporty",
        skip_invisible : false,
        effect : "fadeIn"
    });
});

$(window).bind("load", function() {
    var timeout = setTimeout(function() { $("img.lazy").trigger("sporty") }, 5000);
});
