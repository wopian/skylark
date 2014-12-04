( function( $ ) {
    // Init Skrollr
    var s = skrollr.init({
        render: function(data) {
            //Debugging - Log the current scroll position.
            //console.log(data.curTop);
        }
    });
} )( jQuery );

window.onload=function(){var a=document.getElementById("snow"),t=a.getContext("2d"),n=document.body.clientWidth,o=document.body.clientHeight;a.width=n,a.height=o;for(var r=[],a=0;40>a;a++)r.push({x:Math.random()*n,y:Math.random()*o,a:2*Math.random()+1,b:40*Math.random()});var h=0;setInterval(function(){t.clearRect(0,0,n,o),t.fillStyle="rgba(255,255,255,.8)",t.beginPath();for(var a=0;40>a;a++){var e=r[a];t.moveTo(e.x,e.y),t.arc(e.x,e.y,e.a,0,2*Math.PI,!0)}for(t.fill(),h+=.01,a=0;40>a;a++)e=r[a],e.y+=Math.cos(h+e.b)+1+e.a/2,e.x+=2*Math.sin(h),(e.x>n+5||-5>e.x||e.y>o)&&(r[a]=a%3>0?{x:Math.random()*n,y:-10,a:e.a,b:e.b}:0<Math.sin(h)?{x:-5,y:Math.random()*o,a:e.a,b:e.b}:{x:n+5,y:Math.random()*o,a:e.a,b:e.b})},20)};
