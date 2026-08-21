# Getting Started With OkaPDPAuthorizationBundle

This bundle providing fine-grained authorization using an external Policy Decision Point (PDP).

## Prerequisites

The OkaPDPAuthorizationBundle has the following requirements:

 - PHP 8.0+
 - Symfony 7.4+

## Installation

Installation is a quick (I promise!) 4 step process:

1. Download OkaPDPAuthorizationBundle
2. Enable the Bundle
3. Configure the OkaPDPAuthorizationBundle
4. Use bundle and enjoy!

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require coka/pdp-authorization-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Register the Bundle

Then, register the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project (Flex did it automatically):

```php
return [
    //...
    new Oka\PDPAuthorizationBundle\OkaPDPAuthorizationBundle::class => ['all' => true],
]
```

### Step 3: Configure the Bundle

Add the following configuration to your `config.yml`.

```yaml
# app/config/config.yml
oka_pdp_authorization:
    open_policy_agent:
        policy_url: 'http://localhost:8181/v1/data/authz/allow'
        timeout: 1
        retry_max_attempts: 0
```

### Step 4: Use the bundle is simple

In Controllers :

```php
// App\Controller\FooController.php

//...

#[Route(name: 'admin', path: '/admin')]
#[IsGranted('policy.edit')]
public function admin(): Response
{
    return new Response('', 204);
}
```
