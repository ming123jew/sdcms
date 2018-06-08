#!/bin/sh
#获取是centos6.5还是centos7
centos_version=`rpm -q centos-release|cut -d- -f3`
#shd端口
sshd_port=62222
#防火墙开放端口
open_ports=(80 ${sshd_port})
open_ports_proto=("tcp" "tcp")

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
iptables -A INPUT -s "127.0.0.1" -p tcp --dport 88 -j ACCEPT
#iptables -A INPUT -p tcp --dport ${sshd_port} -j ACCEPT
iptables -A INPUT -j REJECT
iptables -A FORWARD -j REJECT
iptables -A OUTPUT -j ACCEPT
if [ $centos_version==7 ] ; then
	service iptables save
else
	/etc/init.d/iptables save
fi
