<?php

namespace LoginProject\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use LoginProject\Bundle\UserBundle\Form\UserType;
use LoginProject\Bundle\UserBundle\Entity\User;

/**
 * Handles actions related to user registration.
 */
class RegisterController extends Controller
{
    /**
     * Display the registration form.
     */
    public function indexAction()
    {
        if ($this->get('main.auth.manager')->hasRole('ROLE_USER')) {
            return $this->redirectToRoute('homepage');
        }

        $form = $this->createForm(
            new UserType(),
            new User(),
            ['action' => $this->generateUrl('user_register')]
        );

        return $this->render(
            'LoginProjectUserBundle:Register:index.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Register user after submitting data.
     */
    public function saveAction(Request $request)
    {
        if ($this->get('main.auth.manager')->hasRole('ROLE_USER')) {
            return $this->redirectToRoute('homepage');
        }

        $form = $this->createForm(
            new UserType(),
            new User(),
            ['action' => $this->generateUrl('user_register')]
        );

        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $user = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this
                    ->get('session')
                    ->getFlashBag()
                    ->add('info', 'Registration successful, pls login into your new account!');

                return $this->redirectToRoute('homepage');
            } catch (\Exception $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render(
            'LoginProjectUserBundle:Register:index.html.twig',
            ['form' => $form->createView()]
        );
    }
}
