<?php

namespace Test\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CityArea
 *
 * @ORM\Table(name="city_area")
 * @ORM\Entity(repositoryClass="Test\MyBundle\Entity\CityRepository")
 */
class CityArea
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="City")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="CityArea", type="string", length=255)
     */
    private $cityArea;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param integer $city
     * @return CityArea
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return integer 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set cityArea
     *
     * @param string $cityArea
     * @return CityArea
     */
    public function setCityArea($cityArea)
    {
        $this->cityArea = $cityArea;

        return $this;
    }

    /**
     * Get cityArea
     *
     * @return string 
     */
    public function getCityArea()
    {
        return $this->cityArea;
    }
}
