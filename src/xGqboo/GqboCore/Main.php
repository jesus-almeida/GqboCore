<?php

# declare(strict_types=1);

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

use xGqboo\GqboCore\Commands\{Ad, ClearChat, ClearInventory, DayNight, Fly, HealFeed, Info, LobbyTP};
use xGqboo\GqboCore\Events\{AntiVoid, ItemID, JoinQuit};
use xGqboo\GqboCore\Motd\MOTD;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\command\{ConsoleCommandSender, CommandExecutor};

use function array_diff;
use function scandir;

class Main extends PluginBase implements Listener
{
	public $prefix = "§8[§l§bG§fC§r§8]§f ";
	public $config;
	public $motd;

	public function onEnable()
	{
		$this->saveResource("config.yml");
		@mkdir($this->getDataFolder());
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

		$motd = new MOTD($this);
		$motd->changeMOTD();

		foreach (array_diff(scandir($this->getServer()->getDataPath() . "worlds"), ["..", "."]) as $w) {
			if ($this->getServer()->loadLevel($w)) {
				$this->getLogger()->debug("§fWorld: §b" . $w . "§f. §aLoaded successfully!");
			}
		}

		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getServer()->getPluginManager()->registerEvents(new JoinQuit($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new ItemID($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new AntiVoid($this), $this);

		$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "time set 200");
		$this->getCommand("gcore")->setExecutor(new Info($this));
		$this->getCommand("info")->setExecutor(new Info($this));
		$this->getCommand("tags")->setExecutor(new Info($this));
		$this->getCommand("rules")->setExecutor(new Info($this));
		$this->getCommand("social")->setExecutor(new Info($this));
		$this->getCommand("online")->setExecutor(new Info($this));
		$this->getCommand("heal")->setExecutor(new HealFeed($this));
		$this->getCommand("feed")->setExecutor(new HealFeed($this));
		$this->getCommand("hunger")->setExecutor(new HealFeed($this));
		$this->getCommand("cc")->setExecutor(new ClearChat($this));
		$this->getCommand("ccme")->setExecutor(new ClearChat($this));
		$this->getCommand("ci")->setExecutor(new ClearInventory($this));
		$this->getCommand("ad")->setExecutor(new Ad($this));
		$this->getCommand("day")->setExecutor(new DayNight($this));
		$this->getCommand("night")->setExecutor(new DayNight($this));
		$this->getCommand("lobby")->setExecutor(new LobbyTP($this));
		$this->getCommand("fly")->setExecutor(new Fly($this));

		$this->getServer()->getLogger()->info($this->prefix . "§aPlugin Enabled!");
	}

	public function onDisable()
	{
		$this->getServer()->getLogger()->info($this->prefix . "§cPlugin Disabled!");
	}
}
