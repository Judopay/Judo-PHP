# Fix 'default: stdin: is not a tty' bug
# https://github.com/mitchellh/vagrant/issues/1673
sed -i 's/^mesg n$/tty -s \&\& mesg n/g' /root/.profile

export DEBIAN_FRONTEND=noninteractive
sudo apt-get -y install libxml2-dev

# Install PHP 5.4 from source
cd /tmp
wget -O php-5.3.tgz http://uk.php.net/get/php-5.3.28.tar.gz/from/this/mirror
tar zxvf php-5.3.tgz
cd php-5.3.28
./configure
make
sudo make install