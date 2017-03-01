<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 28/02/2017
 * Time: 10:26
 */

namespace Neo4jBundle\Entity;


class GlobalRelation
{
    private $beginNode;

    private $endNode;


    /**
     * GlobalRelation constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getBeginNode()
    {
        return $this->beginNode;
    }

    /**
     * @param mixed $beginNode
     */
    public function setBeginNode($beginNode)
    {
        $this->beginNode = $beginNode;
    }


    /**
     * @return mixed
     */
    public function getEndNode()
    {
        return $this->endNode;
    }

    /**
     * @param mixed $endNode
     */
    public function setEndNode($endNode)
    {
        $this->endNode = $endNode;
    }






}