<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 27/02/2017
 * Time: 12:38
 */

namespace Neo4jBundle\Application;


use AppBundle\Entity\Person;
use Doctrine\Common\Collections\ArrayCollection;

class File
{

    /** @var  string $corePath */
    private $corePath;
    /** @var  ArrayCollection $paths */
    private $paths;
    /** @var  ArrayCollection $relationPath */
    private $relationPath;

    private $basePath;

    /**
     * File constructor.
     * @param $corePath
     */
    public function __construct($corePath)
    {
        $this->corePath = $corePath;
        $this->paths = new ArrayCollection();
        $this->relationPath = new ArrayCollection();
        $this->initBasePath();
    }

    public function checkClass($className)
    {
        $className = $this->basePath . "\\" . $className;
        if ($className == $this->corePath) {
            /**
             * Todo exeption Core cant refer to Core
             */
        } else if (!$this->containPaths($className)) {
            $className = $this->createClass($className);
            $nameClass = "\\" . $this->basePath . "\\" . $className;
            return $nameClass;

        }
    }


    public function createClass($className)
    {


        $newClassName = explode("\\", $className);
        $newClassName = array_pop($newClassName);

        if (!class_exists($this->basePath . "\\" . $newClassName)) {
            $id = "\$id";
            $this->basePath = substr($this->basePath,1);
            $content = <<<EOF
<?php

namespace $this->basePath;

use Neo4jBundle\\Annotation\\Identifier;
use Neo4jBundle\\Entity\\GlobalEntity; 

class $newClassName extends GlobalEntity
{

    /**
      *@Identifier() 
      */ 
    private $id;
    
    
    public function __construct(){
        parent::__construct();
    }
}
EOF;

            $newClass = fopen('..\\src\\' . $this->basePath . "\\" . $newClassName . ".php", 'a+');
            fputs($newClass, $content);
            fclose($newClass);
            call_user_func(array($this, 'loadRelation'),array("\\".$className));
        }
        $this->addPaths($newClassName);
        return $newClassName;

    }


    public function checkRelation($readerProperty, $path)
    {
        $pathRelation = "\\AppBundle\\Relation\\" . $readerProperty->nameRel;
        if (!$this->containRelationPaths($readerProperty->nameRel))
        {
            $this->creeRelation($readerProperty, $path);
            $rel = new $pathRelation();
            dump($rel);
            die();
        }
    }

    public function creeRelation($readerProperty, $path)
    {





        $pathRel = "AppBundle\\Relation";
        $pathRelation = "\\".$pathRel. "\\".$readerProperty->nameRel;
        if (!class_exists($pathRelation)) {
            $content = <<<EOF
<?php

namespace $pathRel ;

use Neo4jBundle\\Entity\\GlobalRelation;

class $readerProperty->nameRel extends GlobalRelation
{
    public function __construct(){
        parent::__construct();
    }
}
EOF;
            $newClass = fopen('..\\src' . $pathRelation . ".php", 'a+');
            fputs($newClass, $content);
            fclose($newClass);
            call_user_func(array($this, 'loadRelation'),array($pathRelation));
        }
        $this->addRelationPaths($readerProperty->nameRel);
    }

    function loadRelation($pathRelation)
    {
        $pathRelation = substr($pathRelation[0],1);
        $pathRelation = "\\".$pathRelation;
        $this->__autoload($pathRelation,true);
    }

    public function initBasePath()
    {

        $basePath = explode("\\", $this->corePath);
        array_pop($basePath);
        $this->basePath = implode("\\", $basePath);
    }

    public function __autoload($class_name,$rel = false)
    {
        if($rel == true)
        {
            $className = '..\\src\\' . $class_name;
        }
        else
        {
            $className = '..\\src\\' . $this->basePath . "\\" . $class_name;
        }
        include $className . '.php';

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

    /**
     * @return ArrayCollection
     */
    public function getRelationPaths()
    {
        return $this->relationPath;
    }

    /**
     * @param  $relationPath
     */
    public function addRelationPaths($relationPath)
    {
        $this->paths->add($relationPath);
    }

    /**
     * @param  $relationPath
     */
    public function removeRelationPaths($relationPath)
    {
        $this->paths->removeElement($relationPath);
    }


    public function containRelationPaths($relationPath)
    {
        return $this->relationPath->contains($relationPath);
    }

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param mixed $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }


}