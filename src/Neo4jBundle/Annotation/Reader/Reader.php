<?php

/**
 * Created by PhpStorm.
 * User: antho
 * Date: 26/02/2017
 * Time: 21:12
 */

namespace Neo4jBundle\Annotation\Reader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;
use Neo4jBundle\Application\File;
use Neo4jBundle\Application\ReflexClass;

class Reader
{

    /** @var  \ReflectionClass $reflexionClass */
    private $reflexionClass;

    /** @var  ArrayCollection $reflexionLoad */
    private $reflexionLoad;

    /** @var  AnnotationReader $annotationReader */
    private $annotationReader;


    /** @var File $file */
    private $file;


    public function __construct($pathCore)
    {
        $this->file = new File($pathCore);
        $this->annotationReader = new AnnotationReader();
        $this->reflexionLoad = new ArrayCollection();
    }



    public function generateCore()
    {

        foreach ($this->reflexionClass->getProperties() as $property) {
            $readerProperty = $this->annotationReader->getPropertyAnnotation($property, 'Neo4jBundle\Annotation\Core');
            if ($readerProperty) {
                if ($readerProperty->collection == true) {

                    if ($readerProperty->name != null) {
                        $pathFile = $this->file->checkClass($readerProperty->name);
                        $this->reflexionLoad->add(new ReflexClass($pathFile));
                        $this->file->generateCollection($this->reflexionClass->name, $property,$pathFile);

                    } else {
                        /**
                         * Todo Return exeption the collection need to contains a name
                         */
                    }
                }
            }
        }


        foreach ($this->file->getPaths() as $path) {
            /** @var \ReflectionClass $reflexionClass */
            $reflexionClass = $this->getReflexionClassLoad($path);
            foreach ($reflexionClass->getProperties() as $property) {
                $readerProperty = $this->annotationReader->getPropertyAnnotation($property, 'Neo4jBundle\Annotation\Relation');
                if ($readerProperty) {
                    if ($readerProperty->nameDb == true) {
                        if ($readerProperty->nameRel != null) {
                            $this->file->checkRelation($readerProperty, $path);
                            $this->file->addCollection($readerProperty, $path, $property);
                        } else {
                            /**
                             * Todo return exeption a relation need to have a relation name
                             */
                        }
                    } else {
                        /**
                         * Todo return exeption a relation need to have a db name
                         */
                    }
                }
            }
        }
    }




    public function getReflexionClassLoad($path)
    {

        /** @var ReflexClass $reflexClass */
        foreach ($this->reflexionLoad as $reflexClass)
        {
            if($reflexClass->getPath() == $path)
            {
                return $reflexClass->getReflexionClass();
            }
        }
        $reflexClass = new ReflexClass($path);
        $this->reflexionLoad->add($reflexClass);
        return $reflexClass->getReflexionClass();
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