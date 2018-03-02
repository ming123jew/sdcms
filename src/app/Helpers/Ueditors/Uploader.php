<?php
namespace app\Helpers\Ueditors;
/**
 * Created by JetBrains PhpStorm.
 * User: taoqili
 * Date: 12-7-18
 * Time: 上午11: 32
 * UEditor编辑器通用上传类
 */
class Uploader
{
    private $fileField; //文件域名
    private $file; //文件上传对象
    private $base64; //文件上传对象
    private $config; //配置信息
    private $oriName; //原始文件名
    private $fileName; //新文件名
    private $fullName; //完整文件名,即从当前配置目录开始的URL
    private $filePath; //完整文件名,即从当前配置目录开始的URL
    private $fileSize; //文件大小
    private $fileType; //文件类型
    private $stateInfo; //上传状态信息,
    private $stateMap = array( //上传状态映射表，国际化用户需考虑此处数据的国际化
        "SUCCESS", //上传成功标记，在UEditor中内不可改变，否则flash判断会出错
        "文件大小超出 upload_max_filesize 限制",
        "文件大小超出 MAX_FILE_SIZE 限制",
        "文件未被完整上传",
        "没有文件被上传",
        "上传文件为空",
        "ERROR_TMP_FILE" => "临时文件错误",
        "ERROR_TMP_FILE_NOT_FOUND" => "找不到临时文件",
        "ERROR_SIZE_EXCEED" => "文件大小超出网站限制",
        "ERROR_TYPE_NOT_ALLOWED" => "文件类型不允许",
        "ERROR_CREATE_DIR" => "目录创建失败",
        "ERROR_DIR_NOT_WRITEABLE" => "目录没有写权限",
        "ERROR_FILE_MOVE" => "文件保存时出错",
        "ERROR_FILE_NOT_FOUND" => "找不到上传文件",
        "ERROR_WRITE_CONTENT" => "写入文件内容错误",
        "ERROR_UNKNOWN" => "未知错误",
        "ERROR_DEAD_LINK" => "链接不可用",
        "ERROR_HTTP_LINK" => "链接不是http链接",
        "ERROR_HTTP_CONTENTTYPE" => "链接contentType不正确",
        "INVALID_URL" => "非法 URL",
        "INVALID_IP" => "非法 IP"
    );
    protected $_files = '';
    protected $thumb = '';
    protected $oldfile = '';
    protected $AdminUploadsConfig = '';

    /**
     * 构造函数
     * @$_files sd无法识别$_FILES
     * @param string $fileField 表单名称
     * @param array $config 配置项
     * @param bool $base64 是否解析base64编码，可省略。若开启，则$fileField代表的是base64编码的字符串表单名
     */
    public function __construct($_files, $fileField, $config, $type = "upload",$thumb='')
    {
        $this->_files = $_files;
        $this->fileField = $fileField;
        $this->config = $config;
        $this->type = $type;
        if($thumb){
            $this->thumb = 'thumb_';
        }
        if( isset( $this->_files['oldfile']) ){
            $this->oldfile =  $this->_files['oldfile'];
        }
        $this->AdminUploadsConfig = $config['AdminUploadsConfig'];
        if ($type == "remote") {
            $this->saveRemote();
        } else if($type == "base64") {
            $this->upBase64();
        } else {
            $this->upFile();
        }

        //$this->stateMap['ERROR_TYPE_NOT_ALLOWED'] = iconv('unicode', 'utf-8', $this->stateMap['ERROR_TYPE_NOT_ALLOWED']);
    }

    /**
     * 上传文件的主处理方法
     * @return mixed
     */
    private function upFile()
    {
        $file = $this->file = $this->_files[$this->fileField];
        if (!$file) {
            $this->stateInfo = $this->getStateInfo("ERROR_FILE_NOT_FOUND");
            return;
        }
        if ($this->file['error']) {
            $this->stateInfo = $this->getStateInfo($file['error']);
            return;
        } else if (!file_exists($file['tmp_name'])) {
            $this->stateInfo = $this->getStateInfo("ERROR_TMP_FILE_NOT_FOUND");
            return;
        } else if (!is_uploaded_file($file['tmp_name'])) {
            $this->stateInfo = $this->getStateInfo("ERROR_TMPFILE");
            return;
        }

        $this->oriName = $file['name'];
        $this->fileSize = $file['size'];
        $this->fileType = $this->getFileExt();
        $this->fullName = $this->getFullName();
        $this->filePath = $this->getFilePath();
        $this->fileName = $this->getFileName();
        $dirname = dirname($this->filePath);

        //检查文件大小是否超出限制
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        //检查是否不允许的文件格式
        if (!$this->checkType()) {
            $this->stateInfo = $this->getStateInfo("ERROR_TYPE_NOT_ALLOWED");
            return;
        }

        //创建目录失败
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {
            $this->stateInfo = $this->getStateInfo("ERROR_CREATE_DIR");
            return;
        } else if (!is_writeable($dirname)) {
            $this->stateInfo = $this->getStateInfo("ERROR_DIR_NOT_WRITEABLE");
            return;
        }

        //移动文件
        if (!(move_uploaded_file($file["tmp_name"], $this->filePath) && file_exists($this->filePath))) { //移动失败
            $this->stateInfo = $this->getStateInfo("ERROR_FILE_MOVE");
        } else { //移动成功

            //如检测到有旧图片，则对旧图片进行删除操作
            if($this->oldfile){
                $this->delOldFile();
            }
            $this->stateInfo = $this->stateMap[0];
        }
    }

    /**
     * 处理base64编码的图片上传
     * @return mixed
     */
    private function upBase64()
    {
        $base64Data = $_POST[$this->fileField];
        $img = base64_decode($base64Data);

        $this->oriName = $this->config['oriName'];
        $this->fileSize = strlen($img);
        $this->fileType = $this->getFileExt();
        $this->fullName = $this->getFullName();
        $this->filePath = $this->getFilePath();
        $this->fileName = $this->getFileName();
        $dirname = dirname($this->filePath);

        //检查文件大小是否超出限制
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        //创建目录失败
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {
            $this->stateInfo = $this->getStateInfo("ERROR_CREATE_DIR");
            return;
        } else if (!is_writeable($dirname)) {
            $this->stateInfo = $this->getStateInfo("ERROR_DIR_NOT_WRITEABLE");
            return;
        }

        //移动文件
        if (!(file_put_contents($this->filePath, $img) && file_exists($this->filePath))) { //移动失败
            $this->stateInfo = $this->getStateInfo("ERROR_WRITE_CONTENT");
        } else { //移动成功
            $this->stateInfo = $this->stateMap[0];
        }

    }

    /**
     * 拉取远程图片
     * @return mixed
     */
    private function saveRemote()
    {
        $imgUrl = htmlspecialchars($this->fileField);
        $imgUrl = str_replace("&amp;", "&", $imgUrl);

        //http开头验证
        if (strpos($imgUrl, "http") !== 0) {
            $this->stateInfo = $this->getStateInfo("ERROR_HTTP_LINK");
            return;
        }

        preg_match('/(^https*:\/\/[^:\/]+)/', $imgUrl, $matches);
        $host_with_protocol = count($matches) > 1 ? $matches[1] : '';

        // 判断是否是合法 url
        if (!filter_var($host_with_protocol, FILTER_VALIDATE_URL)) {
            $this->stateInfo = $this->getStateInfo("INVALID_URL");
            return;
        }

        preg_match('/^https*:\/\/(.+)/', $host_with_protocol, $matches);
        $host_without_protocol = count($matches) > 1 ? $matches[1] : '';

        // 此时提取出来的可能是 ip 也有可能是域名，先获取 ip
        $ip = gethostbyname($host_without_protocol);
        // 判断是否是私有 ip
        if(!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
            $this->stateInfo = $this->getStateInfo("INVALID_IP");
            return;
        }

        $HEADER = <<<HEADER
Host:mbd.baidu.com
User-Agent:User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3218.0 Safari/537.36
HEADER;
        $request = array('method' => 'GET','header' => $HEADER );
        stream_context_get_default( array('https'=>$request) );

        if(strpos($imgUrl,'baidu.com')){
            $imgUrl_old = $imgUrl;
            $imgUrl = self::cdomain_baidu($imgUrl);
        }else{
            $imgUrl_old = $imgUrl;
        }

        //获取请求头并检测死链
        $heads = get_headers($imgUrl, 1);
        //print_r($imgUrl);
        if (!(stristr($heads[0], "200") && stristr($heads[0], "OK"))) {
            $this->stateInfo = $this->getStateInfo("ERROR_DEAD_LINK");
            return;
        }
        //格式验证(扩展名验证和Content-Type验证)
        $fileType = strtolower(strrchr($imgUrl, '.'));
        if (!in_array($fileType, $this->config['allowFiles']) || !isset($heads['Content-Type']) || !stristr($heads['Content-Type'], "image")) {
            $this->stateInfo = $this->getStateInfo("ERROR_HTTP_CONTENTTYPE");
            return;
        }

        //打开输出缓冲区并获取远程图片
        ob_start();
        $context = stream_context_create(
            array('http' => array(
                'follow_location' => false // don't follow redirects
            ))
        );
        readfile($imgUrl, false, $context);
        $img = ob_get_contents();
        ob_end_clean();
        preg_match("/[\/]([^\/]*)[\.]?[^\.\/]*$/", $imgUrl_old, $m);

        $this->oriName = $m ? $m[1]:"";
        $this->fileSize = strlen($img);
        $this->fileType = $this->getFileExt();
        $this->fullName = $this->getFullName();
        $this->filePath = $this->getFilePath();
        $this->fileName = $this->getFileName();
        $dirname = dirname($this->filePath);

        //检查文件大小是否超出限制
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        //创建目录失败
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {
            $this->stateInfo = $this->getStateInfo("ERROR_CREATE_DIR");
            return;
        } else if (!is_writeable($dirname)) {
            $this->stateInfo = $this->getStateInfo("ERROR_DIR_NOT_WRITEABLE");
            return;
        }

        //移动文件
        if (!(file_put_contents($this->filePath, $img) && file_exists($this->filePath))) { //移动失败
            $this->stateInfo = $this->getStateInfo("ERROR_WRITE_CONTENT");
        } else { //移动成功
            $this->stateInfo = $this->stateMap[0];
        }

    }

    /**
     * 上传错误检查
     * @param $errCode
     * @return string
     */
    private function getStateInfo($errCode)
    {
        return !$this->stateMap[$errCode] ? $this->stateMap["ERROR_UNKNOWN"] : $this->stateMap[$errCode];
    }

    /**
     * 获取文件扩展名
     * @return string
     */
    private function getFileExt()
    {
        return strtolower(strrchr($this->oriName, '.'));
    }

    /**
     * 重命名文件
     * @return string
     */
    private function getFullName()
    {
        //替换日期事件
        $t = time();
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $format = $this->config["pathFormat"];
        $format = str_replace("{yyyy}", $d[0], $format);
        $format = str_replace("{yy}", $d[1], $format);
        $format = str_replace("{mm}", $d[2], $format);
        $format = str_replace("{dd}", $d[3], $format);
        $format = str_replace("{hh}", $d[4], $format);
        $format = str_replace("{ii}", $d[5], $format);
        $format = str_replace("{ss}", $d[6], $format);
        $format = str_replace("{time}", $this->thumb.$t, $format);

        //过滤文件名的非法自负,并替换文件名
        $oriName = substr($this->oriName, 0, strrpos($this->oriName, '.'));
        $oriName = preg_replace("/[\|\?\"\<\>\/\*\\\\]+/", '', $oriName);
        $format = str_replace("{filename}", $oriName, $format);

        //替换随机字符串
        $randNum = rand(1, 10000000000) . rand(1, 10000000000);
        if (preg_match("/\{rand\:([\d]*)\}/i", $format, $matches)) {
            $format = preg_replace("/\{rand\:[\d]*\}/i", substr($randNum, 0, $matches[1]), $format);
        }

        $ext = $this->getFileExt();
        return $format . $ext;
    }

    /**
     * 获取文件名
     * @return string
     */
    private function getFileName () {
        return substr($this->filePath, strrpos($this->filePath, '/') + 1);
    }

    /**
     * 获取文件完整路径
     * @return string
     */
    private function getFilePath()
    {
        $fullname = $this->fullName;
//        $rootPath = $_SERVER['DOCUMENT_ROOT'];
//        if (substr($fullname, 0, 1) != '/') {
//            $fullname = '/' . $fullname;
//        }
        //sd框架读取到路径为/ 因此需要作修改
        $rootPath = $this->AdminUploadsConfig['rootpath'];
        return $rootPath . $fullname;
    }

    /**
     * 删除旧文件
     */
    private function delOldFile(){
        //sd框架读取到路径为/ 因此需要作修改 读取配置中设置的路径
        $rootPath = $this->AdminUploadsConfig['rootpath'];
        if(is_file($rootPath.$this->oldfile)){
            echo $rootPath.$this->oldfile;
        }

    }

    /**
     * 文件类型检测
     * @return bool
     */
    private function checkType()
    {
        return in_array($this->getFileExt(), $this->config["allowFiles"]);
    }

    /**
     * 文件大小检测
     * @return bool
     */
    private function  checkSize()
    {
        return $this->fileSize <= ($this->config["maxSize"]);
    }

    /**
     * 获取当前上传成功文件的各项信息
     * @return array
     */
    public function getFileInfo()
    {
        return array(
            "state" => $this->stateInfo,
            "url" => $this->fullName,
            "title" => $this->fileName,
            "original" => $this->oriName,
            "type" => $this->fileType,
            "size" => $this->fileSize
        );
    }

    // 域名转换
    private function cdomain_baidu($str){
        $baidu_domain = '{
    "http://graph.baidu.com": "https://sp0.baidu.com/-aYHfD0a2gU2pMbgoY3K",
    "http://p.qiao.baidu.com":"https://sp0.baidu.com/5PoXdTebKgQFm2e88IuM_a",
    "http://vse.baidu.com":"https://sp3.baidu.com/6qUDsjip0QIZ8tyhnq",
    "http://hdpreload.baidu.com":"https://sp3.baidu.com/7LAWfjuc_wUI8t7jm9iCKT-xh_",
    "http://lcr.open.baidu.com":"https://sp2.baidu.com/8LUYsjW91Qh3otqbppnN2DJv",
    "http://kankan.baidu.com":"https://sp3.baidu.com/7bM1dzeaKgQFm2e88IuM_a",
    "http://xapp.baidu.com":"https://sp2.baidu.com/yLMWfHSm2Q5IlBGlnYG",
    "http://dr.dh.baidu.com":"https://sp0.baidu.com/-KZ1aD0a2gU2pMbgoY3K",
    "http://xiaodu.baidu.com":"https://sp0.baidu.com/yLsHczq6KgQFm2e88IuM_a",
    "http://sensearch.baidu.com":"https://sp1.baidu.com/5b11fzupBgM18t7jm9iCKT-xh_",
    "http://s1.bdstatic.com":"https://ss1.bdstatic.com/5eN1bjq8AAUYm2zgoY3K",
    "http://olime.baidu.com":"https://sp0.baidu.com/8bg4cTva2gU2pMbgoY3K",
    "http://app.baidu.com":"https://sp2.baidu.com/9_QWsjip0QIZ8tyhnq",
    "http://i.baidu.com":"https://sp0.baidu.com/74oIbT3kAMgDnd_",
    "http://c.baidu.com":"https://sp0.baidu.com/9foIbT3kAMgDnd_",
    "http://sclick.baidu.com":"https://sp0.baidu.com/5bU_dTmfKgQFm2e88IuM_a",
    "http://nsclick.baidu.com":"https://sp1.baidu.com/8qUJcD3n0sgCo2Kml5_Y_D3",
    "http://sestat.baidu.com":"https://sp1.baidu.com/5b1ZeDe5KgQFm2e88IuM_a",
    "http://eclick.baidu.com":"https://sp3.baidu.com/-0U_dTmfKgQFm2e88IuM_a",
    "http://api.map.baidu.com":"https://sp2.baidu.com/9_Q4sjOpB1gCo2Kml5_Y_D3",
    "http://ecma.bdimg.com":"https://ss1.bdstatic.com/-0U0bXSm1A5BphGlnYG",
    "http://ecmb.bdimg.com":"https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG",
    "http://t1.baidu.com":"https://ss0.baidu.com/6ON1bjeh1BF3odCf",
    "http://t2.baidu.com":"https://ss1.baidu.com/6OZ1bjeh1BF3odCf",
    "http://t3.baidu.com":"https://ss2.baidu.com/6OV1bjeh1BF3odCf",
    "http://t10.baidu.com":"https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq",
    "http://t11.baidu.com":"https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq",
    "http://t12.baidu.com":"https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq",
    "http://i7.baidu.com":"https://ss0.baidu.com/73F1bjeh1BF3odCf",
    "http://i8.baidu.com":"https://ss0.baidu.com/73x1bjeh1BF3odCf",
    "http://i9.baidu.com":"https://ss0.baidu.com/73t1bjeh1BF3odCf",
    "http://b1.bdstatic.com":"https://ss0.bdstatic.com/9uN1bjq8AAUYm2zgoY3K",
    "http://ss.bdimg.com":"https://ss1.bdstatic.com/5aV1bjqh_Q23odCf",
    "http://opendata.baidu.com":"https://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv",
    "http://api.open.baidu.com":"https://sp0.baidu.com/9_Q4sjW91Qh3otqbppnN2DJv",
    "http://tag.baidu.com":"https://sp1.baidu.com/6LMFsjip0QIZ8tyhnq",
    "http://f3.baidu.com":"https://sp2.baidu.com/-uV1bjeh1BF3odCf",
    "http://s.share.baidu.com":"https://sp0.baidu.com/5foZdDe71MgCo2Kml5_Y_D3",  
    "http://bdimg.share.baidu.com":"https://ss1.baidu.com/9rA4cT8aBw9FktbgoI7O1ygwehsv",
    "http://1.su.bdimg.com":"https://ss0.bdstatic.com/k4oZeXSm1A5BphGlnYG",
    "http://2.su.bdimg.com":"https://ss1.bdstatic.com/kvoZeXSm1A5BphGlnYG",
    "http://3.su.bdimg.com":"https://ss2.bdstatic.com/kfoZeXSm1A5BphGlnYG",
    "http://4.su.bdimg.com":"https://ss3.bdstatic.com/lPoZeXSm1A5BphGlnYG",
    "http://5.su.bdimg.com":"https://ss0.bdstatic.com/l4oZeXSm1A5BphGlnYG",
    "http://6.su.bdimg.com":"https://ss1.bdstatic.com/lvoZeXSm1A5BphGlnYG",
    "http://7.su.bdimg.com":"https://ss2.bdstatic.com/lfoZeXSm1A5BphGlnYG",
    "http://8.su.bdimg.com":"https://ss3.bdstatic.com/iPoZeXSm1A5BphGlnYG",
    "https://graph.baidu.com": "https://sp0.baidu.com/-aYHfD0a2gU2pMbgoY3K",
    "https://p.qiao.baidu.com":"https://sp0.baidu.com/5PoXdTebKgQFm2e88IuM_a",
    "https://vse.baidu.com":"https://sp3.baidu.com/6qUDsjip0QIZ8tyhnq",
    "https://hdpreload.baidu.com":"https://sp3.baidu.com/7LAWfjuc_wUI8t7jm9iCKT-xh_",
    "https://lcr.open.baidu.com":"https://sp2.baidu.com/8LUYsjW91Qh3otqbppnN2DJv",
    "https://kankan.baidu.com":"https://sp3.baidu.com/7bM1dzeaKgQFm2e88IuM_a",
    "https://xapp.baidu.com":"https://sp2.baidu.com/yLMWfHSm2Q5IlBGlnYG",
    "https://dr.dh.baidu.com":"https://sp0.baidu.com/-KZ1aD0a2gU2pMbgoY3K",
    "https://xiaodu.baidu.com":"https://sp0.baidu.com/yLsHczq6KgQFm2e88IuM_a",
    "https://sensearch.baidu.com":"https://sp1.baidu.com/5b11fzupBgM18t7jm9iCKT-xh_",
    "https://s1.bdstatic.com":"https://ss1.bdstatic.com/5eN1bjq8AAUYm2zgoY3K",
    "https://olime.baidu.com":"https://sp0.baidu.com/8bg4cTva2gU2pMbgoY3K",
    "https://app.baidu.com":"https://sp2.baidu.com/9_QWsjip0QIZ8tyhnq",
    "https://i.baidu.com":"https://sp0.baidu.com/74oIbT3kAMgDnd_",
    "https://c.baidu.com":"https://sp0.baidu.com/9foIbT3kAMgDnd_",
    "https://sclick.baidu.com":"https://sp0.baidu.com/5bU_dTmfKgQFm2e88IuM_a",
    "https://nsclick.baidu.com":"https://sp1.baidu.com/8qUJcD3n0sgCo2Kml5_Y_D3",
    "https://sestat.baidu.com":"https://sp1.baidu.com/5b1ZeDe5KgQFm2e88IuM_a",
    "https://eclick.baidu.com":"https://sp3.baidu.com/-0U_dTmfKgQFm2e88IuM_a",
    "https://api.map.baidu.com":"https://sp2.baidu.com/9_Q4sjOpB1gCo2Kml5_Y_D3",
    "https://ecma.bdimg.com":"https://ss1.bdstatic.com/-0U0bXSm1A5BphGlnYG",
    "https://ecmb.bdimg.com":"https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG",
    "https://t1.baidu.com":"https://ss0.baidu.com/6ON1bjeh1BF3odCf",
    "https://t2.baidu.com":"https://ss1.baidu.com/6OZ1bjeh1BF3odCf",
    "https://t3.baidu.com":"https://ss2.baidu.com/6OV1bjeh1BF3odCf",
    "https://t10.baidu.com":"https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq",
    "https://t11.baidu.com":"https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq",
    "https://t12.baidu.com":"https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq",
    "https://i7.baidu.com":"https://ss0.baidu.com/73F1bjeh1BF3odCf",
    "https://i8.baidu.com":"https://ss0.baidu.com/73x1bjeh1BF3odCf",
    "https://i9.baidu.com":"https://ss0.baidu.com/73t1bjeh1BF3odCf",
    "https://b1.bdstatic.com":"https://ss0.bdstatic.com/9uN1bjq8AAUYm2zgoY3K",
    "https://ss.bdimg.com":"https://ss1.bdstatic.com/5aV1bjqh_Q23odCf",
    "https://opendata.baidu.com":"https://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv",
    "https://api.open.baidu.com":"https://sp0.baidu.com/9_Q4sjW91Qh3otqbppnN2DJv",
    "https://tag.baidu.com":"https://sp1.baidu.com/6LMFsjip0QIZ8tyhnq",
    "https://f3.baidu.com":"https://sp2.baidu.com/-uV1bjeh1BF3odCf",
    "https://s.share.baidu.com":"https://sp0.baidu.com/5foZdDe71MgCo2Kml5_Y_D3",  
    "https://bdimg.share.baidu.com":"https://ss1.baidu.com/9rA4cT8aBw9FktbgoI7O1ygwehsv",
    "https://1.su.bdimg.com":"https://ss0.bdstatic.com/k4oZeXSm1A5BphGlnYG",
    "https://2.su.bdimg.com":"https://ss1.bdstatic.com/kvoZeXSm1A5BphGlnYG",
    "https://3.su.bdimg.com":"https://ss2.bdstatic.com/kfoZeXSm1A5BphGlnYG",
    "https://4.su.bdimg.com":"https://ss3.bdstatic.com/lPoZeXSm1A5BphGlnYG",
    "https://5.su.bdimg.com":"https://ss0.bdstatic.com/l4oZeXSm1A5BphGlnYG",
    "https://6.su.bdimg.com":"https://ss1.bdstatic.com/lvoZeXSm1A5BphGlnYG",
    "https://7.su.bdimg.com":"https://ss2.bdstatic.com/lfoZeXSm1A5BphGlnYG",
    "https://8.su.bdimg.com":"https://ss3.bdstatic.com/iPoZeXSm1A5BphGlnYG"
          }';
        $domain = json_decode($baidu_domain, true);
        foreach($domain as $k=>$v){
            $str = str_replace($k, $v, $str);
        }
        return $str;
    }

}