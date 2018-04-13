<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-12
 * Time: 15:23
 */

namespace app\Controllers\Home;
use app\Models\Business\HomeBusiness;

class Article extends Base
{
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);

    }


    public function http_read()
    {
        $id = intval( $this->http_input->postGet('id') );
        if($id>0){

            $this->HomeBusiness = $this->loader->model(HomeBusiness::class,$this);
            //[读取内容+点击+更新点击:start]
            $d = yield $this->HomeBusiness->get_article($id);
            //[读取内容+点击+更新点击:end]
            parent::templateData('article',$d);
            //print_r($d);
            parent::templateData('test',1);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Home/content');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']),false);
            });
        }else{
            parent::httpOutputTis('参数错误.');
        }

    }

    public function http_list()
    {
        parent::templateData('test',1);
        //web or app
        parent::webOrApp(function (){
            $template = $this->loader->view('app::Home/article_list');
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        });
    }


}