<?php

namespace Neo4jBundle\Service;



use AppBundle\Entity\CoreApp;

class App
{

    private $app;

    public function __construct($app)
    {
        $core = "AppBundle\\Entity\\CoreApp";
        $coreApp = new $app();
        dump($coreApp);
        die();

    }
}