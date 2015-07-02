<?php

namespace LoginProject\Bundle\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Session\Session;

class IndexControllerTest extends WebTestCase
{
    /**
     * Test user not authenticated flow.
     */
    public function testNotAuthenticatedLoad()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // fails loading page because login required
        $this->assertFalse(
            $crawler
                ->filter('html:contains("You must see this page only if you are authenticated.")')
                ->count() > 0
        );

        // when not authenticated, redirect expected
        $this->assertTrue(
            $client->getResponse()->isRedirect('/user/auth')
        );
    }

    /**
     * Test user authenticated flow.
     */
    public function testAuthenticatedLoad()
    {
        // tmp setup
        return;

        // set session token
        $user = new \LoginProject\Bundle\UserBundle\Entity\User();
        $user->setUsername('test');
        $user->setPassword('test');
        $token = new UsernamePasswordToken($user, null, 'default', $user->getRoles());

        // set session
        $client = static::createClient();
        $session = $client->getContainer()->get('session');
        $session->setName('PHPSESSID');
        $session->setId(md5('user_login_test'));
        $session->set('user_login', serialize($token));
        $session->save();

        // load homepage
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
        $crawler = $client->request('GET', '/');

        // loading page ok
        $this->assertGreaterThan(
            0,
            $crawler
                ->filter('html:contains("You must see this page only if you are authenticated.")')
                ->count()
        );
    }
}
