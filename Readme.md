# Acuity PHP Tool Kit

## Examples

### Basic

[examples/basic](examples/basic) is a basic API integration fo ra single account.

Create a config file with your [API credentials](https://secure.acuityscheduling.com/app.php?key=api&action=settings) to get started.
Start the example server by doing `php -S localhost:8000 -t examples/basic` and navigate to http://127.0.0.1:8000/

`examples/basic/config.js`
```json
{
	"userId": 1,
	"apiKey": "abc123"
}
```

### OAuth2

[examples/oauth2](examples/oauth2) is an OAuth2 API integration.  Use this to connect multiple accounts.

Create a config file with your OAuth2 credentials to get started.
Start the example server by doing `php -S localhost:8000 -t examples/oauth2` and navigate to http://127.0.0.1:8000/

`examples/oauth2/config.js`
```json
{
	"clientId": "N4HgVZbjHVp3HAkR",
	"clientSecret": "H33vYz88sEiKVbl7EMob1URDrqZrvceSCMmZJpAi",
	"redirectUri": "http://127.0.0.1:8000/oauth2"
}
```

### Custom Sidebar

[examples/custom-sidebar](examples/custom-sidebar) allows you to display custom information in the appointment details sidebar.

Create a config file with your [API key](https://secure.acuityscheduling.com/app.php?key=api&action=settings) credentials to get started.
Start the example server by doing `php -S localhost:8000 -t examples/custom-sidebar` and navigate to http://127.0.0.1:8000/

`examples/custom-sidebar/config.js`
```json
{
	"apiKey": "abc123"
}
```

### Webhooks

[examples/webhooks](examples/webhooks) is a sample webhook integration.

Create a config file with your [API key](https://secure.acuityscheduling.com/app.php?key=api&action=settings) credentials to get started.
Start the example server by doing `php -S localhost:8000 -t examples/webhooks` and navigate to http://127.0.0.1:8000/

`examples/webhook/config.js`
```json
{
	"apiKey": "abc123"
}
```
