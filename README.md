Email Templates Bundle for Symfony2
=======================

This bundle can be useful when you need to send diffrent kind of emails from your app, for eg. user registration or forgot password email. Read usage section.

[![Build Status](https://travis-ci.org/mathewpeterson/EmailTemplateBundle.svg)](https://travis-ci.org/mathewpeterson/EmailTemplateBundle)

## Installation

### Add bundle via composer (Symfony 2.1)

```bash
php composer.phar require sfk/email-template-bundle:dev-master
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

- Create registration email template in your bundle

```
src/Acme/DemoBundle/Resources/views/[Emails]/user_registered.html.twig
```

- Edit template

```html
// src/Acme/DemoBundle/Resources/views/[Emails]/user_registered.html.twig
{% extends 'SfkEmailTemplateBundle::email.html.twig' %}

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
class UserController extends Controller {
    public function registerAction() {
        // ...
        if ($form->isValid()) {
            //.. some actions here
            $formData = array(
                'email' => 'johndoe@example.com',
                'first_name' => 'John',
                'last_name' => 'Doe',
            );
            $template = $this->get('sfk_email_template.loader')
                ->load('AcmeDemoBundle:Emails:user_registered.html.twig', $formData)
            ;
            $message = \Swift_Message::newInstance()
                ->setSubject($template->getSubject())
                ->setFrom($template->getFrom())
                ->setBody($template->getBody(), 'text/html')
                ->setTo($formData['email'])
            ;
            // send email
            $this->get('mailer')->send($message);
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

* [Configuration](https://github.com/getme/EmailTemplateBundle/blob/master/Resources/doc/config.md).
* [How to use templates with database (Doctrine)](https://github.com/getme/EmailTemplateBundle/blob/master/Resources/doc/doctrine.md).

## Credits

This bundle was inspired by [Rendering emails with Twig in Symfony2](http://www.richsage.co.uk/2011/12/16/rendering-emails-with-twig-in-symfony2/) post. Many thanks to its author.
