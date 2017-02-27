<?php

/**
 * Created by PhpStorm.
 * User: antho
 * Date: 26/02/2017
 * Time: 21:12
 */

namespace Neo4jBundle\Annotation\Reader;
use Doctrine\Common\Annotations\AnnotationReader;

class Reader
{

    /** @var  \ReflectionClass $reflexionClass */
    private $reflexionClass;


    /** @var  AnnotationReader $annotationReader */
    private $annotationReader;


    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();
    }



    public function generateCore()
    {
        foreach($this->reflexionClass->getProperties() as $property) {
            $readerProperty = $this->annotationReader->getPropertyAnnotation($property, 'Neo4jBundle\Annotation\Core');
            if ($readerProperty) {
                dump($readerProperty);
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