function liebiao(){
document.querySelector("#playlist").classList.toggle("yhidden");
}
function qiehuan(){
document.querySelector("#playlist").classList.add("yhidden");
document.getElementById('bgmplayer').classList.toggle("bgmon");
document.querySelector("#playlist").scrollTop = document.querySelector(".yd-playing").offsetTop - document.querySelector(".yd-lib").offsetTop;
}
//播放/暂停按钮
function playbtu(){
var oyd = document.getElementById('ydmc');
if (yaudio.paused) {
yaudio.play();//播放音乐并设置图标
oyd.innerHTML = '<svg viewBox="0 0 20 20" fill="currentColor" class="ydicon"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
document.getElementById("ydfm").classList.remove("paused");
} else {
yaudio.pause();//暂停音乐并设置图标
oyd.innerHTML= '<svg viewBox="0 0 20 20" fill="currentColor" class="ydicon"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>';
document.getElementById("ydfm").classList.add("paused");
        }
}

//点播
function dianbo(b,s=0) {
var oyd=document.getElementById('ydmc');
var geshou= '';
document.getElementById("ydfm").classList.add("paused");
document.getElementById('jindu').style.width='0%';
        a=b;//交接
        sj = musicArr[a];
        yaudio.src = sj.mp3;
        yaudio.ti = sj.title;
        yaudio.art = sj.artist;
		yaudio.fm=sj.cover;
if(yaudio.art.length>0){geshou='&nbsp;-&nbsp;'+yaudio.art;}
document.getElementById('ydtitle').innerHTML = yaudio.ti+geshou;
document.getElementById("ydfm").src=yoduplayerpath+'/images/loading.svg';
var img = new Image();
img.src = yaudio.fm;
img.onload = function(){
document.getElementById("ydfm").src=img.src;
document.getElementById("yodubg").style.backgroundImage="url("+img.src+")";
document.getElementById("ydfm").classList.remove("paused");
}
var playlistli=document.querySelectorAll("#playlist li");
playlistli.forEach((value, index) => {
    playlistli[index].classList.remove("yd-playing");
});
playlistli[a].classList.add("yd-playing");
if(s==0){
        yaudio.play();autopause=1;
oyd.innerHTML = '<svg viewBox="0 0 20 20" fill="currentColor" class="ydicon"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
}
}
//上一首
function previous(){
if (a == 0) {//如果当前歌曲是第一首则跳转至最后一首
a =musicArr.length - 1;
}else{//否则跳转至上一首
a = a-1;
}
dianbo(a);//使用next函数进行点播
}
//下一首
function next(s=0){
if (a == musicArr.length - 1) {
a = 0;
}else{
a = a+1;
}  
dianbo(a,s);
}


yaudio.addEventListener("error" ,function() {
if(autonum<=5){autonum++;
if(autopause==0){next(1);}else{next();}
}else{
console.info('播放列表歌曲链接大量失效！');
}
},false);


yaudio.addEventListener('ended',function() {next();},false);