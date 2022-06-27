<?php
die('die');
//error_reporting(0);
set_time_limit(-1);
header('Content-Type: application/json; charset=utf-8');
//$html = file_get_contents("https://nex1music.ir/search/".urlencode($_GET['query'])."/page/".$_GET['page']."/");
$html = file_get_contents("https://nex1music.ir/?s=%D9%85%D8%AD%D8%B3%D9%86/");
//---------------------//
if ($_GET['type'] == "search")
{
    function getTitle()
    {
        global $html;
        preg_match_all('#<h2 class="f14"><i class="icn_blue"></i> <a href="(.*?)">(.*?)</a></h2>#', $html, $match);
        return $match[2];
    }
    function getLink()
    {
        global $html;
        preg_match_all('#<h2 class="f14"><i class="icn_blue"></i> <a href="(.*?)">(.*?)</a></h2>#', $html, $match);
        return $match[1];
    }
    function getLike()
    {
        global $html;
        preg_match_all('#<a id="p_like" class="like f14" rel="(.*?)"><i class="icn_like"></i> (.*?)</a>#', $html, $match);
        return $match[2];
    }
    function getView()
    {
        global $html;
        preg_match_all('#<span>موضوع : <a href="(.*?)" rel="category tag">موزیک</a> ، <a href="(.*?)" rel="category tag">موزیک ایرانی</a> \|\ (.*?) بازدید</span>#', $html, $match);
        return $match[3];
    }
    function getPhoto($link)
    {
        $html = file_get_contents($link);
        preg_match('#<p><img data-src="(.*?)" width="480" height="480" alt="(.*?)" /></p>#', $html, $match);
        return $match[1];
    }
    function getMusic320($link)
    {
        $html = file_get_contents($link);
        preg_match('#<a href="(.*?)"><i></i> دانلود آهنگ با کیفیت اصلی</a><a href="(.*?)"><i></i> دانلود آهنگ با کیفیت 128</a></div>#', $html, $match);
        return explode('?time', $match[1])[0];
    }
    function getMusic128($link)
    {
        $html = file_get_contents($link);
        preg_match('#<a href="(.*?)"><i></i> دانلود آهنگ با کیفیت اصلی</a><a href="(.*?)"><i></i> دانلود آهنگ با کیفیت 128</a></div>#', $html, $match);
        return explode('?time', $match[2])[0];
    }
    function getId()
    {
        global $html;
        preg_match_all('#<a id="p_like" class="like f14" rel="(.*?)"><i class="icn_like"></i> (.*?)</a>#', $html, $match);
        return $match[1];
    }
    //-----------------------//
    for ($i = 0; $i < count(getLink()); $i++)
    {
        $array[$i]['Title'] = trim(str_replace(['به نام', 'دانلود آهنگ'], ['-', null], getTitle()[$i]));
        $array[$i]['Like'] = getLike()[$i];
        $array[$i]['View'] = getView()[$i];
        $array[$i]['Link'] = getLink()[$i];
        $array[$i]['Id'] = getId()[$i];
        $array[$i]['Photo'] = getPhoto(getLink()[$i]);
        $array[$i]['Music_320'] = getMusic320(getLink()[$i]);
        $array[$i]['Music_128'] = getMusic128(getLink()[$i]);
    }
    if (count(getLink()) > 1)
    {
        //echo json_encode(['Ok'=> true, 'Result'=> $array]);
    }
    else
    {
        //echo json_encode(['Ok'=> false]);
    }
}
/*

https://t.me/ghalebwp

https://t.me/ThemeWorld
*/
?>