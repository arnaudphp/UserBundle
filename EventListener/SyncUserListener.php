<?php


namespace Leoo\UserBundle\EventListener;


use Leoo\UserBundle\Entity\User;


final class SyncUserListener
{
    const onUserUpdate = 'leoo.user.update';

    const onUserCreate = 'leoo.user.create';

    const onUserDelete = 'leoo.user.delete';

    const onUserEnable = 'leoo.user.enable';

    const onUserDisable = 'leoo.user.disable';

    public function onUserUpdate(UserEvent $event)
    {
        $user = $event->getUser();
        die('EVENT onUserUpdate');
    }

    public function onUserCreate(UserEvent $event)
    {
        $user = $event->getUser();
        die('EVENT onUserCreate');
    }

    public function onUserDelete(UserEvent $event)
    {
        $user = $event->getUser();
        die('EVENT onUserDelete');
    }

    public function onUserEnable(UserEvent $event)
    {
        $user = $event->getUser();
        die('EVENT onUserEnable');
    }

    public function onUserDisable(UserEvent $event)
    {
        $user = $event->getUser();
        die('EVENT onUserDisable');
    }
}