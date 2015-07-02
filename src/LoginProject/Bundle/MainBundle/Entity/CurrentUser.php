<?php

namespace LoginProject\Bundle\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use LoginProject\Bundle\UserBundle\Entity\User;

/**
 * User.
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="uk_username", columns={"username"})})
 * @ORM\Entity(repositoryClass="LoginProject\Bundle\UserBundle\Repository\UserRepository")
 */
class CurrentUser extends User implements AdvancedUserInterface, \Serializable
{
    /**
     * {@inheritedDoc}.
     */
    public function equals(UserInterface $user)
    {
        if (!$user instanceof self) {
            return false;
        }

        return ($user->getUsername() === $this->getUsername());
    }

    /**
     * {@inheritedDoc}.
     */
    public function getRoles()
    {
        if ($this->getIsAdmin()) {
           return ['ROLE_ADMIN'];
        }

        return ['ROLE_USER'];
    }

    /**
     * {@inheritedDoc}.
     */
    public function isEnabled()
    {
        return true;
    }

    /**
     ** {@inheritedDoc}.
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     ** {@inheritedDoc}.
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     ** {@inheritedDoc}.
     */
    public function getSalt()
    {
        return '';
    }

    /**
     ** {@inheritedDoc}.
     */
    public function eraseCredentials()
    {
        return true;
    }

    /**
     ** {@inheritedDoc}.
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * {@inheritedDoc}.
     */
    public function serialize()
    {
        return serialize(get_object_vars($this));
    }

    /**
     * {@inheritedDoc}.
     */
    public function unserialize($data)
    {
        $data = unserialize($data);
        if (!is_array($data)) {
            return;
        }

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function __toString()
    {
        return $this->serialize();
    }
}
