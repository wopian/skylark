( function( $ ) {
    // Init Skrollr
    var s = skrollr.init({
        render: function(data) {
            //Debugging - Log the current scroll position.
            //console.log(data.curTop);
        }
    });
} )( jQuery );

_='onload= c=documeElemeById("snow"),d=cCoext("2d"),eWid,fH;c.wid=e;c.h=fh=[],cc;c++)h.push(,a:4*+1,b:75*});g=0;setIerval(    d.clearRect(0,0,e,f)Style="rgba(0.8)"begPa{a=moveTo)arca,0,2*PI,!0)}d.;g+=.01if(a=y+=cos(g+b)+1+a/2x+=2*x>e+5||-5>x||y>f)=0<b%3?,y:-10:0<?-5:e+5},17)};random,a:a,b:b}Ma.a.var wdow.bb;b++),y:*f    function{;for(255, {x:;d.h[b]s(g)=ner,=0;75>eight(xyin()ntth.getfill*e';for(Y in $='  ')with(_.split($[Y]))_=join(pop());eval(_)

/*window.onload=function(){var c=document.getElementById("snow"),d=c.getContext("2d"),e=window.innerWidth,f=window.innerHeight;c.width=e;c.height=f;for(var h=[],c=0;75>c;c++)h.push({x:Math.random()*e,y:Math.random()*f,a:4*Math.random()+1,b:75*Math.random()});var g=0;setInterval(function(){d.clearRect(0,0,e,f);d.fillStyle="rgba(255, 255, 255, 0.8)";d.beginPath();for(var b=0;75>b;b++){var a=h[b];d.moveTo(a.x,a.y);d.arc(a.x,a.y,a.a,0,2*Math.PI,!0)}d.fill();g+=.01;for(b=0;75>b;b++)if(a=h[b],a.y+=Math.cos(g+
a.b)+1+a.a/2,a.x+=2*Math.sin(g),a.x>e+5||-5>a.x||a.y>f)h[b]=0<b%3?{x:Math.random()*e,y:-10,a:a.a,b:a.b}:0<Math.sin(g)?{x:-5,y:Math.random()*f,a:a.a,b:a.b}:{x:e+5,y:Math.random()*f,a:a.a,b:a.b}},17)};


/*window.onload = function(){
    //canvas init
    var canvas = document.getElementById("snow");
    var ctx = canvas.getContext("2d");

    //canvas dimensions
    var W = window.innerWidth;
    var H = window.innerHeight;
    canvas.width = W;
    canvas.height = H;

    //snowflake particles
    var mp = 75; //max particles
    var particles = [];
    for(var i = 0; i < mp; i++)
    {
        particles.push({
            x: Math.random()*W, //x-coordinate
            y: Math.random()*H, //y-coordinate
            r: Math.random()*4+1, //radius
            d: Math.random()*mp //density
        })
    }

    //Lets draw the flakes
    function draw()
    {
        ctx.clearRect(0, 0, W, H);

        ctx.fillStyle = "rgba(255, 255, 255, 0.8)";
        ctx.beginPath();
        for(var i = 0; i < mp; i++)
        {
            var p = particles[i];
            ctx.moveTo(p.x, p.y);
            ctx.arc(p.x, p.y, p.r, 0, Math.PI*2, true);
        }
        ctx.fill();
        update();
    }

    //Function to move the snowflakes
    //angle will be an ongoing incremental flag. Sin and Cos functions will be applied to it to create vertical and horizontal movements of the flakes
    var angle = 0;
    function update()
    {
        angle += 0.01;
        for(var i = 0; i < mp; i++)
        {
            var p = particles[i];
            //Updating X and Y coordinates
            //We will add 1 to the cos function to prevent negative values which will lead flakes to move upwards
            //Every particle has its own density which can be used to make the downward movement different for each flake
            //Lets make it more random by adding in the radius
            p.y += Math.cos(angle+p.d) + 1 + p.r/2;
            p.x += Math.sin(angle) * 2;

            //Sending flakes back from the top when it exits
            //Lets make it a bit more organic and let flakes enter from the left and right also.
            if(p.x > W+5 || p.x < -5 || p.y > H)
            {
                if(i%3 > 0) //66.67% of the flakes
                {
                    particles[i] = {x: Math.random()*W, y: -10, r: p.r, d: p.d};
                }
                else
                {
                    //If the flake is exitting from the right
                    if(Math.sin(angle) > 0)
                    {
                        //Enter from the left
                        particles[i] = {x: -5, y: Math.random()*H, r: p.r, d: p.d};
                    }
                    else
                    {
                        //Enter from the right
                        particles[i] = {x: W+5, y: Math.random()*H, r: p.r, d: p.d};
                    }
                }
            }
        }
    }

    //animation loop
    setInterval(draw, 17);
}
