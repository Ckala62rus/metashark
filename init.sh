#!/bin/bash

read -p "Project name:" projectName
read -p "XHPROF PORT:" xhprofPort
read -p "NGINX PORT:" nginxPort
read -p "MYSQL PORT:" mysqlPort

projectName=$(echo "$projectName" | tr '[:upper:]' '[:lower:]')

OS=$(uname -s)

# MacOS
if [[ "$OS" == 'Darwin' ]]; then
  stub=$(cat ./docker/docker-compose.stub)

# Other
else
  # TODO
  # read -p "Project IP (example: 192.168.220.0/28):" projectIP
  stub=$(cat ./docker/docker-compose-linux.stub)
  stub=${stub//\$SUBNET\$/192.168.220.0/28}
  stub=${stub//\$SUBNET_FIRST\$/192.168.220.1}
fi

stub=${stub//\$BACKEND\$/"backend-$projectName"}
stub=${stub//\$XHPROF\$/"xhprof-$projectName"}
stub=${stub//\$NGINX\$/"nginx-$projectName"}
stub=${stub//\$MYSQL\$/"mysql-$projectName"}
stub=${stub//\$XHPROF_PORT\$/"$xhprofPort"}
stub=${stub//\$NGINX_PORT\$/"$nginxPort"}
stub=${stub//\$MYSQL_PORT\$/"$mysqlPort"}

echo "$stub" > docker-compose.yml

#mkdir -p ./backend/public;
#helloWorldExample=$(cat ./docker/hello-world.stub)
#echo "$helloWorldExample" > ./backend/public/index.php