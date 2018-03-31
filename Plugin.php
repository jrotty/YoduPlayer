<?php
/**
 * 一款清爽的BGM播放器,需要您的主题支持pjax或者instantclick才能保证页面切换依旧播放
 * 
 * @package YoduPlayer
 * @author Jrotty
 * @version 2.1.0
 * @link http://qqdie.com/archives/typecho-yoduplayer.html
 */
class YoduPlayer_Plugin implements Typecho_Plugin_Interface
{ 
 public static function activate()
	{
        Typecho_Plugin::factory('Widget_Archive')->header = array('YoduPlayer_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('YoduPlayer_Plugin', 'footer');
    }
	/* 禁用插件方法 */
	public static function deactivate(){}
    public static function config(Typecho_Widget_Helper_Form $form){
       if(strcasecmp(Helper::options()->theme,'yodu')==0){
           echo '检测到您使用的是<b>'.Helper::options()->theme.'</b>模板，已为您启动定制策略！';
       }
 $random = new Typecho_Widget_Helper_Form_Element_Radio(
            'random', array('0' => '不随机播放', '1' => '随机播放'), 0, '随机播放设置',
            '随机播放顾名思义，就是页面打开后随机选择列表一首音乐播放');
        $form->addInput($random);

       $bof = new Typecho_Widget_Helper_Form_Element_Radio(
        'bof', array('0'=> '不自动播放', '1'=> '自动播放'), 0, '播放设置',
            '自动播放顾名思义，就是页面打开后音乐就会自动播放');
        $form->addInput($bof);

$sxj = new Typecho_Widget_Helper_Form_Element_Radio(
        'sxj', array('0'=> '隐藏', '1'=> '不隐藏'), 0, '手机端是/否隐藏',
            '');
        $form->addInput($sxj);
        $musicList = new Typecho_Widget_Helper_Form_Element_Textarea('musicList', NULL, 
'{title:"Alice",artist:"米白",mp3:"//p2.music.126.net/7_DtDbZXhlm-FWGzplUocg==/18802748347310691.mp3",cover:"//p3.music.126.net/R86tDfWlpXzhJFO1KJgfbQ==/17924238556217288.jpg?param=106x106",},
{title:"Old Memory",artist:"三輪学",mp3:"//p2.music.126.net/_b_IF6-KM0UHDJwP9u0Bdw==/1394180758436430.mp3",cover:"//p3.music.126.net/OpgpNNPKznDDMxoBqVJy-Q==/2464005557906815.jpg?param=106x106",},
',_t('歌曲列表'), _t('格式: {title:"xxx", artist:"xxx", mp3:"http:xxxx",cover:"图片地址",} ，每个歌曲之间用英文,隔开。请保证歌曲列表里至少有一首歌！'));
        $form->addInput($musicList);

            $sok = new Typecho_Widget_Helper_Form_Element_Textarea('sok', NULL, 
'',_t('自定义css'), _t('直接在这里输入css即可对播放器样式进行修改'));
        $form->addInput($sok);
    }
    
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    public static function header(){
 if(strcasecmp(Helper::options()->theme,'yodu')==0){
        $cssUrl = Helper::options()->pluginUrl . '/YoduPlayer/yodu/player.css';
    }else{
        $cssUrl = Helper::options()->pluginUrl . '/YoduPlayer/css/player.css';
}
        echo '<link rel="stylesheet" href="' . $cssUrl . '">';
if(Helper::options()->Plugin('YoduPlayer')->sxj=='0'){	
			echo '<style>@media only screen and (max-width:767px){#bgmplayer{display:none}}</style>'. "\n";
}
 if(strcasecmp(Helper::options()->theme,'yodu')==0){
   if(Helper::options()->skin && 'mr'==Helper::options()->skin){
if(Helper::options()->color && 'red'==Helper::options()->color){
	echo '<style>#bgmplayer {background: #F1587E;}.yd-playing { border-left: 3px solid #ffffff;}</style>';
}
if(Helper::options()->color && 'purple'==Helper::options()->color){
	echo '<style>#bgmplayer {background: #800080;}#jindu {background-color: #FF6363;}</style>';
}
if(Helper::options()->color && 'black'==Helper::options()->color){
	echo '<style>#bgmplayer {background: #000000;}#jindu {background-color: #CCC;}</style>';
}
     
   }
if(Helper::options()->skin && 'red'==Helper::options()->skin){
	echo '<style>#bgmplayer {background: #F1587E;}.yd-playing { border-left: 3px solid #ffffff;}</style>';
}
if(Helper::options()->skin && 'purple'==Helper::options()->skin){
	echo '<style>#bgmplayer {background: #800080;}#jindu {background-color: #FF6363;}</style>';
}
if(Helper::options()->skin && 'black'==Helper::options()->skin){
	echo '<style>#bgmplayer {background: #000000;}#jindu {background-color: #CCC;}</style>';
}
if(Helper::options()->skin && 'hei.css'==Helper::options()->skin){
	echo '<style>#bgmplayer {background: rgba(0, 0, 0, 0.5);}#jindu {background-color: rgba(251, 251, 251, 0.68);}</style>';
}
if(Helper::options()->skin && 'bai.css'==Helper::options()->skin || 'white.css'==Helper::options()->skin){
	echo '<style>#bgmplayer {background: rgba(255,255,255,0.8);color: black;box-shadow: 0 0 5px #ccc;}#jindu {background-color: rgba(0, 0, 0, 0.32);}.yd-playing {border-left: 3px solid #000000;}</style>';
}
if(Helper::options()->skin && 'tea.css'==Helper::options()->skin){
	echo '<style>#bgmplayer {background: #795548;}</style>';
}
if(Helper::options()->skin && 'old.css'==Helper::options()->skin){
	echo '<style>#bgmplayer {background: #888;}</style>';
}

}

    echo '<style>'.Helper::options()->plugin('YoduPlayer')->sok.'</style>';
    }

    public static function footer(){
        $options = Helper::options()->plugin('YoduPlayer'); 
if($options->musicList==""){$gqlb='{title:"風の道",artist:"conte-de-fees.com",mp3:"'.Helper::options()->pluginUrl . '/YoduPlayer/images/contedefees_0014.mp3",cover:"'.Helper::options()->pluginUrl . '/YoduPlayer/images/0014.jpg",},';}else{$gqlb=$options->musicList;}
		echo '
<div id="bgmplayer" class="bgmplayer">
<span class="bgmbuttom"  onClick="qiehuan();" >
<i id="ydmusic" class="icon-music"></i>
</span>
<div id="bgmpanel">
<div class="bgmfm"><img id="ydfm" src="" onerror=\'javascript:this.src="'.Helper::options()->pluginUrl . '/YoduPlayer/images/0014.jpg";this.onerror=null;\'></div>
<div class="bgmtitle"><span id="ydtitle"></span></div>
<div class="bgmtime"><span id="ytime">0:00</span></div>
<div class="bgmbtn">
<span onClick="previous();"><i class="icon-zuo"></i></span>
<span onclick="playbtu();"><i id="ydmc"></i></span>
<span onclick="next();"><i class="icon-you"></i></span>
<span onclick="liebiao();"><i class="icon-list"></i></span>
</div>
</div><div id="jindu"></div>
		<ol id="playlist"></ol></div>
             ';

        echo '<script data-no-instant>
var yaudio = new Audio();
yaudio.controls = true;
yaudio.loop = false;
var musicArr=[
'.$gqlb.'
              ];';
	      if (Helper::options()->Plugin('YoduPlayer')->random == '1') {echo 'var a=parseInt(Math.random()*musicArr.length);'. "\n";}else{
echo 'var a=0;'. "\n";}
echo 'var sj=musicArr[a];
yaudio.src=sj.mp3;
yaudio.ti=sj.title;
yaudio.art=sj.artist;
yaudio.fm=sj.cover;';
if(Helper::options()->Plugin('YoduPlayer')->bof=='1'){	
			echo 'yaudio.play();'. "\n";
}
echo '</script>';

        echo '<script  src="'.Helper::options()->pluginUrl . '/YoduPlayer/js/player.js" data-no-instant></script>' . "\n";
        echo '<script  src="'.Helper::options()->pluginUrl . '/YoduPlayer/js/prpr.js"></script>' . "\n";        
    }

}
