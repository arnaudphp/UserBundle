<?php
namespace Leoo\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Leoo\BackBundle\Services\ServicesManager;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
    private $factory;

    private $sm;
    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, ServicesManager $sm)
    {
        $this->factory = $factory;
        $this->sm = $sm;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');

        $services = $this->sm->getServices();

        foreach ($services as $service) {

            $menu->addChild($service->getTitle(), array('route' => 'homepage'));
        }
        // ... add more children

        return $menu;
    }
}