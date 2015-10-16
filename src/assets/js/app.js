/*$(function() {
    $("img.lazy").lazyload({
        //threshold : 200,
        skip_invisible : false,
        effect : "fadeIn"
    });
});*/

Holder.run({});

$(function() {
    $(".lazy").lazyload({
        event: "sporty",
        skip_invisible: false,
        effect: "fadeIn"
    });
});

$(window).bind("load", function() {
    var timeout = setTimeout(function() { $("img.lazy").trigger("sporty"); }, 5000);
});
