<?php
 include( dirname(__FILE__) . '/tiqu.php' );
 include( dirname(__FILE__) . '/config.php' );
 //include( dirname(__FILE__) . '/simple_html_dom.php' );
function _get($str){ 
	$val = !empty($_GET[$str]) ? $_GET[$str] : null; 
	return $val; 
} 
$urlarray=explode("/", _get('t')); 
$url = "http://".$urlarray[0].".sohu.com";
$urltemp="";
for($i=1;$i<count($urlarray);$i++)
{
	$urltemp=$urltemp."/".$urlarray[$i];
}
$url= $url.$urltemp;


if (count(explode("pic",$url))>1)
{
	if(stripos($url,"focus.cn"))//有focus.cn搜狐焦点网，这个站不是.sohu.com
	{
		 $url=str_replace(".sohu.com", "", $url);
	}

	$htm = new tiqu();
	$htm->pic($url);

	$title=$htm->pubtitle;
	$main=$htm->content;
	$tag=$htm->pubtag;
	$ptime=$htm->pubtime;
	$xnews=$htm->xgnews;
}
else
{
	$htm = new tiqu();
	$htm->roll($url);

	$title=$htm->pubtitle;
	$main=$htm->content;
	$tag=$htm->pubtag;
	$ptime=$htm->pubtime;
	$xnews=$htm->xgnews;
}
?>

<!DOCTYPE html lang=""zh-cn"">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php 

echo $title.$tag."-".$web_name; 
?></title>
<meta name="keywords" content="<?php echo $web_key; ?>" />
<meta name="description" content="<?php echo $web_des; ?>" />

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
<div class="conpage">
<div class="title">
<h1>
<?php
echo $title;
?>
</h1>
<span>
<?php
echo $ptime;
?>
	</span>
</div>
<div class="con">
	<?php
echo $main;
?>
</div>

</div>
<div style=" clear: both;"></div>
<div class="xgnews">
<h3>相关文章</h3>
<?php
echo $xnews;
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


				