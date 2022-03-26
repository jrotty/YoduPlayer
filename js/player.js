function liebiao(){
var el = document.querySelector("#playlist");
  if(el.style.display==='none') {el.style.display='block';}else{el.style.display='none';}

}
function qiehuan(){
document.getElementById('playlist').style.display='none';
document.getElementById('bgmplayer').classList.toggle("bgmon");
}
function playbtu(){
var oyd = document.getElementById('ydmc');
if (yaudio.paused) {
            yaudio.play();
           oyd.className = 'icon-music';
document.getElementById("ydfm").className = "Rotation";
        } else {
            yaudio.pause();
            oyd.className = 'icon-bofang';document.getElementById("ydfm").className = "";
        }
var playlistli=document.querySelectorAll("#playlist li");
playlistli.forEach((value, index) => {
    playlistli[index].classList.remove("yd-playing");
});
playlistli[a].classList.add("yd-playing");
}
function next(b) {
var oyd=document.getElementById('ydmc');if(b === undefined){
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
       oyd.className = 'icon-music';
document.getElementById("ydfm").className = "Rotation";
if(yaudio.art){yaudio.art='&nbsp;-&nbsp;'+yaudio.art;}
document.getElementById('ydtitle').innerHTML = yaudio.ti+yaudio.art;
document.getElementById("ydfm").src=yaudio.fm;
var playlistli=document.querySelectorAll("#playlist li");
playlistli.forEach((value, index) => {
    playlistli[index].classList.remove("yd-playing");
});
playlistli[a].classList.add("yd-playing");
}
function previous(){
var oyd=document.getElementById('ydmc');
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
       oyd.className = 'icon-music';
document.getElementById("ydfm").className = "Rotation";
if(yaudio.art){yaudio.art='&nbsp;-&nbsp;'+yaudio.art;}
document.getElementById('ydtitle').innerHTML = yaudio.ti+yaudio.art;
document.getElementById("ydfm").src=yaudio.fm;
var playlistli=document.querySelectorAll("#playlist li");
playlistli.forEach((value, index) => {
    playlistli[index].classList.remove("yd-playing");
});
playlistli[a].classList.add("yd-playing");
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