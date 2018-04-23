<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-23
 * Time: 10:09
 */
namespace app\Controllers\Home\Interfaces;
interface IUserService
{
    /**
     * 登录前
     * @param $context
     * @return mixed
     */
    public function before($context);

    /**
     * 登录后
     * @param $context
     * @return mixed
     */
    public function after($context);
}