<?php

/**
 * 一款清爽的BGM播放器,需要您的主题支持pjax或者instantclick才能保证页面切换依旧播放
 *
 * @package YoduPlayer
 * @author Jrotty
 * @version 1.9.0
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
    public static function deactivate()
    {
    }

    public static function config(Typecho_Widget_Helper_Form $form)
    {

        $yoduc = new Typecho_Widget_Helper_Form_Element_Radio(
            'yoduc', array('0' => '默认', '1' => 'YoDu主题'), 0, '主题选择',
            '使用默认即可，如果你是用的YoDu主题模板，选择第二个不会额外加载字体文件，并且会根据yodu主题皮肤自动变色');
        $form->addInput($yoduc);

        $bof = new Typecho_Widget_Helper_Form_Element_Radio(
            'bof', array('0' => '不自动播放', '1' => '自动播放'), 0, '播放设置',
            '自动播放顾名思义，就是页面打开后音乐就会自动播放');
        $form->addInput($bof);

        $random = new Typecho_Widget_Helper_Form_Element_Radio(
            'random', array('0' => '不随机播放', '1' => '随机播放'), 0, '随机播放设置',
            '随机播放顾名思义，就是页面打开后随机选择列表一首音乐播放');
        $form->addInput($random);

        $sxj = new Typecho_Widget_Helper_Form_Element_Radio(
            'sxj', array('0' => '隐藏', '1' => '不隐藏'), 0, '手机端是/否隐藏',
            '');
        $form->addInput($sxj);
        $musicList = new Typecho_Widget_Helper_Form_Element_Textarea('musicList', NULL,
            '{title:"Alice",artist:"米白",mp3:"//p2.music.126.net/7_DtDbZXhlm-FWGzplUocg==/18802748347310691.mp3",cover:"//p3.music.126.net/R86tDfWlpXzhJFO1KJgfbQ==/17924238556217288.jpg?param=106x106",},
{title:"Old Memory",artist:"三輪学",mp3:"//p2.music.126.net/_b_IF6-KM0UHDJwP9u0Bdw==/1394180758436430.mp3",cover:"//p3.music.126.net/OpgpNNPKznDDMxoBqVJy-Q==/2464005557906815.jpg?param=106x106",},
', _t('歌曲列表'), _t('格式: {title:"xxx", artist:"xxx", mp3:"http:xxxx",cover:"图片地址",} ，每个歌曲之间用英文,隔开。请保证歌曲列表里至少有一首歌！<br><br><div style="background-color:#56A5CE;padding:5px 8px;max-width:250px;border-radius: 2px;"><a href="' . Helper::options()->pluginUrl . '/YoduPlayer/wyapi.php" target="_blank" style="font-size:14px;color:#fff;outline:none;text-decoration:none;">网易云音乐id解析(主机需支持curl扩展)</a>
        	</div>请自行去网易云音乐网页版获取音乐id(具体在每个音乐项目的网址最后会有个id)。<b>将解析出的音乐链接复制到上面歌曲列表里(注意检查与现有歌曲是否用英文,隔开)</b>'));
        $form->addInput($musicList);

        $sok = new Typecho_Widget_Helper_Form_Element_Textarea('sok', NULL,
            '', _t('自定义css'), _t('直接在这里输入css即可对播放器样式进行修改'));
        $form->addInput($sok);
    }

    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }

    public static function header()
    {
        if (Typecho_Widget::widget('Widget_Options')->Plugin('YoduPlayer')->yoduc == '1') {
            $cssUrl = Helper::options()->pluginUrl . '/YoduPlayer/yodu/player.css';
        } else {
            $cssUrl = Helper::options()->pluginUrl . '/YoduPlayer/css/player.css';
        }
        echo '<link rel="stylesheet" href="' . $cssUrl . '">';
        if (Typecho_Widget::widget('Widget_Options')->Plugin('YoduPlayer')->sxj == '0') {
            echo '<style>@media only screen and (max-width:767px){#bgmplayer{display:none}}</style>' . "\n";
        }
        if (Typecho_Widget::widget('Widget_Options')->Plugin('YoduPlayer')->yoduc == '1') {

            if (Typecho_Widget::widget('Widget_Options')->skin && 'red' == Typecho_Widget::widget('Widget_Options')->skin) {
                echo '<style>#bgmplayer {background: #F1587E;}</style>';
            }
            if (Typecho_Widget::widget('Widget_Options')->skin && 'purple' == Typecho_Widget::widget('Widget_Options')->skin) {
                echo '<style>#bgmplayer {background: #800080;}#jindu {background-color: #FF6363;}</style>';
            }
            if (Typecho_Widget::widget('Widget_Options')->skin && 'black' == Typecho_Widget::widget('Widget_Options')->skin) {
                echo '<style>#bgmplayer {background: #000000;}#jindu {background-color: #CCC;}</style>';
            }
            if (Typecho_Widget::widget('Widget_Options')->skin && 'hei.css' == Typecho_Widget::widget('Widget_Options')->skin) {
                echo '<style>#bgmplayer {background: rgba(0, 0, 0, 0.5);}#jindu {background-color: rgba(251, 251, 251, 0.68);}</style>';
            }
            if (Typecho_Widget::widget('Widget_Options')->skin && 'bai.css' == Typecho_Widget::widget('Widget_Options')->skin || 'white.css' == Typecho_Widget::widget('Widget_Options')->skin) {
                echo '<style>#bgmplayer {background: rgba(255,255,255,0.8);color: black;box-shadow: 0 0 5px #ccc;}#jindu {background-color: rgba(0, 0, 0, 0.32);}</style>';
            }
            if (Typecho_Widget::widget('Widget_Options')->skin && 'tea.css' == Typecho_Widget::widget('Widget_Options')->skin) {
                echo '<style>#bgmplayer {background: #795548;}</style>';
            }
            if (Typecho_Widget::widget('Widget_Options')->skin && 'old.css' == Typecho_Widget::widget('Widget_Options')->skin) {
                echo '<style>#bgmplayer {background: #888;}</style>';
            }

        }

        echo '<style>' . Typecho_Widget::widget('Widget_Options')->plugin('YoduPlayer')->sok . '</style>';
    }

    public static function footer()
    {
        $options = Typecho_Widget::widget('Widget_Options')->plugin('YoduPlayer');
        if ($options->musicList == "") {
            $gqlb = '{title:"風の道",artist:"conte-de-fees.com",mp3:"' . Helper::options()->pluginUrl . '/YoduPlayer/images/contedefees_0014.mp3",cover:"' . Helper::options()->pluginUrl . '/YoduPlayer/images/0014.jpg",},';
        } else {
            $gqlb = $options->musicList;
        }
        echo '
<div id="bgmplayer" class="bgmplayer">
<span class="bgmbuttom"  onClick="qiehuan();" >
<i id="ydmusic" class="icon-music"></i>
</span>
<div id="bgmpanel">
<div class="bgmfm"><img id="ydfm" src="" onerror=\'javascript:this.src="' . Helper::options()->pluginUrl . '/YoduPlayer/images/0014.jpg";this.onerror=null;\'></div>
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

        if (Typecho_Widget::widget('Widget_Options')->Plugin('YoduPlayer')->random == '1') {
            echo '<script data-no-instant>
          var yaudio = new Audio();
yaudio.controls = true;
yaudio.loop = false;
var musicArr=[
' . $gqlb . '
              ];
var a = parseInt(Math.random()*(musicArr.length));
var sj=musicArr[a];
yaudio.src=sj.mp3;
yaudio.ti=sj.title;
yaudio.art=sj.artist;
yaudio.fm=sj.cover;';
        } else {
            echo '<script data-no-instant>
var yaudio = new Audio();
yaudio.controls = true;
yaudio.loop = false;
var musicArr=[
' . $gqlb . '
              ];
var a = 0;
var sj=musicArr[a];
yaudio.src=sj.mp3;
yaudio.ti=sj.title;
yaudio.art=sj.artist;
yaudio.fm=sj.cover;';
        }
        if (Typecho_Widget::widget('Widget_Options')->Plugin('YoduPlayer')->bof == '1') {
            echo 'yaudio.play();' . "\n";
        }
        echo '</script>';

        echo '<script  src="' . Helper::options()->pluginUrl . '/YoduPlayer/js/player.js" data-no-instant></script>' . "\n";
        echo '<script  src="' . Helper::options()->pluginUrl . '/YoduPlayer/js/prpr.js"></script>' . "\n";
    }

}
