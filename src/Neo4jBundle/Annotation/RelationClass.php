<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 01/03/2017
 * Time: 09:46
 */

namespace Neo4jBundle\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;
use Doctrine\ORM\Mapping\Annotation;

/**
 * @Annotation
 * @Target({"Class"})
 */
class RelationClass
{

    public $name;
}