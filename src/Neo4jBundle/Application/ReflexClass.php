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

        $path = substr($path,1);
        $obj = new $path;
        $this->reflexionClass = new \ReflectionClass($obj);
        $this->path = $path;
    }

    /**
     * @return ReflexClass
     */
    public function getReflexionClass()
    {
        return $this->reflexionClass;
    }

    /**
     * @param ReflexClass $reflexionClass
     */
    public function setReflexionClass($reflexionClass)
    {
        $this->reflexionClass = $reflexionClass;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }




}