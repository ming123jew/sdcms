<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-28
 * Time: 14:55
 */
namespace app\Controllers\IM;

use app\Process\MyProcess;
use Server\Components\Event\EventDispatcher;
use Server\Components\Process\ProcessManager;
use Server\Memory\Cache;
use app\Controllers\BaseController;


class Ws extends BaseController{
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
        $configs = get_instance()->config;
        $configs_config = $configs['config'];
        //print_r($configs_config);
        //print_r($this->ControllerName);
        //print_r($this->MethodName);
        $this->HtmlUrl = $configs_config[$configs_config['active']]['home']['static_url'];

        parent::templateData('HTML_URL',$this->HtmlUrl);
        unset($configs,$configs_config);
    }

    public function connect()
    {
        $uid = time();
        $this->bindUid($uid);
        $this->send(['type' => 'welcome', 'id' => $uid,'fd'=>$this->fd]);
    }

}