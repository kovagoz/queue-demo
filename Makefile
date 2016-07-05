.PHONY: install test doc

install:
	composer install

test:
	$(CURDIR)/vendor/bin/phpcs --standard=PSR1,PSR2 app/
	$(CURDIR)/vendor/bin/phpunit

doc:
	$(CURDIR)/vendor/bin/apigen generate -s app -d public/doc
