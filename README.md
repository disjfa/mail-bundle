# Mail bundle

[![Check on packagist][packagist-badge]][packagist]
[![MIT License][license-badge]][LICENSE]

[![Watch on GitHub][github-watch-badge]][github-watch]
[![Star on GitHub][github-star-badge]][github-star]
[![Tweet][twitter-badge]][twitter]

### Why is this bundle here

...

### Instalation

```
composer require disjfa/mail-bundle
```

### Setup the interface

Setup the routes in `config/routes/disjfa_mail.yaml`. Here you can edit emails setup in your application.

```yaml
disjfa_mail:
    resource: '@DisjfaMailBundle/Controller/'
    type: annotation
    prefix: '/admin'
```

### Make you own template

Create a class that extends the `MailInterface`. Implement the name, subject and content as you want. You can inject the `Translator` to add simple translations or the twig `Environment` to render out templates.

```php
<?php
namespace Disjfa\MailBundle\Mail;

interface MailInterface
{
    public function getName();
    public function getSubject();
    public function getContent();
}
```

In your templates there should be no twig variables. Escape those, like this: `{{ '{{' }} email {{ '}}' }}`. All the variables used are parsed and collected. The original variables are the only ones that should be used.

If you made a class it will be autoload in the `MailCollection` collection. And so editable if you have set up some routes for the interface.

### Sending emails

Next up is sending emails. In your code just make a message or function that sets up the email.

```php
use Disjfa\MailBundle\Mail\MailFactory;
use Disjfa\MailBundle\Mail\MailService;

function myFunction(MailFactory $mailFactory, MailService $mailService)
{
    $mail = $mailFactory->findByName('name');
    $mailService->send($mail, [
         'param1' => 'value',
         'param2' => 'value',
    ], 'info@example.com');
}
```

And done! Mail sent. Now it is time to setup emails and make more in your application.

### Extend the templates

...

### Enjoy!

Use the bundle. Check what the bundle does. Fork. Make your own. This is here just to make live easier for us all. Make something beautiful.

[packagist-badge]: https://img.shields.io/packagist/php-v/disjfa/mail-bundle
[packagist]: https://packagist.org/packages/disjfa/mail-bundle
[license]: https://github.com/disjfa/mail-bundle/blob/master/LICENSE
[license-badge]: https://img.shields.io/github/license/disjfa/mail-bundle.svg
[github-watch-badge]: https://img.shields.io/github/watchers/disjfa/mail-bundle.svg?style=social
[github-watch]: https://github.com/disjfa/mail-bundle/watchers
[github-star-badge]: https://img.shields.io/github/stars/disjfa/mail-bundle.svg?style=social
[github-star]: https://github.com/disjfa/mail-bundle/stargazers
[twitter-badge]: https://img.shields.io/twitter/url/https/github.com/disjfa/mail-bundle.svg?style=social
[twitter]: https://twitter.com/intent/tweet?text=Check%20out%20mail-bundle!%20-%20Cool%mail%20templates%20for%20symfony%20template!%20Thanks%20@disjfa%20https://github.com/disjfa/mail-bundle%20%F0%9F%A4%97

