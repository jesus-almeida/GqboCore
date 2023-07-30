<?php

namespace xGqboo\GqboCore\Events;

use xGqboo\GqboCore\Main;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;

class ItemID implements Listener
{
    public $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    # Item ID
    public function ItemId(PlayerItemHeldEvent $ev)
    {
        $p = $ev->getPlayer();

        if ($p->hasPermission("gqbocore.id")) {
            $p->sendTip("§l§b" . $ev->getItem()->getId() . "§r§f:§l§b" . $ev->getItem()->getDamage());
        }
    }
}
