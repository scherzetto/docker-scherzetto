.PHONY: check build php-cs-fixer phpstan eslint prettier lint phpunit jest test yarn-install composer-install install vendor

default: help

help::
	@printf "\n"
	@printf "\033[90;42m                                          \033[39;0m\n"
	@printf "\033[90;42m           MyBlog Makefile help:          \033[39;0m\n"
	@printf "\033[90;42m                                          \033[39;0m\n"
	@printf "\n"
	@printf "\033[32m   php-cs-fixer      \033[39m run php-cs-fixer linter\n"
	@printf "\033[32m   phpstan           \033[39m run phpstan code analysis with level max\n"
	@printf "\033[32m   eslint            \033[39m run eslint linter\n"
	@printf "\033[32m   prettier          \033[39m run prettier linter\n"
	@printf "\033[32m   lint              \033[39m run all of the above linters \n"
	@printf "\n"
	@printf "\033[32m   phpunit           \033[39m run phpunit unit test suites\n"
	@printf "\033[32m   jest              \033[39m run jest unit test suites\n"
	@printf "\033[32m   test              \033[39m run phpunit and jest unit test suites\n"
	@printf "\n"
	@printf "\033[32m   composer-install  \033[39m run composer install\n"
	@printf "\033[32m   yarn-install       \033[39m run yarn install\n"
	@printf "\033[32m   install           \033[39m run composer and yarn install\n"
	@printf "\n"
	@printf "\033[32m   check             \033[39m run make install, make lint, and make test in that order\n"
	@printf "\033[32m   watch             \033[39m run Symfony Encore with Webpack to build and watch frontend\n"
	@printf "\033[32m   build             \033[39m run make check and build the frontend for production\n"
	@printf "\n"

.PHONY: check
check: lint test
	@printf "\n"
	@printf "\033[90;42m                                      \033[39;0m\n"
	@printf "\033[90;42m           MyBlog checks OK!          \033[39;0m\n"
	@printf "\033[90;42m                                      \033[39;0m\n"
	@printf "\n"

.PHONY: watch
watch: check
	@printf "\033[90;44m           Watch          \033[39;0m\n"
	@printf "\n"
	yarn encore dev --config ./config/tasks/build/webpack.config.js --watch
	@printf "\033[90;42m           Watching file changes          \033[39;0m\n"

.PHONY: build
build: install check
	@printf "\033[90;44m           Build          \033[39;0m\n"
	@printf "\n"
	node ./config/scripts/build.js
	@printf "\033[90;42m           MyBlog successfully built!          \033[39;0m\n"

.PHONY: php-cs-fixer
php-cs-fixer:
	@printf "\033[90;44m           PHP-CS-Fixer          \033[39;0m\n"
	@printf "\n"
	./vendor/bin/php-cs-fixer fix --diff --verbose --config=./config/tasks/lint/.php_cs.dist
	@printf "\n"

.PHONY: phpstan
phpstan:
	@printf "\033[90;44m           PHPStAn          \033[39;0m\n"
	@printf "\n"
	./vendor/bin/phpstan analyse src tests -lmax -c ./config/tasks/lint/phpstan.neon
	@printf "\n"

.PHONY: eslint
eslint:
	@printf "\033[90;44m           ESLint          \033[39;0m\n"
	@printf "\n"
ifeq (,$(wildcard ./assets))
	@printf "No files to inspect.\n"
else
	./node_modules/.bin/eslint assets -c ./config/tasks/lint/.eslintrc.js --ignore-path ./config/tasks/lint/.eslintignore --fix
endif
	@printf "\n"

.PHONY: prettier
prettier:
	@printf "\033[90;44m           Prettier          \033[39;0m\n"
	@printf "\n"
ifeq (,$(wildcard ./assets))
	@printf "No files to inspect.\n"
else
	./node_modules/.bin/prettier --config ./config/tasks/lint/.prettierrc --ignore-path ./config/tasks/lint/.prettierignore --write ./assets/**/*.js
endif
	@printf "\n"

.PHONY: lint
lint: php-cs-fixer phpstan eslint prettier

.PHONY: phpunit
phpunit:
	@printf "\033[90;44m           PHPUnit          \033[39;0m\n"
	@printf "\n"
	./vendor/bin/phpunit --bootstrap ./vendor/autoload.php ./tests/ --coverage-clover ./docs/coverage/xml --whitelist ./src --log-junit ./test-results/phpunit/results.xml
	@printf "\n"

.PHONY: jest
jest:
	@printf "\033[90;44m           Jest          \033[39;0m\n"
	@printf "\n"
	node ./config/scripts/test.js -o -c ./config/tasks/test/jest.config.js
	@printf "\n"

.PHONY: test
test: phpunit jest

.PHONY: composer-install
composer-install:
	@printf "\033[90;44m           Composer Install          \033[39;0m\n"
	@printf "\n"
	composer install --prefer-dist --no-progress --no-suggest
	@printf "\n"

.PHONY: yarn-install
yarn-install:
	@printf "\033[90;44m           Yarn Install          \033[39;0m\n"
	@printf "\n"
ifeq (, $(shell command -v yarn 2>/dev/null))
	curl -o- -L https://yarnpkg.com/install.sh | bash
	source ~/.bashrc
endif
	yarn install --ignore-optional --ignore-script --no-progress
	@printf "\n"

.PHONY: install
install: composer-install yarn-install

vendor: install
