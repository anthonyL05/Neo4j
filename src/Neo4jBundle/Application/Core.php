<?php

/**
 * Created by PhpStorm.
 * User: antho
 * Date: 27/02/2017
 * Time: 09:00
 */

namespace Neo4jBundle\Application;


use Neo4jBundle\Annotation\Reader\Reader;

/**
 * Class Core
 */
class Core
{

    /**
     * Contain the path of the core class
     */
    private $path;

    /**
     * contain the core app
     */
    private $app;

    /**
     * @var Reader $reader
     */
    private $reader;

    private $reflexionClass = null;

    /**
     * core constructor.
     * @param $path
     * @param $app
     * @param $reader
     */
    public function __construct($path, $app,Reader $reader)
    {
        $this->path = $path;
        $this->app = $app;
        $this->reflexionClass = new \ReflectionClass($this->app);
        $reader->setReflexionClass($this->reflexionClass);
        $this->reader = $reader;

    }

    public function generate()
    {
        $this->reader->generateCore();
        dump($this);
        die();
    }








}