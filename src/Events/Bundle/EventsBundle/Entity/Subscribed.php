<?php

namespace Events\Bundle\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Events\Bundle\EventsBundle\Entity\Event;
use Events\Bundle\EventsBundle\Entity\EventType;
use Events\Bundle\EventsBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscribed")
 * @ORM\HasLifecycleCallbacks()  
 */
class Subscribed {

    /**
     * @ORM\Id
     * @ORM\Column(type = "integer", name= "id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="EventType")
     * @ORM\JoinColumn(name="eventtype1", referencedColumnName="id")
     * 
     */
    private $eventtype1;
    
    /**
     * @ORM\ManyToOne(targetEntity="EventType")
     * @ORM\JoinColumn(name="eventtype2", referencedColumnName="id")
     * 
     */
    private $eventtype2;
    
    /**
     * @ORM\ManyToOne(targetEntity="EventType")
     * @ORM\JoinColumn(name="eventtype3", referencedColumnName="id")
     * 
     */
    private $eventtype3;
    
//    /**
//     * @ORM\ManyToOne(targetEntity="EventType")
//     * @ORM\JoinColumn(name="eventtype4", referencedColumnName="id")
//     * 
//     */
//    private $eventtype4;
//    /**
//     * @ORM\ManyToOne(targetEntity="EventType")
//     * @ORM\JoinColumn(name="eventtype5", referencedColumnName="id")
//     * 
//     */
//    private $eventtype5;
//    /**
//     * @ORM\ManyToOne(targetEntity="EventType")
//     * @ORM\JoinColumn(name="eventtype6", referencedColumnName="id")
//     * 
//     */
//    private $eventtype6;
//    /**
//     * @ORM\ManyToOne(targetEntity="EventType")
//     * @ORM\JoinColumn(name="eventtype7", referencedColumnName="id")
//     * 
//     */
//    private $eventtype7;
//    /**
//     * @ORM\ManyToOne(targetEntity="EventType")
//     * @ORM\JoinColumn(name="eventtype8", referencedColumnName="id")
//     * 
//     */
//    private $eventtype8;
//    /**
//     * @ORM\ManyToOne(targetEntity="EventType")
//     * @ORM\JoinColumn(name="eventtype9", referencedColumnName="id")
//     * 
//     */
//    private $eventtype9;
//    /**
//     * @ORM\ManyToOne(targetEntity="EventType")
//     * @ORM\JoinColumn(name="eventtype10", referencedColumnName="id")
//     * 
//     */
//    private $eventtype10;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     * 
     */
    private $user;

    public function getEventtype1() {
        return $this->eventtype1;
    }

    public function setEventtype1($eventype) {
        $this->eventtype1 = $eventype;
    }
    
    public function getEventtype2() {
        return $this->eventtype2;
    }

    public function setEventtype2($eventype) {
        $this->eventtype2 = $eventype;
    }
    
    public function getEventtype3() {
        return $this->eventtype3;
    }

    public function setEventtype3($eventype) {
        $this->eventtype3 = $eventype;
    }
//    public function getEventtype4() {
//        return $this->eventtype4;
//    }
//
//    public function setEventtype4($eventype) {
//        $this->eventtype4 = $eventype;
//    }
//    public function getEventtype5() {
//        return $this->eventtype5;
//    }
//
//    public function setEventtype5($eventype) {
//        $this->eventtype5 = $eventype;
//    }
//    public function getEventtype6() {
//        return $this->eventtype6;
//    }
//
//    public function setEventtype6($eventype) {
//        $this->eventtype6 = $eventype;
//    }
//    public function getEventtype7() {
//        return $this->eventtype7;
//    }
//
//    public function setEventtype7($eventype) {
//        $this->eventtype7 = $eventype;
//    }
//    public function getEventtype8() {
//        return $this->eventtype8;
//    }
//
//    public function setEventtype8($eventype) {
//        $this->eventtype8 = $eventype;
//    }
//    public function getEventtype9() {
//        return $this->eventtype9;
//    }
//
//    public function setEventtype9($eventype) {
//        $this->eventtype9 = $eventype;
//    }
//    public function getEventtype10() {
//        return $this->eventtype10;
//    }
//
//    public function setEventtype10($eventype) {
//        $this->eventtype10 = $eventype;
//    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

}