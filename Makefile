.PHONY: all clean install uninstall clean.docker dev test docker.phpunit

all: docker

clean: clean.vendor

dev: composer-dev

test: dev
	vendor/bin/phpunit --coverage-html out

clean.docker:
	docker ps -aq | xargs docker rm -f

clean.dockeri:
	docker images -q | xargs docker rmi

clean.vendor:
	rm -rf vendor composer.lock

composer-prod: clean.vendor
	composer install --no-dev

composer-dev:
	composer install

docker: docker.phar
	docker build -t photo_sorter_tdd .

build.docker:
	docker build -t photo_sorter_tdd_build build

docker.phar: build.docker clean.vendor
	docker run -it -v `pwd`:/app photo_sorter_tdd_build /bin/bash -c 'cd /app && composer install --no-dev && php -d phar.readonly=off /usr/bin/phar-composer build && chmod 777 photo_sorter_tdd.phar'

docker.composer-dev: build.docker
	docker run -it -v `pwd`:/app photo_sorter_tdd_build /bin/bash -c 'cd /app && /usr/bin/composer install && chmod -R g+w,o+w vendor'

docker.phpunit: docker.composer-dev
	docker run -it -v `pwd`:/app photo_sorter_tdd_build /bin/bash -c 'cd /app && php -dxdebug.coverage_enable=1 /app/vendor/bin/phpunit --configuration /app/phpunit.xml'
