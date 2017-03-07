<?php

namespace Events\Bundle\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="name",type="string") 
     * 
     */
    protected $name;

    /**
     * @var string
     * 
     * @ORM\Column(name="start_time", type="string") 
     */
    protected $start_time;

    /**
     * @var string
     * 
     * @ORM\Column(name="end_time", type="string") 
     */
    protected $end_time;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Get Event Name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Set Event Name
     *
     * @return string
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get start time
     * 
     * @return string 
     */
    public function getStartTime() {
        return $this->start_time;
    }
    
    /**
     * Set start time
     *  
     * @param string $start_time 
     */
    public function setStartTime($start_time) {
        $this->start_time = $start_time;
    }

    /**
     *  Get End Time
     *
     * @return string 
     */
    public function getEndTime() {
        return $this->end_time;
    }

    /**
     * Set End Time
     * 
     * @param type $end_time 
     */
    public function setEndTime($end_time) {
        $this->end_time = $end_time;
    }

}
