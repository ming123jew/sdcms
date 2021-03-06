#!/bin/sh
#获取是centos6.5还是centos7
centos_version=`rpm -q centos-release|cut -d- -f3`
#shd端口
sshd_port=62222
#防火墙开放端口
open_ports=(80 ${sshd_port})
open_ports_proto=("tcp" "tcp")

#系统加固操作
mkdir -p /home/system/backup/

chattr -i /etc/passwd
chattr -i /etc/inittab
chattr -i /etc/group
chattr -i /etc/shadow
chattr -i /etc/gshadow

#sshd设置
mkdir -p /home/system/backup/etc/ssh/
if [ -f "/home/system/backup/etc/ssh/sshd_config" ] ; then
	#存在不操作
	echo "found"
else
	cp -a /etc/ssh/sshd_config /home/system/backup/etc/ssh/sshd_config
	sed -i "s/#Port 22/Port ${sshd_port}/g" `grep '#Port 22' -rl /etc/ssh/sshd_config`
	if [ $centos_version==7 ] ; then
		systemctl restart sshd.service
	else
		service sshd restart
	fi
fi

#防火墙设置
mkdir -p /home/system/backup/etc/init.d/
if [ $centos_version==7 ] ; then
	systemctl stop firewalld
	systemctl mask firewalld
	yum install -y iptables-services
	systemctl enable iptables
	systemctl restart iptables
else
	cp -a /etc/init.d/iptables /home/system/backup/etc/init.d/iptables
fi
iptables -F
iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
#按索引
for((i=0;i<${#open_ports[*]};i++))
do
	iptables -A INPUT -p ${open_ports_proto[$i]} --dport ${open_ports[$i]} -j ACCEPT
	#echo ${open_ports[$i]}+${open_ports_proto[$i]}
done
#iptables -A INPUT -p tcp --dport 80 -j ACCEPT
#iptables -A INPUT -p tcp --dport ${sshd_port} -j ACCEPT
iptables -A INPUT -j REJECT
iptables -A FORWARD -j REJECT
iptables -A OUTPUT -j ACCEPT
if [ $centos_version==7 ] ; then
	service iptables save
else
	/etc/init.d/iptables save
fi

#禁止不用用户【注意不要禁止sshd root www mysql】
if [ -f "/home/system/backup/etc/passwd" ] ; then
	#存在不操作
	echo "found"
else
	mkdir -p /home/system/backup/etc/
	cp -a /etc/passwd /home/system/backup/etc/passwd
	#在每行的头添加字符#，命令如下：
	sed -i 's/^/#&/g' /etc/passwd
	#给root删除#
	sed -i "s/#root/root/g" `grep '#root' -rl /etc/passwd`
	#给sshd删除#
	sed -i "s/#sshd/sshd/g" `grep '#sshd' -rl /etc/passwd`
	#给www删除#
	sed -i "s/#www/www/g" `grep '#www' -rl /etc/passwd`
	#给mysql删除#
	sed -i "s/#mysql/mysql/g" `grep '#mysql' -rl /etc/passwd`
	if [ $centos_version==7 ] ; then
		#yum install policycoreutils-python
		#semanage port -a -t ssh_port_t -p tcp ${sshd_port}
		echo "ok"
	fi
fi


#关闭重启ctl-alt-delete组合键
if [ $centos_version==7 ] ; then
	if [ -f "/home/system/backup/usr/lib/systemd/system/ctrl-alt-del.target" ] ; then
		#存在不操作
		echo "found"
	else
		ln -s /usr/lib/systemd/system/reboot.target /usr/lib/systemd/system/ctrl-alt-del.target
		#centos7
		mkdir -p /home/system/backup/usr/lib/systemd/system/
		cp -a /usr/lib/systemd/system/ctrl-alt-del.target /home/system/backup/usr/lib/systemd/system/ctrl-alt-del.target
		rm -fr /usr/lib/systemd/system/ctrl-alt-del.target
		init q
	fi
else
	#centos6
	if [ -f "/home/system/backup/etc/init/control-alt-delete.conf" ] ; then
		#存在不操作
		echo "found"
	else
		mkdir -p /home/system/backup/etc/init
		cp -a /etc/init/control-alt-delete.conf /home/system/backup/etc/init/control-alt-delete.conf
		sed -i 's/exec \/sbin\/shutdown/#exec \/sbin\/shutdown/g' `grep 'exec \/sbin\/shutdown' -rl /etc/init/control-alt-delete.conf`
	fi
fi

#chattr给文件增加不可更改属性
chattr +i /etc/passwd
chattr +i /etc/inittab
chattr +i /etc/group
chattr +i /etc/shadow
chattr +i /etc/gshadow

#安装htop
#mkdir -p /home/tool/htop
#yum install  --installroot=/home/tool/htop -y htop
#安装git
#还原操作

#ulimit设置
if grep -q "* soft nofile 262140" /etc/security/limits.conf
then
    echo "found"
else
	echo "* soft nofile 262140" >> /etc/security/limits.conf 
fi

if grep -q "* hard nofile 262140" /etc/security/limits.conf
then
    echo "found"
else
	echo "* hard nofile 262140" >> /etc/security/limits.conf 
fi

if grep -q "root soft nofile 262140" /etc/security/limits.conf
then
    echo "found"
else
	echo "root soft nofile 262140" >> /etc/security/limits.conf 
fi

if grep -q "root hard nofile 262140" /etc/security/limits.conf
then
    echo "found"
else
	echo "root hard nofile 262140" >> /etc/security/limits.conf 
fi

if grep -q "* soft core unlimited" /etc/security/limits.conf
then
    echo "found"
else
	echo "* soft core unlimited" >> /etc/security/limits.conf 
fi

if grep -q "* hard core unlimited" /etc/security/limits.conf
then
    echo "found"
else
	echo "* hard core unlimited" >> /etc/security/limits.conf 
fi

if grep -q "root soft core unlimited" /etc/security/limits.conf
then
    echo "found"
else
	echo "root soft core unlimited" >> /etc/security/limits.conf 
fi

if grep -q "root hard core unlimited" /etc/security/limits.conf
then
    echo "found"
else
	echo "root hard core unlimited" >> /etc/security/limits.conf 
fi



