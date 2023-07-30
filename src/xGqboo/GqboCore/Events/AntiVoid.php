<?php

namespace xGqboo\GqboCore\Events;

use xGqboo\GqboCore\Main;

use pocketmine\{Server, Player};
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;

class AntiVoid implements Listener
{
    public $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    # Anti-Void
    public function AntiVoid(PlayerMoveEvent $ev)
    {
        $p = $ev->getPlayer();
        $l = $p->getLevel();
        $dWorld = $this->main->getServer()->getDefaultLevel();

        if ($l->getName() === $dWorld->getName()) {
            if ($p->getY() < -5) {
                $p->teleport($dWorld->getSafeSpawn());
                $p->sendTip("§l§b! §r§fA donde crees q vas §l§b!§r");
            }
        }
    }
}
