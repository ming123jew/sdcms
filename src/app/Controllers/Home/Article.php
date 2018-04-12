<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-12
 * Time: 15:23
 */

namespace app\Controllers\Home;


class Article extends Base
{
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);

    }

    public function http_read()
    {

        parent::templateData('test',1);
        //web or app
        parent::webOrApp(function (){
            $template = $this->loader->view('app::Home/article_read');
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        });
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