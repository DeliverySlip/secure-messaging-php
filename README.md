# Secure Messaging PHP Sample SDK
The Secure Messaging PHP SDK allows clients to create applications to communicate with the DeliverSlip Secure Messaging
API.

The project is currently in Alpha. Although there is now working portions of the project, it is not version 1.0.0

# Prerequisites
To use the secure-messaging-php SDK you will need a PHP 5.6 installed along with Composer. In order to then use the SDK
you will also need a valid Secure Messaging Account.

You can install Composer here: [https://getcomposer.org/](https://getcomposer.org/)

# Setup

## Create A .phar File
You can compile the project into a phar file for use with your own projects.
From composer you will need to globally install box
```$xslt
composer global require kherge/box --prefer-source
```
Then from the project root execute the following command
```$xslt
box build -c ./box.json
```
This will then build the phar project. It is quite slow. You can add `-vv` to the above command for more verbose
output of its progress. Once it has completed there will be a `secure-messaging-php.phar` file placed in the project
root. Copy the file and import it into your project. An example of what that may look like is as follows:
```php
require_once("./secure-messaging-php.phar");

use SecureMessaging\CCC\ServiceCodeResolver;

$secureMessenger = SecureMessenger::resolveViaServiceCode("<portalcode>");
// do something with the secure messenger
```


## Manual
Install project dependencies by executing:
```$xslt
composer install
```
OR from the project root
```$xslt
php ./composer.phar install
```

# Usage
For examples on how to use the supported features in the PHP SDK, see the unit tests folders.

#Testing
If you would like to run unit tests on the SDK, create a `config.ini` file within the `tests` folder of the project
and enter the following information:
```ini
servicecode=<servicecode>
username=<email>
password=<password>
recipient=<recipientemail>
```
The servicecode is the unique code representing your portal. You can find this by logging into your account at
[https://w.deliveryslip.com](https://w.deliveryslip.com). Once you have logged in, copy the service code that will
have been appended onto the url after you have completed logging in. For additional help, contact support or your
portal admin.
The username and password are then the login credentials you use to access your secure email account. Add a recipient
email so that the mailing tests know where to send, this could be your same email if you would like, or another
email already part of the same portal.

You will also need to run the setup steps to install the composer dependencies before executing the tests. Tests
can then be simply installed with phpunit



# Development Notes
* Jan 6, 2017  - Currently this project is under development and is not usable at this time
* July 25, 2018 - Alpha release of the PHP SDK. Primary focus is development of equivalent features available
in the Java and C# SDKs