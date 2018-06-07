<?php
define('PASSWORD', '50240902');   // 第一次使用请把123修改为您自己的密码。
define('DATADIR', 'data');  // 如果您的网站自定义了data目录，请在这里修改。


define("UPLOAD", 1);        // 恶意代码上传接口开关。如果您要关闭请设置为0。
define('VERSION', 20130928); //版本信息。
define('UPDATE_URL_JS', 'http://tool.scanv.com/dedekiller/update_ver.php');
define('UPDATE_URL', 'http://tool.scanv.com/dedekiller/update_utf.php');
define('UPLOAD_URL', 'http://tool.scanv.com/dedekiller/recvfile.php?host='.$_SERVER['SERVER_NAME']);

error_reporting(0);
set_time_limit(0);

ini_set("memory_limit", "100m");
header("Content-type: text/html;charset=utf-8");

if(!isset($_COOKIE['dedekillerpwd']) || $_COOKIE['dedekillerpwd'] != md5(PASSWORD)) {

    if($_SERVER['REQUEST_METHOD']=='GET'){
        echo <<< ENT
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8 />
    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Microsoft Yahei, Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
        }
        a {
            color: #09c;
            text-decoration: none;
        }
        a:hover {
            color: #08a;
            text-decoration: underline;
        }
        input{
            border: 1px solid #CCCCCC;
            border-radius: 3px 3px 3px 3px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            color: #555555;
            display: inline-block;
            line-height: normal;
            padding: 4px;
            width: 80px;
        }   
        .hero-unit {
            margin: 0 auto 0 auto;
            font-size: 18px;
            font-weight: 200;
            line-height: 30px;
            border-radius: 6px;
            padding: 20px 60px 10px;
        }
        .hero-unit>h2 {
            text-shadow: 2px 2px 2px #ccc;
            font-weight: normal;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.428571429;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }
        .btn:focus {
            outline: thin dotted #333;
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
        }

        .btn:hover,
        .btn:focus {
            color: #ffffff;
            text-decoration: none;
        }

        .btn:active,
        .btn.active {
            outline: 0;
            -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        }

        .btn-default {
            color: #ffffff;
            background-color: #474949;
            border-color: #474949;
        }

        .btn-default:hover,
        .btn-default:focus,
        .btn-default:active,
        .btn-default.active {
            background-color: #3a3c3c;
            border-color: #2e2f2f;
        }
        .btn-success {
            color: #ffffff;
            background-color: #5cb85c;
            border-color: #5cb85c;
        }

        .btn-success:hover,
        .btn-success:focus,
        .btn-success:active,
        .btn-success.active {
            background-color: #4cae4c;
            border-color: #449d44;
        }
        .btn-primary {
            color: #ffffff;
            background-color: #428bca;
            border-color: #428bca;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary.active {
            background-color: #357ebd;
            border-color: #3071a9;
        }
        .main {
            width: 960px;
            margin: 0 auto;
        }
        .title, .check{
            text-align: center;
        }
        .check button {
            width: 200px;
            font-size: 20px;
        }
        .check a.btn {
            color: #ffffff;
            text-decoration: none;
        }
        .content {
            margin-top: 20px;
            padding: 15px 30px 30px;
            box-shadow: 0 1px 1px #aaa;
            background: #fff;
        }
        dt {
            font-size: 25px;
        }
        table {
            width: 100%;
            border-collapse:collapse;
            border-spacing: 0;
        }
        th, td {
            text-align: left;
        }
        td {
            border-bottom: solid 1px #e0e0e0;
            height: 40px;
            vertical-align: top;
            line-height: 40px;
        }
        .item_t td {
            border-bottom: 0;
        }
        .item_y {
            word-wrap: break-word;
            word-break: break-word;
            width: 860px;
            color: Red;
            text-indent: 1em;
            padding-bottom: 10px;
        }
        .yt, .yv {
            line-height: 1.7em;
        }
        .yt {
            color: #f00;
        }
        .yv {
            color: #00f;
            font-size: 12px;
        }
        .item_n {
            width: 860px;
            color: #0a0;
            text-indent: 1em;
        }
        .ads>ul {
            list-style: none;
            padding: 0;
        }
        .ads>ul>li {
            float: left;
            padding-right: 20px;
        }
        .foot {
            text-align: center;
            font-size: 13px;
        }
        .clearfix:before,
        .clearfix:after {
            display: table;
            content: " ";
        }
        .clearfix:after {
            clear: both;
        }

    </style>
</head>
<body>
<div class="main">
    <div class="hero-unit">
        <h2 class="title">DedeCMS顽固木马后门专杀工具 V 2.0</h2>
        <div class="check">
            <form method="post" action="">
                  管理密码：<input type="text" name="pwd" />
                  <input type="submit" value="登陆" />
            </form>
            <table>
                <tbody>
                    <thead>
                        <tr><td class="item">该工具为<a href='http://zhanzhang.anquan.org'>安全联盟站长平台</a>针对DedeCMS爆发的90sec.php等顽固木马后门而定制的专杀工具。</td></tr>
                        <tr><td class="item">主要有如下特点：一切为加强DedeCMS安全而生！</td></tr>
                        <tr><td class="item">-->1.扫瞄并修补漏洞,从安全设置上加强DedeCMS自身的安全防御（根本上解决90sec.php等顽固木马的“病因”）</td></tr>
                        <tr><td class="item">-->2.清扫数据库（根本上解决90sec.php等顽固木马“复发”问题） </td></tr>
                        <tr><td class="item">-->3.查杀多种网站木马后门及恶意DDos脚本（解决90sec.php等顽固木马基本“症状”） </td></tr>
                        <tr><center><a class="jl" target="_blank" href="http://bbs.anquan.org/forum.php?mod=forumdisplay&fid=162">使用教程</a> 安全联盟站长交流群：126020287</center></tr>
                    </thead>
                </tbody>
            </table>
    </div>
</div>
</body>
</html>
ENT;
        die();
    } else {
        if (isset($_POST['pwd']) && $_POST['pwd'] == PASSWORD){
            if ($_POST['pwd'] == '123') {
                echo "<script>alert(\"修改默认密码，才能正常登陆！方法：记事本打开本文件把代码：define('PASSWORD', '123'); 里的123修改为您的密码，建议密码设置复杂点！\");</script>";
                die();
            }

			$mypwd = md5(PASSWORD);
            setcookie('dedekillerpwd', $mypwd);
			echo "<script>document.cookie='dedekillerpwd=".$mypwd."';window.location.href='';</script>";
			die();

        } else {
            echo "<script>alert('密码不正确');</script>";
            die();
        }
    }
}

//检测是否存放至根目录
if(!file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.DATADIR.DIRECTORY_SEPARATOR.'common.inc.php'))
{
    echo <<< ENT
<html>
<head>
<title>DedeCMS顽固木马后门专杀工具提示</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base target='_self'/>
<style>div{line-height:160%;}</style></head>
<body leftmargin='0' topmargin='0' bgcolor='#FFFFFF'>
<center>
<script>
document.write("<br /><div style='width:450px;padding:0px;border:1px solid #DADADA;'><div style='padding:6px;font-size:12px;border-bottom:1px solid #DADADA;background:#DBEEBD ';'><b>DedeCMS顽固木马后门专杀工具提示！</b></div>");
document.write("<div style='height:130px;font-size:10pt;background:#ffffff'><br />");
document.write("请将该文件放到您站点的根目录，和index.php同一级目录");
</script>
</center>
</body>
</html>

ENT;

    exit();
}


define('DEDEROOT', str_replace("\\", '/', dirname(__FILE__) ) );
define('DEDEINC', str_replace("\\", '/', dirname(__FILE__) )."/include" );
define('DEDEDATA', DEDEROOT.DIRECTORY_SEPARATOR.DATADIR);

//数据库配置文件
require_once(DEDEINC.'/common.func.php');
require_once(DEDEDATA.'/common.inc.php');

if(file_exists(DEDEDATA.'/helper.inc.php'))
{
    require_once(DEDEDATA.'/helper.inc.php');
    // 若没有载入配置,则初始化一个默认小助手配置
    if (!isset($cfg_helper_autoload))
    {
        $cfg_helper_autoload = array('util', 'charset', 'string', 'time', 'cookie');
    }
    // 初始化小助手
    helper($cfg_helper_autoload);
}

//检测是否存在变量覆盖
$arrs1 = array(0x6E,0x73,0x6C,0x6D,0x73,0x74,0x7A);  //nslmstz
$arrs2 = array(0x6A,0x75,0x73,0x74,0x34,0x66,0x75,0x6E);  //just4fun

require_once(dirname(__FILE__).'/include/dedesql.class.php');

//启用session,防止后期恶意用户操作
session_save_path(DEDEDATA.DIRECTORY_SEPARATOR.'sessions');
session_start();

class Checker{

    // 存在安装目录与否
    public $bExistInstall = false;

    // 存在变量覆盖漏洞与否
    public $bExistVul = false;

    // myTag表中是否存在恶意数据
    public $bMytagEvil = false;

    // myad表中是否存在恶意数据
    public $bMyadEvil = false;

    public $bFlinkEvil = false;

    public $bSearchEvil = false;

    public $bFeedBackEvil = false;

    public $bUploadSafeEvil = false;

    public $bMemberBuyActionEvil = false;

    public $bFeedBackajaxEvil = false;

    public $bWrongSetting = false;

    // myTag中的恶意数据
    public $aEvilMytagData = array();

    // myAd中的恶意数据
    public $aEvilMyadData = array();

    // userlist
    public $aUserList = array();

    // dede version
    public $aVersion = array();

    public $arFlinkData = array();

    // 本文件所在目录，也就是跟目录
    private $_currentDir = '';

    public $strDefaultAdminDir = '';
    public $strWeakPasswd = '';

    // 该文件的名字
    private $_curFileName = '';

    // 排除扫描的文件，使用正则表示
    private $_excludeFile = '';

    function __construct(){
        //设置排除文件
        $url = $_SERVER['PHP_SELF'];
        $filename = end(explode("/", $url));
        $this->_curFileName =  $filename;
        $sessionFile = "sess_\\w{26}";
        $this->_excludeFile = "#".$filename.'|'.$sessionFile.'#';
        $this->_currentDir = dirname(__FILE__);
    }


    public function start(){
        $this->isExistInstall();
        $this->isExistVul();
        $this->isMytagEvil();
        $this->isMyadEvil();
        $this->listAllUser();
        $this->getVersion();
        $this->checkFlinkVul();
        $this->checkSearchSqlInjectVul();
        $this->checkFeedBackSqlInjectVul();
        $this->checkFeedBackajaxVul();
        $this->checkUploadSafeSqlInjectVul();
        #$this->checkDefaultAdminDir();
        $this->checkMemberBuyActionSqlInject();
        $this->checkFlinkData();
        $this->checkWeakPasswd();
        $this->checkSetting();

        $this->storeToSession();
    }


    public function getVersion(){
        $removeVerArray = @file("http://updatenew.dedecms.com/base-v57/verinfo.txt");
        $localVer = @file_get_contents(DEDEDATA."/admin/ver.txt");

        if(empty($localVer)){
            $localVer = "unknown";
        }

        $removeVer = $removeVerArray[count($removeVerArray)-1];
        $removeVer = substr($removeVer, 0, 8);

        if($localVer != $removeVer){
            $this->aVersion = array(1, $localVer, $removeVer);
        }else{
            $this->aVersion = array(0, $localVer, $removeVer);
        }

    }

    /**
     * 判断是否存在安装目录，并设置$this->bExistInstall
     *
     * @param none
     *
     * @return bool 结果
     */
    public function isExistInstall(){
        if(is_dir(dirname(__FILE__).'/install/')){
            $this->bExistInstall = true;
            return true;
        }else{
            $this->bExistInstall = false;
            return false;
        }
    }


    /**
     * 判断是否存在变量覆盖漏洞，并设置$this->bExistVul
     *
     * @param string $paramName  自定义变量覆盖名字
     * @param string $paramValue  自定义变量的值
     *
     * @return  bool结果
     */
    public function isExistVul($paramName='nslmstz', $paramValue='just4fun'){
        //var_dump($GLOBALS);
        if(isset($GLOBALS[$paramName]) and $GLOBALS[$paramName] == $paramValue){
            $this->bExistVul = true;
            return true;
        }else{
            $this->bExistVul = false;
            return false;
        }
    }


    /**
     * 检测myTag表中是否存在恶意数据
     *
     * @return  bool 结果
     */
    public function isMytagEvil(){
        $this->aEvilMytagData = $this->checkData('mytag');

        if($this->aEvilMytagData){
            $this->bMytagEvil = true;
            return true;
        }else{
            $this->bMytagEvil = false;
            return false;
        }
    }


    /**
     * 检测myAd表中是否存在恶意数据
     *
     * @return  bool 结果
     */
    public function isMyadEvil(){
        $this->aEvilMyadData = $this->checkData('myad');

        if($this->aEvilMyadData){
            $this->bMyadEvil = true;
            return true;
        }else{
            $this->bMyadEvil = false;
            return false;
        }
    }


    /**
     * list all the users
     *
     * @return none
     */
    public function listAllUser(){
        global $dsql;
        $arWeakPasswd = array('123456', 'admin', 'admin123', 'dede', 'test', 'password', '123456789');

        $dsql->SetQuery("SELECT id, pwd, userid FROM #@__admin");
        $dsql->Execute();

        while($row = $dsql->GetArray()){
            $this->aUserList[$row['id']] = array($row['userid']);
            $strPwd = $row['pwd'];
            foreach($arWeakPasswd as $key => $strWeakPasswd) {
                if(strpos(md5($strWeakPasswd), $strPwd) !== false){
                    $this->aUserList[$row['id']][] = $strWeakPasswd;
                    break;
                }
            }
        }
        return $this->aUserList;
    }


    public function checkFlinkVul(){
        $arVulFileContent = @file('plus/flink.php');

        if($arVulFileContent) {
            $strVulFileContent = @file_get_contents('plus/flink.php');
            if(substr_count($strVulFileContent, '$logo') != 3) {
                $this->bFlinkEvil = false;
                return false;
            }

            if(strpos(trim($arVulFileContent[28]), '$logo = htmlspecialchars($logo);') === false) {
                $this->bFlinkEvil = false;
                return false;
            }

            if(strpos(trim($arVulFileContent[32]), 'VALUES(\'50\',\'$url\',\'$webname\',\'$logo\',\'$msg\',\'$email\',\'$typeid\',\'$dtime\',\'0\')') === false) {
                $this->bFlinkEvil = false;
                return false;
            }

            $this->bFlinkEvil = true;
            return true;
        }
        $this->bFlinkEvil = false;
        return false;
    }

    public function checkSearchSqlInjectVul() {
        $strFileContent = @file_get_contents('plus/search.php');

        if($strFileContent) {
            if(strpos($strFileContent, '$typeid = intval($typeid);') !== false) {
                $this->bSearchEvil = false;
                return false;
            } else {
                $this->bSearchEvil = true;
                return true;
            }
        }

        $this->bSearchEvil = false;
        return false;
    }

    public function checkFeedBackSqlInjectVul() {
        $strFileContent = @file_get_contents('plus/feedback.php');

        if($strFileContent) {
            if(strpos($strFileContent, '$arctitle = addslashes($row[\'arctitle\']);') !== false) {
                $this->bFeedBackEvil = false;
                return false;
            } else {
                $this->bFeedBackEvil = true;
                return true;
            }
        }

        $this->bFeedBackEvil = false;
        return false;
    }

    public function checkFeedBackajaxVul() {
        $strFileContent = @file_get_contents('plus/feedback_ajax.php');

        if($strFileContent) {
            if(strpos($strFileContent, '$arctitle = addslashes(RemoveXSS($title));') !== false) {
                $this->bFeedBackajaxEvil = false;
                return false;
            } else {
                $this->bFeedBackajaxEvil = true;
                return true;
            }
        }

        $this->bFeedBackajaxEvil = false;
        return false;
    }

    public function checkUploadSafeSqlInjectVul() {
        // 检测是否存在注入
        $superhei = 'superhei.avi';
        $GLOBALS['_FILES']['superhei']['tmp_name'] = "justforfun\\\\'";
        $GLOBALS['_FILES']['superhei']['name'] = 'superhei.avi';
        $GLOBALS['_FILES']['superhei']['size'] = 123;
        $GLOBALS['_FILES']['superhei']['type'] = 'super/hei';

        if (!is_file(DEDEINC.DIRECTORY_SEPARATOR.'uploadsafe.inc.php')) {
            $this->bUploadSafeEvil = false;
            return false;
        }

        @include(DEDEINC.DIRECTORY_SEPARATOR.'uploadsafe.inc.php');

        if ($superhei == "justforfun\\\\'") {
            $this->bUploadSafeEvil = false;
            return false;
        } else {
            $this->bUploadSafeEvil = true;
            return true;
        }
    }

    public function checkMemberBuyActionSqlInject() {
        $strFileContent = @file_get_contents(DEDEROOT.DIRECTORY_SEPARATOR.'member/buy_action.php');

        if($strFileContent) {
            if(strpos($strFileContent, 'mchStrCode($string, $operation = \'ENCODE\')') !== false) {
                $this->bMemberBuyActionEvil = false;
                return false;
            } else {
                $this->bMemberBuyActionEvil = true;
                return true;
            }
        }

        $this->bMemberBuyActionEvil = false;
        return false;
    }

    /**
     *check default admin dir
     */
    public function checkDefaultAdminDir() {
        $arDefaultDir = array('/dede/login.php', '/admin/login.php', '/manager/login.php');
        foreach($arDefaultDir as $key => $strDefaultDir) {
            $strFileName = realpath($this->_currentDir.DIRECTORY_SEPARATOR.$strDefaultDir);
            if ($strFileName) {
                $this->strDefaultAdminDir = dirname($strFileName);
                break;
            }
        }

    }

    /*
     * check weak password
     */

    public function checkWeakPasswd() {
        global $dsql;


        $dsql->SetQuery("SELECT pwd FROM #@__admin");
        $dsql->Execute();

        while($row = $dsql->GetArray()){

        }
    }

    public function checkFlinkData() {
        global $dsql;

        $dsql->SetQuery("SELECT id, logo, url FROM #@__flink");
        $dsql->Execute();

        while($row = $dsql->GetArray()){
            $strLogo = $row['logo'];
            $strUrl = $row['url'];
            if(strpos($strLogo, array('\'', '<')) !== false || strpos($strUrl, array('<', '\'')) !== false) {
                $this->arFlinkData[$row['id']] = array($row['logo'], $row['url']);
            }
        }
    }

    public function checkSetting() {
        global $dsql;

        $dsql->SetQuery("SELECT value FROM #@__sysconfig where varname='cfg_mb_open'");
        $dsql->Execute();

        $row = $dsql->GetArray();

        if($row['value'] == "Y") {
            $this->bWrongSetting = true;
            return true;
        }
        return false;
    }


    /**
     * 检测表中是否存在恶意数据
     *
     * @param string $tableName  需要检查的表
     *
     * @return  array 返回可能是恶意数据的数组
     */
    private function checkData($tableName){
        global $dsql;
        $evilData = array();

        $dsql->SetQuery("SELECT aid, normbody, expbody FROM #@__".$tableName);
        $dsql->Execute();

        while($row = $dsql->GetArray()){
            $checkContent = $row['normbody'].$row['expbody'];
            if(strpos($checkContent, '<?') !== false){
                $evilData[$row['aid']] = array($row['normbody'], $row['expbody']);
            }
        }
        return $evilData;

    }




    /**
     *  将所有检测结果存放入session中
     *
     *  @return none
     */
    private function storeToSession(){
        session_unset();
        $_SESSION['bExistInstall'] = $this->bExistInstall;
        $_SESSION['bExistVul'] = $this->bExistVul;
        $_SESSION['bMyadEvil'] = $this->bMyadEvil;
        $_SESSION['bMytagEvil'] = $this->bMytagEvil;
        $_SESSION['bFlinkEvil'] = $this->bFlinkEvil;
        $_SESSION['bWrongSetting'] = $this->bWrongSetting;
        $_SESSION['bFeedBackEvil'] = $this->bFeedBackEvil;
        $_SESSION['bFeedBackajaxEvil'] = $this->bFeedBackajaxEvil;
        $_SESSION['bSearchEvil'] = $this->bSearchEvil;
        $_SESSION['bUploadSafeEvil'] = $this->bUploadSafeEvil;
        # $_SESSION['strDefaultAdminDir'] = $this->strDefaultAdminDir;
        $_SESSION['bMemberBuyActionEvil'] = $this->bMemberBuyActionEvil;
        $_SESSION['strWeakPasswd'] = $this->strWeakPasswd;
        $_SESSION['aEvilMyadData'] = $this->aEvilMyadData;
        $_SESSION['aEvilMytagData'] = $this->aEvilMytagData;
        $_SESSION['aEvilFlinkData'] = $this->arFlinkData;
        $_SESSION['aUserList'] = $this->aUserList;
        $_SESSION['aVersion'] = $this->aVersion;
    }

};



class Cleaner{

    // 存在安装目录与否
    public $bExistInstall = false;

    // 存在变量覆盖漏洞与否
    public $bExistVul = false;

    // myTag表中是否存在恶意数据
    public $bMytagEvil = false;

    // myad表中是否存在恶意数据
    public $bMyadEvil = false;

    // 存在后门与否
    public $bExistBackdoor = false;

    // myTag中的恶意数据
    public $aEvilMytagData = array();

    // myAd中的恶意数据
    public $aEvilMyadData = array();

    public $aEvilFlinkData = array();

    // 后门文件
    public $aBackdoorFiles = array();

    // userlist
    public $aUserList = array();

    // 本文件所在目录，也就是跟目录
    private $_currentDir = '';


    function  __construct(){
        $this->bExistInstall = isset($_SESSION['bExistInstall']) ? $_SESSION['bExistInstall']: false;
        $this->bExistVul = isset($_SESSION['bExistVul']) ? $_SESSION['bExistVul']: false;
        $this->bMyadEvil = isset($_SESSION['bMyadEvil']) ? $_SESSION['bMyadEvil']: false;
        $this->bMytagEvil = isset($_SESSION['bMytagEvil']) ? $_SESSION['bMytagEvil']: false;
        $this->bExistBackdoor = isset($_SESSION['bExistBackdoor']) ? $_SESSION['bExistBackdoor']: false;
        $this->aEvilFlinkData = isset($_SESSION['aEvilFlinkData']) ? $_SESSION['aEvilFlinkData']: false;
        $this->aEvilMyadData = isset($_SESSION['aEvilMyadData']) ? $_SESSION['aEvilMyadData']: array();
        $this->aEvilMytagData = isset($_SESSION['aEvilMytagData']) ? $_SESSION['aEvilMytagData']: array();
        $this->aBackdoorFiles = isset($_SESSION['aBackdoorFiles']) ? $_SESSION['aBackdoorFiles']: array();
        $this->aUserList = isset($_SESSION['aUserList']) ? $_SESSION['aUserList']: array();

        $this->_currentDir = dirname(__FILE__);


    }


    /**
     * 检测表中是否存在恶意数据
     *
     * @return  bool
     */
    public function delInstallDir(){
        if(!$this->bExistInstall)
            return;

        if($this->delTree($this->_currentDir.'/install/')){
            $this->bExistInstall = false;
            unset($_SESSION['bExistInstall']);
            return ture;
        }else{
            return false;
        }

    }


    /**
     * 删除myAd表中的恶意数据
     *
     * @param string $myadId
     *
     * @return  bool
     */
    public function delMyadData($myadId){
        global $dsql;

        $rowId = intval($myadId);
        if(!array_key_exists($rowId, $this->aEvilMyadData))
            return false;

        return $dsql->ExecuteNoneQuery2("DELETE FROM #@__myad WHERE aid=".$rowId);

    }


    /**
     * 删除myTag表中的恶意数据
     *
     * @param string $mytagId
     *
     * @return  bool
     */
    public function delMytagData($mytagId){
        global $dsql;

        $rowId = intval($mytagId);
        if(!array_key_exists($rowId, $this->aEvilMytagData))
            return false;

        return $dsql->ExecuteNoneQuery2("DELETE FROM #@__mytag WHERE aid=".$rowId);
    }


    public function delFlinkData($flinkId){
        global $dsql;

        $rowId = intval($flinkId);
        if(!array_key_exists($rowId, $this->aEvilFlinkData))
            return false;

        return $dsql->ExecuteNoneQuery2("DELETE FROM #@__flink WHERE id=".$rowId);
    }


    public function delBackdoor($fileId, $bUpload=true){
        $fileId = intval($fileId);
        $bUpload = UPLOAD;

        if(!array_key_exists($fileId, $this->aBackdoorFiles)){
            return false;
        }

        if ($bUpload) {
            $fileName = $this->aBackdoorFiles[$fileId][0];
            //$fileContent = file_get_contents($fileName);

            sendFileRequest(UPLOAD_URL, $fileName);
        }

        return @unlink($this->aBackdoorFiles[$fileId][0]);

    }

    /**
     * 删除myTag表中的恶意数据
     *
     * @param string $userId
     *
     * @return  bool
     */
    public function delUser($userId){
        global $dsql;

        $rowId = intval($userId);
        if(!array_key_exists($rowId, $this->aUserList))
            return false;

        return $dsql->ExecuteNoneQuery2("DELETE FROM #@__admin WHERE id=".$rowId);
    }





    public function chgDefaultAdminDir($dir){
        $strDefaultAdminDir = realpath('dede');
        $dir = $this->_currentDir.DIRECTORY_SEPARATOR.$dir;

        if(is_dir($dir)) {
            return false;
        }

        return @rename("dede/", $dir);
    }

    /**
     * 删除一个目录
     *
     * @param string $dir  需要检查的表
     *
     * @return  bool 成功与否
     */
    private function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

}



class BackdoorChcker {

    private $_strCurDir = '';

    public $bExistBackdoor = false;

    // 后门文件
    public $aBackdoorFiles = array();

    // 后门指纹
    private $_strBackdoorPrint = "#(exec|base64_decode|edoced_46esab|eval|system|proc_open|popen|curl_exec|curl_multi_exec|parse_ini_file|show_source)\\s*?\\(\\s*?\\\$(_POST|_GET|_REQUEST|GLOBALS)#is";

    // 检测关键字
    private $_arBadWord = array('90sec','Copyright spider Clean Backdoor','Eval PHP Code','Udp1-fsockopen','xxddos');


    function __construct() {
        $this->_strCurDir = realpath(dirname(__FILE__));
    }



    /**
     * get all the dirs , store to a array 广度优先
     * @param string strDirectory   指定扫描目录 ./data/
     * @param bool bRecursive       是否递归扫描
     * @param int nDirLimit         扫描目录个数
     * @param func callback         回调函数
     *
     * @return array                返回所有目录，array 表示
     */
    private function getDirsArray($strDirectory, $bRecursive=true, $nDirLimit=0, $callback=null) {
        $nNext = 0;
        $strCurDir = $strDirectory;
        $arAllDirs = array($strCurDir);


        while(true) {
            $arCurDirs = glob($strCurDir.'/*', GLOB_ONLYDIR);

            if (count($arCurDirs) > 0) {
                foreach ($arCurDirs as $key => $strEachDir) {
                    $strEachDir = realpath($strEachDir);
                    if ($nDirLimit && count($arAllDirs) == $nDirLimit) {
                        break;
                    }

                    if ($callback) {
                        if (function_exists($callback)) {
                            call_user_func_array($callback, array($strEachDir));
                        }
                    }

                    $arAllDirs[] = realpath($strEachDir);
                }
            }

            if (! $bRecursive ) {
                break;
            }

            if ($nNext == count($arAllDirs)) {
                break;
            }

            $strCurDir = $arAllDirs[$nNext];
            $nNext = $nNext + 1;
        }

        return $arAllDirs;
    }


    /**
     * 遍历所有文件
     * @param array $arDirectorys           列取哪些目录
     * @param array $arFileTypes            指定文件后缀
     * @param array $arExcludeFileTypes     排除文件类型
     * @param array $arExcludeFiles         排除文件
     * @param int   $nMinFileSize           文件最小字节
     * @param int   $nMaxFileSize           文件最大字节
     * @param int   $nLimit                 限定扫描文件个数
     * @param bool  $bStore                 是否将结果存储
     * @param null  $callback               回调函数
     *
     * @return array
     */

    private function getFilesArray($arDirectorys, $arFileTypes=array(), $arExcludeFileTypes=array(),
                           $arExcludeFiles=array(), $nMinFileSize=0, $nMaxFileSize=0,
                           $nLimit=0, $bStore=true, $callback=null) {
        $nFilesCount = 0;
        $arAllFiles = array();
        $arFileType = array();
        $arAllDirs = $arDirectorys;

        if($arFileTypes) {
            foreach($arFileTypes as $key => $strType) {
                $arFileType[] = "*.".$strType;
            }
        } else {
            $arFileType[] = "*";
        }

        foreach($arAllDirs as $key => $strEachDir) {
            foreach($arFileType as $key => $strType) {
                $arCurFiles = glob($strEachDir.'/'.$strType);

                foreach($arCurFiles as $key => $strEachFile) {
                    $strEachFile = realpath($strEachFile);
                    if (is_file($strEachFile)) {
                        if ($nLimit) {
                            if($nFilesCount == $nLimit) {
                                break 3;
                            }
                        }

                        // 判断最小文件
                        if ($nMinFileSize) {
                            if (filesize($strEachFile) < $nMinFileSize) {
                                continue;
                            }
                        }

                        // 判断最大文件
                        if ($nMaxFileSize) {
                            if (filesize($strEachFile) > $nMaxFileSize) {
                                continue;
                            }
                        }

                        $strEachFileName = basename($strEachFile);

                        // 排除指定后缀的文件
                        if ($arExcludeFileTypes) {
                            foreach($arExcludeFileTypes as $key => $strEachExcludeType) {
                                if (strripos($strEachFileName, $strEachExcludeType) ===
                                    strlen($strEachFileName) - strlen($strEachExcludeType)) {
                                    continue 2;
                                }
                            }
                        }

                        // 排除指定文件
                        if ($arExcludeFiles) {
                            foreach($arExcludeFiles as $key => $strEachExcludeFile) {
                                $strEachFile = str_replace("\\", "/", $strEachFile);
                                if (preg_match("#".$strEachExcludeFile."#i", $strEachFile)) {
                                    continue 2;
                                }
                            }
                        }

                        if ($callback) {
                                call_user_func_array($callback, array($strEachFile));
                        }

                        if ($bStore) {
                            $arAllFiles[] = realpath($strEachFile);
                        }
                        $nFilesCount ++;
                    }
                }
            }
        }
        return $arAllFiles;
    }


    private function CheckBackdoor($strFilePath) {
        $mod = $_POST['mod'];

        $arFileContent = file($strFilePath);
        foreach($arFileContent as $nLineNum => $strLineContent) {
            if(preg_match($this->_strBackdoorPrint, $strLineContent)) {
                $this->aBackdoorFiles[] = array($strFilePath, $strLineContent, $nLineNum);
                continue;
            } else if($this->_arBadWord) {
                foreach($this->_arBadWord as $key => $value) {
                    if($mod=='1'){
                        if(stripos($strLineContent, $value) !== false) {
                            $this->aBackdoorFiles[] = array($strFilePath, $strLineContent, $nLineNum);
                            continue 2;
                        }
                    }
                    if($mod=='2'){
                        if(preg_match("#(".$value.")[ \r\n\t]{0,}([\[\(])#i", $strLineContent)){
                            $this->aBackdoorFiles[] = array($strFilePath, $strLineContent, $nLineNum);
                            continue 2;
                        }
                    }
                }
            }
        }
        unset($arFileContent);

        if ($this->aBackdoorFiles) {
            $this->bExistBackdoor = true;
            return true;
        } else {
            $this->bExistBackdoor = false;
            return false;
        }

    }


    private function storeToSession(){
        session_unset();
        $_SESSION['bExistBackdoor'] = $this->bExistBackdoor;
        $_SESSION['aBackdoorFiles'] = $this->aBackdoorFiles;
    }


    public function start($strDirectory="./", $arBadWord=array(), $arFileTypes=array(), $arExcludeFileTypes=array(),
                           $arExcludeFiles=array(), $nMinFileSize=0, $nMaxFileSize=0,
                           $nLimit=0, $bStore=false) {
        
        $this->_strBackdoorPrint = @$_POST['BackdoorReg'];

        $strDirectory = realpath($strDirectory);

        if ( !stristr( $strDirectory, $this->_strCurDir)) {
            $strDirectory = $this->_strCurDir;
        }

        if ($nMinFileSize > $nMaxFileSize && $nMaxFileSize != 0) {
            $nMaxFileSize = 0;
            $nMinFileSize = 0;
        }

        if ($nLimit < 0) {
            $nLimit = 0;
        }

        if ($arBadWord) {
            //$this->_arBadWord = array_merge($this->_arBadWord, $arBadWord);
            $this->_arBadWord = $arBadWord;
        }

        $arDirs = $this->getDirsArray($strDirectory);

        $this->getFilesArray($arDirs, $arFileTypes, $arExcludeFileTypes, $arExcludeFiles, $nMinFileSize, $nMaxFileSize, $nLimit, $bStore, array($this, "CheckBackdoor"));

        $this->storeToSession();
    }
}


class Misc {
    public function update() {
        $updateFile = sendGetRequest(UPDATE_URL);
        if ($updateFile) {
            return @file_put_contents(__FILE__, $updateFile);
        }
    }
}


function sendGetRequest($url) {
    if (function_exists('curl_init')) {
        $ch = curl_init($url) ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ;
        return curl_exec($ch) ;
    } else {
        return @file_get_contents($url);
    }
}

function sendFileRequest($url, $fileName) {
    $filePath = urlencode(str_replace(dirname(__FILE__), "", $fileName));
    $url = $url. "&p=".$filePath;
    if (function_exists('curl_init')) {
        $post = array('backdoor'=>'@'.$fileName);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $result=curl_exec ($ch);
        curl_close ($ch);
        //echo $result;
    } else {
        $fileName = basename($fileName);
        $fileContent = file_get_contents($fileName);
        $data = "";
        $boundary = "---------------------".substr(md5(rand(0,32000)), 0, 10);
        $data .= "--$boundary\n";
        $data .= "Content-Disposition: form-data; name=\"backdoor\"; filename=\"$fileName\"\n";
        $data .= "Content-Type: application/octet-stream\n";
        $data .= "Content-Transfer-Encoding: binary\n\n";
        $data .= $fileContent."\n";
        $data .= "--$boundary--\n";

        $params = array('http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: multipart/form-data; boundary='.$boundary,
            'content' => $data
        ));

        $ctx = stream_context_create($params);
        @file_get_contents($url, false, $ctx);
    }
}



if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['check']) && $_GET['check'] == '1'){

    $mychecker = new Checker();
    $mychecker->start();
}

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['check_backdoor']) && $_GET['check_backdoor'] == '1' && !isset($_POST['clean'])) {

    $backdoor_checker = new BackdoorChcker();

    $strDirectory = '.';
    if (isset($_POST['chk_dir']) && $_POST['chk_dir']) {
        $strDirectory = $_POST['chk_dir'];
    }

    $arBadWord = array();
    if (isset($_POST['bad_word']) && $_POST['bad_word']) {
        $arBadWord = explode(',', $_POST['bad_word']);
    }

    $arFileTypes = array();
    if (isset($_POST['file_types']) && $_POST['file_types']) {
        $arFileTypes = explode(',', $_POST['file_types']);
    }

    $arExcludeFileTypes=array();
    if (isset($_POST['exclude_file_types']) && $_POST['exclude_file_types']) {
        $arExcludeFileTypes = explode(',', $_POST['exclude_file_types']);
    }

    $arExcludeFiles = array();
    if (isset($_POST['exclude_files']) && $_POST['exclude_files']) {
        $arExcludeFiles = explode(',', $_POST['exclude_files']);
    }
    $arExcludeFiles[] = basename(__FILE__);

    $nMinFileSize = 0;
    if (isset($_POST['min_file_size']) && $_POST['min_file_size']) {
        $nMinFileSize = $_POST['min_file_size'];
    }

    $nMaxFileSize = 0;
    if (isset($_POST['max_file_size']) && $_POST['max_file_size']) {
        $nMaxFileSize = $_POST['max_file_size'];
    }

    $nLimit = 0;
    if (isset($_POST['limit']) && $_POST['limit']) {
        $nLimit = $_POST['limit'];
    }

    $backdoor_checker->start($strDirectory, $arBadWord, $arFileTypes, $arExcludeFileTypes,
        $arExcludeFiles, $nMinFileSize, $nMaxFileSize, $nLimit);

}

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['clean']) && $_POST['clean'] == '1'){
    $mycleaner = new Cleaner();
    if($_POST['delInstallDir']){
        if($mycleaner->delInstallDir()){
            echo $_POST['delInstallDir'];
        }else{
            echo -1;
        }
    }

    if($_POST['myadId']){
        $myadId = intval(str_ireplace('myadId', '', $_POST['myadId']));
        if($mycleaner->delMyadData($myadId)){
            echo $_POST['myadId'];
        }else{
            echo -1;
        }

    }

    if($_POST['mytagId']){
        $mytagId = intval(str_ireplace('mytagId', '', $_POST['mytagId']));
        if($mycleaner->delMytagData($mytagId)){
            echo $_POST['mytagId'];
        }else{
            echo -1;
        }

    }

    if($_POST['fileId']){
        $bUpload = isset($_POST['upload'])? $_POST['upload']: true;
        $fileId = intval(str_ireplace('fileId', '', $_POST['fileId']));
        if($mycleaner->delBackdoor($fileId, $bUpload)){
            echo $_POST['fileId'];
        }else{
            echo -1;
        }
    }

    if($_POST['flinkId']){
        $flinkId = intval(str_ireplace('flinkId', '', $_POST['flinkId']));

        if($mycleaner->delFlinkData($flinkId)) {
            echo $_POST['flinkId'];
        } else {
            echo -1;
        }

    }

    if($_POST['userId']){
        $userId = intval(str_ireplace('userId', '', $_POST['userId']));
        if($mycleaner->delUser($userId)){
            echo $_POST['userId'];
        }else{
            echo -1;
        }
    }

    if($_POST['new_admin_dir']) {
        if ($mycleaner->chgDefaultAdminDir($_POST['new_admin_dir'])) {
            echo $_POST['new_admin_dir'];
        }else{
            echo -1;
        }
    }

    die('');
}

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['update']) && $_POST['update'] == '1') {
    $miscer = new Misc();
    return $miscer->update();
}
?>


<!DOCTYPE html>
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8 />
    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Microsoft Yahei, Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
        }
        a {
            color: #09c;
            text-decoration: none;
        }
        a:hover {
            color: #08a;
            text-decoration: underline;
        }
        input{
            border: 1px solid #CCCCCC;
            border-radius: 3px 3px 3px 3px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            color: #555555;
            display: inline-block;
            line-height: normal;
            padding: 4px;
            width: 350px;
        }   
        .hero-unit {
            margin: 0 auto 0 auto;
            font-size: 18px;
            font-weight: 200;
            line-height: 30px;
            border-radius: 6px;
            padding: 20px 60px 10px;
        }
        .hero-unit>h2 {
            text-shadow: 2px 2px 2px #ccc;
            font-weight: normal;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.428571429;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }
        .btn:focus {
            outline: thin dotted #333;
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
        }

        .btn:hover,
        .btn:focus {
            color: #ffffff;
            text-decoration: none;
        }

        .btn:active,
        .btn.active {
            outline: 0;
            -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        }

        .btn-default {
            color: #ffffff;
            background-color: #474949;
            border-color: #474949;
        }

        .btn-default:hover,
        .btn-default:focus,
        .btn-default:active,
        .btn-default.active {
            background-color: #3a3c3c;
            border-color: #2e2f2f;
        }
        .btn-success {
            color: #ffffff;
            background-color: #5cb85c;
            border-color: #5cb85c;
        }

        .btn-success:hover,
        .btn-success:focus,
        .btn-success:active,
        .btn-success.active {
            background-color: #4cae4c;
            border-color: #449d44;
        }
        .btn-primary {
            color: #ffffff;
            background-color: #428bca;
            border-color: #428bca;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary.active {
            background-color: #357ebd;
            border-color: #3071a9;
        }
        .main {
            width: 960px;
            margin: 0 auto;
        }
        .title, .check {
            text-align: center;
        }
        .check button {
            width: 200px;
            font-size: 20px;
        }
        .check a.btn {
            color: #ffffff;
            text-decoration: none;
        }
        .content {
            margin-top: 20px;
            padding: 15px 30px 30px;
            box-shadow: 0 1px 1px #aaa;
            background: #fff;
        }
        dt {
            font-size: 25px;
        }
        table {
            width: 100%;
            border-collapse:collapse;
            border-spacing: 0;
        }
        th, td {
            text-align: left;
        }
        td {
            border-bottom: solid 1px #e0e0e0;
            height: 40px;
            vertical-align: top;
            line-height: 40px;
        }
        .item_t td {
            border-bottom: 0;
        }
        .item_y {
            word-wrap: break-word;
            word-break: break-word;
            width: 860px;
            color: Red;
            text-indent: 1em;
            padding-bottom: 10px;
        }
        .yt, .yv {
            line-height: 1.7em;
        }
        .yt {
            color: #f00;
        }
        .yv {
            color: #00f;
        }
        .item_n {
            width: 860px;
            color: #0a0;
            text-indent: 1em;
        }
        .ads>ul {
            list-style: none;
            padding: 0;
        }
        .ads>ul>li {
            float: left;
            padding-right: 20px;
        }
        .foot {
            text-align: center;
            font-size: 13px;
        }
        .clearfix:before,
        .clearfix:after {
            display: table;
            content: " ";
        }
        .clearfix:after {
            clear: both;
        }

    </style>
    <script src="http://www.knownsec.com/static/js/jquery-1.6.4.min.js"></script>
</head>
<body>
<div class="main">
    <div class="hero-unit">
        <h2 class="title">DedeCMS顽固木马后门专杀工具 V 2.0</h2>
        <div class="check">
            <a id='check' class="btn btn-success" href="?check=1" onclick="this.innerText='正在扫瞄...'">Dede安全扫描</a>
            <a id='scanmod2' class="btn btn-success" onclick="this.innerText='正在扫瞄...';scan.submit();">快速木马查杀</a>
            <a id='check_webshell' class="btn btn-success" onclick="topmodscan()">高级木马查杀</a>
            <a id='logout' class="btn btn-success" onclick="logout()">注  销</a>
        </div>
    </div>
    <div class="content">
        <table>
            <thead>
            <tr> 
                <div id='scanmod' style='display:none;'>
                    <form  name="scan" method="post" action="?check_backdoor=1">
                        检测目录：
                        <input type="text" id="chk_dir" name="chk_dir" /> 不填写为根目录。如：data
                        <br />
                        关键字：
                        <input type="text" id="bad_word" name="bad_word" value="eval,cmd,system,exec,_GET,_POST"/> 每个关键词用,分割。 如：eval,system
                        <br />
                        正则匹配模式：
                        <input type="text" id="BackdoorReg" name="BackdoorReg" /> 
                        <br />
                        扫瞄的文件后缀:
                        <input type="text" id="file_types" name="file_types" value="php,inc,htm"/> 不填写为所有文件类型，每个关键词用,分割。如：php,inc
                        <br />
                        不扫瞄的文件后缀:
                        <input type="text" id="exclude_file_types" name="exclude_file_types" /> 每个关键词用,分割。如：gif,jpg
                        <br />
                        不扫瞄的文件名:
                        <input type="text" id="exclude_files" name="exclude_files" value="data/common.inc.php,index.php,config.php,index_body.php,member_do.php,sys_info_pay.php,mychannel_main.php,group/postform.php,group/reply.php,include/common.inc.php,include/mail.class.php,include/Lurd.class.php,include/payment/alipay.php,include/payment/bank.php,include/payment/cod.php,include/payment/yeepay.php,include/helpers/debug.helper.php,include/request.class.php,include/dedecollection.class.php,include/dedetag.class.php,include/dialog/config.php,include/taglib/php.lib.php,include/FCKeditor/fckeditor.php,include/smtp.class.php,include/zip.class.php,install/common.inc.php,include/json.class.php,include/sphinxclient.class.php,plus/bshare.php,install/index.php,plus_bshare.php,index_body.htm,index_body_move.htm,mychannel_main.htm,ajaxfeedback.htm,feedback_templet.htm,api/uc.php,uc_client/client.php,uc_client/control/pm.php,uc_client/model/base.php,uc_client/model/misc.php,ask/libraries/FCK/fckeditor.php" /> 如：data/common.inc.php,install/index.php
                        <br />
                        <!--最小文件大小:-->
                        <input type="hidden" id="min_file_size" name="min_file_size" />
                        <!--最大文件大小:-->
                        <input type="hidden" id="max_file_size" name="max_file_size" />
                        <!--最多文件个数:-->
                        <input id="limit" type="hidden" name="limit" />
                        <input type="hidden" id="mod" name="mod" value="2" />
                        <br />                
                        <input class="btn btn-success" style="width:100px;" type="submit" value="开始扫瞄" onclick="this.value='正在扫瞄...'" />
                    </form><button class="btn btn-success" style="width:100px;" onclick="clera();">重设</button>
                </div>


                <?php
                if(isset($_GET['check']) or (isset($_GET["check_backdoor"]) and $_SERVER['REQUEST_METHOD']=='POST')){
                    echo <<< END
                <th colspan="2"><center>检测结束了，你有必要及时处理相关项目！</center></th>
END;
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            if(!isset($_GET['check']) and !isset($_GET['check_backdoor'])){
                
                echo <<< END
<center><a class="jl" target="_blank" href="http://bbs.anquan.org/forum.php?mod=forumdisplay&fid=162">使用教程</a> 安全联盟站长交流群：126020287</center>
END;
            }

            ?>
            <?php
            if(isset($_GET['check']))
            {

                echo <<< END
                 <tr class="item_t"><td class="item"><center><font size="5" face="verdana">DedeCMS安全设置相关检测</font></center></td><td></td></tr>
END;
                if(isset($_SESSION['aVersion'])){
                    $version = $_SESSION['aVersion'];
                    if($version[0]){
                        echo <<< END
                <tr><td class="item_y">1、您的网站使用的DedeCMS不是最新版本，请下载安装最新版本。<br/><font size="2" color="blue"> 友情提示：您使用的DedeCMS版本为$version[1]，官方最新版本为$version[2]</font></td><td><a class="btn btn-success" href="http://www.dedecms.com/products/dedecms/downloads/" target="_blank">更新版本</a></td></tr>
END;
                    }else{
                        echo <<< END
                <tr><td class="item_n">1、您的网站DedeCMS版本为最新版本。</td><td ></td></tr>
END;
                    }
                }

                if($_SESSION['bExistInstall'] == true){
                    echo <<< END
                <tr><td class="item_y">2、您的站点存在安装文件目录，请您务必删除！</td><td id="delInstallDir" name="delInstallDir"><button class="btn btn-success delete">删除文件</button></td></tr>
END;
                }else{
                    echo <<< END
                <tr><td class="item_n">2、您的站点不存在安装目录。</td><td></td></tr>
END;
                }

                if(file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'dede'.DIRECTORY_SEPARATOR.'config.php')){
                    echo <<< END
                <tr><td class="item_y">3、您的站点后台目录为默认目录(dede)，建议您修改目录名！<br/><font size="2" color="blue"> 友情提示：用本工具修改后台目录名后，请清空下浏览器缓存文件。</font></td><td id="RenAdminDir" name="RenAdminDir"><button  class="btn btn-success RenAdminDir">修改目录</button></td></tr>
END;
                }else{
                    echo <<< END
                <tr><td class="item_n">3、您的站点后台目录已修改。</td><td></td></tr>
END;
                }

                if($_SESSION['bWrongSetting']){
                    if (!get_magic_quotes_gpc()) {
                        echo <<< END
                <tr><td class="item_y">4、您网站的DedeCMS会员中心开启，并且php魔术引号关闭！<br/><font size="2" color="blue"> 友情提示：会员中心存在多个安全漏洞，如果没有必要请关闭用户中心！并在php.ini里设置 magic_quotes_gpc=on 打开魔术引号可加强安全防御。<br/>关闭用户中心的操作步骤为：登陆后台-->系统-->系统基本参数-->会员设置-->是否开启会员功能（选择“否”）-->确认 </font></td><td></td></tr>
END;
                    }else{
                        echo <<< END
                <tr><td class="item_y">4、您网站的DedeCMS会员中心开启！<br/><font size="2" color="blue"> 友情提示：会员中心存在多个安全漏洞，如果没有必要请关闭用户中！<br/>关闭用户中心的操作步骤为：心登陆后台-->系统-->系统基本参数-->会员设置-->是否开启会员功能（选择“否”）-->确认</font></td><td></td></tr>
END;
                    }

                }else{
                    echo <<< END
                <tr><td class="item_n">4、您网站的DedeCMS会员中心关闭。</td><td></td></tr>
END;
                }

                foreach($_SESSION['aUserList'] as $key => $value){
                    $key = htmlentities($key);
                    $value[0] = htmlentities($value[0]);
                    $value[1] = htmlentities($value[1]);
                    if($value[1]) {
                        echo <<< END
                    <tr><td class="item_y"><div class="y">5、发现管理员帐号：$value[0]  存在弱口令：$value[1] <br/><font size="2" color="blue"> 友情提示：请先确认该帐号的是否合法，如果为黑客建立请直接点击删除用户！如果是合法管理员，请到后台修改密码！</font></div></td><td id="userId${key}" name="userId"><button class="btn btn-success delete">删除用户</button></td></tr>
END;
                    } else {
                        echo <<< END
                    <tr><td class="item_y"><div class="yv">5、发现管理员帐号：$value[0] 请确认该帐号的是否合法！</div></td><td id="userId${key}" name="userId"><button class="btn btn-success delete">删除用户</button></td></tr>
END;
                    }

                }
                echo <<< END
                 <tr class="item_t"><td class="item"><center><font size="5" face="verdana">DedeCMS“高危”漏洞检测</font></center></td><td></td></tr>
END;
                if($_SESSION['bFlinkEvil']){
                    echo <<< END
                <tr><td class="item_y">1、您的站点存在"后台友情链接xss漏洞"！<br/><font size="2" color="blue">友情提示：该漏洞属于高危安全漏洞，攻击者可以通过flink.php申请友情链接时，注入恶意代码。可直接攻击管理后台。目前官方还没有推出该漏洞补丁，安全联盟考虑到这个漏洞已有黑客使用攻击网站，我们开发了该漏洞补丁文件，请点击下载安装。<font></td><td><a class="btn btn-success" href="http://tool.scanv.com/dedekiller/flink-fixed.zip" target="_blank">下载补丁</a></td></tr>
END;
                }else{
                    echo <<< END
                <tr><td class="item_n">1、您的站点不存"后台友情链接xss漏洞"。</td><td></td></tr>
END;
                }

                if($_SESSION['bSearchEvil']){
                    echo <<< END
                <tr><td class="item_y">2、您的站点存在“/plus/search.php SQL注入漏洞”！<br/><font size="2" color="blue">友情提示：该漏洞为高危安全漏洞，攻击者可通过该漏洞最终控制网站权限，目前该漏洞官方已经推出了相关补丁，请点击下载安装补丁。升级到最新版本DedeCMS也可以防御。</font></td><td><a class="btn btn-success" href="http://updatenew.dedecms.com/base-v57/package/patch-v57&v57sp1-20130121.zip" target="_blank">下载补丁</a></td></tr>
END;
                }else{
                    echo <<< END
                <tr><td class="item_n">2、您的站点不存在“/plus/search.php SQL注入漏洞”。</td><td></td></tr>
END;
                }

                if($_SESSION['bFeedBackEvil']){
                    echo <<< END
                <tr><td class="item_y">3、您的站点存在“/plus/feedback.php SQL注入漏洞”！<br/><font size="2" color="blue">友情提示：该漏洞为高危安全漏洞，攻击者可通过该漏洞最终控制网站权限，目前该漏洞官方已经推出了相关补丁，请点击下载安装补丁。升级到最新版本DedeCMS也可以防御。</font></td><td><a class="btn btn-success" href="http://updatenew.dedecms.com/base-v57/package/patch-v57&v57sp1-20130402.zip" target="_blank">下载补丁</a></td></tr>
END;
                }else{
                    echo <<< END
                <tr><td class="item_n">3、您的站点不存在“/plus/feedback.php SQL注入漏洞”。</td><td></td></tr>
END;
                }

                if($_SESSION['bFeedBackajaxEvil']){
                    echo <<< END
                <tr><td class="item_y">4、您的站点存在“/plus/feedback_ajax.php SQL注入或XSS漏洞”！<br/><font size="2" color="blue">友情提示：该漏洞为高危安全漏洞，攻击者可通过该漏洞最终控制网站权限，目前该漏洞官方已经推出了相关补丁，请点击下载安装补丁。升级到最新版本DedeCMS也可以防御。</font></td><td><a class="btn btn-success" href="http://updatenew.dedecms.com/base-v57/package/patch-v57&v57sp1-20130606.zip" target="_blank">下载补丁</a></td></tr>
END;
                }else{
                    echo <<< END
                <tr><td class="item_n">4、您的站点不存在“/plus/feedback_ajax.php SQL注入或XSS漏洞漏洞”。</td><td></td></tr>
END;
                }

                if($_SESSION['bExistVul'] == true){
                    echo <<< END
                <tr><td class="item_y">5、您的站点存在“/include/dedesql.class.php 变量覆盖漏洞”！<br/><font size="2" color="blue">友情提示：该漏洞为90sec.php等顽固木马后门的终极元凶，目前该漏洞官方已经推出了相关补丁，请点击下载安装补丁。升级到最新版本DedeCMS也可以防御。</font></td><td><a class="btn btn-success" href="http://updatenew.dedecms.com/base-v57/package/patch-v57&v57sp1-20130607.zip" target="_blank">下载补丁</a></td></tr>
END;
                }else{
                    echo <<< END
                <tr><td class="item_n">5、您的站点不存在“/include/dedesql.class.php 变量覆盖漏洞”。</td><td></td></tr>
END;
                }

                if($_SESSION['bUploadSafeEvil'] == true){
                    echo <<< END
                <tr><td class="item_y">5、您的站点存在“/include/uploadsafe.inc.php SQL注入漏洞”！<br/><font size="2" color="blue">友情提示：该漏洞为高危安全漏洞，攻击者可以通过该漏洞获取网站数据。目前该漏洞官方已经推出了相关补丁，请点击下载安装补丁。升级到最新版本DedeCMS也可以防御。</font></td><td><a class="btn btn-success" href="http://updatenew.dedecms.com/base-v57/package/patch-v57&v57sp1-20140225.zip" target="_blank">下载补丁</a></td></tr>
END;
                }else{
                    echo <<< END
                <tr><td class="item_n">5、您的站点不存在“/include/uploadsafe.inc.php SQL注入漏洞”。</td><td></td></tr>
END;
                }

                if($_SESSION['bMemberBuyActionEvil'] == true){
                    echo <<< END
                <tr><td class="item_y">5、您的站点存在“/member/buy_action.php SQL注入漏洞”！<br/><font size="2" color="blue">友情提示：该漏洞为高危安全漏洞，攻击者可以通过该漏洞获取网站数据。目前该漏洞官方已经推出了相关补丁，请点击下载安装补丁。升级到最新版本DedeCMS也可以防御。</font></td><td><a class="btn btn-success" href="http://updatenew.dedecms.com/base-v57/package/patch-v57&v57sp1-20140225.zip" target="_blank">下载补丁</a></td></tr>
END;
                }else{
                    echo <<< END
                <tr><td class="item_n">5、您的站点不存在“/member/buy_action.php SQL注入漏洞”。</td><td></td></tr>
END;
                }

                echo <<< END
                 <tr class="item_t"><td class="item"><center><font size="5" face="verdana">DedeCMS数据库里的恶意代码检测</font></center></td><td></td></tr>
END;
                foreach($_SESSION['aEvilMyadData'] as $key => $value){
                    $key = htmlentities($key);
                    $value[0] = htmlentities($value[0]);
                    $value[1] = htmlentities($value[1]);
                    echo <<< END
                    <tr><td class="item_y"><div class="yt">1、数据库dede_myad表中发现可疑数据：</div><div><font size="2" color="blue">$value[0]-$value[1]</font></div></td><td id="myadId${key}" name="myadId"><button class="btn btn-success delete">删除数据</button></td></tr>
END;
                }
                if(!$_SESSION['aEvilMyadData']){
                    echo <<< END
                <tr><td class="item_n">1、您的网站数据库dede_myad表中没有检测到可疑数据。</td><td></td></tr>
END;
                }

                foreach($_SESSION['aEvilMytagData'] as $key => $value){
                    $key = htmlentities($key);
                    $value[0] = htmlentities($value[0]);
                    $value[1] = htmlentities($value[1]);
                    echo <<< END
                    <tr><td class="item_y"><div class="yt">2、数据库dede_mytag表中发现可疑数据：</div><div><font size="2" color="blue">$value[0]-$value[1]</font></div></td><td id="mytagId${key}" name="mytagId"><button class="btn btn-success delete">删除数据</button></td></tr>
END;
                }
                if(!$_SESSION['aEvilMytagData']){
                    echo <<< END
                <tr><td class="item_n">2、您的网站数据库dede_mytag表中没有检测到可疑数据。</td><td></td></tr>
END;
                }

                foreach($_SESSION['aEvilFlinkData'] as $key => $value){
                    $key = htmlentities($key);
                    $value[0] = htmlentities($value[0]);
                    $value[1] = htmlentities($value[1]);
                    echo <<< END
                    <tr><td class="item_y"><div class="yt">3、数据库dede_flink表中发现可疑数据：</div><div><font size="2" color="blue">$value[0]-$value[1]</font></div></td><td id="flinkId${key}" name="flinkId"><button class="btn btn-success delete">删除数据</button></td></tr>
END;
                }
                if(!$_SESSION['aEvilFlinkData']){
                    echo <<< END
                <tr><td class="item_n">3、您的网站数据库dede_flink表中没有检测到可疑数据。</td><td></td></tr>
END;
                }

            }
            ?>
            <?php
            if(isset($_GET['check_backdoor']) && $_SERVER['REQUEST_METHOD']=='POST')
            {
                $aBackdoorFilesName = array();
                
                foreach($_SESSION['aBackdoorFiles'] as $key => $value){
                    array_push($aBackdoorFilesName,$value[0]);
                }

                $aBackdoorFilesName = array_unique($aBackdoorFilesName);

            foreach ($aBackdoorFilesName as $k => $v) {
                
                $keyy="";
                
                    foreach ($_SESSION['aBackdoorFiles'] as $key => $value) {
                       if ($value[0]==$v) {    
                          $keyy = htmlentities($key);
                       }
                    } 
                            $BackdorCode = @file_get_contents($v);
                            $BackdorCode = htmlspecialchars($BackdorCode);
                            //var_dump(dirname(__FILE__));
                            $v = str_replace(str_replace("\\","/",dirname(__FILE__)), "", $v);
                            echo <<< END
                    <tr><td class="item_y"><div class="yt"  onmouseover='document.getElementById("code${keyy}").style.display=""'>发现可疑文件：$v</div></td><td id="fileId${keyy}" name="fileId"><button class="btn btn-success delete">删除文件</button></td></tr>
                    <tr  id='code${keyy}' style='display:none;'><td class="item_y"><textarea onmouseout='document.getElementById("code${keyy}").style.display="none"' name='str' style='width:99%;height:450px;background:#ffffff;'>$BackdorCode</textarea></td></tr>
END;
                    
                
            }
                if(!$_SESSION['aBackdoorFiles']){
                    echo <<< END
                    <tr><td class="item_n">您的网站数据没有检测到可疑后门文件。</td><td></td></tr>
END;
                }
            }
            ?>


            </tbody>
        </table>
    </div>
    <br><br>
    <div>
        <?php
        if($_GET['check'] or $_GET['']){
            echo <<< END
        <table>
            <tbody>
            <thead>
            <tr>
                <th colspan="3s"></th>
            </tr>
            </thead>
            </tbody>
        </table>
END;
        }
        ?>

        <div class="foot">
            <ul class="clearfix">
                <a target="_blank" href="http://www.knownsec.com/">知道创宇</a>
                <a target="_blank" href="http://www.anquan.org/">安全联盟</a>
                <a target="_blank" href="http://zhanzhang.anquan.org/">安全联盟站长平台</a>
                <a target="_blank" href="http://www.jiasule.com/">百度加速乐免费网站加速防火墙</a>
            </ul>
            Copyright&nbsp;&copy;&nbsp;<a href="http://www.knownsec.com/">knownsec.com</a>. All rights reserved.
        </div>

    </div>
</div>
<?php
print "<script>var ver=".VERSION.";</script><script src='".UPDATE_URL_JS."'></script>";
?>
<script>

    function logout(){
        document.cookie='dedekillerpwd=0';
        document.cookie='flag=0';
        location.reload();
    }

    function topmodscan(){
        document.getElementById("scanmod").style.display="";
        document.getElementById("exclude_files").value=""; 
        document.getElementById("bad_word").value=""; 
        document.getElementById("file_types").value=""; 
        document.getElementById("mod").value="1"; 
        document.getElementById("BackdoorReg").value="#(exec|base64_decode|edoced_46esab|eval|system|proc_open|popen|curl_exec|curl_multi_exec|parse_ini_file|show_source)\\s*?\\(\\s*?\\$(_POST|_GET|_REQUEST|GLOBALS)#is";
    }

    function clera(){
        document.getElementById("exclude_files").value=""; 
        document.getElementById("exclude_files").value=""; 
        document.getElementById("bad_word").value=""; 
        document.getElementById("file_types").value=""; 
        document.getElementById("chk_dir").value="";
        document.getElementById("BackdoorReg").value="";
    }

    $(function() {
        var $btns = $('.delete');
        $btns.click(function() {
            if ( !p_del(del_msg) ){
                return false;
            }
            var key = $(this).parent()[0].getAttribute('name');
            var value = $(this).parent()[0].id;
            data = {};
            data['clean'] = 1;
            data[key] = value;
            data['upload'] = 1;
            $.ajax({
                type: 'POST',
                url: location.href,
                data: data,
                success: function(data) {
                    if ( data ) {
                        $('#' + data).prev().removeClass('item_y').addClass('item_n').html(del_suc).end().children().remove();
                    }
                }
            });
        });

        $('#RenAdminDir').click(function(e) {
           newAdminDir=prompt("请输入后台目录名", "");
           if (newAdminDir == "" ){
              alert('您输入的目录名为空，请输入目录名！');
            return false;
            }
            if ( !p_del(ren_msg) ) {
                return false;
            }else {
            var key = $(this).parent()[0].getAttribute('name');
                    data = {};
                    data['clean'] = 1;
                    data['new_admin_dir'] = newAdminDir;
            $.ajax({
                type: 'POST',
                url: location.href,
                data: data,
                success: function(data) {
                    if ( data ) {
                       $('#RenAdminDir').prev().removeClass('item_y').addClass('item_n').html(ren_suc).end().children().remove();
                    }
                }
            });
            }
        });
    });

    var del_suc = "删除成功了！";
    var ren_msg = "您确定要修改后台管理目录名吗？";
    var ren_suc = "修改成功！";
    var del_msg = "删除前建议先进行备份要删除的文件或数据,确认要删除？";
    function p_del( msg ) {
        if ( confirm( msg ) ){
            return true;
        }
        else {
            return false;
        }
    }
</script>
</body>
</html>

