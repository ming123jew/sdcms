<?php
namespace app\Controllers\Admin;
use app\Helpers\Ueditors\Uploader;
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-2-28
 * Time: 9:23
 */


/*
 * @desc   Ueditor上传  版本utf8.ueditor1_4_3_3
 * @author ming123jew
 *
 */
class Ueditor extends Base{

    /**
     * @param string $controller_name
     * @param string $method_name
     * @throws \Exception
     */
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
    }

    public function http_index(){

        //header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
        //header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
        date_default_timezone_set("Asia/chongqing");
        error_reporting(E_ERROR);
        //@header("Content-Type: text/html; charset=utf-8");

        $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(__DIR__."/config.ueditor.json")), true);
        $this->http_output->setHeader("Content-Type","text/html; charset=utf-8");
        $action = $this->http_input->get('action');

        switch ($action) {
            case 'config':
                $result =  json_encode($CONFIG);
                break;

            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                //$result = include("action_upload.php");
                $CONFIG['AdminUploadsConfig'] = $this->AdminUploadsConfig;
                $result = self::_Upload($CONFIG);
                break;

            /* 列出图片 */
            case 'listimage':
                //$result = include("action_list.php");
                $CONFIG['AdminUploadsConfig'] = $this->AdminUploadsConfig;
                $result = self::_list($CONFIG);
                break;
            /* 列出文件 */
            case 'listfile':
                //$result = include("action_list.php");
                $CONFIG['AdminUploadsConfig'] = $this->AdminUploadsConfig;
                $result = self::_list($CONFIG);
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                //$result = include("action_crawler.php");
                $CONFIG['AdminUploadsConfig'] = $this->AdminUploadsConfig;
                $result = self::_crawler($CONFIG);
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        $callback = $this->http_input->get('callback');
        if ($callback) {
            if (preg_match("/^[\w_]+$/", $callback)) {
                unset($CONFIG,$action,$callback);
                $this->http_output->end( htmlspecialchars($_GET["callback"]) . '(' . $result . ')' ) ;
            } else {
                unset($CONFIG,$action,$callback,$_GET,$result);
                $this->http_output->end( json_encode(array(
                    'state'=> 'callback参数不合法'
                )) );
            }
        } else {
            unset($CONFIG,$action,$callback,$_GET);
            $this->http_output->end($result) ;
        }
    }



    private function _Upload($CONFIG){
        /* 上传配置 */
        $base64 = "upload";
        $action = $this->http_input->get('action');
        switch (htmlspecialchars($action)) {
            case 'uploadimage':
                $config = array(
                    "pathFormat" => $CONFIG['imagePathFormat'],
                    "maxSize" => $CONFIG['imageMaxSize'],
                    "allowFiles" => $CONFIG['imageAllowFiles'],
                    "AdminUploadsConfig"=>$CONFIG['AdminUploadsConfig']
                );
                $fieldName = $CONFIG['imageFieldName'];
                break;
            case 'uploadscrawl':
                $config = array(
                    "pathFormat" => $CONFIG['scrawlPathFormat'],
                    "maxSize" => $CONFIG['scrawlMaxSize'],
                    "allowFiles" => $CONFIG['scrawlAllowFiles'],
                    "AdminUploadsConfig"=>$CONFIG['AdminUploadsConfig'],
                    "oriName" => "scrawl.png"
                );
                $fieldName = $CONFIG['scrawlFieldName'];
                $base64 = "base64";
                break;
            case 'uploadvideo':
                $config = array(
                    "pathFormat" => $CONFIG['videoPathFormat'],
                    "maxSize" => $CONFIG['videoMaxSize'],
                    "allowFiles" => $CONFIG['videoAllowFiles'],
                    "AdminUploadsConfig"=>$CONFIG['AdminUploadsConfig']
                );
                $fieldName = $CONFIG['videoFieldName'];
                break;
            case 'uploadfile':
            default:
                $config = array(
                    "pathFormat" => $CONFIG['filePathFormat'],
                    "maxSize" => $CONFIG['fileMaxSize'],
                    "allowFiles" => $CONFIG['fileAllowFiles'],
                    "AdminUploadsConfig"=>$CONFIG['AdminUploadsConfig']
                );
                $fieldName = $CONFIG['fileFieldName'];
                break;
        }

        $thumb = $this->http_input->get('thumb');
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($this->http_input->getFiles(),$fieldName, $config, $base64, $thumb);

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */
        $info = $up->getFileInfo();
        //print_r($info);
        //插入数据库
//        $model_MagazineUeditor = new MagazineUeditor();
//        $token = $this->request->param('token');
//        if( $token  ){
//            $info['token'] = $token;
//        }
//        $res = $model_MagazineUeditor->Add($info);
//        if(!$res){
//            return ['code'=>0,'msg'=>$model_MagazineUeditor->getError()];
//        }

        /* 返回数据 */
        unset($base64,$action,$config,$fieldName,$up,$thumb,$CONFIG);
        return json_encode($info);
    }

    private function _list($CONFIG){

        /* 判断类型 */
        $action =  $this->http_input->get('action');
        switch ($action) {
            /* 列出文件 */
            case 'listfile':
                $allowFiles = $CONFIG['fileManagerAllowFiles'];
                $listSize = $CONFIG['fileManagerListSize'];
                $path = $CONFIG['fileManagerListPath'];
                break;
            /* 列出图片 */
            case 'listimage':
            default:
                $allowFiles = $CONFIG['imageManagerAllowFiles'];
                $listSize = $CONFIG['imageManagerListSize'];
                $path = $CONFIG['imageManagerListPath'];
        }
        $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

        /* 获取参数 */
        $size = $this->http_input->get('size');
        $start =  $this->http_input->get('start');
        $size = ($size) ? htmlspecialchars($size) : $listSize;
        $start = ($start) ? htmlspecialchars($start) : 0;
        $end = $start + $size;

        /* 获取文件列表 */
        //$_SERVER['DOCUMENT_ROOT']
        //sd框架读取到路径为/ 因此需要作修改
        $rootPath = $this->AdminUploadsConfig['rootpath'];
        //print_r($_SERVER);
        $path = $rootPath . (substr($path, 0, 1) == "/" ? "":"/") . $path;
        $files = self::_getfiles($path, $allowFiles);
        if (!count($files)) {
            return json_encode(array(
                "state" => "no match file",
                "list" => array(),
                "start" => $start,
                "total" => count($files)
            ));
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--){
            $list[] = $files[$i];
        }
        //倒序
        //for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
        //    $list[] = $files[$i];
        //}

        /* 返回数据 */
        $result = json_encode(array(
            "state" => "SUCCESS",
            "list" => $list,
            "start" => $start,
            "total" => count($files)
        ));
        unset($CONFIG,$action,$allowFiles,$listSize,$path,$size,$start,$end,$rootPath,$files,$len,$list);
        return $result;
    }

    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param array $files
     * @return array
     */
    private function _getfiles($path, $allowFiles, &$files = array())
    {
        if (!is_dir($path)) return null;
        if(substr($path, strlen($path) - 1) != '/') $path .= '/';
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    self::_getfiles($path2, $allowFiles, $files);
                } else {
                    if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
                        $rootPath = $this->AdminUploadsConfig['rootpath'];
                        $files[] = array(

                            'url'=> substr($path2, strlen($rootPath)),
                            'mtime'=> filemtime($path2)
                        );
                    }
                }
            }
        }
        unset($path, $allowFiles, $handle, $file,$rootPath,$path2);
        return $files;
    }

    /**
     * 抓取远程图片
     * User: Jinqn
     * Date: 14-04-14
     * Time: 下午19:18
     */
    private function _crawler($CONFIG){
        set_time_limit(0);

        /* 上传配置 */
        $config = array(
            "pathFormat" => $CONFIG['catcherPathFormat'],
            "maxSize" => $CONFIG['catcherMaxSize'],
            "allowFiles" => $CONFIG['catcherAllowFiles'],
            "AdminUploadsConfig"=>$CONFIG['AdminUploadsConfig'],
            "oriName" => "remote.png",

        );
        $fieldName = $CONFIG['catcherFieldName'];

        /* 抓取远程图片 */
        $list = array();

        if ( $this->http_input->post($fieldName) ) {
            $source = $this->http_input->post($fieldName);
        } else {
            $source = $this->http_input->get($fieldName);
        }
        foreach ($source as $imgUrl) {
            $item = new Uploader($this->http_input->getFiles(),$imgUrl, $config, "remote");
            $info = $item->getFileInfo();
            array_push($list, array(
                "state" => $info["state"],
                "url" => $info["url"],
                "size" => $info["size"],
                "title" => htmlspecialchars($info["title"]),
                "original" => htmlspecialchars($info["original"]),
                "source" => htmlspecialchars($imgUrl)
            ));

            //插入数据库
//            $model_MagazineUeditor = new MagazineUeditor();
//            $token = $this->request->param('token');
//            if( $token  ){
//                $info['token'] = $token;
//            }
//            $info['islocal'] = htmlspecialchars($imgUrl);
//            $res = $model_MagazineUeditor->Add($info);
//            if(!$res){
//                return ['code'=>0,'msg'=>$model_MagazineUeditor->getError()];
//            }
        }
        print_r($list);
        unset($CONFIG,$config,$fieldName,$source,$imgUrl,$item,$info);
        /* 返回抓取数据 */
        return json_encode(array(
            'state'=> count($list) ? 'SUCCESS':'ERROR',
            'list'=> $list
        ));
    }



}