<?php

class HttpClient{

    private $callback = null;

    public function __construct($url, $method = 'GET', $postfields = NULL, $headers = array()){

        //子进程发起请求
        $process = new swoole_process(function(swoole_process $worker) use($url, $method, $postfields, $headers){
            $response = $this->http($url, $method, $postfields, $headers);
            $worker->write($response);
        }, true);
        $process->start();

        //异步读取
        swoole_event_add($process->pipe, function($pipe) use ($process){
            $response = $process->read();
            // print_r($response);
            if(is_callable($this->callback)){
                call_user_func($this->callback, $response); //回调
            }
            swoole_event_del($pipe);
        });
    }

    public function setCallback($callback){
        $this->callback = $callback;
    }

    /**
     * http请求
     */
    private function http($url, $method, $postfields = NULL, $headers = array()) {
        try{
            $ssl = stripos($url,'https://') === 0 ? true : false;
            $ci = curl_init();
            /* Curl settings */
            curl_setopt($ci, CURLOPT_USERAGENT, @$_SERVER['HTTP_USER_AGENT']); //在HTTP请求中包含一个"User-Agent: "头的字符串。
            curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ci, CURLOPT_TIMEOUT, 30);
            curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ci, CURLOPT_ENCODING, "");
            if ($ssl) {
                curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
                curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
            }
            curl_setopt($ci, CURLOPT_HEADER, FALSE);

            switch ($method) {
                case 'POST':
                    curl_setopt($ci, CURLOPT_POST, TRUE);
                    if (!empty($postfields)) {
                        curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                    }
                    break;
            }

            curl_setopt($ci, CURLOPT_URL, $url );
            curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
            curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );

            $response = curl_exec($ci);
            $httpCode = curl_getinfo($ci, CURLINFO_HTTP_CODE);
            $httpInfo = curl_getinfo($ci);

            if (FALSE === $response)
                throw new Exception(curl_error($ci), curl_errno($ci));

        } catch(Exception $e) {
            throw $e;
        }

        //echo '<pre>';
        //var_dump($response);
        //var_dump($httpInfo);

        curl_close ($ci);
        return $response;
    }
}

$client = new HttpClient('http://www.52fhy.com/test.json');
$client->setCallback(function($response){
    print_r($response);
});
echo "OK\n";