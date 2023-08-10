<?php

namespace xGqboo\GqboCore\Motd;

use xGqboo\GqboCore\Main;

class MOTD
{
  public $main;
  public $config;

  public function __construct(Main $main)
  {
      $this->main = $main;
      $this->config = $this->main->config;
  }

  public function onRun($tick)
	{
		$this->changeMOTD();
	}

	public function changeMOTD()
	{
		$this->main->config->reload();
		$motd = $this->main->config->get("motd");
		$this->main->getServer()->getNetwork()->setName($motd);
	}
}
