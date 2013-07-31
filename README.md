# syMongodbOdmPlugin

use [MongoDB ODM for PHP](https://github.com/symflo/mongodb-odm) for SF1.

## Requirements

* PHP 5.4+
* [SyDependencyInjectionPlugin](https://github.com/symflo/syDependencyInjectionPlugin)

## Installation

Add autoload Composer on your symfony project.
In the `config/ProjectConfiguration.class.php` add:

```php
<?php
require_once __DIR__.'/../vendor/autoload.php';
?>
```

Add Symfony DependencyInjection Component in your `composer.json`

```shell
    "require": {
        ...
        "symflo/mongodb-odm": "dev-master",
        ...
    },
```

Activate the plugin in the `config/ProjectConfiguration.class.php`.

```php
<?php

class ProjectConfiguration extends sfProjectConfiguration
{
    public function setup()
    {
        $this->enablePlugins(array(
            /* ... */
            'syMongodbOdmPlugin',
        ));
    }
}
?>
```

And activate extension to load services in your app.yml

```yaml
syDependencyInjectionPlugin:
    extensions:
      - SyMongodbOdmExtension
      ...
```

## Configuration

In `app.yml`:

```yaml
all:
  syMongodbOdmPlugin:
    databases:
      default:
        host: 127.0.0.1
        user: ''
        password: ''
        database: database
    documents:
      user: 'Your\Namespace\Document\UserDocument'
      message: 'Your\Namespace\Document\MessageDocument'
```

## In your Action

```php
<?php
//...

public function executeYourAction(sfWebRequest $request)
{ 
    $dm = $this->getService('symflo.mongodbodm.document.manager');
    $users = $dm->getCollection('users')->find();
}

//...
?>
```