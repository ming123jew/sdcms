<?php

namespace app\Controllers\Home;

use app\Extend\WxSdk\WechatAuth;
use app\Extend\WxSdk\Jssdk;
use app\Models\StatsModel;
define(WEIXIN_CACHE_PATH,'a');
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 17-09-14
 * Time: am09:51
 */
class Base extends \app\Controllers\BaseController
{
    public $WechatAuth;
    public $AppId = '';
    public $AppSecret = '';
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);

    }

    protected function _getJsSdk(){
        $Jssdk = new Jssdk($this->AppId, $this->AppSecret);
        return $Jssdk->getSignPackage();
    }


    /**
     * @desc 统计数据
     * @return null
     */
    public function _Stats($type='click'){
        $StatsModel = $this->loader->model('StatsModel',$this);
        $date = date('Ymd',time());
        $val = yield $StatsModel->updateOrInsert($date);
        return $val;
    }

    /**
     * @desc 记录分享
     */
    public function Share(){
        $type=$this->request->param('type');
        self::_Stats($type);
    }

    /**
     * @desc   判断是不是微信浏览器
     * @return bool
     */
    protected function _Is_Weixin(){
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }


    public function defaultMethod()
    {
        $this->redirectController('Home/Main','test');
    }


}