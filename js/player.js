function liebiao(){
var el = document.querySelector("#playlist");
  if(el.style.display==='none') {el.style.display='block';}else{el.style.display='none';}

}
function qiehuan(){
document.getElementById('playlist').style.display='none';
document.getElementById('bgmplayer').classList.toggle("bgmon");
}
//播放/暂停按钮
function playbtu(){
var oyd = document.getElementById('ydmc');
if (yaudio.paused) {
            yaudio.play();
oyd.innerHTML = '<svg viewBox="0 0 20 20" fill="currentColor" class="ydicon"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
document.getElementById("ydfm").classList.remove("paused");
        } else {
            yaudio.pause();
oyd.innerHTML= '<svg viewBox="0 0 20 20" fill="currentColor" class="ydicon"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>';
document.getElementById("ydfm").classList.add("paused");
        }
var playlistli=document.querySelectorAll("#playlist li");
playlistli.forEach((value, index) => {
    playlistli[index].classList.remove("yd-playing");
});
playlistli[a].classList.add("yd-playing");
}

//下一首
function next(b) {
var oyd=document.getElementById('ydmc');
var geshou= '';
document.getElementById('jindu').style.width='0%';
if(b === undefined){
if (a == musicArr.length - 1) {
            a = 0;
        } else {
            a = a+1;
        }}else{a=b;}
        sj = musicArr[a];
        yaudio.src = sj.mp3;
        yaudio.ti = sj.title;
        yaudio.art = sj.artist;
		yaudio.fm=sj.cover;
        yaudio.play();var autopause=0;
oyd.innerHTML = '<svg viewBox="0 0 20 20" fill="currentColor" class="ydicon"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
if(yaudio.art.length>0){geshou='&nbsp;-&nbsp;'+yaudio.art;}
document.getElementById('ydtitle').innerHTML = yaudio.ti+geshou;
document.getElementById("ydfm").src=yaudio.fm;
var playlistli=document.querySelectorAll("#playlist li");
playlistli.forEach((value, index) => {
    playlistli[index].classList.remove("yd-playing");
});
playlistli[a].classList.add("yd-playing");
document.getElementById("ydfm").classList.remove("paused");
}

//上一首
function previous(){
var oyd=document.getElementById('ydmc');
var geshou= '';
if (a == 0) {
          a =musicArr.length - 1;
        }else{
  a = a-1;
}
        sj = musicArr[a];
        yaudio.src = sj.mp3;
        yaudio.ti = sj.title;
        yaudio.art = sj.artist;
		yaudio.fm=sj.cover;
        yaudio.play();var autopause=0;

oyd.innerHTML = '<svg viewBox="0 0 20 20" fill="currentColor" class="ydicon"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
if(yaudio.art.length>0){geshou='&nbsp;-&nbsp;'+yaudio.art;}
document.getElementById('ydtitle').innerHTML = yaudio.ti+geshou;
document.getElementById("ydfm").src=yaudio.fm;
var playlistli=document.querySelectorAll("#playlist li");
playlistli.forEach((value, index) => {
    playlistli[index].classList.remove("yd-playing");
});
playlistli[a].classList.add("yd-playing");
document.getElementById("ydfm").classList.remove("paused");
}


function dianbo(a){
var oyd=document.getElementById('ydmc');
var b=a;
  next(b);
  }
yaudio.addEventListener("error" ,function() {next();},false);
yaudio.addEventListener('ended',
function() {next();},
false);