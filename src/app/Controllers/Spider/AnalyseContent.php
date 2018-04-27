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

    public $htmlDom;
    public $findHtml;
    public $response;

    public function getContent(){
        var_dump("a");
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


class IAnalyseContent implements ISpiderService{
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




