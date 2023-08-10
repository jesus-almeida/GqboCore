<?php

namespace xGqboo\GqboCore\Commands;

use xGqboo\GqboCore\Main;

use pocketmine\{Server, Player};
use pocketmine\command\{Command, CommandSender, CommandExecutor};

class ClearInventory implements CommandExecutor
{
    public $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function onCommand(CommandSender $s, Command $cmd, $label, array $args)
    {
        if (strtolower($cmd->getName() == "ci")) {
            if (!$s instanceof Player) {
                $s->sendMessage($this->main->prefix . "§cThis command can only be executed by players!");
                return;
            }

            $s->getInventory()->clearAll();
            $s->removeAllEffects();
            $s->sendMessage($this->main->prefix . "§aCleaned your inventory and position effects!");
        }
    }
}
