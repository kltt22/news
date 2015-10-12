<?php
 
function _get($str){ 
$val = !empty($_GET[$str]) ? $_GET[$str] : null; 
return $val; 
} 
$urlarray=explode("/", _get('t')); 

$url = "http://".$urlarray[0].".sohu.com/".$urlarray[1]."/".$urlarray[2];
$html =  file_get_contents($url);
	$html = iconv( "gb2312" , "utf-8//IGNORE" , $html );
$text=$html; 
//去除换行及空白字符（序列化內容才需使用）
//$text=str_replace(array("/r","/n","/t","/s"), '', $text);  
//取出 div 标签且 id 为 PostContent 的內容，并储存至二维数组 $match 中   
preg_match('/<div[^>]*itemprop="articleBody"[^>]*>(.*?) <\/div>/si',$text,$match);
//打印出match[0]
print($match[0]);
				?>