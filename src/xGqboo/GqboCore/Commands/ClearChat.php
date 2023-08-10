<?php

namespace xGqboo\GqboCore\Commands;

use xGqboo\GqboCore\Main;

use pocketmine\{Server, Player};
use pocketmine\command\{Command, CommandSender, CommandExecutor};

class ClearChat implements CommandExecutor
{
    public $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function onCommand(CommandSender $s, Command $cmd, $label, array $args)
    {
        if (strtolower($cmd->getName() == "cc")) {
            if (!$s->hasPermission("gqbocore.cc")) {
                $s->sendMessage("");
                return;
            }

            $s->getServer()->broadcastMessage("§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f§f\n§f\n§f\n" . $this->main->prefix . "§aThe chat was deleted by the player: §l§b" . $s->getName() . "§f\n§f\n");
        }

        if (strtolower($cmd->getName() == "ccme")) {
            $s->sendMessage("§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f§f\n§f\n§f\n" . $this->main->prefix . "§aYour chat has been deleted§f\n§f\n");
            $s->sendPopup("");
            $s->sendTip("");
        }
    }
}
