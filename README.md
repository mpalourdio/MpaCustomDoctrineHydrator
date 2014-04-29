[![Build Status](https://travis-ci.org/mpalourdio/MpaCustomDoctrineHydrator.png?branch=master)](https://travis-ci.org/mpalourdio/MpaCustomDoctrineHydrator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mpalourdio/MpaCustomDoctrineHydrator/badges/quality-score.png?s=2c109f8b765d059d4b33cb1f6195eae07b2fdb1c)](https://scrutinizer-ci.com/g/mpalourdio/MpaCustomDoctrineHydrator/)
[![Code Coverage](https://scrutinizer-ci.com/g/mpalourdio/MpaCustomDoctrineHydrator/badges/coverage.png?s=b249873714b3c85f08dfcd9306bd4c6b9cb19ba0)](https://scrutinizer-ci.com/g/mpalourdio/MpaCustomDoctrineHydrator/)


MpaCustomDoctrineHydrator
=========================

Helps you deal with Doctrine Module Hydrator and date / datetime columns regardings Locale etc.

Requirements
============
PHP 5.5+ - Only Composer installation supported


Configuration
=============
Copy **mpacustomdoctrinehydrator.config.global.php.dist** in your **autoload folder** and rename it by removing the .dist
extension.

Add your own date formats that are compliant with php \DateTime

see http://www.php.net/manual/fr/datetime.createfromformat.php

Usage
=====

```php
$hydrator = $this->sm->get('customdoctrinehydrator')->setEntity('Application\Entity\Myentity');
$form->setHydrator($hydrator);
```

If your entity contains date columns, \DateTime objects will be automatically assigned to a strategy that will extract them to strings.

In your forms :
```php
//Get your date format (you must inject $sl in your form)
$cdhConfig  = $sm->get('Config');
$dateConfig = $cdhConfig['mpacustomdoctrinehydrator']['formats'][Locale::getDefault()];
$dateFormat = $dateConfig['date_format'];

$this->add(
            [
                'name'       => 'mydate',
                'type'       => 'MpaCustomDoctrineHydrator\Form\Element\HydratedDate',
                'attributes' => [
                    'id'    => 'mydate',
                ],
                'options'    => [
                    'label'  => 'My date',
                    'format' => $dateFormat
                ],
            ]
        );
```

You can too apply the filter as standalone
```php
public function getInputFilterSpecification()
{
        $filters = [
            'otherdate' => [
                'filters' => [
                    ['name' => 'DateToDateTime'],
                ],
            ],
        ];
        return $filters;
}
```

/!\ If you don't create your fieldsets/forms via the FormElementManager, you must manually inject $sl so the HydratedDate can fetch the configuration
```php
$this->getFormFactory()->getFormElementManager()->setServiceLocator($this->sm);
```

/!\ To use the DateToDateTime short name, you must do this. Otherwise, use the FCQN
```php
$plugins = $this->sm ->get('FilterManager');
$chain   = new FilterChain;
$chain->setPluginManager($plugins);
$myForm->getFormFactory()->getInputFilterFactory()->setDefaultFilterChain($chain);
```

This can work with annotation too, just provide @Annotation\Type("MpaCustomDoctrineHydrator\Form\Element\HydratedDate") or apply only the filter by FCQN


Installation
============
Add to the **require** list  
"mpalourdio/mpa-custom-doctrine-hydrator": "dev-master"

Add "MpaCustomDoctrineHydrator" to your **modules list** in **application.config.php**
