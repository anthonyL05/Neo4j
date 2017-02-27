<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 27/02/2017
 * Time: 12:38
 */

namespace Neo4jBundle\Application;


use Doctrine\Common\Collections\ArrayCollection;

class File
{

    /** @var  string $corePath */
    private $corePath;
    /** @var  ArrayCollection $paths */
    private $paths;

    /**
     * File constructor.
     * @param $corePath
     */
    public function __construct($corePath)
    {
        $this->corePath = $corePath;
        $this->getBasePath();
    }

    public function checkClass($className)
    {

        $className = $this->getBasePath()."\\".$className;
        if($className == $this->corePath)
        {
            /**
             * Todo exeption Core cant refer to Core
             */
        }
        else
        {
            if(!$this->containPaths($className))
            {
                $this->createClass($className);
            }
        }
    }


    public function createClass($className)
    {
        $newClass = fopen('../src'.$className.".php", 'r+');
        fputs($newClass,"test");
        fclose($newClass);
    }


    public function getBasePath()
    {
        $basePath = explode("\\",$this->corePath);
        array_pop($basePath);
        $this->basePath = implode("\\",$basePath);
    }

    /**
     * @return ArrayCollection
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * @param  $paths
     */
    public function addPaths($paths)
    {
        $this->paths->add($paths);
    }

    /**
     * @param  $paths
     */
    public function removePaths($paths)
    {
        $this->paths->removeElement($paths);
    }


    public function containPaths($paths)
    {
        return $this->paths->contains($paths);
    }

}