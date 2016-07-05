.PHONY: install test doc

install:
	composer install

test:
	$(CURDIR)/vendor/bin/phpcs --standard=ruleset.xml -n app/
	$(CURDIR)/vendor/bin/phpunit

doc:
	$(CURDIR)/vendor/bin/apigen generate -s app -d public/doc
