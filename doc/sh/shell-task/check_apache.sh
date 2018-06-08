#!/bin/sh
#AAAA=`curl -o /dev/null -s -w %{http_code} "http://www.topnews9.com/test.php"`
AAAAA=`curl -o /dev/null -s -w %{http_code} "http://127.0.0.1:88"`
if [[ $AAAAA -eq 200 || $AAAAA -eq 403 ]]
then  echo "test is ok"
else
    #echo "test is killed"
    cd /home/work/httpd-2.4.25/bin/ && ./apachectl restart
fi

