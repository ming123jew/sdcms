#!/bin/sh
    PIDS=`ps -ef |grep mysqld |grep -v grep | awk '{print $2}'`
    if [ "$PIDS"!="" ];then
    	#pkill mysqld
	#service mysqld restart      
        echo "mysqld is running."  
    else
        service mysqld restart
    fi

