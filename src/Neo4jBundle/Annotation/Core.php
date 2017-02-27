<?php

/**
 * Created by PhpStorm.
 * User: antho
 * Date: 25/02/2017
 * Time: 14:09
 */

namespace Neo4jBundle\Annotation;


use Doctrine\ORM\Mapping\Annotation;

/**
 * Class Core
 * @package Neo4jAccesBundle\Annotation
 * Read the anotation of Core property
 */

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Core
{
    /** contains boolean for collection type */
    public $collection;

    /** contains name of each class contains in the collection*/
    public $name;
}