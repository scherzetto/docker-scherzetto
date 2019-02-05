.PHONY: check build php-cs-fixer phpstan eslint prettier lint phpunit jest test yarn-install composer-install install
.PHONY: vendor vendor-installed modules-installed project-installed env-ready

DOCKER=docker-compose
EXEC=$(DOCKER) exec php
GITHUB_API_TOKEN=${GITHUB_API_TOKEN}
PROJECT_DIR=$(filter-out $(CURDIR)/docker/., $(wildcard $(CURDIR)/*/.))

default: help

help::
	@printf "\n"
	@printf "\033[90;42m                                          \033[39;0m\n"
	@printf "\033[90;42m           MyBlog Makefile help:          \033[39;0m\n"
	@printf "\033[90;42m                                          \033[39;0m\n"
	@printf "\n"
	@printf "\033[32m   build                   \033[39m run docker-compose build\n"
	@printf "\033[32m   up                      \033[39m run docker-compose up in detached mode\n"
	@printf "\033[32m   down                    \033[39m run docker-compose down\n"
	@printf "\n"
	@printf "\033[32m   create [projectName]    \033[39m run composer create-project scherzetto/scherzetto [projectName]\n"
	@printf "\033[32m   composer-install        \033[39m run composer install\n"
	@printf "\033[32m   yarn-install            \033[39m run yarn install\n"
	@printf "\033[32m   install                 \033[39m run composer-install and yarn-install\n"
	@printf "\n"
	@printf "\033[32m   php-cs-fixer            \033[39m run php-cs-fixer linter\n"
	@printf "\033[32m   phpstan                 \033[39m run phpstan code analysis with level max\n"
	@printf "\033[32m   eslint                  \033[39m run eslint linter\n"
	@printf "\033[32m   prettier                \033[39m run prettier linter\n"
	@printf "\033[32m   lint                    \033[39m run all of the above linters \n"
	@printf "\n"
	@printf "\033[32m   phpunit                 \033[39m run phpunit unit test suites\n"
	@printf "\033[32m   jest                    \033[39m run jest unit test suites\n"
	@printf "\033[32m   test                    \033[39m run phpunit and jest unit test suites\n"
	@printf "\n"
	@printf "\033[32m   security                \033[39m run sensiolabs security checker on dependencies\n"
	@printf "\033[32m   check                   \033[39m run make install, make lint, and make test in that order\n"
	@printf "\033[32m   watch                   \033[39m run Symfony Encore with Webpack to build and watch frontend\n"
	@printf "\033[32m   prod                    \033[39m run make check and build the frontend for production\n"
	@printf "\n"

########## Utilitaries ########
.PHONY: env-ready
env-ready:
ifeq (, $(wildcard ./.env))
	cp .env.dist .env
endif
ifeq (, $(wildcard ./docker-compose.yml))
	cp docker-compose.yml.dist docker-compose.yml
endif

.PHONY: php-created
php-created: env-ready
ifeq (, $(shell docker-compose ps --services | grep php))
	$(MAKE) build
endif

.PHONY: php-running
php-running: php-created
ifeq (, $(shell docker-compose ps --filter "status=running" --services | grep php))
	$(MAKE) up
endif

.PHONY: project-cloned
project-cloned: php-running
ifeq (, $(wildcard ./src))
	$(MAKE) create
endif

.PHONY: vendor-installed
vendor-installed: project-cloned
ifeq (, $(wildcard ./vendor))
	$(MAKE) composer-install
endif

.PHONY: modules-installed
modules-installed: project-cloned
ifeq (, $(wildcard ./node_modules))
	$(MAKE) yarn-install
endif

.PHONY: project-installed
project-installed: vendor-installed modules-installed

########## Actual commands ##########
.PHONY: build
build: env-ready
	@printf "\033[90;44m           Build          \033[39;0m\n"
	@printf "\n"
	$(DOCKER) build --force --no-cache
	@printf "\n"

.PHONY: up
up: env-ready
	@printf "\033[90;44m           Up          \033[39;0m\n"
	@printf "\n"
	$(DOCKER) up -d
	@printf "\n"

.PHONY: down
down: env-ready
	@printf "\033[90;44m           Down          \033[39;0m\n"
	@printf "\n"
	$(DOCKER) down --remove-orphans
	@printf "\n"

.PHONY: create
create: php-running
	@printf "\033[90;44m           Clone          \033[39;0m\n"
	@printf "\n"
	$(EXEC) composer create-project scherzetto/scherzetto $(filter-out $@, $(MAKECMDGOALS))
	$(EXEC) chown -R 1000:1000 $(filter-out $@, $(MAKECMDGOALS))
	@printf "\n"

.PHONY: composer-install
composer-install:
	@printf "\033[90;44m           Composer Install          \033[39;0m\n"
	@printf "\n"
	$(EXEC) composer install --prefer-dist --no-progress --no-suggest --working-dir $(PROJECT_DIR)
	@printf "\n"

.PHONY: yarn-install
yarn-install:
	@printf "\033[90;44m           Yarn Install          \033[39;0m\n"
	@printf "\n"
ifeq (, $(shell command -v yarn 2>/dev/null))
	$(EXEC) curl -o- -L https://yarnpkg.com/install.sh | bash
	$(EXEC) source ~/.bashrc
endif
	$(EXEC) yarn install --ignore-optional --ignore-script --no-progress
	@printf "\n"

.PHONY: install
install: env-ready project-installed

.PHONY: php-cs-fixer
php-cs-fixer: vendor-installed
	@printf "\033[90;44m           PHP-CS-Fixer          \033[39;0m\n"
	@printf "\n"
	$(EXEC) ./vendor/bin/php-cs-fixer fix --diff --verbose --config=./config/tasks/lint/.php_cs.dist
	@printf "\n"

.PHONY: phpstan
phpstan: vendor-installed
	@printf "\033[90;44m           PHPStAn          \033[39;0m\n"
	@printf "\n"
	$(EXEC) ./vendor/bin/phpstan analyse src tests -lmax -c ./config/tasks/lint/phpstan.neon
	@printf "\n"

.PHONY: eslint
eslint: modules-installed
	@printf "\033[90;44m           ESLint          \033[39;0m\n"
	@printf "\n"
ifeq (,$(wildcard ./assets))
	@printf "No files to inspect.\n"
else
	$(EXEC) ./node_modules/.bin/eslint assets -c ./config/tasks/lint/.eslintrc.js --ignore-path ./config/tasks/lint/.eslintignore --fix
endif
	@printf "\n"

.PHONY: prettier
prettier: modules-installed
	@printf "\033[90;44m           Prettier          \033[39;0m\n"
	@printf "\n"
ifeq (,$(wildcard ./assets))
	@printf "No files to inspect.\n"
else
	$(EXEC) ./node_modules/.bin/prettier --config ./config/tasks/lint/.prettierrc --ignore-path ./config/tasks/lint/.prettierignore --write ./assets/**/*.js
endif
	@printf "\n"

.PHONY: lint
lint: php-cs-fixer phpstan eslint prettier

.PHONY: phpunit
phpunit: vendor-installed
	@printf "\033[90;44m           PHPUnit          \033[39;0m\n"
	@printf "\n"
	$(EXEC) ./vendor/bin/phpunit --bootstrap ./vendor/autoload.php ./tests/ --coverage-clover ./docs/coverage/xml --whitelist ./src --log-junit ./test-results/phpunit/results.xml
	@printf "\n"

.PHONY: jest
jest: modules-installed
	@printf "\033[90;44m           Jest          \033[39;0m\n"
	@printf "\n"
	$(EXEC) node ./config/scripts/test.js -o -c ./config/tasks/test/jest.config.js
	@printf "\n"

.PHONY: test
test: phpunit jest

.PHONY: security
security: vendor-installed
	@printf "\n"
	@printf "\033[90;42m           Security          \033[39;0m\n"
	$(EXEC) ./vendor/bin/security-checker security:check ./composer.lock
	@printf "\n"

.PHONY: check
check: security lint test
	@printf "\n"
	@printf "\033[90;42m                                      \033[39;0m\n"
	@printf "\033[90;42m           MyBlog checks OK!          \033[39;0m\n"
	@printf "\033[90;42m                                      \033[39;0m\n"
	@printf "\n"

.PHONY: watch
watch: project-installed check
	@printf "\033[90;44m           Watch          \033[39;0m\n"
	@printf "\n"
	$(EXEC) yarn encore dev --config ./config/tasks/build/webpack.config.js --watch
	@printf "\033[90;42m           Watching file changes          \033[39;0m\n"

.PHONY: prod
prod: project-installed check
	@printf "\033[90;44m           Prod          \033[39;0m\n"
	@printf "\n"
	$(EXEC) node ./config/scripts/build.js
	@printf "\033[90;42m           MyBlog successfully built!          \033[39;0m\n"

vendor: install
