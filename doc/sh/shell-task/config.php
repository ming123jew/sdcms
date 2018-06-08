<?php 
$GLOBALS['mainurl'] =  "http://www.evdays.com";
$GLOBALS['subDomainUrl'] = 'http://m.evdays.com';
/*$GLOBALS['mainurl'] =  "http://192.168.1.222";
$GLOBALS['subDomainUrl'] = 'http://m.evdays.com';*/

//*****缓存start******//

define('MROOT', str_replace("\\", '/', dirname(__FILE__)));
define('MAPI', MROOT.'/api' );
define('MDATA', MROOT.'/data');
include(MAPI.'/cache/cache.php');
include(MAPI.'/file/file.php');
include(MAPI.'/common/cookie.helper.php');


define("CACHE_TIME_LIST",300);//列表缓存５分钟
define("CACHE_TIME_RelateNews",900);//列表缓存1５分钟

//*****缓存end******//
ini_set('date.timezone','Asia/Shanghai');
ini_set("error_reporting","E_ALL & ~E_NOTICE");


function  getUrlContent($url,$params='')
{
	
	//$params = implode('&',$params);
	$ch = curl_init();// 创建一个新cURL资源
	$timeout = 4;
	curl_setopt ($ch, CURLOPT_URL, $url);//需要获取的URL地址，也可以在 curl_init()函数中设置。
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0); //强制协议为1.0
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); //强制使用IPV4协议解析域
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);//将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
	curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout);//设置curl允许执行的最长秒数
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);//在发起连接前等待的时间，如果设置为0，则无限等待。
	curl_setopt ( $ch, CURLOPT_POST, 1 ); //启用POST提交
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params);


	$file_contents = curl_exec($ch);
	$curl_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
	$t = 0;
	if($curl_code==200){
		curl_close($ch);//关闭cURL资源，并且释放系统资源
		return $file_contents;
	}
	/**
	else{
		$t++;
		if($t==5){
			return "";
		}else{
			getUrlContent($url,$params);
		}
	}
	
/*	curl_close($ch);//关闭cURL资源，并且释放系统资源
	return $file_contents;*/

}

/**
 *  自动转换字符集 支持数组转换
 *
 * @access    public
 * @param     string  $str  转换的内容
 * @return    string
 */
if ( ! function_exists('AutoCharset'))
{
    function AutoCharset($fContents, $from='gbk', $to='utf-8')
    {
        /*$from   =  strtoupper($from)=='UTF8'? 'utf-8' : $from;
        $to       =  strtoupper($to)=='UTF8'? 'utf-8' : $to;
        if( strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents)) ){
            //如果编码相同或者非字符串标量则不转换
            return $fContents;
        }
        if(is_string($fContents) ) 
        {
            if(function_exists('mb_convert_encoding'))
            {
                return mb_convert_encoding ($fContents, $to, $from);
            } elseif (function_exists('iconv'))
            {
                return iconv($from, $to, $fContents);
            } else {
                return $fContents;
            }
        }
        elseif(is_array($fContents))
        {
            foreach ( $fContents as $key => $val ) 
            {
                $_key =     AutoCharset($key,$from,$to);
                $fContents[$_key] = AutoCharset($val,$from,$to);
                if($key != $_key )
                    unset($fContents[$key]);
            }
            return $fContents;
        }
        else{
            return $fContents;
        }*/
		return $fContents;
    }
}

/*魔法变量开始*/
foreach(Array('_GET','_POST','_COOKIE') as $_request){
	foreach($$_request as $_k => $_v)  {
		${$_k}=MagicQuotes($_v);     //直接将$_Post,$_Get等中的变量替换出来.
	}
}

function MagicQuotes(&$svar) {
	if(!get_magic_quotes_gpc()) {
		if( is_array($svar) ) {
			foreach($svar as $_k => $_v) 
				$svar[$_k] = MagicQuotes($_v);
		} else {
			$svar = addslashes($svar);
		}
	}
	return $svar;
}
/*魔法变量结束*/

?>
