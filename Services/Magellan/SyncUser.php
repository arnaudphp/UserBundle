<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 09/05/2016
 * Time: 15:48
 */

namespace Leoo\UserBundle\Services\Magellan;

use Doctrine\ORM\EntityManager;
use Leoo\UserBundle\Entity\User;

class SyncUser
{
    public function __construct(EntityManager $entityManager)
    {

    }

    public function onUpdate(User $user)
    {
        // API CALL TO MAGELLAN
    }
}