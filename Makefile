SHELL = /bin/sh
UID := $(shell id -u)
GID := $(shell id -g)
SYSTEM := $(shell uname -s)
PROCESSOR := $(shell uname -p)

ifeq (${SYSTEM},Darwin)
compose := docker compose
else
compose := docker-compose
endif

exec-no-xdebug:= $(compose) exec -e XDEBUG_MODE=off -u www-data php
exec:= $(compose) exec -u www-data php

help:                                                                           ## shows this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\.]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.PHONY: up
up:																				## Start the Docker Compose stack for the complete project
	USER_ID="${UID}" $(compose) up -d --build --remove-orphans

.PHONY: down
down:																			## Bring down the Docker Compose stack for the complete project
	$(compose) down

.PHONY: php
php:																			## Bash in Docker container
	$(exec) bash || true

.PHONY: init
init:																			## Initialize dependencies
	$(exec) composer install

logs:                                                                  	        ## Docker Compose logs
	$(compose) logs -f

phpunit:                                                                        ## run phpunit tests
	$(exec) vendor/bin/phpunit --testdox -v --colors="always" $(OPTIONS)

psalm:																			## run psalm
	$(exec) ./vendor/bin/psalm

cache:																			## clear and warm up symfony cache
	$(exec-no-xdebug) bin/console ca:cl
	$(exec-no-xdebug) bin/console ca:wa

