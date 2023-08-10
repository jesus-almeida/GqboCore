<?php

namespace xGqboo\GqboCore\Commands;

use xGqboo\GqboCore\Main;

use pocketmine\{Server, Player};
use pocketmine\command\{Command, CommandSender, CommandExecutor, ConsoleCommandSender};

class LobbyTP implements CommandExecutor
{
    public $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function onCommand(CommandSender $s, Command $cmd, $label, array $args)
    {
        if (strtolower($cmd->getName()) === "lobby") {
            if (!$s instanceof Player) {
                $s->sendMessage("§f\n§f" . $this->main->prefix . "§cThis command can only be executed by players!§f\n§f");
                return;
            }

            $defL = $this->main->getServer()->getDefaultLevel();
            if ($defL !== null) {
                $l = $defL->getSpawnLocation();
                $s->teleport($l);
                $s->sendTip("§aWelcome to the Lobby!§f\n§f\n§f\n§f\n§f\n§f\n§f");
            }
        }
    }
}
