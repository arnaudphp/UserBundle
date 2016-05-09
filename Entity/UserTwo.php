<?php

namespace Leoo\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_two")
 * @UniqueEntity(fields = "username", targetClass = "Leoo\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Leoo\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class UserTwo extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=255)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}