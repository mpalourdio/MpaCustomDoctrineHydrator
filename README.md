WTF
===
File:
vendor/zendframework/zendframework/library/Zend/View/Helper/Escaper/AbstractHelper.php

Message:
Object provided to Escape helper, but flags do not allow recursion

Requirements
============
PHP 5.4+

MpaCustomDoctrineHydrator
======================

Simple factory that helps you deal with Doctrine Module Hydrator and date / datetime columns

Configuration
=====
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
