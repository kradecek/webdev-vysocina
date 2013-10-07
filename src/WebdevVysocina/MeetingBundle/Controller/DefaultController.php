<?php

namespace WebdevVysocina\MeetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        $defaultData = array('email' => '@');
        $form = $this->createFormBuilder($defaultData)
                ->add('name', 'text', array(
                    'label' => 'Vaše jméno',
                    'constraints' => array(
                        new NotBlank())))
                ->add('email', 'email', array(
                    'label' => 'E-mail',
                    'constraints' => array(
                        new Email())))
                ->add('message', 'textarea', array(
                    'label' => 'Zpráva',
                    'attr' => array('placeholder' => 'Napište nám'),
                    'constraints' => array(
                        new NotBlank())))
                ->add('send', 'submit', array('label' => 'Odeslat'))
                ->getForm();

        $form->handleRequest($request);
        
        if ($form->isValid()) {

            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();


            $message = \Swift_Message::newInstance()
                ->setSubject('WebDev Vysočina')
                ->setFrom($data['email'])
                ->setTo('kradecek@gmail.com')
                ->setBody($data['message']);
            
            if ($this->get('mailer')->send($message)) {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Email byl odeslán!'
                );
            }
        }

        return $this->render('WebdevVysocinaMeetingBundle:Default:index.html.twig', array('contactForm' => $form->createView()));
    }

}
