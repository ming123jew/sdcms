#!/bin/sh
#AAAA=`curl -o /dev/null -s -w %{http_code} "http://www.topnews9.com/test.php"`
AAAAA=`curl -o /dev/null -s -w %{http_code} "http://127.0.0.1"`
if [[ $AAAAA -eq 200 || $AAAAA -eq 403 ]]
then  
    echo "test is ok"
else
    #Linux判断进程是否存在并启动该进程
    PIDS=`ps -ef |grep nginx |grep -v grep | awk '{print $2}'`
    if [ ! -n "$PIDS" ];then
        #存在则先杀掉
    	pkill nginx
    fi
    #echo "test is killed"
    cd /home/work/tengine-2.1.0/sbin/ && ./nginx
fi

