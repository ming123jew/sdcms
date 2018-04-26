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
use Server\Asyn\HttpClient\HttpClient;
use Server\Components\CatCache\TimerCallBack;
use Server\CoreBase\ChildProxy;


class AnalyseUrl extends Base {

    /**
     * 任务是否完成
     * @var bool
     */
    protected $isComplete = false;


    public function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name); // TODO: Change the autogenerated stub
    }


    public function handle($class,string $s,...$argv){
        yield call_user_func(array($class,$s),...$argv);
    }

    public $loadhtml = '';
    //获取连接
    public function getUrlList(...$argv){
        //print_r($argv[0]);
        $response =  self::_http($argv[0],self::_agent());
        //print_r($response);
        $this->loadhtml = $this->SimpleHtmlDom->load($response);
        $family = new ISpiderServiceFamily();
        //链接检测器
        $family->addDecorator(new IAnalyseUrl());

         $family->before($this);
         $family->after($this);

        //内容检测器
        //ini_set('memory_limit', '256M');
//        $script = $this->SimpleHtmlDom->find('script');
//        foreach ( $script as $e){
//            print_r($e->innertext);
//        }

        $this->html_tag = '';

        $this->SimpleHtmlDom->clear();

    }

    private function _http($url,$agent)
    {
        $ch = curl_init($url);
        $options = [
            CURLOPT_USERAGENT => $agent,
            CURLOPT_REFERER => $this->referer,
        ];
        curl_setopt_array($ch, $options);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $output = curl_exec($ch);
        return $output;
    }


    public function getUrlContent(){
        print_r("yes");
    }

    public function getBody(){

    }
    public function getTitle(){

    }
    public function getDesc(){

    }
}


class IAnalyseUrl implements ISpiderService{
    public function before($context)
    {
        // TODO: Implement before() method.
        //查找所有链接
        $find = [];
        $i=0;
        foreach ($context->loadhtml->find('div .alist') as $e){
            foreach ($e->find(' li h3 a ') as $ee){
                $find[$i]['url'] = $ee->href;
                $find[$i]['title'] = $ee->innertext;
                $i++;
            }
        }
        print_r($find);

    }
    public function after($context)
    {
        // TODO: Implement after() method.
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




