<?php
/**
 * 一款清爽的BGM播放器,需要您的主题支持pjax或者instantclick才能保证页面切换依旧播放
 * 
 * @package YoduPlayer
 * @author Jrotty
 * @version 2.3.3
 * @link https://github.com/jrotty/YoduPlayer
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

$d=array();
$n=0;
while ($n<=200) {
$d[$n] = $n.'px';$n=$n+5;
}

    $set1 = new Typecho_Widget_Helper_Form_Element_Select('top', $d, '65', _t('距离顶部间距'), _t('播放器按钮显示在网页的右上角，这里的设置就是播放器组件距离顶部的间距，默认为65px'));
    $form->addInput($set1);

$sxj = new Typecho_Widget_Helper_Form_Element_Radio(
        'sxj', array('0'=> '隐藏', '1'=> '不隐藏'), 0, '手机端是/否隐藏',
            '');
        $form->addInput($sxj);
        $musicList = new Typecho_Widget_Helper_Form_Element_Textarea('musicList', NULL, NULL,_t('歌曲列表'), _t('格式: {title:"xxx", artist:"xxx", mp3:"http:xxxx",cover:"图片地址",} ，每个歌曲之间用英文,隔开。请保证歌曲列表里至少有一首歌！'));
        $form->addInput($musicList);
      
            $sok = new Typecho_Widget_Helper_Form_Element_Textarea('sok', NULL, 
'',_t('自定义css'), _t('直接在这里输入css即可对播放器样式进行修改'));
        $form->addInput($sok);
    }
    
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    public static function header(){
        $cssUrl = Helper::options()->pluginUrl . '/YoduPlayer/css/player.css?2022328';
        echo '<link rel="stylesheet" href="' . $cssUrl . '">';
        $css="";
if(Helper::options()->Plugin('YoduPlayer')->top){
		$css.='#bgmplayer{top: '.Helper::options()->Plugin('YoduPlayer')->top.'px;}';  
}
if(Helper::options()->Plugin('YoduPlayer')->sxj=='0'){	
		$css.='@media only screen and (max-width:767px){#bgmplayer{display:none}}';
}
    echo '<style>'.$css.Helper::options()->plugin('YoduPlayer')->sok.'</style>';
    }

    public static function footer(){
        $options = Helper::options()->plugin('YoduPlayer'); 
if($options->musicList==""){
    $gqlb='{title:"未设置歌曲",artist:"",mp3:"'.Helper::options()->pluginUrl . '/YoduPlayer/images/huaq.mp3",cover:"'.Helper::options()->pluginUrl . '/YoduPlayer/images/moren.jpg",},';}else{$gqlb=$options->musicList;}
		echo '
<div id="bgmplayer" class="bgmplayer">
<span class="bgmbuttom"  onClick="qiehuan();" >
<i id="ydmusic" class="icon-music"></i>
</span>
<div id="bgmpanel">
<div class="bgmfm" onclick="playbtu();"><img id="ydfm" class="Rotation paused" src="" onerror=\'javascript:this.src="'.Helper::options()->pluginUrl . '/YoduPlayer/images/0014.jpg";this.onerror=null;\'></div>
<div class="bgmtitle"><span id="ydtitle"></span></div>
<div class="bgmtime"><span id="ytime">0:00</span></div>
<div class="bgmbtn">
<span onClick="previous();"><i class="icon-zuo"></i></span>
<span onclick="playbtu();"><i id="ydmc"></i></span>
<span onclick="next();"><i class="icon-you"></i></span>
<span onclick="liebiao();"><i class="icon-list"></i></span>
</div>
</div><div id="jindu"></div>
		<ul id="playlist"></ul></div>
             ';

        echo '<script data-no-instant>
var yaudio = new Audio();
yaudio.controls = true;
yaudio.loop = false;
yaudio.volume = 0.68;
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
echo '</script>';

        echo '<script  src="'.Helper::options()->pluginUrl . '/YoduPlayer/js/player.js?2022328" data-no-instant></script>' . "\n";
        echo '<script  src="'.Helper::options()->pluginUrl . '/YoduPlayer/js/prpr.js?2022328"></script>' . "\n";        
    }

}
