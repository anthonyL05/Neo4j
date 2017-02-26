<?php

namespace Neo4jBundle\Service;



class App
{

    private $app;

    public function __construct($app)
    {
        $coreApp = new $app();
        dump($coreApp);
        die();

    }
}