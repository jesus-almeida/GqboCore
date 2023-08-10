<?php

namespace xGqboo\GqboCore\Commands;

use xGqboo\GqboCore\Main;

use pocketmine\{Server, Player};
use pocketmine\command\{Command, CommandSender, CommandExecutor, ConsoleCommandSender};

class DayNight implements CommandExecutor
{
    public $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function onCommand(CommandSender $s, Command $cmd, $label, array $args)
    {
        if (strtolower($cmd->getName() == "day")) {
            if (!$s->hasPermission("gqbocore.night")) {
                $s->sendMessage("");
                return;
            }

            $this->main->getServer()->dispatchCommand(new ConsoleCommandSender(), "time set day");
            $s->sendMessage("§f\n" . $this->main->prefix . "§aYou have changed the time to day!§f\n");
        }

        if (strtolower($cmd->getName() == "night")) {
            if (!$s->hasPermission("gqbocore.night")) {
                $s->sendMessage("");
                return;
            }

            $this->main->getServer()->dispatchCommand(new ConsoleCommandSender(), "time set night");
            $s->sendMessage("§f\n" . $this->main->prefix . "§aYou have changed the time to night!§f\n");
        }
    }
}
