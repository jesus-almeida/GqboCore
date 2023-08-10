<?php

namespace xGqboo\GqboCore\Commands;

use xGqboo\GqboCore\Main;

use pocketmine\{Server, Player};
use pocketmine\command\{Command, CommandSender, CommandExecutor};

class HealFeed implements CommandExecutor
{
    public $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function onCommand(CommandSender $s, Command $cmd, $label, array $args)
    {
        if (strtolower($cmd->getName()) === "heal") {
            if (!$s->hasPermission("gqbocore.heal")) {
                $s->sendMessage("");
                return;
            }

            if (!$s instanceof Player) {
                $s->sendMessage($this->main->prefix . "§cThis command can only be executed by players!");
                return;
            }

            $s->setHealth(20);
            $s->sendMessage($this->main->prefix . "§aYour life has been filled!");
        }

        if (strtolower($cmd->getName() == "feed")) {
            if (!$s->hasPermission("gqbocore.feed")) {
                $s->sendMessage("");
                return;
            }

            if (!$s instanceof Player) {
                $s->sendMessage($this->main->prefix . "§cThis command can only be executed by players!");
                return;
            }

            $s->setFood(20);
            $s->sendMessage($this->main->prefix . "§aYour food has been refilled!");
        }
        // (It was a test)
        if (strtolower($cmd->getName() == "hunger")) {
            if (!$s->hasPermission("gqbocore.hunger")) {
                $s->sendMessage("");
                return;
            }

            if (!$s instanceof Player) {
                $s->sendMessage($this->main->prefix . "§cThis command can only be executed by players!");
                return;
            }

            $s->setFood(0);
            $s->sendMessage($this->main->prefix . "§aYour food has been refilled!");
        }
    }
}
