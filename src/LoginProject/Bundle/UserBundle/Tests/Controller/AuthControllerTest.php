<?php

namespace LoginProject\Bundle\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    /**
     * Successful authentication.
     */
    public function testAuthenticationOK()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/auth');
        $form = $crawler->selectButton('Login')->form(
            [
             'password' => 'test',
             'username' => 'test',
            ]
        );

        $client->submit($form);

        // when auth succeeded, redirects to homepage
        $this->assertTrue(
            $client->getResponse()->isRedirect('/')
        );
    }

    /**
     * Failed authentication.
     */
    public function testAuthenticationFail()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/auth');
        $form = $crawler->selectButton('Login')->form(
            [
             'password' => 'guest',
             'username' => 'guest',
            ]
        );

        $client->submit($form);

        // when auth fails, redirects to login page
        $this->assertTrue(
            $client->getResponse()->isRedirect('/user/auth')
        );
    }
}
