<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-25
 * Time: 16:22
 */

namespace app\Controllers\Spider;
use app\Helpers\Simplehtmldom\SimpleHtmlDom;
use Server\Asyn\HttpClient\HttpClient;
use Server\Asyn\HttpClient\HttpClientPool;
use Server\CoreBase\ChildProxy;

class Analyse
{
    public $htmlDom;//simple_html_dom实例
    public $findHtml;//找到的内容
    public $response;//内容数组，key包含 body statusCode 等
    public $match;//规则
    /**
     * 抓取返回的状态
     * @var bool
     */
    public $httpStatusCode = false;
    /**
     * 任务是否完成
     * @var bool
     */
    public $isComplete = false;
    protected $SimpleHtmlDom;
    protected $agent = [
        "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; AcooBrowser; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
        "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Acoo Browser; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.0.04506)",
        "Mozilla/4.0 (compatible; MSIE 7.0; AOL 9.5; AOLBuild 4337.35; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
        "Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)",
        "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)",
        "Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 1.0.3705; .NET CLR 1.1.4322)",
        "Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727; InfoPath.2; .NET CLR 3.0.04506.30)",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN) AppleWebKit/523.15 (KHTML, like Gecko, Safari/419.3) Arora/0.3 (Change: 287 c9dfb30)",
        "Mozilla/5.0 (X11; U; Linux; en-US) AppleWebKit/527+ (KHTML, like Gecko, Safari/419.3) Arora/0.6",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2pre) Gecko/20070215 K-Ninja/2.1.1",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9) Gecko/20080705 Firefox/3.0 Kapiko/3.0",
        "Mozilla/5.0 (X11; Linux i686; U;) Gecko/20070322 Kazehakase/0.4.5",
        "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.8) Gecko Fedora/1.9.0.8-1.fc10 Kazehakase/0.5.6",
        "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) AppleWebKit/535.20 (KHTML, like Gecko) Chrome/19.0.1036.7 Safari/535.20",
        "Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; fr) Presto/2.9.168 Version/11.52",
    ];



    public function __construct()
    {
        $this->SimpleHtmlDom =new SimpleHtmlDom();
    }

    public function handle(array $class_action,...$argv){
        return yield call_user_func($class_action,...$argv);
    }

    protected function _http($url,$agent)
    {
        $ch = curl_init($url);
        $options = [
            CURLOPT_USERAGENT => $agent,
            CURLOPT_REFERER => '',
        ];
        curl_setopt_array($ch, $options);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $output = curl_exec($ch);
        return $output;

    }

    protected function _http_pool($url,$params=[],$url_port='',$UserAgent="",$Referer="",$SetCookie=""){
        if(empty($UserAgent)){
            $UserAgent = self::_agent();
        }
        $url_array=parse_url($url);
        //print_r($url_array);
        $scheme = $url_array['scheme'].'://';
        $host=$url_array['host'];
        $path = $url_array['path'];
        $query = isset($url_array['query'])&&!empty($url_array['query']) ? '?'.$url_array['query']:'';
//        $cli = new \swoole_http_client($scheme.$host, $url_port);
//        $cli->setHeaders(['User-Agent' => 'swoole','Referer'=>$Referer,'Set-Cookie'=>$SetCookie]);
//        $cli->get($path.$query, function ($cli) {
//
//            print_r($cli->body);
//            return  $cli->body;
//        });

        //同步版本
//        $ci = new HttpClientPool( get_instance()->config,$scheme.$host);
//        $ci->httpClient->setHeaders(['User-Agent' => 'swoole','Referer'=>$Referer,'Set-Cookie'=>$SetCookie])->execute($path.$query,function ($data){
//           var_dump($data);
//        });

        //协程版本
        $ci = new HttpClientPool( get_instance()->config,$scheme.$host.$url_port);
        if($params){
            //print_r($params);
            $ci->httpClient->setData($params);
            $ci->httpClient->setMethod('POST');
            $ci->httpClient->setHeaders(['User-Agent' => 'swoole','Referer'=>$Referer,'Set-Cookie'=>$SetCookie]);
            $data = yield $ci->httpClient->coroutineExecute($path.$query);
        }else{
            $data = yield $ci->httpClient
                ->setHeaders(['User-Agent' => 'swoole','Referer'=>$Referer,'Set-Cookie'=>$SetCookie])
                ->coroutineExecute($path.$query);
        }

        $data['baseurl'] = $ci->baseUrl;
        unset($url,$params,$url_port,$UserAgent,$Referer,$SetCookie,$url_array,$scheme,$host,$path,$query,$ci);
        return $data;
    }



    protected function _agent(){
        return $this->agent[rand(0, count($this->agent) - 1)];
    }

    protected  function _charset($data){
        if( !empty($data) ){
            $fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
            if( $fileType != 'UTF-8'){
                $data = mb_convert_encoding($data ,'utf-8' , $fileType);
            }
        }
        return $data;
    }


    /**
     * 获取文章META信息
     * @param $data
     * @param string $tag
     * @return array|mixed
     */
    protected function _getMeta($data,$tag="") {
        $meta = array();
        if (!empty($data)) {
            #Title
            preg_match('/<TITLE>([\w\W]*?)<\/TITLE>/si', $data, $matches);
            if (!empty($matches[1])) {
                $meta['title'] = $matches[1];
            }

            #Keywords
            preg_match('/<META\s+name="keywords"\s+content="([\w\W]*?)"/si', $data, $matches);
            if (empty($matches[1])) {
                preg_match("/<META\s+name='keywords'\s+content='([\w\W]*?)'/si", $data, $matches);
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+content="([\w\W]*?)"\s+name="keywords"/si', $data, $matches);
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+http-equiv="keywords"\s+content="([\w\W]*?)"/si', $data, $matches);
            }
            if (!empty($matches[1])) {
                $meta['keywords'] = $matches[1];
            }

            #Description
            preg_match('/<META\s+name="description"\s+content="([\w\W]*?)"/si', $data, $matches);
            if (empty($matches[1])) {
                preg_match("/<META\s+name='description'\s+content='([\w\W]*?)'/si", $data, $matches);
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+content="([\w\W]*?)"\s+name="description"/si', $data, $matches);
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+http-equiv="description"\s+content="([\w\W]*?)"/si', $data, $matches);
            }
            if (!empty($matches[1])) {
                $meta['description'] = $matches[1];
            }
        }
        if(!empty($tag)){
            unset($data,$matches);
            return $meta[$tag];
        }else{
            unset($data,$tag,$matches);
            return $meta;
        }
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        //print_r("__destruct");
        $this->SimpleHtmlDom->clear();//清空SimpleHtmlDom
    }


}