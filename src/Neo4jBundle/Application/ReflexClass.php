<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 27/02/2017
 * Time: 16:13
 */

namespace Neo4jBundle\Application;


class ReflexClass
{

    /** @var  ReflexClass $reflexionClass */
    private $reflexionClass;

    /** @var  string $path */
    private $path;

    /**
     * ReflexClass constructor.
     * @param string $path
     */
    public function __construct($path)
    {
       dump($path);
       die();
    }


}