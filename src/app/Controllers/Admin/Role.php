<?php
namespace app\Controllers\Admin;
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-1-5
 * Time: 12:02
 */
class Role  extends Base{
    /**
     * @param string $controller_name
     * @param string $method_name
     */
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }
    public function http_menu()
    {
        if($this->http_input->getRequestMethod()=='POST'){
            $end = [
                'status' => 0,
                'code'=>200,
                'message'=>'message.'
            ];
            $this->http_output->end(json_encode($end),false);
        }else{
            parent::templateData('test',1);
            //web or app
            parent::webOrApp(function (){
                $template = $this->loader->view('app::Admin/system_menu');
                $this->http_output->end($template->render(['data'=>$this->TemplateData,'message'=>'']));
            });
        }
    }
}