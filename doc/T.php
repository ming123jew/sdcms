<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 10:15
 */
//for($i=0;$i<=3;$i++){
//    echo str_repeat(" ",3-$i);
//    echo str_repeat("*",$i*2+1);
//    echo "\n";
//}

$arr = [
    'result'=>[
        'id'=>1,
        'name'=>'ming'
    ],
    'ext'=>[]
];
$arr = json_decode(json_encode($arr));

$arr['result'][1]['manage'] = 'fuck';

print_r($arr);


$a = 'hello';
$b = &$a;
//unset($b);
$b = 'world';
echo $a;
exit;



//二分法/折半查找
//二分查找的基本思想是将n个元素分成大致相等的两部分，取a[n/2]与x做比较，如果x=a[n/2],则找到x,算法中止；如果x<a[n/2],则只要在数组a的左半部分继续搜索x,如果x>a[n/2],则只要在数组a的右半部搜索x.
//时间复杂度无非就是while循环的次数！
//总共有n个元素，
//渐渐跟下去就是n,n/2,n/4,....n/2^k（接下来操作元素的剩余个数），其中k就是循环的次数
//由于你n/2^k取整后>=1
//即令n/2^k=1
//可得k=log2n,（是以2为底，n的对数）
//所以时间复杂度可以表示O(h)=O(log2n)
function bin_search($s,$a){
    $low = 0;
    $height = count($a)-1;
    while($low<=$height){
        //取中间
        $mid = intval(($low+$height)/2);
        if($a[$mid]>$s){
            //比较，如果中间元素比S大，则height-1
            $height = $mid -1;
        }else if($a[$mid]<$s){
            //比较，如果中间元素比S小，则low+1
            $low = $mid + 1;
        }else{
            return $mid;
        }
    }
    return -1;
}
//折半查找要求线性表必须采用顺序存储结构，而且表中元素按关键字有序排列。
$start_time = microtime(true);
$array = [1,5,3,6,6,8,9,10];
var_dump(bin_search(10,$array));
echo "\nused:".round(microtime(true)-$start_time,3)." {".memory_get_usage()."}\n";


//顺序查找  缺点是效率低下
//顺序查找是在一个已知无(或有序）序队列中找出与给定关键字相同的数的具体位置。原理是让关键字与队列中的数从最后一个开始逐个比较，直到找出与给定关键字相同的数为止，它的缺点是效率低下。
function seq_search($arr,$k){
    $n = count($arr);
    for ($i=0;$i<$n;$i++){
        if($arr[$i]==$k){
            break;
        }
    }
    if($i<$n){
        return $i;
    }else{
        return -1;
    }

}
$array = [1,5,9,3,6,6,8,10];
$start_time = microtime(true);
var_dump(seq_search($array,10));
echo "\nused:".round(microtime(true)-$start_time,3)."{".memory_get_usage()."}\n";

//冒泡
//冒泡排序算法的原理如下：
//比较相邻的元素。如果第一个比第二个大，就交换他们两个。
//对每一对相邻元素做同样的工作，从开始第一对到结尾的最后一对。在这一点，最后的元素应该会是最大的数。
//针对所有的元素重复以上的步骤，除了最后一个。
//持续每次对越来越少的元素重复上面的步骤，直到没有任何一对数字需要比较
function bubble_search($arr){
    $c = count($arr);
    for ($i=0;$i<$c;$i++){
        for ($j=0;$j<$c-$i-1;$j++){
            if($arr[$j]>$arr[$j+1]){
                $p = $arr[$j];//交换
                $arr[$j] = $arr[$j+1];
                $arr[$j+1] = $p;
            }
        }
    }
    return $arr;
}
$array = [1,5,9,3,6,6,8,10];
$start_time = microtime(true);
print_r(bubble_search($array));
echo "\nused:".round(microtime(true)-$start_time,3)."{".memory_get_usage()."}\n";



function check_string($str){
    if(!get_magic_quotes_gpc()){
        $str = addslashes($str);
    }

    $str = htmlspecialchars($str);
    return $str;
}


exit(0);

//

class T
{
    static function test(){
        echo __FILE__;
    }

}
//$i = 0;
//while ($i<100){
//    $fp = fopen("F:\\2017_web_sys\\123.207.0.104_sd_2017\\doc\\lock.txt", "w+");
//    if(flock($fp,LOCK_EX | LOCK_NB)) {
//        //..处理订单
//        //echo "ok";
//        //b在进行更改库存的时候 进行判断，如存在空库存则回滚
//        echo "ok";
//        flock($fp,LOCK_UN);
//        fclose($fp);
//    } else {
//        echo "no";
//    }
//    $i++;
//}
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


$mutex = new SyncMutex("UniqueName");
$res = $mutex->lock(2000);
//sleep(5);
if (!$res){
    echo "\nprocess  unable to lock mutex. \n";
}else{
    echo "\nprocess  successfully got the mutex \n";
    $mutex->unlock();
}



