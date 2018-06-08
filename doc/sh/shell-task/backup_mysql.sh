#!/bin/bash
#功能说明：本功能用于备份数据库
#编写日期：2016/08/03

DATE=`date +%y%m%d`
COPY_DB=evdays160326

#关闭数据库
service mysqld stop
#拷贝数据库
cp -r /home/work/mysql-5.7.17/data/$COPY_DB /home/backup/mysql/$COPY_DB
#打开数据库
service mysqld start
#压缩文件
zip -rj /home/backup/mysql/$DATE /home/backup/mysql/$COPY_DB
#删除拷贝的文件
rm -rf /home/backup/mysql/$COPY_DB


#处理7天内的备份文件
find /home/backup/mysql/ -name "18*" -type f -mtime +7 -delete

