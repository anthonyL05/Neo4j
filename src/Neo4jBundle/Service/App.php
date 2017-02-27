<?php

namespace Neo4jBundle\Service;

use Neo4jBundle\Annotation\Reader\Reader;
use Neo4jBundle\Application\Core;

class App
{

    /**
     * Contain the core app
     */
    /** @var Core $core */
    private $core;

    public function __construct($app)
    {
        $coreApp = new $app();
        $reader = new Reader($app);
        $this->core = new Core($app,$coreApp,$reader);
    }

    public function generateApp()
    {
        $this->core->generate();
    }
}