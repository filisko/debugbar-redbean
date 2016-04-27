# RedBean collector for Debugbar
With this collector you will be able to see a new section in your Debugbar called "RedBean", which will contain all the executed queries by RedBean.

## Install
To install it you can use Composer:

`composer require filisko/debugbar-redbean`

Once installed, you to make use of the addCollector() method of Debugbar to add RedBean's collector. So you may have something like that somewhere:
```php
$debugbar = new \DebugBar\StandardDebugBar();
```

And adding our collector: 
```php
$debugbar = new \DebugBar\StandardDebugBar();
$debugbar->addCollector(new Filisko\DebugBar\DataCollector\RedBeanCollector(R::getLogger()));
```

Something very **IMPORTANT** is that you have to pass your logger as a parameter to the collector. To get your RedBean's logger use the provided method by RedBean called **R::getLogger()**.

And last but not least, remember that to be able to see the executed SQL queries by RedBean, you must enable the debug mode.

```php
/*
Possible log modes:
-------------------
0 Log and write to STDOUT classic style (default)
1 Log only, class style
2 Log and write to STDOUT fancy style
3 Log only, fancy style
*/
R::debug(TRUE, 1);
```

After that you should see a tab in your Debugbar called "RedBean".