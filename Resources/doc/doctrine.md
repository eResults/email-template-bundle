## How to use templates with database (Doctrine)

The example below implements Doctrine, but you can use any ORM, it's simple.

* Your entity must implement ```eResults\EmailTemplateBundle\Template\EmailTemplateInterface``` interface, see doctrine example below:

```php
<?php
// src/Acme/DemoBundle/Entity.php
namespace Acme\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use eResults\EmailTemplateBundle\Template\EmailTemplateInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="email_templates")
 */
class Email implements EmailTemplateInterface
{
    // implement interface methods
    // ...
}
```
Now you can load it

```php
<?php

class UserController extends Controller {
    public function registerAction() {
        // ...
        $em = $this->getDoctrine()->getEntityManager();

        if ($form->isValid()) {
            //.. some actions here
            $formData = array(
                'email' => 'johndoe@example.com',
                'first_name' => 'John',
                'last_name' => 'Doe',
            );

            $entity = $em->getRepository('AcmeDemoBundle:Email')->findOneBy(array(
                'name' => 'user_registered_email',
            ));
            if (null !== $entity) {
                $template = $this->get('eresults_email_template.loader.object')
                    ->load($entity, $formData)
                ;
            } else {
                $template = $this->get('eresults_email_template.loader.twig')
                    ->load('AcmeDemoBundle/Emails/user_registered.html.twig', $formData)
                ;
            }

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
That's it!, in the example above, if doctrine record is not found then it will fall to twig template. 
