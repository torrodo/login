<?php

namespace LoginProject\Bundle\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Handles actions related to homepage.
 */
class IndexController extends Controller
{
    public function indexAction(Request $request)
    {    	
        return  $this->stream('LoginProjectHomeBundle:Index:index.html.twig');
    }

    public function adminAction(Request $request)
    {
        return  $this->stream('LoginProjectHomeBundle:Index:admin.html.twig');
    }
}
