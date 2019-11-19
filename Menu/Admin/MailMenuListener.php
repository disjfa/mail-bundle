<?php

namespace Disjfa\MailBundle\Menu\Admin;

use Disjfa\MenuBundle\Menu\ConfigureMenuEvent;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class MailMenuListener
{
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        try {
            $menu = $event->getMenu();
            $menu->addChild('mail', [
                'label' => 'Mail templates',
                'route' => 'disjfa_mail_template_index',
            ])->setExtra('icon', 'fa-envelope');
        } catch (RouteNotFoundException $e) {
            // routing.yml not set up
            return;
        }
    }
}
