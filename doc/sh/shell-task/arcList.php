<?php

/**
*	文章栏目列表调取接口
*
* 参数名    可必选    描述
* typeid      是      栏目id号
* evtype      否      电动类型（可选值：电动汽车[evauto] 电动自行车[evbicycle]）
* pageindex   否      页码
* pagesize    否      每页显示条数（默认10）
* limit       否      限制显示条数（默认100）
* flag        否      文章属性（头条[h]推荐[c]图片[p]幻灯[f]滚动[s]跳转[j]特荐[a]加粗[b]）
*
*/
include (dirname(__FILE__).'/../../config.php');
function  getArcList($typeid,$flag,$orderby,$desc='desc',$limit,$pageindex,$pagesize)
{	
	 $rowArcList = array();
	 $url = $GLOBALS['mainurl']."/api/m/article/arcList.php?fname=getArcList&typeid=$typeid&flag=$flag&orderby=$orderby&desc=$desc&limit=$limit&pageindex=$pageindex&pagesize=$pagesize";
	$cachekey = md5($url);
	//$rowArcList = GetCache('mobile', $cachekey);	
	if(empty($rowArcList)){
	 $json_string = getUrlContent($url); 	
	 $rowArcList = json_decode($json_string,true);	
	 $rowArcList =   AutoCharset($rowArcList,'utf-8','gbk');
	 SetCache('mobile', $cachekey, $rowArcList);	
	}
/*	//echo $url;exit;
	 $json_string = getUrlContent($url); 	
	 $rowArcData = json_decode($json_string,true);
	 $rowArcList =   AutoCharset($rowArcData,'utf-8','gbk');		
*/
	 return $rowArcList;

}


/**
*	文章栏目列表调取接口
*
* 参数名    可必选    描述
* typeid      是      栏目id号
* evtype      否      电动类型（可选值：电动汽车[evauto] 电动自行车[evbicycle]）
* pageindex   否      页码
* pagesize    否      每页显示条数（默认10）
* limit       否      限制显示条数（默认100）
* flag        否      文章属性（头条[h]推荐[c]图片[p]幻灯[f]滚动[s]跳转[j]特荐[a]加粗[b]）
*
*/
function  getArcListExt($typeid,$flag,$orderby,$desc='desc',$limit,$pageindex,$pagesize)
{	
	 $rowArcList = array();
	 $url = $GLOBALS['mainurl']."/api/m/article/arcList.php?fname=getArcListExt&typeid=$typeid&flag=$flag&orderby=$orderby&desc=$desc&limit=$limit&pageindex=$pageindex&pagesize=$pagesize";
	$cachekey = md5($url);
	$rowArcList = GetCache('mobile', $cachekey);	
	if(empty($rowArcList)){
	 $json_string = getUrlContent($url); 	
	 $rowArcList = json_decode($json_string,true);		 
	 $rowArcList =   AutoCharset($rowArcList,'utf-8','gbk');
	 SetCache('mobile', $cachekey, $rowArcList, CACHE_TIME_LIST);	
	}
/*	//echo $url;exit;
	 $json_string = getUrlContent($url); 	
	 $rowArcData = json_decode($json_string,true);
	 $rowArcList =   AutoCharset($rowArcData,'utf-8','gbk');		
*/
	return $rowArcList;

}


/**
 *  返回新闻的关联新闻内容
 *
 * @access    public
 * @param     int  $aid  文档AID
 * @return    void
 */
function GetRelateNews($location,$aid){
	 $url =$GLOBALS['mainurl']."/api/m/article/arcList.php?fname=GetRelateNews&location=$location&aid=$aid";
	 $html = getUrlContent($url); 
	 return $html;
		
}


?>
