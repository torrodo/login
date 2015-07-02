<?php

namespace LoginProject\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User.
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="uk_username", columns={"username"})})
 * @ORM\Entity(repositoryClass="LoginProject\Bundle\UserBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var string
     */
    const UNDERAGE = 'underage';
    const OVERAGE = 'overage';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\Length(min = 5, max = 64,
     * minMessage = "The username must have at least 5 characters.",
     * maxMessage = "The username must have at most 65 characters."
     * )
     *
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
     */
    protected $username;

    /**
     * @var string
     *
     * @Assert\Length(min = 8, max = 64,
     * minMessage = "The password must have at least 8 characters.",
     * maxMessage = "The password must have at most 65 characters."
     * )
     *
     * @ORM\Column(name="password", type="string", length=32, nullable=false)
     */
    protected $password;

    /**
     * @var string
     *
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     * @ORM\Column(name="email", type="string", length=128, nullable=false)
     */
    protected $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=false)
     */
    protected $birthday;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="is_admin", type="integer", nullable=false)
     */
    protected $isAdmin = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="age_status", type="string", nullable=true)
     */
    protected $ageStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set birthday.
     *
     * @param \DateTime $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday.
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set admin flag.
     *
     * @param bool $isAdmin
     *
     * @return User
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get admin flag.
     *
     * @return bool
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set age status.
     *
     * @param string $ageStatus
     *
     * @return User
     */
    public function setAgeStatus($ageStatus)
    {
        $this->ageStatus = $ageStatus;

        return $this;
    }

    /**
     * Get age status.
     *
     * @return string
     */
    public function getAgeStatus()
    {
        return $this->ageStatus;
    }

    /**
     * Set creation date.
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get creation date.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
}
