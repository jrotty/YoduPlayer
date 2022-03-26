document.body.onclick=function(){ 
// 点击播放器外面的事物时关闭抽屉

document.getElementById('playlist').style.display='none';
document.getElementById('bgmplayer').classList.remove("bgmon");
};
document.getElementById('bgmplayer').onclick=function(){ 
    event.stopPropagation();
};



document.addEventListener("DOMContentLoaded", () => {
  // Load playlist
  var element = document.getElementById('playlist')
	for (var i = 0; i < musicArr.length; i++){
		var item = musicArr[i];var anum = i+1;
      if(anum<10){anum='0'+anum;}
   element.insertAdjacentHTML('beforeend','<li class="yd-lib"><span class="anum">'+anum+'.</span><strong style="margin-left: 5px;">'+item.title+'</strong><span style="float: right;" class="artist">'+item.artist+'</span></li>');
		if (item.mp3 == "") {
			document.querySelectorAll("#playlist li")[i].style.color='#ddd';
		}
	}
var playlistli=document.querySelectorAll("#playlist li");
playlistli.forEach((value, index) => {
    playlistli[index].classList.remove("yd-playing");
    playlistli[index].onclick=function(){ 
 dianbo(index);
  };
});
playlistli[a].classList.add("yd-playing");


});


var ody=document.getElementById('ydmc');
if (yaudio.paused) {var autopause=0;
ody.className = 'icon-bofang';
document.getElementById("ydfm").className = "";
} else {var autopause=1;
ody.className = 'icon-music';
document.getElementById("ydfm").className = "Rotation";
}

document.getElementById('ydtitle').innerHTML = yaudio.ti+'&nbsp;-&nbsp;'+yaudio.art;
document.getElementById("ydfm").src=yaudio.fm;
var setProgress = function(value){
		var currentSec = parseInt(value%60) < 10 ? '0' + parseInt(value%60) : parseInt(value%60),
			ratio = value / yaudio.duration * 100;

document.getElementById('jindu').style.width=ratio+'%';
document.getElementById('ytime').innerHTML = (parseInt(value/60)+':'+currentSec);
	}

	var updateProgress = function(){
		setProgress(yaudio.currentTime);
	}

timeout = setInterval(updateProgress, 500);
