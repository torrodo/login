<?php

namespace LoginProject\Bundle\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserRepository extends EntityRepository implements UserProviderInterface
{
    /**
     * Load user by username.
     *
     * @param string $username
     * @param string $password
     *
     * @return User
     */
    public function loadUserByUsernameAndPassword($username, $password)
    {
        return
            $this->createQueryBuilder('u')
                ->where('u.username = :username')
                ->andWhere('u.password = :password')
                ->setParameter('username', $username)
                ->setParameter('password', md5($password))
                ->getQuery()
                ->getOneOrNullResult();
    }

    /**
     * {@inheritedDoc}.
     */
    public function loadUserByUsername($username)
    {
        return $this->findByUsername($username);
    }

    /**
     * {@inheritedDoc}.
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->findByUserId($user->getId());
    }

    /**
     * {@inheritedDoc}.
     */
    public function supportsClass($class)
    {
        $userClass = $this->getClassMetadata()->getName();

        return ($class === $userClass) || is_subclass_of($class, $userClass);
    }

    /**
     * Get user by id.
     * 
     * To avoid errors like:
     * "Reloading user from user provider: Unknown column 't0.id' in 'where clause'"
     * It's triggered on authentication when user interface object is reloaded from the db.
     *
     * @param int $id
     *
     * @return CurrentUser
     */
    protected function findByUserId($id)
    {
        $sql = 'SELECT * FROM `user` WHERE id = :id';

        return $this
                    ->getEntityManager()
                    ->getConnection()
                    ->executeQuery(
                        $sql, 
                        ['id' => $id]
                    )
                    ->fetchObject(
                        'LoginProject\Bundle\MainBundle\Entity\CurrentUser'
                    );
    }
}
