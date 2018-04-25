<?php

namespace app\Controllers\Spider;
use app\Helpers\Simplehtmldom\SimpleHtmlDom;
use PhpAmqpLib\Message\AMQPMessage;
use Server\Asyn\HttpClient\HttpClientPool;
use Server\CoreBase\ChildProxy;

/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 17-09-14
 * Time: am09:51
 */
class Base extends \app\Controllers\BaseController
{
    protected $SimpleHtmlDom;
    protected $AMQPClent;
    protected $AMQPMessage;
    protected $AMQPMessage_exchange = 'amqp-spider-cache';
    protected $WeixinSougouHttpClient;

    protected $agent = [
        "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; AcooBrowser; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
        "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Acoo Browser; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.0.04506)",
        "Mozilla/4.0 (compatible; MSIE 7.0; AOL 9.5; AOLBuild 4337.35; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
        "Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)",
        "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)",
        "Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 1.0.3705; .NET CLR 1.1.4322)",
        "Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727; InfoPath.2; .NET CLR 3.0.04506.30)",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN) AppleWebKit/523.15 (KHTML, like Gecko, Safari/419.3) Arora/0.3 (Change: 287 c9dfb30)",
        "Mozilla/5.0 (X11; U; Linux; en-US) AppleWebKit/527+ (KHTML, like Gecko, Safari/419.3) Arora/0.6",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2pre) Gecko/20070215 K-Ninja/2.1.1",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9) Gecko/20080705 Firefox/3.0 Kapiko/3.0",
        "Mozilla/5.0 (X11; Linux i686; U;) Gecko/20070322 Kazehakase/0.4.5",
        "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.8) Gecko Fedora/1.9.0.8-1.fc10 Kazehakase/0.5.6",
        "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) AppleWebKit/535.20 (KHTML, like Gecko) Chrome/19.0.1036.7 Safari/535.20",
        "Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; fr) Presto/2.9.168 Version/11.52",
    ];

    //构造随机ip
    protected $ip_long = [
        ['607649792', '608174079'], //36.56.0.0-36.63.255.255
        ['1038614528', '1039007743'], //61.232.0.0-61.237.255.255
        ['1783627776', '1784676351'], //106.80.0.0-106.95.255.255
        ['2035023872', '2035154943'], //121.76.0.0-121.77.255.255
        ['2078801920', '2079064063'], //123.232.0.0-123.235.255.255
        ['-1950089216', '-1948778497'], //139.196.0.0-139.215.255.255
        ['-1425539072', '-1425014785'], //171.8.0.0-171.15.255.255
        ['-1236271104', '-1235419137'], //182.80.0.0-182.92.255.255
        ['-770113536', '-768606209'], //210.25.0.0-210.47.255.255
        ['-569376768', '-564133889'], //222.16.0.0-222.95.255.255
    ];
    protected $host = '';
    protected $header = '';
    protected $referer = '';
    protected $antiLeech = '';

    public function __construct(string $proxy = ChildProxy::class)
    {
        parent::__construct($proxy);
        get_instance()->addAsynPool('WeixinSougouHttpClient',new HttpClientPool($this->config,'http://weixin.sogou.com/'));
        $this->WeixinSougouHttpClient =  get_instance()->getAsynPool('WeixinSougouHttpClient');
        $this->SimpleHtmlDom =new SimpleHtmlDom();
        $this->AMQPMessage =  new AMQPMessage('', ['content_type' => 'text/plain', 'delivery_mode' => 2]);
        $this->AMQPClent =  get_instance()->getAsynPool('AMQP');

    }
    public function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name); // TODO: Change the autogenerated stub
    }

    /**
     * 特殊字符转换
     * @author bignerd
     * @since  2016-08-16T17:30:52+0800
     * @param  $string
     * @return $string
     */
    protected function _htmlTransform($string)
    {
        $string = str_replace('&quot;','"',$string);
        $string = str_replace('&amp;','&',$string);
        $string = str_replace('amp;','',$string);
        $string = str_replace('&lt;','<',$string);
        $string = str_replace('&gt;','>',$string);
        $string = str_replace('&nbsp;',' ',$string);
        $string = str_replace("\\", '',$string);
        return $string;
    }

    protected function _ip(){
        $rand_key = mt_rand(0, 9);
        return long2ip(mt_rand($this->ip_long[$rand_key][0], $this->ip_long[$rand_key][1]));
    }

    protected function _agent(){
        return $this->agent[rand(0, count($this->agent) - 1)];
    }

}