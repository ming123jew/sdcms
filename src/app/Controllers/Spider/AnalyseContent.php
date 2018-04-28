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

class AnalyseContent extends Analyse {

    public $response;//内容数组，key包含 body statusCode 等
    public function getContent(...$argv){

        $this->response = yield self::_http_pool($argv[0]['url']);
        //将结果返回给任务管理器,是否完成
        $this->isComplete = true;//
        $this->httpStatusCode = 200;
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




