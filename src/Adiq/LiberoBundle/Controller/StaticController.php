<?php

namespace Adiq\LiberoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Static Pages controller.
 *
 * @Route("/")
 */
class StaticController extends Controller
{

    /**
     * Landing/Splash page
     *
     * @Route("/", name="splash")
     * @Method("GET")
     * @Template("AdiqLiberoBundle::splash.html.twig")
     */
    public function indexAction()
    {
        return [];
    }
}
