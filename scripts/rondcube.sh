#!/bin/bash


clear

cat << "HEIM"

    Ce script appartient à Versa Group / Mercure Hosting.
    Toute copie ou utilisation non-autorisée entraînera des poursuites judiciaires.

HEIM

echo -e "\e[1;33mMerci de ne pas annuler le script d'installation Rondcube ni de vous déconnecter du SSH\e[0m"

# Variables
DB_ROOT_PASS="azertyuiopqsdfghjklmwxcvbn"
DB_NAME="roundcube"
DB_USER="roundcube"
DB_PASS="azertyuiopqsdfghjklmwxcvbn"
SERVER_IP="none"
WEB_ROOT="/var/www/roundcube"
ROUNDCUBE_VERSION="1.6.2"
ROUNDCUBE_URL="https://github.com/roundcube/roundcubemail/releases/download/${ROUNDCUBE_VERSION}/roundcubemail-${ROUNDCUBE_VERSION}-complete.tar.gz"

# Update system
apt update && apt upgrade -y

# Install dependencies
apt install -y apache2 mariadb-server php php-mysql php-pear php-net-smtp php-intl php-mbstring php-zip php-xml php-gd wget tar unzip curl

# Configure MySQL
mysql -e "CREATE DATABASE ${DB_NAME};"
mysql -e "GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';"
mysql -e "FLUSH PRIVILEGES;"

# Download and extract Roundcube
wget -O /tmp/roundcube.tar.gz ${ROUNDCUBE_URL}
mkdir -p ${WEB_ROOT}
tar xzf /tmp/roundcube.tar.gz -C ${WEB_ROOT} --strip-components=1

# Set permissions
chown -R www-data:www-data ${WEB_ROOT}
chmod -R 775 ${WEB_ROOT}/temp ${WEB_ROOT}/logs

# Configure Apache
cat > /etc/apache2/sites-available/roundcube.conf <<EOF
<VirtualHost *:80>
    ServerAdmin webmaster@${DOMAIN}
    DocumentRoot ${WEB_ROOT}
    ServerName ${DOMAIN}
    <Directory ${WEB_ROOT}>
        Options +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog \${APACHE_LOG_DIR}/roundcube_error.log
    CustomLog \${APACHE_LOG_DIR}/roundcube_access.log combined
</VirtualHost>
EOF

a2ensite roundcube.conf
a2enmod rewrite
systemctl restart apache2

# Configure Roundcube
cd ${WEB_ROOT}/config
cp config.inc.php.sample config.inc.php

sed -i "s/\('db_dsnw'\) = 'sqlite:\/\/\/\/.*'/\1 = 'mysql:\/\/${DB_USER}:${DB_PASS}@localhost\/${DB_NAME}'/" config.inc.php

# Secure MySQL installation
mysql_secure_installation <<EOF

Y
${DB_ROOT_PASS}
${DB_ROOT_PASS}
Y
Y
Y
Y
EOF

echo "L'installation de rondcube est terminÃ©e http://${SERVER_IP}/installer"

# Remove installer directory after setup
# rm -rf ${WEB_ROOT}/installer