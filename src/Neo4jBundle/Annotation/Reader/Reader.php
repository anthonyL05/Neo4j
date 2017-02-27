<?php

/**
 * Created by PhpStorm.
 * User: antho
 * Date: 26/02/2017
 * Time: 21:12
 */

namespace Neo4jBundle\Annotation\Reader;
use Doctrine\Common\Annotations\AnnotationReader;
use Neo4jBundle\Application\File;

class Reader
{

    /** @var  \ReflectionClass $reflexionClass */
    private $reflexionClass;


    /** @var  AnnotationReader $annotationReader */
    private $annotationReader;


    /** @var File $file */
    private $file;


    public function __construct($pathCore)
    {
        $this->file = new File($pathCore);
        $this->annotationReader = new AnnotationReader();
    }



    public function generateCore()
    {
        foreach($this->reflexionClass->getProperties() as $property) {
            $readerProperty = $this->annotationReader->getPropertyAnnotation($property, 'Neo4jBundle\Annotation\Core');
            if ($readerProperty) {
                if($readerProperty->collection == true)
                {
                    if($readerProperty->name != null)
                    {
                        $this->file->checkClass($readerProperty->name);
                    }
                    else
                    {
                        /**
                         * Todo Return exeption collection doit posséder un nom
                         */
                    }
                }
            }
        }
    }




    /**
     * @return mixed
     */
    public function getReflexionClass()
    {
        return $this->reflexionClass;
    }

    /**
     * @param mixed $reflexionClass
     */
    public function setReflexionClass($reflexionClass)
    {
        $this->reflexionClass = $reflexionClass;
    }


}