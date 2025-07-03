@echo off

set /p projectName=Project name:
set /p xhprofPort=XHPROF PORT:
set /p nginxPort=NGINX PORT:
set /p mysqlPort=MYSQL PORT:

set replace=^
-replace '\$BACKEND\$', 'backend-%projectName%' ^
-replace '\$XHPROF\$', 'xhprof-%projectName%' ^
-replace '\$NGINX\$', 'nginx-%projectName%' ^
-replace '\$MYSQL\$', 'mysql-%projectName%' ^
-replace '\$XHPROF_PORT\$', '%xhprofPort%' ^
-replace '\$NGINX_PORT\$', '%nginxPort%' ^
-replace '\$MYSQL_PORT\$', '%mysqlPort%'

set command=(Get-Content ./docker/docker-compose.stub) %replace%

powershell -Command "%command% | Set-Content docker-compose.yml"