# Simplicate - Rainforest Auth

A simple PHP port of Rainforest QA's Ruby auth gem which allows verification of [Rainforest](https://www.rainforestqa.com/) webhook messages using your private API key.

## Installation

Run `composer require simplicate/rainforest-auth` or add it to your `composer.json` manually:

    {
      "require": {
        "simplicate/rainforest-auth": "^1.0"
      }
    }

## API key

The API key can be found under the [Accounts setting page](https://app.rainforestqa.com/settings/account). **Please note**: the token used MUST be the account owner his or her token!

## Examples

Checking if the signature is valid:

```php
$apiKey = 'abc';

// Should be safe data from the $_POST var
$post = [
  'digest'        => 'abc',
  'callback_type' => 'before_run',
  'options'       => [
    'run_id' => 123123,
  ],
];

$auther = new \Simplicate\Rainforest\Auther($apiKey);

if(!$auther->verify($digest, $callbackType, $options)) {
  throw new \Exception('Could not verify that the request came from Rainforest');
}

// Everything's all right! Do your housekeeping.
```

If you have a job that's going to take longer than 25 seconds, [Rainforest advises](https://help.rainforestqa.com/developer-tools/integrations/webhooks#advanced-webhooks) you respond immediately with a 202 Accepted, and send a POST request when you're ready for Rainforest to continue:

```php
// Same payload as before

$callbackUrl = $auther->getCallbackUrl($post['options']['run_id'], $post['callback_type']);

// Make a POST request to this URL through php-curl, or your preferred HTTP client
```

## License
MIT License.

## Copyright
Copyright (c) 2018 Simplicate Software B.V.
