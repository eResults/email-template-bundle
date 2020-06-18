## Configuration

The service that loads and renders email is called 'Loader'. 

Default loader is Twig, you can access it as shown below

```php 
$this->get('eresults_email_template.loader')
    ->load('AcmeDemoBundle::my_template.html.twig')
;
```
>**'eresults_email_template.loader'** is just an alias to the twig, object or any other loader 
>depending on the settings in app/config/config.yml (See below)

You can change default loader in  ```app/config/config.yml``` file

```yml
# default value is 'eresults_email_template.loader.twig'
eresults_email_template:
    default_loader: service_name
```

---

### There are 3 loaders available at the moment:

* Twig (Renders emails from Twig templates)

```php 
$this->get('eresults_email_template.loader.twig')
    ->load('AcmeDemoBundle/my_template.html.twig', $params)
;
```

* Object (Useful rendering emails from database or just objects)

```php 
$this->get('eresults_email_template.loader.object')
    ->load($entity, $params)
;
```

* Chain (Makes possible to chain many loaders. See example below)

```
# app/config/config.yml
services:
    # This loader will be used first
    email_template.loader.doctrine:
        class: Acme\DemoBundle\Email\DoctrineLoader
        public: false
        tags: [{name: eresults_email_template.chain_loader}]
        arguments: ["@doctrine.orm.entity_manager"]
    # Second loader
    email_template.loader.twig:
        class: eResults\EmailTemplateBundle\Loader\TwigLoader
        public: false
        tags: [{name: eresults_email_template.chain_loader}]
        arguments: ["@twig"]

eresults_email_template:
    default_loader: eresults_email_template.loader.chain
```

Custom Loader:

```php
<?php

namespace Acme\DemoBundle\Email;

use eResults\EmailTemplateBundle\Loader\LoaderInterface;
use eResults\EmailTemplateBundle\Loader\LoaderException;
use eResults\EmailTemplateBundle\Template\EmailTemplateInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineLoader implements LoaderInterface
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function load($templateName, array $parameters = []): EmailTemplateInterface
    {
        $template = $this->em->getRepository('Email')->findOneBy([
            'name' => $templateName,
        ]);

        if (!$template instanceof EmailTemplateInterface) {
            throw new LoaderException(sprintf('Could not load "%s" template.', $templateName));
        }

        return $template;
    }
}
```


