function qiehuan(){
var el = document.getElementById('bgmplayer');
var className = 'bgmon';
if (el.classList) {
  el.classList.toggle(className);
} else {
  var classes = el.className.split(' ');
  var existingIndex = classes.indexOf(className);

  if (existingIndex >= 0)
    classes.splice(existingIndex, 1);
  else
    classes.push(className);

  el.className = classes.join(' ');
}


}
function playbtu(){
var oyd = document.getElementById('ydmc');
if (yaudio.paused) {
            yaudio.play();
           oyd.className = 'iconfont icon-music';
document.getElementById("ydfm").className = "Rotation";
        } else {
            yaudio.pause();
            oyd.className = 'iconfont icon-bofang';document.getElementById("ydfm").className = "";
        }
}
function next() {
var oyd=document.getElementById('ydmc');
if (a == musicArr.length - 1) {
            a = 0;
        } else {
            a = a + 1;
        }
        var sj = musicArr[a];
        yaudio.src = sj.mp3;
        yaudio.ti = sj.title;
        yaudio.art = sj.artist;
yaudio.fm=sj.cover;
        yaudio.play();var autopause=0;
       oyd.className = 'iconfont icon-music';
document.getElementById("ydfm").className = "Rotation";
document.getElementById('ydtitle').innerHTML = yaudio.ti+'&nbsp;-&nbsp;'+yaudio.art;
document.getElementById("ydfm").src=yaudio.fm;
}
function previous(){
var oyd=document.getElementById('ydmc');
if (a > 0) {
            a = a - 1;
        }else{
a =musicArr.length - 1;
}
        var sj = musicArr[a];
        yaudio.src = sj.mp3;
        yaudio.ti = sj.title;
        yaudio.art = sj.artist;
yaudio.fm=sj.cover;
        yaudio.play();var autopause=0;
       oyd.className = 'iconfont icon-music';
document.getElementById("ydfm").className = "Rotation";
document.getElementById('ydtitle').innerHTML = yaudio.ti+'&nbsp;-&nbsp;'+yaudio.art;
document.getElementById("ydfm").src=yaudio.fm;
}

yaudio.addEventListener('ended',
function() {
    next();
},
false);

var ody=document.getElementById('ydmc');
if (yaudio.paused) {var autopause=0;
ody.className = 'iconfont icon-bofang';
document.getElementById("ydfm").className = "";
} else {var autopause=1;
ody.className = 'iconfont icon-music';
document.getElementById("ydfm").className = "Rotation";
}

document.getElementById('ydtitle').innerHTML = yaudio.ti+'&nbsp;-&nbsp;'+yaudio.art;
document.getElementById("ydfm").src=yaudio.fm;
var setProgress = function(value){
		var currentSec = parseInt(value%60) < 10 ? '0' + parseInt(value%60) : parseInt(value%60),
			ratio = value / yaudio.duration * 100;

document.getElementById('ytime').innerHTML = (parseInt(value/60)+':'+currentSec);
	}

	var updateProgress = function(){
		setProgress(yaudio.currentTime);
	}

timeout = setInterval(updateProgress, 500);