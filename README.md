# RedBean collector for Debugbar

## Result
![RedBeanPHP collector for Debugbar](https://i.snag.gy/oLuxqH.jpg "RedBeanPHP collector for Debugbar")


## Installation and configuration
Install it via composer:

`composer require filisko/debugbar-redbean`

To make this work you must enable RedBean's debug mode to log your queries. You can simply use RedBean's Facade debug() method.

## How to use

To use this logger with any application, you could basically do something like that:

```php
R::setup('mysql:host=hostname;dbname=db', 'username', 'password');
/*
Possible log modes:
-------------------
0 Log and write to STDOUT classic style (default)
1 Log only, class style
2 Log and write to STDOUT fancy style
3 Log only, fancy style (it works nicely with this one)
*/
R::debug(true, 3);

// ... your queries here ...

// Get RedBean's Logger
$logger = R::getLogger();
$debugbar = new \DebugBar\StandardDebugBar();
$debugbar->addCollector(new \Filisko\DebugBar\DataCollector\RedBeanCollector($logger));
```

#### Extras
If you realized that RedBean puts at the end of your SQL queries something like '--keep-cache' for internal caching purposes and you want to hide this part from the logger, you could simply use a static flag to disable it:
```php
\Filisko\DebugBar\DataCollector\RedBeanCollector::$showKeepCache = false; // That's all!
```
