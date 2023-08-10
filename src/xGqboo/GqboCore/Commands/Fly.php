<?php

namespace xGqboo\GqboCore\Commands;

use xGqboo\GqboCore\Main;

use pocketmine\{Server, Player};
use pocketmine\command\{Command, CommandSender, CommandExecutor};

class Fly implements CommandExecutor
{
    public $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function onCommand(CommandSender $s, Command $cmd, $label, array $args)
    {
        if (strtolower($cmd->getName() == "fly")) {
            if (!$s->hasPermission("gqbocore.fly")) {
                $s->sendMessage("");
                return;
            }
            if (!$s instanceof Player) {
                $s->sendMessage($this->main->prefix . "§cThis command can only be executed by players!");
                return;
            }

            if (count($args) == 0) {
                $s->sendMessage("§f\n§f" . $this->main->prefix . "§cUsage: §7/Fly On|Off§f\n§f");
                return;
            } elseif (isset($args[0]) && strtolower($args[0]) == "off") {
                $s->setAllowFlight(false);
                $s->sendMessage("§f\n§f" . $this->main->prefix . "§cFlight mode deactivated!§f\n§f");
            } elseif (isset($args[0]) && strtolower($args[0]) == "on") {
                $s->setAllowFlight(true);
                $s->sendMessage("§f\n§f" . $this->main->prefix . "§aFlight mode activated!§f\n§f");
            }
        }
    }
}
