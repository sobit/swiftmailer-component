swiftmailer-component
=====================

Component for [Yii Framework][1] based application which provides simple configuration interface for [Swift Mailer library][2].

Installation
------------

Add dependency to your ```composer.json``` file:

```json
{
    "require": {
        "sobit/swiftmailer-component": "dev-master"
    }
}
```

Update your ```protected/config/main.php``` file:

```php
<?php

Yii::setPathOfAlias('vendor', dirname(__FILE__) . '/../vendor');

return array(
    'components' => array(
        'swiftMailer' => array(
            'class'    => 'vendor.sobit.swiftmailer-component.SwiftMailerComponent',
            
            'host'     => 'localhost', // smtp host
            'port'     => 25,          // smtp port
            'username' => null,        // username
            'password' => null,        // password
            'security' => null,        // security, e.g. "ssl"
        ),
    ),
);
```

Usage
-----

Most simple usage example:

```php
$message = Yii::app()->swiftMailer->createMessage('Test subject', 'Test body content');
Yii::app()->swiftMailer->send($message);
```

[1]: https://github.com/yiisoft/yii "Yii Framework"
[2]: https://github.com/swiftmailer/swiftmailer "Swift Mailer"
