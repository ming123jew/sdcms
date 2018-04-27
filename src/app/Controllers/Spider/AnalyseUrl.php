<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-25
 * Time: 16:21
 */

namespace app\Controllers\Spider;


use app\Controllers\Spider\Interfaces\ISpiderService;
use app\Controllers\Spider\Interfaces\ISpiderServiceFamily;
use app\Helpers\Simplehtmldom\SimpleHtmlDom;
use PhpAmqpLib\Message\AMQPMessage;

class AnalyseUrl extends Analyse {

    public $htmlDom;
    public $findHtml;
    public $response;
    protected $AMQPMessage;
    protected $AMQPMessage_exchange = 'amqp-spider-cache';
    protected $WeixinSougouHttpClient;

    // Example
    //$html = str_get_html("<div>foo <b>bar</b></div>");
    //$e = $html->find("div", 0);
    //
    //echo $e->tag; // Returns: " div"
    //echo $e->outertext; // Returns: " <div>foo <b>bar</b></div>"
    //echo $e->innertext; // Returns: " foo <b>bar</b>"
    //echo $e->plaintext; // Returns: " foo bar"

    //获取连接
    public function getUrlList(...$argv){
        //print_r($argv[0]);
        //curl方式获取内容
        //$response =  self::_http($argv[0],self::_agent());
        //swoole方式获取内容，支持高并发+协程
        $this->response = yield self::_http_pool($argv[0]);
        //print_r($this->response);
        //$t1 = microtime(true);
        if($this->response['statusCode']==200){
            $this->htmlDom = $this->SimpleHtmlDom->load($this->response['body']);
            $family = new ISpiderServiceFamily();
            //链接检测器
            $family->addDecorator(new IAnalyseUrl());

            $family->before($this);
            $family->after($this);
        }
//        echo "\nstarttime:".$t1."\n";
//        print_r(self::getTitle());
//        $t2 = microtime(true);
//        echo "\nendtime:".$t2."\n";
//        echo "\nsum:".($t2-$t1)."\n";
//        echo "\nmem".memory_get_usage() ."\n";
        print_r($this->findHtml);
        //获取到的列表再次投递到任务表，进行获取文章操作
        yield self::_http_pool('http://118.89.26.188:8081/Spider/Webpage/get_content',':8081',['params'=>$this->findHtml]);

        //var_dump($this->AMQPClent);
//        $channel = $this->AMQPClent->channel();
//        foreach ($this->findHtml as $key=>$value){
//            //投递一个任务
//            $msgBody = json_encode(["url" => $value['url'],'callBackClass'=>'AnalyseContent','action'=>'getContent']);
//            $this->AMQPMessage->setBody($msgBody);
//            //$msg = new AMQPMessage($this->AMQPMessage, ['content_type' => 'text/plain', 'delivery_mode' => 2]); //生成消息  //, ['content_type' => 'text/plain', 'delivery_mode' => 2]
//            $channel->basic_publish($this->AMQPMessage,$this->AMQPMessage_exchange); //推送消息到某个交换机
//        }
//        $channel->close();
        //将结果返回给任务管理器,是否完成
        $this->isComplete = true;//
        return $this;
    }

    public function getBaseUrl(){
        return $this->response['baseurl'];
    }

    public function getAllBody(){
        return $this->response['body'];
    }

    public function getFindBody(){
        return $this->findHtml;
    }

    public function getTitle(){
            return $this->htmlDom->find('title')[0]->innertext ;
    }
    public function getDescription(){
        return self::_getMeta(self::getAllBody(),'description');
    }
}


class IAnalyseUrl implements ISpiderService{
    public function before($context)
    {
        // TODO: Implement before() method.
        //查找所有链接
        $find = [];
//        $i=0;
//        foreach ($context->html->find('div .alist') as $e){
//            foreach ($e->find(' li h3 a ') as $ee){
//                $find[$i]['url'] = $ee->href;
//                $find[$i]['title'] = $ee->innertext;
//                $i++;
//            }
//        }

        //根据元素匹配
        $gz_array = [
            'div .alist li',//规则1
            'li h3 a',//规则2
            /*'#/<a .*?>.*?<\/a>/#',*/

        ];
        $last = end($gz_array);
        $find = self::match_find($gz_array,$context->htmlDom,$last);

        //根据规则匹配返回给findHtml
        $context->findHtml = ($find);
    }

    /**
     * 根据元素进行匹配，如div ID class 或多级元素 ul li a
     * 如有正则表示式则进行正则匹配
     * @param $gz_array
     * @param $html
     * @param $last
     * @return array
     */
    public function match_find($gz_array,$html,$last){
        $find = [];
        foreach ($gz_array as $key=>$value){
            //如果是正则，则进行正则匹配，否则进行元素匹配
            if(substr($value,0,1)=='#'){
                if ($last==$value){
                    $value = str_replace('#', '', $value);
                    preg_match_all($value, $html, $out);
                    //print_r($out);
                    $e = '';
                    for ($n = 0; $n < count($out[0]); $n++) {
                        $e .= $out[0][$n];
                    }
                    $find = $e;
                }else {
                    //移除第一个元素
                    array_shift($gz_array);
                    $value = str_replace('#', '', $value);
                    preg_match_all($value, $html, $out);
                    $e = '';
                    for ($n = 0; $n < count($out[0]); $n++) {
                        $e .= $out[0][$n];
                    }
                    self::match_find($gz_array, $e, $last);
                }
            }else{
                //判断是否是dom
                if(is_string($html)){
                    $simple_html_dom = new SimpleHtmlDom();
                    $html = $simple_html_dom->load($html);
                }
                if ($last==$value){
                    $i=0;
                    foreach ($html->find($value) as $ee){
                        $find[$i]['url'] = $ee->href;
                        $find[$i]['title'] = $ee->innertext;
                        $i++;
                    }
                }else{
                    array_shift($gz_array);
                    foreach ($html->find($value) as $e){
                        self::match_find($gz_array,$e,$last);
                    }
                }
            }

        }
        return $find;
    }


    public function  preg_match($gz_array,$html,$last){

    }


    public function after($context)
    {
        // TODO: Implement after() method.
        //根据规则匹配返回给findHtml
        //$context->findHtml = ("xxx".$context->html."xxx");
    }
}

class  IAnalyseBody implements ISpiderService{
    public function before($context)
    {
        // TODO: Implement before() method.

    }
    public function after($context)
    {
        // TODO: Implement after() method.
    }
}




