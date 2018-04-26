<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-23
 * Time: 10:09
 */
namespace app\Controllers\Spider\Interfaces;

// 扩展家族
class ISpiderServiceFamily implements ISpiderService {
    /**
     * 前置操作结果集
     * @var array
     */
    protected $before_result = [];

    /**
     * 后置操作结果集
     * @var array
     */
    protected $after_result = [];

    /**
     * 装饰器
     * @var array
     */
    protected $decorator = [];

    /**
     * 增加装饰器
     * @param ISpiderService $decorator
     */
    public function addDecorator(ISpiderService $decorator)
    {
        $this->decorator[] = $decorator;
    }

    /**
     * 获取前置操作结果
     * @return array
     */
    public function getBeforeResult(){

        return $this->before_result;
    }

    /**
     * 获取后置操作结果
     * @return array
     */
    public function getAfterResult(){
        return $this->after_result;
    }

    /**
     * 登录前
     * @param $context
     * @return mixed
     */
    public function before($context)
    {
        // TODO: Implement before() method.
        foreach ($this->decorator as $decorator) {
            $this->before_result[] =  $decorator->before($context);
        }
    }

    /**
     * 登录后
     * @param $context
     * @return mixed
     */
    public function after($context)
    {
        // TODO: Implement after() method.
        foreach ($this->decorator as $decorator) {
            $this->after_result[] =  $decorator->after($context);
        }

    }
}