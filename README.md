# composer-package-template
composer-package-template

## 约定
- Contract 合同; 合约; 契约;
- Provider 供应者; 提供者; 供养人（在执行完所请求的操作后，供应者Web服务返回所期望的值）;
- Parser 解析器

## Installation

```
docker run -it -v e:/dnmp/www/composer-package-template:/app composer install
```

## PSR规范之 php-cs-fixer 

### （1）格式化项目
```
/var/www/composer-package-template # vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix
Loaded config default from "/var/www/composer-package-template/.php-cs-fixer.php".
   1) composer-package-template/src/Exception/Exception.php
   2) composer-package-template/src/Exception/InvalidConfigException.php
   3) composer-package-template/src/Exception/ServiceNotFoundException.php
   4) composer-package-template/src/functions.php
   5) composer-package-template/src/Hello.php
```

### （2）通过脚本格式代码
```
$ docker run -it -v e:/dnmp/www/composer-package-template:/app composer run-script cs-fix
> vendor/bin/php-cs-fixer fix
Loaded config default from "/app/.php-cs-fixer.php".
   1) /app/src/Hello.php

Fixed all files in 0.492 seconds, 12.000 MB memory used
```

### 选项
```
--format 输出文件格式，支持txt、xml
--verbose 
--level 应用哪种PSR类型。支持psr0、psr1、psr2。默认是psr2
--dry-run 显示需要修复但是没有修复的代码

php php-cs-fixer.phar fix /path/to/project --level=psr0
php php-cs-fixer.phar fix /path/to/project --level=psr1
php php-cs-fixer.phar fix /path/to/project --level=psr2
php php-cs-fixer.phar fix /path/to/project --level=symfony
```

## 单元测试

### （1）IDE

![debug](./debug.png)

### （2）命令phpunit
```
./vendor/bin/phpunit -c phpunit.xml --colors=always
```

### （3）通过 composer run-script

```
$ docker run -it -v e:/dnmp/www/composer-package-template:/app composer run-script test
> vendor/bin/php-cs-fixer fix
Loaded config default from "/app/.php-cs-fixer.php".
   1) /app/src/Hello.php

Fixed all files in 0.492 seconds, 12.000 MB memory used
```

### PHPUnit settings are not configured.

![PHPUnit settings](./PHPUnit%20settings.png)