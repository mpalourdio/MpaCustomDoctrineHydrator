WTF
===
File:
vendor/zendframework/zendframework/library/Zend/View/Helper/Escaper/AbstractHelper.php

Message:
Object provided to Escape helper, but flags do not allow recursion

CustomDoctrineHydrator
======================

Simple factory that helps you deal with Doctrine Module Hydrator and date / datetime colums

Usage
=====

```php
$hydrator = $this->sm->get('customdoctrinehydrator')->setEntity('Application\Entity\Myentity');
$form->setHydrator($hydrator);
```

If your entity contains date columns, \DateTime objects will be automatically assigned to a strategy that will extract them to strings.

The strategy automaticcaly formats your \DateTme object with those parameters :
  * The default locale
  * The IntlDateFormatter::SHORT/IntlDateFormatter::NONE
  * The timezone
  * Gregorian calendar

Those parameters are supposed to be configurable in the future...