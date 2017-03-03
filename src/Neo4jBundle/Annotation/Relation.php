<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 28/02/2017
 * Time: 09:31
 */

namespace Neo4jBundle\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;
use Doctrine\ORM\Mapping\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Relation
{

    public $nameDb;

    public $nameRel;

    public $multiple;

    public $target;

}