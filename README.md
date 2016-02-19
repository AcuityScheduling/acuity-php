# Acuity Scheduling API - PHP Tool Kit

Welcome to the Acuity Scheduling PHP SDK.  This SDK provides examples and a standard library for integrating with the [Acuity Scheduling API](https://acuityscheduling.com/) using PHP.  You can learn more about developing for Acuity Scheduling at [developers.acuityscheduling.com](https://developers.acuityscheduling.com/).

## Installation

This package can be installed with composer or added to your application manually.  To install with composer, first execute in a shell:

```sh
$ composer require acuityscheduling/acuityscheduling
```

Then include the `vendor/autoload.php` in your app.

```php
<?php
require_once('vendor/autoload.php');
```

If you're installing manually, simply include the `AcuityScheduling.php` file in your app.

## Hello World

Here's a basic example to get started.  Just set your <a href="https://secure.acuityscheduling.com/app.php?key=api&action=settings" target="_blank">API credentials</a> and run:

```php
<?php
require_once('vendor/autoload.php');

$userId = null;
$apiKey = null;

$acuity = new AcuityScheduling(array(
  'userId' => $userId,
  'apiKey' => $apiKey
));

$appointments = $acuity->request('/appointments');
print_r($appointments);
```

## Examples

You'll find several examples of different Acuity integrations in the [examples/](examples/) directory.  These examples cover:
* [Basic API Access](#basic-api-access)
* [OAuth2 API Access](#oauth2-api-access)
* [Webhooks](#webhooks)
* [Custom Sidebar](#custom-sidebar)

##### Sample `examples/config.json`

Create a config file with your <a href="https://secure.acuityscheduling.com/app.php?key=api&action=settings" target="_blank">API credentials</a> to get started.  All examples
share a common config file containing your Acuity `userId` and `apiKey` for basic API access and verifying callbacks.  [OAuth2 examples](#oauth2-api-access) require
additional OAuth2 client account credentials.

```json
{
	"userId": 1,
	"apiKey": "abc123"
}
```

### Basic API Access

[examples/basic/](examples/basic) is a basic API integration for a single account.

Start the example server by doing `php -S localhost:8000 -t examples/basic` and navigate to <a href="http://127.0.0.1:8000/" target="_blank">127.0.0.1:8000</a>

### OAuth2 API Access

[examples/oauth2/](examples/oauth2) is an OAuth2 API integration.  Use this to get connected with multiple Acuity accounts.

Create a config file with your OAuth2 credentials to get started.  If you don't have OAuth2 credentials, please fill out this <a href="https://acuityscheduling.com/oauth2/register" target="_blank">registration form</a>.
Start the example server by doing `php -S localhost:8000 -t examples/oauth2` and navigate to <a href="http://127.0.0.1:8000/" target="_blank">127.0.0.1:8000</a>

##### Sample `examples/config.json`
```json
{
	"clientId": "N4HgVZbjHVp3HAkR",
	"clientSecret": "H33vYz88sEiKVbl7EMob1URDrqZrvceSCMmZJpAi",
	"redirectUri": "http://127.0.0.1:8000/oauth2"
}
```

### Webhooks

[examples/webhooks/](examples/webhooks) is a sample webhook integration.

Start the example server by doing `php -S localhost:8000 -t examples/webhooks` and navigate to <a href="http://127.0.0.1:8000/" target="_blank">127.0.0.1:8000</a>

### Custom Sidebar

[examples/custom-sidebar/](examples/custom-sidebar) allows you to display custom information in the appointment details sidebar.

Start the example server by doing `php -S localhost:8000 -t examples/custom-sidebar` and navigate to <a href="http://127.0.0.1:8000/" target="_blank">127.0.0.1:8000</a>
