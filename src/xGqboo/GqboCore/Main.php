<?php

declare(strict_types=1);

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
 * Version: 2.0
 * Author: xGqboo
 * My Discord: xgqboo
*/

namespace xGqboo\GqboCore;

# GqboCore
use xGqboo\GqboCore\Commands\Cmds;
use xGqboo\GqboCore\Events\{AntiVoid, ItemID, JoinQuit};
# Pocketmine
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\command\{ConsoleCommandSender, CommandExecutor};
# Others
use function array_diff;
use function scandir;

class Main extends PluginBase implements Listener
{
	public $config;
	public $prefix = "§8[§l§bG§fC§r§8]§f ";

	# Plugin Enabled
	public function onEnable()
	{
		// Config
		$this->saveResource("config.yml");
		@mkdir($this->getDataFolder());
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		// Server MOTD
		$this->getServer()->getNetwork()->setName(($this->config->get("motd")));
		// Load Worlds
		foreach (array_diff(scandir($this->getServer()->getDataPath() . "worlds"), ["..", "."]) as $w) {
			if ($this->getServer()->loadLevel($w)) {
				$this->getLogger()->debug("§fWorld: §b${w}§f. §aLoaded successfully!");
			}
		}
		// Events
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getServer()->getPluginManager()->registerEvents(new JoinQuit($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new ItemID($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new AntiVoid($this), $this);
		// Commands
		$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "time set 200");

		$this->getCommand("gcore")->setExecutor(new Cmds($this));
		$this->getCommand("heal")->setExecutor(new Cmds($this));
		$this->getCommand("feed")->setExecutor(new Cmds($this));
		$this->getCommand("hunger")->setExecutor(new Cmds($this));
		$this->getCommand("cc")->setExecutor(new Cmds($this));
		$this->getCommand("ci")->setExecutor(new Cmds($this));
		$this->getCommand("ad")->setExecutor(new Cmds($this));
		$this->getCommand("info")->setExecutor(new Cmds($this));
		$this->getCommand("tags")->setExecutor(new Cmds($this));
		$this->getCommand("rules")->setExecutor(new Cmds($this));
		$this->getCommand("social")->setExecutor(new Cmds($this));
		$this->getCommand("online")->setExecutor(new Cmds($this));
		$this->getCommand("day")->setExecutor(new Cmds($this));
		$this->getCommand("night")->setExecutor(new Cmds($this));
		$this->getCommand("lobby")->setExecutor(new Cmds($this));
		$this->getCommand("fly")->setExecutor(new Cmds($this));
		// Plugin Enabled Message
		$this->getServer()->getLogger()->info($this->prefix . "§aPlugin Enabled!");
	}

	# Plugin Disabled
	public function onDisable()
	{
		// Message
		$this->getServer()->getLogger()->info($this->prefix . "§cPlugin Disabled!");
	}
}
