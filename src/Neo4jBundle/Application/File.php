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

    private $basePath;

    /**
     * File constructor.
     * @param $corePath
     */
    public function __construct($corePath)
    {
        $this->corePath = $corePath;
        $this->paths = new ArrayCollection();
        $this->getBasePath();
    }

    public function checkClass($className)
    {
        $className = $this->basePath."\\".$className;
        if($className == $this->corePath)
        {
            /**
             * Todo exeption Core cant refer to Core
             */
        }
        else if(!$this->containPaths($className))
        {
            $className = $this->createClass($className);
            $nameClass = "\\".$this->basePath."\\".$className;
        }
    }


    public function createClass($className)
    {

        $use = "use Neo4jBundle\\Annotation\\Identifier; \n use Neo4jBundle\\Entity\\GlobalEntity; \n";
        $contenuClass = "/** \n *@Identifier() \n */ \n private \$id;\n";
        $contenuClass .= "public function __construct() \n { \n  parent::__construct(); \n  } \n";
        $newClassName = explode("\\",$className);
        $newClassName = array_pop($newClassName);
        if(!class_exists($this->basePath."\\".$newClassName)) {
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
            $this->addPaths($newClassName);
            $this->__autoload($className);
        }
        return $newClassName;

    }


    public function getBasePath()
    {

        $basePath = explode("\\",$this->corePath);
        array_pop($basePath);
        $this->basePath = implode("\\",$basePath);
    }

    public function __autoload($class_name)
    {
        $className = '..\\src\\'.$this->basePath."\\".$class_name;
        include $className.'.php';
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