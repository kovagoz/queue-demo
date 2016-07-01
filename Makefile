.PHONY: install test

install:
	composer install

test:
	$(CURDIR)/vendor/bin/phpcs --standard=PSR1,PSR2 app/
	$(CURDIR)/vendor/bin/phpunit
