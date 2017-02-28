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

        $use = "use Neo4jBundle\\Annotation\\Identifier; \n use Neo4jBundle\\Entity\\GlobalEntity; \n";
        $contenuClass = "/** \n *@Identifier() \n */ \n private \$id;\n";
        $contenuClass .= "public function __construct() \n { \n  parent::__construct(); \n  } \n";
        $newClassName = explode("\\", $className);
        $newClassName = array_pop($newClassName);
        if (!class_exists($this->basePath . "\\" . $newClassName)) {
            $content = "<?php \n";
            $content .= "namespace " . $this->basePath . ";\n";
            $content .= $use;
            $content .= "class " . $newClassName . " extends GlobalEntity\n";
            $content .= "{";
            $content .= "\n";
            $content .= $contenuClass;
            $content .= "}";
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
            /**
             * Todo Creat and fill the new Relation
             */
        }
    }

    public function creeRelation($readerProperty, $path)
    {

        $pathRel = "AppBundle\\Relation";
        $pathRelation = "\\".$pathRel. "\\".$readerProperty->nameRel;
        $use = "use Neo4jBundle\\Entity\\GlobalRelation; \n";
        $contenuClass = "public function __construct() \n { \n  parent::__construct(); \n  } \n";
        if (!class_exists($pathRelation)) {
            $content = "<?php \n";
            $content .= "namespace " . $pathRel . ";\n";
            $content .= $use;
            $content .= "class " . $readerProperty->nameRel . " extends GlobalRelation\n";
            $content .= "{";
            $content .= "\n";
            $content .= $contenuClass;
            $content .= "}";
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