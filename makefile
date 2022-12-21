# Docker:
# ------
# $ make build              - build docker containers
# $ make up       	        - start docker containers
# $ make down               - stop docker containers
# $ make exec               - exec -it php-fpm
# $ make queue-start   		- run queue
# ------

include ./.env
export
##================================================================================
## Variables
##================================================================================
DOCKER_EXEC_PHP_FPM = docker exec -it  ${APP_ENV}.${APP_NAME}.php-fpm
DOCKER_COMPOSE_FILENAME = docker-compose-local.yml
ifeq (${APP_ENV},$(filter ${APP_ENV},prod preprod))
	DOCKER_COMPOSE_FILENAME = docker-compose-prod.yml
endif

##================================================================================
# $ make build              - build docker containers
##================================================================================
build:
	docker network create ${APP_NETWORK_NAME} || true && \
    docker-compose -f $(DOCKER_COMPOSE_FILENAME) build --no-cache

##================================================================================
# $ make up       	        - start docker containers
##================================================================================
up:
	docker-compose -f $(DOCKER_COMPOSE_FILENAME) up --build -d

##================================================================================
# $ make down               - stop docker containers
##================================================================================
down:
	docker-compose -f ${DOCKER_COMPOSE_FILENAME} down

##================================================================================
# $ make exec               - exec -it php-fpm
##================================================================================
exec:
	$(DOCKER_EXEC_PHP_FPM) bash

##================================================================================
# $ make queue-start   		- run queue
##================================================================================
queue-start:
	$(DOCKER_EXEC_PHP_FPM) pm2 start ./pm2.config.js  \
	&& $(DOCKER_EXEC_PHP_FPM) pm2 set pm2-logrotate:rotateInterval '* * * * 5' \
	&& $(DOCKER_EXEC_PHP_FPM) pm2 set pm2-logrotate:dateFormat YYYY-MM-DD

##================================================================================
# $ make queue-stop   		- stop consumers
##================================================================================
queue-stop:
	$(DOCKER_EXEC_PHP_FPM) pm2 stop ./pm2.config.js

##================================================================================
# $ make queue-list   		- list queue
##================================================================================
queue-list:
	$(DOCKER_EXEC_PHP_FPM) pm2 list

##================================================================================
# $ make queue-restart   	- restart queue
##================================================================================
queue-restart:
	$(DOCKER_EXEC_PHP_FPM) pm2 delete all && $(DOCKER_EXEC_PHP_FPM) pm2 start ./pm2.config.js

##================================================================================
# $ make queue-monitor   	- monitor queue
##================================================================================
queue-monitor:
	$(DOCKER_EXEC_PHP_FPM) pm2 monit

##================================================================================
# $ make queue-log   	   - realtime queue log
##================================================================================
queue-log:
	$(DOCKER_EXEC_PHP_FPM) pm2 log

