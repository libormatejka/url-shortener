# Start dev environment
up:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml up -d --remove-orphans;
	@echo 'App is running on http://localhost';

# Start dev environment with forced build
up\:build:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml up -d --build;

# Stop dev environment
down:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml down;

# Show logs - format it using less
logs:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml logs -f --tail=10 | less -S +F;

# Exec sh on php container
exec\:php:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php sh;

# Exec sh on Node container
exec\:node:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec node sh;

# Init project
init:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml run php composer install;
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec node npm install;
	chmod -R 777 log;
	chmod -R 777 temp;
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php bin/console orm:schema-tool:drop --force --full-database;
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php bin/console orm:schema-tool:create;
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php bin/console doctrine:fixtures:load;

#DB
db-drob:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php bin/console orm:schema-tool:drop --force --full-database;

db-create:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php bin/console orm:schema-tool:create;

db-load:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php bin/console doctrine:fixtures:load --append;
.PHONY: db
db:
	make db-drob
	make db-create
	make db-load

#Code Sniffer
.PHONY: cs
cs:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php ./vendor/bin/phpcs --cache=./qa/phpcs/phpcs.cache --standard=./qa/phpcs/ruleset.xml --extensions=php --encoding=utf-8 --tab-width=4 -sp --colors app tests

#Code Sniffer Fix it
.PHONY: cs-fix
cs-fix:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php ./vendor/bin/phpcbf --cache=./qa/phpcs/phpcs.cache --standard=./qa/phpcs/ruleset.xml --extensions=php --encoding=utf-8 --tab-width=4 -sp --colors app tests

#PHPSTAN
.PHONY: phpstan
phpstan:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php ./vendor/bin/phpstan analyse --level 7 --ansi app

#PHP UNIT TESTS
.PHONY: tests
tests:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php ./vendor/bin/phpunit tests --colors --testdox

#DB-TESTS
.PHONY: db-tests
db-tests:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php bin/console orm:validate-schema --skip-sync

code-checker:
	docker-compose --project-name "cbbb" -f .docker/docker-compose.yml exec php ./vendor/bin/code-checker --ignore migrations --ignore config/manifest.json

code-checker-fix:
	docker-compose --project-name "cbbb" -f .docker/docker-compose.yml exec php ./vendor/bin/code-checker --ignore migrations --ignore config/manifest.json --fix

.PHONY: qa
qa:
	make cs
	make cs-fix
	make phpstan
	make tests
	make db-tests
	make code-checker
	make code-checker-fix

# Migrations
diff:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php bin/console orm:schema-tool:drop --force --full-database;
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php bin/console migrations:migrate --allow-no-migration --no-interaction;
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php bin/console migrations:diff;
	git add migrations/*
	make init

# Deployment
deploy-test:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php php deployment deployment.ini -t

.PHONY: deploy
deploy:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec php php deployment deployment.ini

# Fix
.PHONY: fix
fix:
	make cs-fix
	make code-checker-fix

# Webpack
build:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec node npm run build

serve:
	docker-compose --project-name cbbb -f .docker/docker-compose.yml exec node npm run serve
