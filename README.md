WTF
===
File:
vendor/zendframework/zendframework/library/Zend/View/Helper/Escaper/AbstractHelper.php

Message:
Object provided to Escape helper, but flags do not allow recursion

MpaCustomDoctrineHydrator
======================

Simple factory that helps you deal with Doctrine Module Hydrator and date / datetime columns

Configuration
=====
Copy **mpacustomdoctrinehydrator.config.global.php.dist** in your **autoload folder** and rename it by removing the .dist
extension.

By default, days and month are 2 digits formatted, and years are 4 digits formatted. You can change that in
**mpacustomdoctrinehydrator.config.global.php**. It follows the php IntlDateFormatter Predefined Constants values.

See http://php.net/manual/en/class.intldateformatter.php

Usage
=====

```php
$hydrator = $this->sm->get('customdoctrinehydrator')->setEntity('Application\Entity\Myentity');
$form->setHydrator($hydrator);
```

If your entity contains date columns, \DateTime objects will be automatically assigned to a strategy that will extract them to strings.

The strategy automatically formats your \DateTime object with those parameters :
  * The default locale
  * The IntlDateFormatter::SHORT/IntlDateFormatter::NONE
  * The timezone
  * Gregorian calendar

Installation
============
Add **at the top** of your composer.json  
"minimum-stability": "dev",  
"prefer-stable": true

Add to the **require** list  
"mpalourdio/mpa-custom-doctrine-hydrator": "dev-master"

Add "MpaCustomDoctrineHydrator" to your **modules list** in **application.config.php**
