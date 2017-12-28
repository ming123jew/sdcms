<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-28
 * Time: 14:55
 */
namespace app\Controllers\Home;

class Status extends Base
{
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }

    public function http_index(){

        parent::templateData('test',1);

        //web or app
        parent::webOrApp(function (){
            $template = $this->loader->view('app::Home/status');
            $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
        });
    }
}