<?php

namespace Events\Bundle\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventType
 *
 * @ORM\Table(name="eventtype")
 * @ORM\Entity
 */
class EventType {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
   
    /**
     * @var string
     * 
     * @ORM\Column(name="description",type="string") 
     * 
     */
    protected $description;

    /**
     * @var string
     * 
     * @ORM\Column(name="location", type="string") 
     */
    protected $location;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }    
    
    /**
     * Get Description
     * 
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set Description
     *
     * @param string $description 
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Get Location
     *
     * @return string 
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * Set Location
     *  
     * @param string $location 
     */
    public function setLocation($location) {
        $this->location = $location;
    }
    
}