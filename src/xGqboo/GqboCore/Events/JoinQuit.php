<?php

namespace xGqboo\GqboCore\Events;

use xGqboo\GqboCore\Main;

use pocketmine\{Server, Player};
use pocketmine\event\Listener;
use pocketmine\event\player\{PlayerJoinEvent, PlayerLoginEvent, PlayerQuitEvent, PlayerDeathEvent};
use pocketmine\level\Level;
use pocketmine\level\sound\ExplodeSound;
use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\math\Vector3;

class JoinQuit implements Listener
{
    public $main;
    public $config;

    public function __construct(Main $main)
    {
        $this->main = $main;
        $this->config = $this->main->config;
    }

    # Players Login
    public function onLogin(PlayerLoginEvent $ev)
    {
        $p = $ev->getPlayer();

        $l = $this->main->getServer()->getDefaultLevel();
        $p->teleport($l->getSafeSpawn());
    }
    # Players Join
    public function onJoin(PlayerJoinEvent $ev)
    {
        $p = $ev->getPlayer();
        $n = $p->getName();
        $config = $this->config;
        $msg = $config->get("join-msg");
        $msg = str_replace("{name}", $n, $msg);

        $ev->setJoinMessage("");
        $this->main->getServer()->broadcastMessage($msg);

        $p->setHealth(20);
        $p->setFood(20);
    }
    # Players Quit
    public function onQuit(PlayerQuitEvent $ev)
    {
        $p = $ev->getPlayer();
        $n = $p->getName();
        $config = $this->config;
        $msg = $config->get("quit-msg");
        $msg = str_replace("{name}", $n, $msg);

        $ev->setQuitMessage("");
        $this->main->getServer()->broadcastMessage($msg);
    }
    # Players Deaths
    public function onDeath(PlayerDeathEvent $ev)
    {
        $ev->setDeathMessage("");

        $p = $ev->getPlayer();
        $l = $p->getLevel();

        $s = new ExplodeSound($p);
        $l->addSound($s);

        $pos = $p->getPosition()->add(0, $p->getEyeHeight(), 0);

        for ($i = 0; $i < 5; $i++) {
            $x = $pos->getX() + mt_rand(-1, 1);
            $y = $pos->getY() + mt_rand(0, 1);
            $z = $pos->getZ() + mt_rand(-1, 1);

            $par = new AngryVillagerParticle(new Vector3($x, $y, $z));
            $l->addParticle($par);
        }
    }
}
