.PHONY: check php-cs-fixer phpstan phpunit

default: help

help::
	@printf "\n"
	@printf "\033[90;42m                                          \033[39;0m\n"
	@printf "\033[90;42m           MyBlog Makefile help:          \033[39;0m\n"
	@printf "\033[90;42m                                          \033[39;0m\n"
	@printf "\n"
	@printf "\033[32m   php-cs-fixer      \033[39m run php-cs-fixer linter\n"
	@printf "\033[32m   phpstan           \033[39m run phpstant code analysis with level max\n"
	@printf "\033[32m   phpunit           \033[39m run phpunit unit test suites\n"
	@printf "\033[32m   check             \033[39m run all of the above in the given order\n"
	@printf "\033[32m   install           \033[39m run composer install\n"
	@printf "\n"

.PHONY: check
check: php-cs-fixer phpstan phpunit

.PHONY: php-cs-fixer
php-cs-fixer: vendor
	./vendor/bin/php-cs-fixer fix --diff --verbose --config=.php_cs.dist

.PHONY: phpstan
phpstan: vendor
	./vendor/bin/phpstan analyse src tests -lmax -c phpstan.neon

.PHONY: phpunit
phpunit: vendor
	./vendor/bin/phpunit --bootstrap ./vendor/autoload.php ./tests/ --coverage-clover ./docs/coverage/xml --whitelist ./src --log-junit ./test-results/phpunit/results.xml

.PHONY: install
install:
	composer install --prefer-dist --no-progress --no-suggest

vendor: install
