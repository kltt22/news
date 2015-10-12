<?php
	include( dirname(__FILE__) . '/config.php' );
	function _get($str){ 
$val = !empty($_GET[$str]) ? $_GET[$str] : null; 
return $val; 
} 
$urlarray=explode("/", _get('t')); 

	$url = "http://".$urlarray[0].".sohu.com/".$urlarray[1]."/".$urlarray[2];
	
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
	preg_match_all( '/<title>([\s\S]*?)-([\s\S]*?)<\/title>/' , $html , $str );
	$title1=$str[1][0];//获取文章标题


	preg_match_all( '/<div class="tagIntg">([\s\S]*?)<\/div>/' , $html , $str );
	if (count($str[0])>0)
	{
	$strlag="ok";
	$titlernd=$str[0][0];
	 preg_match_all( '/<li><a([\s\S]*?)>([\s\S]*?)<\/a><\/li>/' , $titlernd , $titlestr );//获取相关长尾词
		shuffle($titlestr[2]);//打乱顺序，实现随机抽取
		}
	else
	$strlag="";
	
 preg_match_all( '/<([\s\S]*?)time([\s\S]*?)>([\s\S]*?)</' , $html , $str );
 //var_dump($str);
var_dump($str);
echo $str[3][count($str[3])-1];

echo $str[3][count($str[3])-2];
die();

	/**
	preg_match_all( '/ <div id=\"media_name\" style=\"display:none\">([\s\S]*?)<\/div>/' , $html , $str );
	$conly=$str[1][0];//获取文章来源**/
	preg_match_all( '/id=\"contentText\">([\s\S]*?)<\/div>/' , $html , $str );
	$con=$str[1][0];//获取文章内容
	
	echo $con;
	die();
	
		
		
		

    
	

?>
<!DOCTYPE html lang=""zh-cn"">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $tit.','.$web_key; ?>" />
<meta name="description" content="<?php echo $tit.','.$web_des; ?>" />
<title><?php 
if ($strlag=="ok")
echo $title1."-".$titlestr[2][0]."-".$titlestr[2][1]."-".$titlestr[2][2]."-".$titlestr[2][3]."-".$titlestr[2][4]; 
else
echo $title1;
?></title>
<style>
.body{
	width:960px;
	height:auto;
	margin:0px auto;
}
.block{
	width:960px;
	height:auto;
	margin:0px auto;
	border-top:#000000 5px solid;
	border-bottom:#000000 5px solid;
}
.title{
	width:940px;
	height:35px;
	margin-left:20px;
	line-height:35px;
	font-family:Microsoft YaHei ! important;
	font-size:24px;
	color:#339900;
	border-bottom:#333333 1px solid;
}
.con{
	width:960px;
	height:auto;
	margin:0px;
	margin-top:2px;
	font-family:Microsoft YaHei ! important;
	font-size:18px;
	line-height:30px;
	text-indent:36px;
}
.about{
	text-align:center;
	font-size:16px;
	font-family:Microsoft YaHei ! important;
	line-height:20px;
}
</style>
</head>
<body>
	<div class="block">
		<div class="title"><?php echo $tit; ?></div>
		<div class="con">
			<?php
				echo $con;
			?>
		</div>
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