<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2017-12-28
 * Time: 14:55
 */
namespace app\Controllers\IM;

use app\Models\Data\ImHistoryLogModel;
use app\Models\Data\ImHistoryModel;
use app\Process\MyProcess;
use Server\Components\Event\EventDispatcher;
use Server\Components\Process\ProcessManager;
use Server\Memory\Cache;
use app\Controllers\BaseController;


class Ws extends BaseController{
    protected $Map;
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

        $this->bindUid($this->client_data->uid);
        $this->send(['type' => 'welcome', 'id' => $this->client_data->uid,'fd'=>$this->fd]);
    }

    public function sendData(){

        //$this->Data['client_data'][$this->fd] = $this->client_data;
        //print_r($this->client_data);
//        if(isset($this->client_data->to->fd)&&$this->client_data->to->fd>0){
//            //当前用户在线，则直接推送消息
//            $this->send(['type' => 'sendData', 'message' => $this->Data['client_data'][$this->fd],'fd'=>$this->client_data->to->fd]);
//        }

        //print_r($this->client_data->message->to->type);
        //print_r($this->client_data->message->mine);

        //记录到数据库
        $this->Model['ImHistoryModel'] = $this->loader->model(ImHistoryModel::class,$this);
        $intoColumns = ['type','content','create_time','sender_uid','receiver_uid'];
        $intoValues = [
            $this->client_data->message->to->type,
            json_encode(  ['mine'=>(array)$this->client_data->message->mine,'to'=>(array)$this->client_data->message->to]  ),
            time(),
            $this->client_data->message->mine->id,
            $this->client_data->message->to->id,
        ];
        $this->Data['ImHistoryModel'] = yield $this->Model['ImHistoryModel']->insertMultiple($intoColumns,$intoValues);
        unset($intoColumns,$intoValues);
        $this->client_data->message->mine->type = $this->client_data->message->to->type;
        $this->sendToUid($this->client_data->message->to->id,['type'=>'sendData','data'=>$this->client_data->message->mine]);
        //$this->send(['type' => 'sendData', 'message' => $this->Data['client_data'][$this->fd],'fd'=>$this->fd]);
    }


    public function historyData(){
        $this->Model['ImHistoryLogModel'] = $this->loader->model(ImHistoryLogModel::class,$this);
        //删除之前所有记录
        yield $this->Model['ImHistoryLogModel']->deleteByUid($this->client_data->uid);
        //记录到数据库
        $intoColumns = ['content','create_time','uid'];
        $intoValues = [
            $this->client_data->message,
            time(),
            $this->client_data->uid
        ];
        $this->Model['ImHistoryLogModel'] = yield $this->Model['ImHistoryLogModel']->insertMultiple($intoColumns,$intoValues);
        unset($intoColumns,$intoValues);
    }
}