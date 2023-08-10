<?php

namespace xGqboo\GqboCore\Commands;

use xGqboo\GqboCore\Main;

use pocketmine\{Server, Player};

use pocketmine\command\{Command, CommandSender, CommandExecutor, ConsoleCommandSender};

class Info implements CommandExecutor
{

    public $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    # Commands
    public function onCommand(CommandSender $s, Command $cmd, $label, array $args)
    {
        if (strtolower($cmd->getName() == "gcore")) {
            if (count($args) == 0) {
                $s->sendMessage("");
            } elseif (isset($args[0]) && strtolower($args[0]) == "cmds") {
                $s->sendMessage("");
            } elseif (isset($args[0]) && strtolower($args[0]) == "perms") {
                $s->sendMessage("");
            }
        }

        if (strtolower($cmd->getName() == "info")) {
            $s->sendMessage("§f\n§f" . $this->main->prefix . "INFO . . .§f\n§f");
        }

        if (strtolower($cmd->getName() == "tags")) {
            $s->sendMessage("§f\n§f" . $this->main->prefix . "TAGS . . .§f\n§f");
        }

        if (strtolower($cmd->getName() == "rules")) {
            $s->sendMessage("§f\n§f" . $this->main->prefix . "RULES . . .§f\n§f");
        }

        if (strtolower($cmd->getName() == "social")) {
            $s->sendMessage("§f\n§f" . $this->main->prefix . "SOCIAL . . .§f\n§f");
        }

        if (strtolower($cmd->getName() == "online")) {
            $s->sendMessage("§f\n§f" . $this->main->prefix . "ONLINE: " . count($this->main->getServer()->getOnlinePlayers()) . "§f\n§f");
        }
    }
}
