<?php

namespace Leoo\UserBundle\EventListener;
use Leoo\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user    = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

}