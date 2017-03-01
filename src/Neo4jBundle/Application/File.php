<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 27/02/2017
 * Time: 12:38
 */

namespace Neo4jBundle\Application;


use AppBundle\Entity\Person;
use AppBundle\Relation\Friend;
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
        }else if (!$this->containPaths($className)) {
            $className = $this->createClass($className);
            $nameClass = "\\" . $this->basePath . "\\" . $className;


        }
        return $nameClass;
    }


    public function createClass($className)
    {

        $newClassName = explode("\\", $className);
        $newClassName = array_pop($newClassName);

        if (!class_exists($this->basePath . "\\" . $newClassName)) {
            $id = "\$id";
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
        $this->addPaths($this->basePath . "\\" . $newClassName);
        return $newClassName;

    }


    public function checkRelation($readerProperty, $path)
    {
        $pathRelation = "\\AppBundle\\Relation\\" . $readerProperty->nameRel;
        if (!$this->containRelationPaths($readerProperty->nameRel))
        {
            $this->creeRelation($readerProperty, $path);
        }
        $rel = new $pathRelation();

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
use Neo4jBundle\\Annotation\\RelationClass;

/**
 *@RelationClass(name = "$readerProperty->nameDb ")
 */
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

    public function addCollection($readerProperty,$path,$property)
    {
        $collectionPath = explode("\\",$path);
        array_pop($collectionPath);
        array_pop($collectionPath);
        $collectionPath = implode("\\",$collectionPath);
        $collectionPath .= "\\Relation\\".$readerProperty->nameRel;
        $useArrayCollection = "";
        if($readerProperty != "false")
        {

            $objFile = fopen('..\\src\\' . $path . ".php", 'a+');
            $contents = fread($objFile, filesize('..\\src\\' . $path . ".php"));
            $contents = explode("}",$contents);
            array_pop($contents);
            array_pop($contents);
            $fonctionContent = "";
            $getMethodeName = "get".ucfirst($property->name);
            $addMethodeName = "add".ucfirst($property->name);
            $removeMethodeName = "remove".ucfirst($property->name);

            $use = "";
            $rel = new $path();
            if(!method_exists($rel ,$getMethodeName ))
            {
                $thisReturn = "\$this->".$property->name;
                $getMethodeContent = <<<EOF
                
    public function $getMethodeName()
    {
        return $thisReturn;
    }
EOF;
                $fonctionContent .= $getMethodeContent;
            }
            if(!method_exists($rel ,$addMethodeName ))
            {
                $use = "use ".$collectionPath.";";
                $param = "\$".$property->name;
                $thisAction = "\$this->".$property->name."->add(".$param.")";
                $thisRetour = "\$this";
                $addMethodeContent = <<<EOF
                
    public function $addMethodeName($readerProperty->nameRel $param)
    {
        $thisAction;
        return $thisRetour;
    }
EOF;
                $fonctionContent .= $addMethodeContent;
            }
            if(!method_exists($rel ,$removeMethodeName ))
            {
                $use = "use ".$collectionPath.";";
                $param = "\$".$property->name;
                $thisAction = "\$this->".$property->name."->remove(".$param.")";
                $thisRetour = "\$this";
                $removeMethodeContent = <<<EOF
                
    public function $removeMethodeName($readerProperty->nameRel $param)
    {
        $thisAction;
        return $thisRetour;
    }
EOF;
                $fonctionContent .= $removeMethodeContent;
            }
        $contents[] = $fonctionContent."\n";
        $contents = implode("}",$contents);
        $contents .= "\n }";
        $newArrayCollection = "\$this->".$property->name ." = new ArrayCollection();";
        if(!strstr($contents,$newArrayCollection))
        {
            $contents = str_replace("parent::__construct();", "parent::__construct();\r\n\t\t".$newArrayCollection, $contents);
            $useArrayCollection = "use Doctrine\\Common\\Collections\\ArrayCollection;";
        }
        if($use != "")
        {
            if(!strstr($contents,$use))
            {
                if(strstr($contents,"use Neo4jBundle\\Entity\\GlobalEntity;"))
                {
                    $replace = <<<EOF
use Neo4jBundle\\Entity\\GlobalEntity;
$use
$useArrayCollection
EOF;
                    $contents = str_replace("use Neo4jBundle\\Entity\\GlobalEntity;", $replace, $contents);
                }
            }
        }
        file_put_contents('..\\src\\' . $path . ".php",$contents);
        }
        else
        {
            /**
             * Todo create normal getter setter and condition
             */
        }
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
        $this->relationPath->add($relationPath);
    }

    /**
     * @param  $relationPath
     */
    public function removeRelationPaths($relationPath)
    {
        $this->relationPath->removeElement($relationPath);
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