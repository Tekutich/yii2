# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
    config.vm.box = "bento/centos-7"

    config.vm.provider :virtualbox do |virtualbox, override|
      virtualbox.memory = 4096
      virtualbox.cpus = 2
      virtualbox.name = "php-yii"
      virtualbox.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/vagrant", "1"]
    end

    #config.vbguest.auto_update = false

    # Если нет Guest Additions:
    # vagrant vbguest --do install

    # При ошибке:
    # Дать команду vagrant ssh
    # Внутри ВМ:
    # > sudo yum update -y
    # > sudo yum install -y kernel-devel
    # > sudo ls /usr/src/kernels/`uname -r`
    # Дать команду vagrant reload

    config.vagrant.plugins = ["vagrant-vbguest"]

    config.vm.network "forwarded_port", guest: 8080, host: 8080
    config.vm.network "forwarded_port", guest: 3306, host: 3306

    config.vm.synced_folder ".", "/vagrant", type: "virtualbox"

    config.vm.network "private_network", ip: "192.168.100.101"

    config.vm.provision "shell", inline: <<-'SHELL'
        # Обновление системы
        sudo yum -y update
        sudo yum -y install epel-release

        # Установка nginx
        sudo yum -y install mc git nginx policycoreutils-python-utils unzip
        sudo chown vagrant:vagrant /var/log/nginx

        sudo echo "
        user vagrant;
        worker_processes auto;
        error_log /var/log/nginx/error.log;
        pid /var/run/nginx.pid;

        events {
            worker_connections 1024;
        }

        http {
            sendfile            off; # bug in VirtualBox
            tcp_nopush          on;
            tcp_nodelay         on;
            keepalive_timeout   65;
            types_hash_max_size 2048;

            client_max_body_size 1024m;

            include             /etc/nginx/mime.types;
            default_type        application/octet-stream;

            server {
                listen 8080 default_server;
                server_name  _;
                root /vagrant/web;
                index index.html index.htm index.php;

                location / {
                    try_files \$uri \$uri/ /index.php\$is_args\$args;
                }

                location ~ \.php\$ {
                    try_files \$uri =404;
                    include /etc/nginx/fastcgi_params;
                    fastcgi_pass  unix:/var/run/php-fpm/php-fpm.sock;
                    fastcgi_index index.php;
                    fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
                    fastcgi_read_timeout 3600;
                }
            }
        }
        " > /etc/nginx/nginx.conf

        sudo systemctl start nginx
        sudo systemctl enable nginx

        # Установка MySQL
        sudo yum -y install mariadb-server

        sudo systemctl start mariadb
        sudo systemctl enable mariadb

        # Установка PHP-FPM
        sudo yum -y install https://rpms.remirepo.net/enterprise/remi-release-7.rpm
        sudo yum -y module install php:remi-7.4
        sudo yum-config-manager --enable remi-php74
        sudo yum -y install php php-fpm php-common php-gd php-mbstring php-xml php-opcache php-cli php-intl php-ldap php-sodium php-pecl-imagick php-soap php-zip php-zip php-pdo php-mysqlnd

        sudo mkdir /var/run/php-fpm
        sudo rm -rf /etc/localtime
        sudo ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
        sudo sed -i "s/;date.timezone.*/date.timezone = Europe\\/Moscow/g" /etc/php.ini
        sudo sed -i "s/; max_input_vars.*/max_input_vars = 100000/g" /etc/php.ini
        sudo sed -i "s/short_open_tag*/short_open_tag = On/g" /etc/php.ini
        sudo sed -i "s/error_reporting.*/error_reporting \= E_ALL \& ~E_DEPRECATED \& ~E_STRICT \& ~E_NOTICE \& ~E_WARNING/g" /etc/php.ini
        sudo sed -i "s/;realpath_cache_size = .*/realpath_cache_size = 4096k/g" /etc/php.ini
        sudo sed -i "s/upload_max_filesize = .*/upload_max_filesize = 512M/g" /etc/php.ini
        sudo sed -i "s/memory_limit = .*/memory_limit = 1024M/g" /etc/php.ini
        sudo sed -i "s/post_max_size = .*/post_max_size = 512M/g" /etc/php.ini
        sudo sed -i "s/;date.timezone.*/date.timezone = Europe\\/Moscow/g" /etc/php.ini
        sudo sed -i "s/;\s*max_input_vars.*/max_input_vars = 100000/g" /etc/php.ini
        sudo sed -i "s/short_open_tag = .*/short_open_tag = On/g" /etc/php.ini
        sudo sed -i "s/display_errors = .*/display_errors = On/g" /etc/php.ini
        sudo sed -i "s/;realpath_cache_size = .*/realpath_cache_size = 4096k/g" /etc/php.ini
        sudo sed -i "s/opcache.max_accelerated_files=.*/opcache.max_accelerated_files=100000/g" /etc/php.d/10-opcache.ini
        sudo sed -i "s/listen = 127.0.0.1:9000/listen = \\/var\\/run\\/php-fpm\\/php-fpm.sock/g" /etc/php-fpm.d/www.conf
        sudo sed -i "s/user = apache/user = vagrant/g" /etc/php-fpm.d/www.conf
        sudo sed -i "s/group = apache/group = vagrant/g" /etc/php-fpm.d/www.conf
        sudo sed -i "s/;listen.owner = nobody/listen.owner = vagrant/g" /etc/php-fpm.d/www.conf
        sudo sed -i "s/;listen.group = nobody/listen.group = vagrant/g" /etc/php-fpm.d/www.conf
        sudo sed -i "s/listen.acl_users/;listen.acl_users/g" /etc/php-fpm.d/www.conf

        sudo systemctl start php-fpm
        sudo systemctl enable php-fpm

        # Установка Composer
        cd /tmp
        sudo curl -sS https://getcomposer.org/installer | sudo php
        sudo mv /tmp/composer.phar /usr/local/bin/composer
        sudo chmod +x /usr/local/bin/composer
        mkdir -p /home/vagrant/.config/composer
        sudo sh -c 'echo \"{"github-oauth": {"github.com": "5a07804b8b4b3a25750cd446f42451d6701e8fc8"}}\" > /home/vagrant/.config/composer/auth.json'
        sudo chown -R vagrant:vagrant /home/vagrant/.config

        # Настройка SELinux
        sudo semanage fcontext -a -t httpd_sys_rw_content_t "/vagrant(/.*)?"
        sudo restorecon -R /vagrant
        sudo chown -R vagrant:vagrant /var/lib/php/session

        sudo semanage permissive -a httpd_t
        sudo setsebool -P httpd_can_network_connect on

        sudo firewall-cmd --permanent --add-port=8080/tcp
        sudo firewall-cmd --reload

        # Перезапуск сервисов
        sudo systemctl restart nginx
        sudo systemctl restart php-fpm
        sudo systemctl restart mariadb

        # Импорт БД из файла
        sudo mysql -u root mysql -e'SET PASSWORD FOR root@localhost = PASSWORD("asd_123"); FLUSH PRIVILEGES;'
        sudo mysql -u root -p"asd_123" mysql -e'CREATE USER root@"%" IDENTIFIED BY "asd_123"; GRANT ALL ON *.* TO root@"%"; FLUSH PRIVILEGES;'

        # Периодический дамп БД в файл (на Windows - с преобразованием в CRLF)
        sudo mysql -u root -p"asd_123" -e'CREATE DATABASE IF NOT EXISTS testdb CHARACTER SET utf8 COLLATE utf8_unicode_ci'
        sudo mysql -u root -p"asd_123" testdb < /vagrant/sql/db.sql
        echo '*/2 * * * * mysqldump --skip-comments -u root -p"asd_123" testdb > /vagrant/sql/db.sql' | crontab

        if [ ! -d /vagrant/vendor ]
        then
            cd /home/vagrant
            /usr/local/bin/composer create-project --prefer-dist yiisoft/yii2-app-basic
            rm -f /home/vagrant/yii2-app-basic/Vagrantfile
            cp -r /home/vagrant/yii2-app-basic/* /vagrant/
            rm -rf /home/vagrant/yii2-app-basic
            cd /vagrant
            /usr/local/bin/composer update
        fi
    SHELL

    config.vm.provision "shell", inline: <<-'SHELL', run: 'always'
        mysql -u root -p"asd_123" testdb < /vagrant/sql/db.sql
    SHELL
end
