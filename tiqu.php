<?php
include( dirname(__FILE__) . '/simple_html_dom.php' );
class tiqu
{
	public $content="";//正文
	public $pubtitle="";//标题
	public $pubtag="";//长尾关键词
	public $pubtime="";//发布时间
	public $xgnews="";//相关新闻
	function roll($url)//普通文章提取
	{ 
		$html =  file_get_contents($url);
		$html = iconv( "gb2312" , "utf-8//IGNORE" , $html );
		$htm = new simple_html_dom();
		$htm->load($html);
		$main = $htm->find('div[id=contentText]',0);
		if (!isset($main))
		{
			if(null==$htm->find('div[itemprop="articleBody"]',0))//媒体栏目下的正文标签
			{die();}
		     else
		     {
		     	$main =$htm->find('div[itemprop="articleBody"]',0);
		     }
			
		}
		//清除原站seo数据
		$tt = $main->find('div[style="display:none;"]',0);
		if ($tt!=null)
		{
			$tt->outertext='';
		}
		//清除原站广告框架
		$tt = $main->find('iframe',0);
		if ($tt!=null)
		{

			$tt->outertext='';	
		}
         //清除原站A链接
		$a = $main->find('a');
		if (count($a)>0)
		{
			for($i=0;$i<count($a);$i++) 
			{
				$a[$i]->href = null;
			}

		}
		$this->content=$main->innertext;//输出正文
        //输出标题
		$title = $htm->find('h1');
		$h1="";
		for ($i=0;$i<count($title);$i++)
		{
			$h1=$h1.$title[$i]->plaintext;
			$h1=str_replace("搜狐", "", $h1);
		}
        $this->pubtitle=$h1;
        //输出发布时间
		$time=$htm->find('.time',0);
		$this->pubtime=$time->plaintext;
		//输出长尾关键词
		$tag=$htm->find('.tagIntg',0);
		$titletag="";
		if(isset($tag))
		{
			$titletag=$tag->plaintext;
			$titletag=str_replace("                                  ", ",", $titletag);
			$titletag=str_replace("                              ", ",", $titletag);
		}
        $this->pubtag=$titletag;
        //输出相关新闻
		$xnew=$htm->find('.list14',0);
		$xnews="";
		if(isset($xnew))
		{
			$xnewtt=$xnew->find('.more',0);
			if(isset($xnewtt))
			{
				$xnewtt->outertext='';
			}
			$xnews=$xnew->innertext;
			$xnews=str_replace("http://", "read.php?t=", $xnews);
            $xnews=str_replace(".sohu.com", "", $xnews);
		}
        $this->xgnews=$xnews;
        $htm->clear();
	

	}

	function pic($url)//图库提取
	{//图库页面标题
		$html =  file_get_contents($url);
		$html = iconv( "gb2312" , "utf-8//IGNORE" , $html );
		$htm = new simple_html_dom();
		$htm->load($html);
		$h1 = $htm->find('h1',0);
		$this->pubtitle=$h1->children(0)->plaintext;
		$htm->clear();//释放对象

        //图库正文
		$jsurl=str_replace("shtml","js", $url);
		$html =  file_get_contents($jsurl);

		$html = iconv( "gb2312" , "utf-8//IGNORE" , $html );
		preg_match_all( '/=([\s\S]*?)};/' , $html , $str );

		$nstr=str_replace("=","", $str[0][0]);

		$nstr=str_replace(";", "", $nstr);

		$json=json_decode($nstr,true);

        $main="";
		for($i=0;$i<count($json['items']);$i++)
		{
			$main=$main."<img src=".$json['items'][$i]['link'].$json['items'][$i]['pic2']." width='500px'  alt='".$json['items'][$i]['title']."'>";
			$main=$main."<p>".$json['items'][$i]['desc']."</P>";
		}
		$this->content=$main;
	}
}
?>