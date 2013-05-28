<?php

namespace BgvSessionDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="BgvSessionDoctrine\Repository\SessionRepository")
* @ORM\Table(name="BgvSessionDoctrine_Session")
*/
class Session
{
    /**
     * @var string
     * @ORM\Column(type="string", length=32,  nullable=false)
     */
    protected $id = '';

    /**
     * @var integer
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    protected $modified;

    /**
     * @var integer
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    protected $lifetime;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $data;

    /**
     * @var string
     * @ORM\Column(type="string", length=255,  nullable=false)
     */
    protected $name = 'PHPSESSID';

    /**
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $lifetime
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;
    }

    /**
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}