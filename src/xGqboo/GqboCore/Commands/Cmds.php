<?php

namespace xGqboo\GqboCore\Commands;

use xGqboo\GqboCore\Main;

use pocketmine\{Server, Player};

use pocketmine\command\{Command, CommandSender, CommandExecutor, ConsoleCommandSender};

class Cmds implements CommandExecutor
{

    public $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    # Commands
    public function onCommand(CommandSender $s, Command $cmd, $label, array $args)
    {
        // GCore Command
        if (strtolower($cmd->getName() == "gcore")) {
            if (count($args) == 0) {
                $s->sendMessage("");
            } elseif (isset($args[0]) && strtolower($args[0]) == "cmds") {
                $s->sendMessage("");
            } elseif (isset($args[0]) && strtolower($args[0]) == "perms") {
                $s->sendMessage("");
            }
        }
        // Heal Command
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
        // Feed Command
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
        // Hunger Command (It was a test)
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
        // ClearChat Command
        if (strtolower($cmd->getName() == "cc")) {
            if (!$s->hasPermission("gqbocore.cc")) {
                $s->sendMessage();
                return;
            }

            $s->getServer()->broadcastMessage("§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f§f\n§f\n\n" . $this->main->prefix . "§aThe chat was deleted by the player: §l§b" . $s->getName());
        }
        // Clear Inventory And Potion Effects Command
        if (strtolower($cmd->getName() == "ci")) {
            if (!$s instanceof Player) {
                $s->sendMessage($this->main->prefix . "§cThis command can only be executed by players!");
                return;
            }

            $s->getInventory()->clearAll();
            $s->removeAllEffects();
            $s->sendMessage($this->main->prefix . "§aCleaned your inventory and position effects!");
        }
        // Advertisement Command
        if (strtolower($cmd->getName() == "ad")) {
            if (!$s->hasPermission("gqbocore.ad")) {
                $s->sendMessage("");
                return;
            }

            if (count($args) > 0) {
                $msg = implode(" ", $args);
                $this->main->getServer()->broadcastMessage("§8§l[§r§eAD§8§l]§r§l§b " . $msg);
            } else {
                $s->sendMessage($this->main->prefix . "§cUsage: /Ad <Message>");
                return;
            }
        }
        // Info Command
        if (strtolower($cmd->getName() == "info")) {
            $s->sendMessage("§f\n§f" . $this->main->prefix . "INFO . . .§f\n§f");
        }
        // Tags Command
        if (strtolower($cmd->getName() == "tags")) {
            $s->sendMessage("§f\n§f" . $this->main->prefix . "TAGS . . .§f\n§f");
        }
        // Rules Command
        if (strtolower($cmd->getName() == "rules")) {
            $s->sendMessage("§f\n§f" . $this->main->prefix . "RULES . . .§f\n§f");
        }
        // Social Command
        if (strtolower($cmd->getName() == "social")) {
            $s->sendMessage("§f\n§f" . $this->main->prefix . "SOCIAL . . .§f\n§f");
        }
        // Online Command
        if (strtolower($cmd->getName() == "online")) {
            $s->sendMessage("§f\n§f" . $this->main->prefix . "ONLINE: " . count($this->main->getServer()->getOnlinePlayers()) . "§f\n§f");
        }
        // Day Command
        if (strtolower($cmd->getName() == "day")) {
            $this->main->getServer()->dispatchCommand(new ConsoleCommandSender(), "time set day");
            $s->sendMessage($this->main->prefix . "Haz cambiado el tiempo a dia");
        }
        // Night Command
        if (strtolower($cmd->getName() == "night")) {
            $this->main->getServer()->dispatchCommand(new ConsoleCommandSender(), "time set night");
            $s->sendMessage($this->main->prefix . "Haz cambiado el tiempo a noche");
        }
        // Lobby Command
        if (strtolower($cmd->getName()) === "lobby") {
            $defLevel = $this->main->getServer()->getDefaultLevel();
            if ($defLevel !== null) {
                $lobby = $defLevel->getSpawnLocation();
                $s->teleport($lobby);
                $s->sendMessage($this->main->prefix . "Bienvenido al lobby principal!");
            }
        }
        // Fly Command
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
                $s->sendMessage($this->main->prefix . "uso");
                return;
            } elseif (isset($args[0]) && strtolower($args[0]) == "off") {
                $s->setAllowFlight(false);
                $s->sendMessage($this->main->prefix . "off");
            } elseif (isset($args[0]) && strtolower($args[0]) == "on") {
                $s->setAllowFlight(true);
                $s->sendMessage($this->main->prefix . "on");
            }
        }
    }
}
