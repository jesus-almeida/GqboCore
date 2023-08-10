<?php

namespace xGqboo\GqboCore\Commands;

use xGqboo\GqboCore\Main;

use pocketmine\{Server, Player};
use pocketmine\command\{Command, CommandSender, CommandExecutor};

class Ad implements CommandExecutor
{
    public $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function onCommand(CommandSender $s, Command $cmd, $label, array $args)
    {
        if (strtolower($cmd->getName() == "ad")) {
            if (!$s->hasPermission("gqbocore.ad")) {
                $s->sendMessage("");
                return;
            }

            if (count($args) > 0) {
                $msg = implode(" ", $args);
                $this->main->getServer()->broadcastMessage("§8§l[§r§eAD§8§l]§r§b " . $msg);
            } else {
                $s->sendMessage($this->main->prefix . "§cUsage: /Ad <Message>");
                return;
            }
        }
    }
}
