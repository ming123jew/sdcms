#if [ -f "/home/system/backup/etc/ssh/sshd_config" ] ; then
#echo 'aaa';
#fi

#AA=`find /etc/security/limits.conf | xargs grep -ri "* soft nofile"`
#echo $AA


#if grep -q "* soft nofile" /etc/security/limits.conf
#then
#    echo "found"
#else
#    echo "not found"
#fi

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
		yum install policycoreutils-python
		semanage port -a -t ssh_port_t -p tcp ${sshd_port}
	fi
fi
