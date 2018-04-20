<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-12
 * Time: 15:23
 */

namespace app\Controllers\Home;


use Server\CoreBase\ChildProxy;

class User extends Base
{

    protected $HomeBusiness;
    protected $ContentHitsModel;
    protected $ContentCommentModel;

    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);

    }

    public function __construct(string $proxy = ChildProxy::class)
    {
        parent::__construct($proxy);
    }

    public function http_login()
    {
        $family = new IUserServiceExtensionFamily();
        //权限装饰器
        $family->addDecorator(  new Check() );
        //积分装饰器
        $family->addDecorator(  new Score() );

        $newLWord = [];
        $family->beforeLogin($this);

        //调用数据访问层
        print_r("\nmiddle\n");

        $family->behindLogin($this);
        parent::httpOutputTis('ok');
    }
}

// 扩展接口
interface IUserServiceExtension{
    /**
     * 登录前
     * @param $context
     * @return mixed
     */
    public function beforeLogin($context);

    /**
     * 登录后
     * @param $context
     * @return mixed
     */
    public function behindLogin($context);
}

//检查权限
class Check implements IUserServiceExtension{
    /**
     * 登录前
     * @param $context
     * @return mixed
     */
    public function beforeLogin($context)
    {
        // TODO: Implement beforeLogin() method.
        print_r($context->http_input->postGet('username'));
        //检查用户名
        print_r("beforeLogin:check_username.\n");
    }

    /**
     * 登录后
     * @param $context
     * @return mixed
     */
    public function behindLogin($context)
    {
        // TODO: Implement behindLogin() method.
    }
}

// 用户积分
class Score implements IUserServiceExtension {
    /**
     * 登录前
     * @param $context
     * @return mixed
     */
    public function beforeLogin($context)
    {
        // TODO: Implement beforeLogin() method.
    }

    /**
     * 登录后
     * @param $context
     * @return mixed
     */
    public function behindLogin($context)
    {
        // TODO: Implement behindLogin() method.
        print_r("behindLogin:add_score.\n");
    }
}

// 扩展家族
class IUserServiceExtensionFamily implements IUserServiceExtension{
    //装饰器
    protected $decorator = [];
    //增加装饰器
    public function addDecorator(IUserServiceExtension $decorator)
    {
        $this->decorator[] = $decorator;
    }

    /**
     * 登录前
     * @param $context
     * @return mixed
     */
    public function beforeLogin($context)
    {
        // TODO: Implement beforeLogin() method.
        foreach ($this->decorator as $decorator) {
            $decorator->beforeLogin($context);
        }
    }

    /**
     * 登录后
     * @param $context
     * @return mixed
     */
    public function behindLogin($context)
    {
        // TODO: Implement behindLogin() method.
        foreach ($this->decorator as $decorator) {
            $decorator->behindLogin($context);
        }

    }
}