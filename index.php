<?php
	include( dirname(__FILE__) . '/config.php' );
	function _get($str){ 
$val = !empty($_GET[$str]) ? $_GET[$str] : null; 
return $val; 
} 
	if( _get('p') == "" ){
		$url = "http://roll.sohu.com/";
	} else {
		$url = "http://roll.sohu.com/index_"._get('p').".shtml";
	}
	if( _get('m') == "" ){
		$url = "http://roll.sohu.com/";
	} else {
		$url = "http://roll.sohu.com/"._get('m')."_bak/";
	}
	//echo $url;
	//die();
	
	function curl_get_contents($url)   
{   define("_USERAGENT_","Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36");
    $ch = curl_init();   
    curl_setopt($ch, CURLOPT_URL, $url);            //设置访问的url地址   
    //curl_setopt($ch,CURLOPT_HEADER,1);            //是否显示头部信息   
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);           //设置超时   
    curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);   //用户访问代理 User-Agent   
    //curl_setopt($ch, CURLOPT_REFERER,_REFERER_);        //设置 referer   
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);      //跟踪301   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果   
    $r = curl_exec($ch);   
    curl_close($ch);   
    return $r;   
}  
	$html =  curl_get_contents($url);
	$html = iconv( "gb2312" , "utf-8//IGNORE" , $html );
	
	

	preg_match_all( '/\_(.*?)\.shtml\'>上一页/' , $html , $str );

	if (count($str[0])>0)
	{
	$page1=$str[1][0];
	}
    else
	{
	$page1="";
	}
	
	preg_match_all( '/\_(.*?)\.shtml\'>下一页/' , $html , $str );
	if (count($str[0])>0)
	{
	$page2=$str[1][0];
	}
    else
	{
	$page2="#";
	}

	preg_match_all( '/\_(.*?)\.shtml\'>末页/' , $html , $str );
    if (count($str[0])>0)
	{
	$page3=$str[1][0];
	}
    else
	{
	$page3="#";
	}
    
	
	preg_match_all( '/<div class="list14">([\s\S]*?)<\/div>/' , $html , $str );
     $htmlcon=$str[0][0];
	preg_match_all( '/<div class="sideNav">([\s\S]*?)<\/div>/' , $html , $str );
     $htmlnav=$str[0][0];
	
	preg_match_all( '/<li>(.*?)<\/li>/' , $htmlcon , $str100 );
	preg_match_all( '/<li>(.*?)<\/li>/' , $htmlnav , $navstr );
    
	
?>
<!DOCTYPE html lang=""zh-cn"">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $web_key; ?>" />
<meta name="description" content="<?php echo $web_des; ?>" />
<title>最新新闻-新闻头条-<?php echo $web_name; ?></title>
<link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
<div class="nav">
<ul>
<li><a href="/"><strong>首页</strong></a></li>
<li><a href="?m=yule">娱乐</a></li>
<li><a href="?m=it">IT数码</a></li>
<li><a href="?m=auto">汽车</a></li>
<li><a href="?m=sports">体育</a></li>
<li><a href="?m=focus">房产</a></li>
<li><a href="?m=women">女性</a></li>
<li><a href="?m=fashion">时尚</a></li>
<li><a href="?m=health">健康</a></li>
<li><a href="?m=cul">文化</a></li>
<li><a href="?m=learning">教育</a></li>
<li><a href="?m=money">财经</a></li>
<li><a href="?m=stock">证券</a></li>
<li><a href="?m=games">游戏</a></li>
<li><a href="?m=media">媒体</a></li>
<li><a href="?m=city">城市</a></li>
<li><a href="?m=luxury">奢侈品</a></li>
<li><a href="?m=star">评论</a></li>
<li><a href="?m=travel">旅游</a></li>
<li><a href="?m=pic">大视野</a></li>
<li><a href="?m=subject">专题</a></li>
</ul>
</div>
<div class="block">
<ul>
<?php

for( $i = 0 ; $i <= count($str100[1])-1 ; $i++ ){

?>
	
	<li>
	<?php 

    $li=str_replace("[<a href=\"http://roll.sohu.com/", "[<a href=\"?m=", $str100[1][$i]);
	$li=str_replace("/\"", "\"", $li);
	$li=str_replace("http://", "read.php?t=", $li);
	$li=str_replace(".sohu.com", "", $li);
	$li=str_replace("[", "", $li);
	$li=str_replace("]", "", $li);
	echo $li;
	?>
	</li>
<?php
}
?>
</ul>
</div>
<div class="page">
	<a href="/">首页</a>
	<?php
	if ($page1!="")
	{
	
	echo "<a href=\"?p=".$page1."\">上一页</a>";
	
	}
	else
	{
	echo "上一页";
	}
	echo "<a href=\"?p=".$page2."\">下一页</a>";
	echo "<a href=\"?p=".$page3."\">末页</a>";
	?>
	
	
</div>
<br />
<hr>
<p class="about">
	<?php
		echo $about.$tongji;
		
	?>
</p>
</body>
</html>