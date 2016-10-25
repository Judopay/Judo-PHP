# Fix 'default: stdin: is not a tty' bug
# https://github.com/mitchellh/vagrant/issues/1673
sed -i 's/^mesg n$/tty -s \&\& mesg n/g' /root/.profile

sudo apt-get -y install php5-cli