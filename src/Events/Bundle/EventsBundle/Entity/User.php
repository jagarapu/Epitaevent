<?php

namespace Events\Bundle\EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscriber")
 * @UniqueEntity(fields="username",message="Username already used",groups={"registration"})
 * @UniqueEntity(fields="email",message = "Email Already Used",groups={"registration"})
 * @ORM\HasLifecycleCallbacks()  
 */
class User extends BaseUser {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type = "integer", name= "id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="firstname", length=100)
     * @Assert\NotBlank( message = "Name should not be blank",groups={"registration"})
     * @Assert\Length(max=100,maxMessage="Name should be less than 100 characters",groups={"registration"})
     * @Assert\Regex(
     *      pattern="/\d/",
     *      match=false,
     *      message="Name should not contain numbers",groups={"registration"})
     */
    public $firstname;

    /**
     * @ORM\Column(type="string", name="lastname", length=100)
     * @Assert\NotBlank( message = "Name should not be blank",groups={"registration"})
     * @Assert\Length(max=100,maxMessage="Name should be less than 100 characters",groups={"registration"})
     * @Assert\Regex(
     *      pattern="/\d/",
     *      match=false,
     *      message="Name should not contain numbers",groups={"registration"})
     */
    public $lastname;

    /**
     * @Assert\Email(message = "Email not valid",groups={"registration"})
     * @Assert\NotBlank(message = "Email not blank",groups={"registration"})
     * @Assert\Length(max=255,maxMessage="Email should be less than 255 characters",groups={"registration"})
     */
    protected $email;

    /**
     * 
     * @Assert\NotBlank( message = "Username should not be blank",groups={"registration"})
     * @Assert\Regex(
     *      pattern="/[^a-zA-Z0-9-_]/",
     *      match = false,
     *      message = "Username shoud not contain special characters other than - and _",groups={"registration"})
     * @Assert\Length(min=4,max=30,minMessage="Username must be atleast 4 characters",maxMessage="Username must be maximum 30 characters",groups={"registration"})
     */
    protected $username;

    /**
     * @Assert\NotBlank( message = "Password must not be blank",groups={"registration","resetpassword"})
     * @Assert\Length(min=4,minMessage="Password minimum length must be 4 characters",groups={"registration","resetpassword"})
     */
    protected $plainPassword;

    /**
     * @ORM\Column(type="datetime", name="createdon",nullable=true)
     */
    public $createdon;

    /**
     * @ORM\Column(type="datetime", name="modifiedon",nullable=true)
     */
    public $modifiedon;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Candidate
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Candidate
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get Username
     *
     * @return string 
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set plainpassword
     *
     * @param string $password
     * @return Candidate
     */
    public function setPlainpassword($password) {
        $this->plainPassword = $password;

        return $this;
    }

    /**
     * Get Password
     *
     * @return string 
     */
    public function getPlainpassword() {
        return $this->plainPassword;
    }

    /**
     * Set createdon
     *
     * @param \DateTime $createdon
     * @return Lead
     */
    public function setCreatedon($createdon) {
        $this->createdon = $createdon;

        return $this;
    }

    /**
     * Get createdon
     *
     * @return \DateTime 
     */
    public function getCreatedon() {
        return $this->createdon;
    }

    /**
     * Set modifiedon
     *
     * @param \DateTime $createdon
     * @return Candidate
     */
    public function setModifiedon($modifiedon) {
        $this->modifiedon = $modifiedon;

        return $this;
    }

    /**
     * Get modifiedon
     *
     * @return \DateTime 
     */
    public function getModifiedon() {
        return $this->modifiedon;
    }

}