.PHONY: install clean

install:
	composer install
	mysql -u root < ./data/sql/init_db.sql
	php app/console server:start 

clean:
	php bin/php-cs-fixer.phar fix ./src
