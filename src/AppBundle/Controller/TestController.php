<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TestController extends Controller
{

    /**
     * @Route("/app", name="try_app")
     */
    public function CreeAppAction()
    {

        $app = $this->get('neo4j.application');
        $app->generateApp();
        die();
    }

    /**
     * @Route("/test", name="try_test")
     */
    public function TestStructure()
    {
        $personne = new Person();
        $personne1 = new Person();
        dump($personne);
        die();
    }
}
