Email Templates Bundle for Symfony2
=======================

This bundle can be useful when you need to send diffrent kind of emails from your app, for eg. user registration or forgot password email. Read usage section.

[![Build Status](https://travis-ci.org/mathewpeterson/EmailTemplateBundle.svg)](https://travis-ci.org/mathewpeterson/EmailTemplateBundle)

## Installation

### Add bundle via composer (Symfony 2.1)

```bash
composer req eresults/email-template-bundle
```

### Add bundle to your application kernel

```php
// app/AppKernel.php
public function registerBundles() 
{
    $bundles = array(
        // ...
        new eResults\EmailTemplateBundle\eResultsEmailTemplateBundle(),
    );
}
```

## Usage

- Create registration email template in your app

```
templates/email/user_registered.html.twig
```

- Edit template

```html
// templates/email/user_registered.html.twig
{% extends '@eResultsEmailTemplateBundle/email.html.twig' %}

{% block from -%}
example@example.org
{%- endblock %}

{% block subject -%}
Thanks for registering {{ first_name }}!
{%- endblock %}

{% block body -%}
Hello {{ first_name }},
<br />
<br />
Thank you for registering at our website! below your account details:
<br />
<br />
First Name: {{ first_name }}<br />
Last Name: {{ last_name }}<br />
Email: {{ email }}<br />
<br />
Thanks
{%- endblock %}
```
- Now you can send it from your controller

```php
<?php
// ...
class UserController extends Controller
{
    public function registerAction(LoaderInterface $loader, \Swift_Mailer $mailer) {
        // ...
        if ($form->isValid()) {
            //.. handle your form
            $formData = array(
                'email' => 'johndoe@example.com',
                'first_name' => 'John',
                'last_name' => 'Doe',
            );

            $template = $loader->load('email/user_registered.html.twig', $formData);
            $message = \Swift_Message::newInstance()
                ->setSubject($template->getSubject())
                ->setFrom($template->getFrom())
                ->setBody($template->getBody(), 'text/html')
                ->setTo($formData['email'])
            ;

            $mailer->send($message);
        }
    }
}
```
Thats's it! John Doe will receive an email as below:

```html
Hello John,
Thank you for registering at our website! below your account details:

First Name: John
Last Name: Doe
Email: johndoe@example.com

Thanks
```

## Advanced Usage

* [Configuration](./docs/config.md).
* [How to use templates with database (Doctrine)](./docs/doctrine.md).
