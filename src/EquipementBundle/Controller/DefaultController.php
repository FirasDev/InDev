<?php

namespace EquipementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/shop", name="shop")
     */
    public function indexAction()
    {
        return $this->render('EquipementBundle:Default:index.html.twig');
    }
}
