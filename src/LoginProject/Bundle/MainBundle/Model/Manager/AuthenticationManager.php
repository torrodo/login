<?php

namespace LoginProject\Bundle\MainBundle\Model\Manager;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use LoginProject\Bundle\MainBundle\Entity\CurrentUser;
use LoginProject\Bundle\MainBundle\Model\Exception\AuthenticationFailedException;

/**
 * Handles user authentication based on TokenInterface.
 */
class AuthenticationManager
{
    /**
     * @var SecurityContextInterface
     */
	protected $securityContext;

    /**
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

	/**
     * Authenticate user by request against repository and creates its credentials.
     *
     * @param Request $request
     * @param RegistryInterface $storage
     *
     * @throws AuthenticationFailedException
     */
	public function authenticateByRequest(Request $request, RegistryInterface $storage)
	{
	    $user = $storage
                ->getRepository('LoginProjectMainBundle:CurrentUser')
                ->loadUserByUsernameAndPassword(
                    $request->get('username'),
                    $request->get('password')
        );

	    if (!$user instanceof CurrentUser) {
	    	throw new AuthenticationFailedException('authentication failed, wrong username or password');
	    }

        $token = new UsernamePasswordToken($user, null, 'default', $user->getRoles());
        $this->securityContext->setToken($token);
	}

    /**
     * Removes user authentication and clear its credentials.
     *
     * @param Request $request
     * @param Response $response
     *
     * @throws AuthenticationFailedException
     */
    public function clearCredentials(Request $request, Response $response)
    {
        $request->getSession()->invalidate();
        $this->securityContext->setToken(null);
    }

    /**
     * Get token from security context.
     *
     * @return TokenInterface
     */
    public function getToken() 
    {
        return $this->securityContext->getToken();
    }

    /**
     * Get the current user of the application.
     *
     * @return CurrentUser|null
     */
    public function getUser() 
    {
        $user = $this->securityContext->getToken()->getUser();

        return ($user instanceof CurrentUser ? $user : null);
    }

    /**
     * Checks whether the current user is authenticated or not.
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        $user = $this->securityContext->getToken()->getUser();

        return ($user instanceof CurrentUser);
    }

    /**
     * Checks whether the current user has the specified permission.
     *
     * @param string $role
     *
     * @return bool
     */
    public function hasRole($role) 
    {
        return $this->securityContext->isGranted($role);
    }
}