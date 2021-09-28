# composer-package-template
composer-package-template

## Installation

```php
docker run --rm --interactive --tty -v e:/dnmp/www/composer-package-template:/app composer install
```

## PSR规范之 php-cs-fixer 

格式化项目
```php
/var/www/composer-package-template # vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix
Loaded config default from "/var/www/composer-package-template/.php-cs-fixer.php".
   1) composer-package-template/src/Exception/Exception.php
   2) composer-package-template/src/Exception/InvalidConfigException.php
   3) composer-package-template/src/Exception/ServiceNotFoundException.php
   4) composer-package-template/src/functions.php
   5) composer-package-template/src/Hello.php
```