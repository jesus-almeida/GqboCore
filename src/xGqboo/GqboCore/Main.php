<?php

/*
 *        _____       _                 
 *       / ____|     | |                
 * __  _| |  __  __ _| |__   ___   ___  
 * \ \/ / | |_ |/ _` | '_ \ / _ \ / _ \ 
 *  >  <| |__| | (_| | |_) | (_) | (_) |
 * /_/\_\\_____|\__, |_.__/ \___/ \___/ 
 *                 | |                  
 *                 |_|                  
 *
 * Name: GqboCore
 * Version: 1.0 Beta
 * Author: xGqboo
 * My Discord: xgqboo
*/

namespace xGqboo\GqboCore;

// Plugin
use pocketmine\plugin\PluginBase;
// Events
use pocketmine\event\Listener;
use pocketmine\event\player\{PlayerJoinEvent, PlayerLoginEvent, PlayerQuitEvent, PlayerDeathEvent, PlayerItemHeldEvent, PlayerMoveEvent, PlayerInteractEvent};
// Pocketmine
use pocketmine\Player;
use pocketmine\IPlayer;
use pocketmine\Server;
// Utils
use pocketmine\utils\{TextFormat, Config};
// Levels
use pocketmine\level\Level;
use pocketmine\level\sound\ExplodeSound;
use pocketmine\level\particle\AngryVillagerParticle;
// Math
use pocketmine\math\Vector3;
// Commands
use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
// Item
use pocketmine\item\Item;

class Main extends PluginBase implements Listener
{
    private $config;
    public $prefix = "§8[§l§bG§fC§r§8]§f ";
    public $noperm = "§cYou do not have permission yo use this command!";

    # Plugin Enabled
    public function onEnable()
    {
        // Config
        $this->saveResource("config.yml");
        @mkdir($this->getDataFolder());
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        // Server MOTD
        $this->getServer()->getNetwork()->setName(($this->config->get("motd")));
        // Register Events
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "time set 200");

        $this->getServer()->loadLevel("world1");
        // Plugin Enabled Message
        $this->getServer()->getLogger()->info($this->prefix . "§aPlugin Enabled!");
    }
    # Players Login
    public function onLogin(PlayerLoginEvent $event)
    {
        $player = $event->getPlayer();

        $level = $this->getServer()->getDefaultLevel();
        $player->teleport($level->getSafeSpawn());
    }
    # Players Join
    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $message = $this->getConfig()->get("join-msg");
        $message = str_replace("{name}", $player->getName(), $message);

        $event->setJoinMessage("");
        $this->getServer()->broadcastMessage($message);

        $player->setHealth(20);
        $player->setFood(20);
    }
    # Players Quit
    public function onQuit(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer();
        $message = $this->getConfig()->get("quit-msg");
        $message = str_replace("{name}", $player->getName(), $message);

        $event->setQuitMessage("");
        $this->getServer()->broadcastMessage($message);
    }
    # Players Deaths
    public function onDeath(PlayerDeathEvent $event)
    {
        $event->setDeathMessage("");

        $player = $event->getPlayer();
        $level = $player->getLevel();

        $sound = new ExplodeSound($player);
        $level->addSound($sound);

        $position = $player->getPosition()->add(0, $player->getEyeHeight(), 0);

        for ($i = 0; $i < 5; $i++) {
            $x = $position->getX() + mt_rand(-1, 1);
            $y = $position->getY() + mt_rand(0, 1);
            $z = $position->getZ() + mt_rand(-1, 1);

            $particle = new AngryVillagerParticle(new Vector3($x, $y, $z));
            $level->addParticle($particle);
        }
    }
    # Item ID
    public function ItemId(PlayerItemHeldEvent $event)
    {
        $player = $event->getPlayer();

        if ($player->hasPermission("gqbocore.id")) {
            $player->sendTip("§l§b" . $event->getItem()->getId() . "§r§f:§l§b" . $event->getItem()->getDamage());
        }
    }
    # Anti-Void
    public function onVoid(PlayerMoveEvent $event)
    {
        $player = $event->getPlayer();
        $level = $player->getLevel();
        $defWorld = $this->getServer()->getDefaultLevel();

        if ($level->getName() === $defWorld->getName()) {
            if ($player->getY() < -5) {
                $player->teleport($defWorld->getSafeSpawn());
                $player->sendTip("§l§b! §r§fA donde crees q vas §l§b!§r");
            }
        }
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
                $s->sendMessage($this->prefix . $this->noperm);
                return false;
            }

            if (!$s instanceof Player) {
                $s->sendMessage($this->prefix . "§cThis command can only be executed by players!");
                return false;
            }

            $s->setHealth(20);
            $s->sendMessage($this->prefix . "§aYour life has been filled!");
            return true;
        }
        // Feed Command
        if (strtolower($cmd->getName() == "feed")) {
            if (!$s->hasPermission("gqbocore.feed")) {
                $s->sendMessage($this->prefix . $this->noperm);
                return false;
            }

            if (!$s instanceof Player) {
                $s->sendMessage($this->prefix . "§cThis command can only be executed by players!");
                return false;
            }

            $s->setFood(20);
            $s->sendMessage($this->prefix . "§aYour food has been refilled!");
            return true;
        }
        // Hunger Command (It was a test)
        /*if (strtolower($cmd->getName() == "hunger")) {
            if (!$s->hasPermission("gqbocore.hunger")) {
                $s->sendMessage($this->prefix . $this->noperm);
                return false;
            }

            if (!$s instanceof Player) {
                $s->sendMessage($this->prefix . "§cThis command can only be executed by players!");
                return false;
            }

            $s->setFood(0);
            $s->sendMessage($this->prefix . "§aYour food has been refilled!");
            return true;
        }*/
        // ClearChat Command
        if (strtolower($cmd->getName() == "cc")) {
            if (!$s->hasPermission("gqbocore.cc")) {
                $s->sendMessage($this->prefix . $this->noperm);
                return false;
            }

            $s->getServer()->broadcastMessage("§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f\n§f§f\n§f\n\n" . $this->prefix . "§aThe chat was deleted by the player: §l§b" . $s->getName());
            return true;
        }
        // Clear Inventory And Potion Effects Command
        if (strtolower($cmd->getName() == "ci")) {
            if (!$s->hasPermission("gqbocore.ci")) {
                $s->sendMessage($this->prefix . $this->noperm);
                return false;
            }

            if (!$s instanceof Player) {
                $s->sendMessage($this->prefix . "§cThis command can only be executed by players!");
                return false;
            }

            $s->getInventory()->clearAll();
            $s->removeAllEffects();
            $s->sendMessage($this->prefix . "§aCleaned your inventory and position effects!");
            return true;
        }
        // Advertisement Command
        if (strtolower($cmd->getName() == "ad")) {
            if (!$s->hasPermission("gqbocore.ad")) {
                $s->sendMessage($this->prefix . $this->noperm);
                return false;
            }

            if (count($args) > 0) {
                $msg = implode(" ", $args);
                $this->getServer()->broadcastMessage("§8§l[§r§eAD§8§l]§r§l§b " . $msg);
                return true;
            } else {
                $s->sendMessage($this->prefix . "§cUsage: /Ad <Message>");
                return false;
            }
        }
        // Info Command
        if (strtolower($cmd->getName() == "info")) {
            $s->sendMessage("§f\n§f" . $this->prefix . "INFO . . .§f\n§f");
        }
        // Tags Command
        if (strtolower($cmd->getName() == "tags")) {
            $s->sendMessage("§f\n§f" . $this->prefix . "TAGS . . .§f\n§f");
        }
        // Rules Command
        if (strtolower($cmd->getName() == "rules")) {
            $s->sendMessage("§f\n§f" . $this->prefix . "RULES . . .§f\n§f");
        }
        // Social Command
        if (strtolower($cmd->getName() == "social")) {
            $s->sendMessage("§f\n§f" . $this->prefix . "SOCIAL . . .§f\n§f");
        }
        // Online Command
        if (strtolower($cmd->getName() == "online")) {
            $s->sendMessage("§f\n§f" . $this->prefix . "ONLINE: " . count($this->getServer()->getOnlinePlayers()) . "§f\n§f");
        }
        // Day Command
        if (strtolower($cmd->getName() == "day")) {
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "time set day");
            $s->sendMessage($this->prefix . "Haz cambiado el tiempo a dia");
        }
        // Night Command
        if (strtolower($cmd->getName() == "night")) {
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "time set night");
            $s->sendMessage($this->prefix . "Haz cambiado el tiempo a noche");
        }
        // Lobby Command
        if (strtolower($cmd->getName()) === "lobby") {
            $defLevel = $this->getServer()->getDefaultLevel();
            if ($defLevel !== null) {
                $lobby = $defLevel->getSpawnLocation();
                $s->teleport($lobby);
                $s->sendMessage($this->prefix . "¡Bienvenido al lobby principal!");
            }
        }
        // Fly Command
        if (strtolower($cmd->getName() == "fly")) {
            if (!$s->hasPermission("gqbocore.fly")) {
                $s->sendMessage($this->prefix . $this->noperm);
                return false;
            }

            if (!$s instanceof Player) {
                $s->sendMessage($this->prefix . "§cThis command can only be executed by players!");
                return false;
            }

            if (count($args) == 0) {
                $s->sendMessage($this->prefix . "uso");
                return false;
            } elseif (isset($args[0]) && strtolower($args[0]) == "off") {
                $s->setAllowFlight(false);
                $s->sendMessage($this->prefix . "off");
                return true;
            } elseif (isset($args[0]) && strtolower($args[0]) == "on") {
                $s->setAllowFlight(true);
                $s->sendMessage($this->prefix . "on");
                return true;
            }
        }
    }
    # Plugin Disabled
    public function onDisable()
    {
        // Message
        $this->getServer()->getLogger()->info($this->prefix . "§cPlugin Disabled!");
    }
}
