[![Build Status](https://travis-ci.org/mpalourdio/MpaCustomDoctrineHydrator.png?branch=master)](https://travis-ci.org/mpalourdio/MpaCustomDoctrineHydrator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mpalourdio/MpaCustomDoctrineHydrator/badges/quality-score.png?s=2c109f8b765d059d4b33cb1f6195eae07b2fdb1c)](https://scrutinizer-ci.com/g/mpalourdio/MpaCustomDoctrineHydrator/)
[![Code Coverage](https://scrutinizer-ci.com/g/mpalourdio/MpaCustomDoctrineHydrator/badges/coverage.png?s=b249873714b3c85f08dfcd9306bd4c6b9cb19ba0)](https://scrutinizer-ci.com/g/mpalourdio/MpaCustomDoctrineHydrator/)


MpaCustomDoctrineHydrator
=========================

Module that helps you deal with dates for DoctrineModule & ZF2 : filtering, hydration, Locale etc.
Extends and replace the ZF2 Date Element to be compliant with doctrine hydration.

The filter and the element can be used as standalone. Using the provided element via the FormElementManager adds automatic conversion formats for date strings to \DateTime.
Automatic filtering and validation are provided regarding the date format (Y-m-d, etc.) that depends of the \Locale. A placeholder is added to your form element too when rendered.

The hydrator service adds a strategy to all date columns of your entity for extraction and hydration.

Requirements
============
PHP 5.5+ - Only Composer installation supported


Installation
============
Add to the **require** list   of your composer.json
"mpalourdio/mpa-custom-doctrine-hydrator": "0.*"

Add "MpaCustomDoctrineHydrator" to your **modules list** in **application.config.php**


Configuration
=============
Copy **mpacustomdoctrinehydrator.config.global.php.dist** in your **autoload folder** and rename it by removing the .dist
extension.

Add your own date formats (if needed) that are compliants with php \DateTime

see http://www.php.net/manual/fr/datetime.createfromformat.php

Usage (the easy and lazy way)
=============================

Create your forms with the doctrine ORM form annotation builder. Just set the FEM as the form factory

```php
$builder       = new \DoctrineORMModule\Form\Annotation\AnnotationBuilder($this->entityManager);
$builder->setFormFactory(
    new \Zend\Form\Factory($this->serviceLocator->get('FormElementManager'))
        );
$form = $builder->createForm('User');
```
Then, hydrate your form

```php
$hydrator = $this->sm->get('customdoctrinehydrator')->setEntity('Application\Entity\Myentity');
$form->setHydrator($hydrator);
```

You're done! Date colums will be hydrated/extracted, filtered and validated automatically, without providing anything else in your entities.
Your form elements will have a placeholder.


Usage (the hard and decoupled way)
=================================

```php
$hydrator = $this->sm->get('customdoctrinehydrator')->setEntity('Application\Entity\Myentity');
$form->setHydrator($hydrator);
```
In your forms classes, when not using the FormElementManager :
```php

$this->add(
            [
                'name'       => 'mydate',
                'type'       => 'MpaCustomDoctrineHydrator\Form\Element\HydratedDate',
                'attributes' => [
                    'id'    => 'mydate',
                ],
                'options'    => [
                    'label'  => 'My date',
                    'format' => 'd.m/Y' // format needed
                ],
            ]
        );
```

If you pull your forms from the FEM, just grab the element as a 'Date'. The format here is not needed, config will be pulled from service config.

```php
$this->add(
            [
                'name'       => 'mydate',
                'type'       => 'Date',
                'attributes' => [
                    'id'    => 'mydate',
                ],
                'options'    => [
                    'label'  => 'My date',
                ],
            ]
        );
```

You can use too the filter as standalone on other form elements with custom formats if needed. For this, use the filter FQCN.

If you use the filter shortname (```php DateToDateTime ```), the config will be pulled form the service config (ie. The options array will be ignored).

```php
public function getInputFilterSpecification()
{
        $filters = [
            'otherdate' => [
                'filters' => [
                    [
                        'name' => 'MpaCustomDoctrineHydrator\Filter\DateToDateTime',
                        'options' => [
                            'format' => 'd/m/Y' ('date_format' is also accepted)
                        ]
                    ],
                ],
            ],
        ];
        return $filters;
}
```

or simply

```php
public function getInputFilterSpecification()
{
        $filters = [
            'otherdate' => [
                'filters' => [
                    [
                        'name' => 'DateToDateTime',
                    ], // no options needed here, would be ignored anyway
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

/!\ Tip : To use the 'DateToDateTime' filter short name in a form grabbed without the FEM , you must do the following :
```php
$plugins = $this->sm ->get('FilterManager');
$chain   = new FilterChain;
$chain->setPluginManager($plugins);
$myForm->getFormFactory()->getInputFilterFactory()->setDefaultFilterChain($chain);
```

You can use the provided strategy as standalone with your hydrators too.

TODO
====

Handle Time, and Datetime format.
