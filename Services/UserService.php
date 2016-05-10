<?php

namespace Leoo\UserBundle\Services;

use Leoo\BackBundle\Model\ServiceInterface;
use Leoo\BackBundle\Model\ServiceModel;
use Symfony\Component\Translation\Translator;

class UserService implements ServiceInterface
{
    use ServiceModel;

    protected $name = "User";
    protected $path = __DIR__;
}
