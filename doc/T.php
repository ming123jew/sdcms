<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 10:15
 */

class T
{
    static function test(){
        echo __FILE__;
    }

}
$i = 0;
while ($i<100){
    $fp = fopen("F:\\2017_web_sys\\123.207.0.104_sd_2017\\doc\\lock.txt", "w+");
    if(flock($fp,LOCK_EX | LOCK_NB)) {
        //..处理订单
        //echo "ok";
        //b在进行更改库存的时候 进行判断，如存在空库存则回滚
        echo "ok";
        flock($fp,LOCK_UN);
        fclose($fp);
    } else {
        echo "no";
    }
    $i++;

}
//
//$pid_file = "F:\\2017_web_sys\\123.207.0.104_sd_2017\\doc\\lock.txt";
//$pid ="d";
//$fp = fopen($pid_file, 'w+');
//if(flock($fp, LOCK_EX | LOCK_NB)){
//    echo "got the lock \n";
//ftruncate($fp, 0); // truncate file
//fwrite($fp, $pid);
//fflush($fp); // flush output before releasing the lock
//sleep(10); // long running process
//flock($fp, LOCK_UN);// 释放锁定
//} else {
//    echo "Cannot get pid lock. The process is already up \n";
//}
//fclose($fp);


$mutex = new SyncMutex("UniqueName");
//
//for($i=0; $i<2; $i++){
//    $pid = pcntl_fork();
//if($pid <0){
//die("fork failed");
//}elseif ($pid>0){
//    echo "parent process \n";
//}else{
//        echo "child process {$i} is born. \n";
//obtainLock($mutex, $i);
//}
//}
//
//while (pcntl_waitpid(0, $status) != -1) {
//    $status = pcntl_wexitstatus($status);
//echo "Child $status completed\n";
//}
//
//function obtainLock ($mutex, $i){
//    echo "process {$i} is getting the mutex \n";
//$res = $mutex->lock(200);
//sleep(1);
//if (!$res){
//echo "process {$i} unable to lock mutex. \n";
//}else{
//        echo "process {$i} successfully got the mutex \n";
//$mutex->unlock();
//}
//exit();
//}

//$mutex = new SyncMutex("UniqueName");
//$res = $mutex->lock(2000);
//sleep(5);
//if (!$res){
//    echo "\nprocess  unable to lock mutex. \n";
//}else{
//    echo "\nprocess  successfully got the mutex \n";
//    $mutex->unlock();
//}


use app\Controllers\Spider\AnalyseUrl;
try{
//    $ref = new \ReflectionClass('b');
//    if($ref->isSubclassOf(a::class)){
//        $ins = $ref->newInstance();
//        print_r($ins);
//        //$ins->handler('aa');
//        $ins->aa();
//        echo "work-over."."\n";
//
//    }else{
//        print_r("\nnot found callbackclass.");
//
//    }
    Ioc::make('AnalyseUrl','aa');
}catch (\Exception $e){
    echo $e->getMessage();
}
/**
 *
 * 工具类，使用该类来实现自动依赖注入。
 *
 */
class Ioc {

    // 获得类的对象实例
    public static function getInstance($className) {

        $paramArr = self::getMethodParams($className);

        return (new ReflectionClass($className))->newInstanceArgs($paramArr);
    }

    /**
     * 执行类的方法
     * @param  [type] $className  [类名]
     * @param  [type] $methodName [方法名称]
     * @param  [type] $params     [额外的参数]
     * @return [type]             [description]
     */
    public static function make($className, $methodName, $params = []) {

        // 获取类的实例
        $instance = self::getInstance($className);

        // 获取该方法所需要依赖注入的参数
        $paramArr = self::getMethodParams($className, $methodName);

        return $instance->{$methodName}(array_merge($paramArr, $params));
    }

    /**
     * 获得类的方法参数，只获得有类型的参数
     * @param  [type] $className   [description]
     * @param  [type] $methodsName [description]
     * @return [type]              [description]
     */
    protected static function getMethodParams($className, $methodsName = '__construct') {

        // 通过反射获得该类
        $class = new ReflectionClass($className);
        $paramArr = []; // 记录参数，和参数类型

        // 判断该类是否有构造函数
        if ($class->hasMethod($methodsName)) {
            // 获得构造函数
            $construct = $class->getMethod($methodsName);

            // 判断构造函数是否有参数
            $params = $construct->getParameters();

            if (count($params) > 0) {

                // 判断参数类型
                foreach ($params as $key => $param) {

                    if ($paramClass = $param->getClass()) {

                        // 获得参数类型名称
                        $paramClassName = $paramClass->getName();

                        // 获得参数类型
                        $args = self::getMethodParams($paramClassName);
                        $paramArr[] = (new ReflectionClass($paramClass->getName()))->newInstanceArgs($args);
                    }
                }
            }
        }

        return $paramArr;
    }
}

class a{

}
class b extends a{
    public function aa(){
        echo "aa";
    }
}