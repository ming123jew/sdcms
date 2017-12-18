<?php
/**
 * Created by PhpStorm.
 * Description: 用于跨域处理
 * User: ming123jew
 * Date: 2017-12-18
 * Time: 11:10
 */
namespace app\Middlewares;

use Server\Components\Middleware\HttpMiddleware;

class HeaderMiddleware extends HttpMiddleware{


    public function __construct()
    {
        parent::__construct();

    }

    public function before_handle()
    {
        //print_r("here");
        $this->response->header("Access-Control-Allow-Origin", "*");
    }

    public function after_handle($path)
    {


    }

}