<?php

namespace LoginProject\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use LoginProject\Bundle\MainBundle\Model\Exception\AuthenticationFailedException;
use LoginProject\Bundle\MainBundle\Model\Manager\AuthenticationManager;

/**
 * Actions related to user authentication.
 */
class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function loginAction()
    {
        if ($this->get('main.auth.manager')->hasRole('ROLE_USER')) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('LoginProjectUserBundle:Auth:index.html.twig');
    }

    /**
     * Authenticate user & create credentials.
     */
    public function authAction(Request $request)
    {
        $authManager = $this->get('main.auth.manager');
        if ($authManager->hasRole('ROLE_USER')) {
            return $this->redirectToRoute('homepage');
        }

        try {
            $authManager->authenticateByRequest(
                $request, 
                $this->get('doctrine')
            );
        } catch (AuthenticationFailedException $e) {
            $errorMsg = $e->getMessage();

            return $this->redirectToRoute('user_login_page');
        } catch (\Exception $e) {
            $errorMsg = 'Authentication error, please try it later.';

            throw new AuthenticationException($errorMsg); 
        } finally {
            if (isset($errorMsg)) {
                $this->get('session')->getFlashBag()->add('error', $errorMsg);
            }
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * Logout user & remove credentials.
     */
    public function logoutAction(Request $request)
    {
        $response = new RedirectResponse($this->generateUrl('user_login_page'));
        $this->get('main.auth.manager')->clearCredentials($request, $response);

        return $response;
    }

}
