<?php

namespace Itzdvbravo\BravoClan\Forms\SubForms;

use pocketmine\Player;

use jojoe77777\FormAPI\CustomForm;
use Itzdvbravo\BravoClan\Forms\ClanForm;
use Itzdvbravo\BravoClan\Main;

Class InfoSubForm extends CustomForm{

	/** @var Player */
	private $player;

	public function __construct(Player $player){
		$this->player = $player;
		$this->setForm();
		$callable = $this->getCallable();
		parent::__construct($callable);
	}

	/**
	* @return void
	*/
	public function setForm() :void{
		$player = $this->player;
		$this->setTitle("Info clan");
		$clan = Main::$file->getClan(Main::$clan->player[strtolower($player->getName())]);
		$this->addLabel("§eYour Clan Info");
        $this->addLabel("§eLeader: {$clan['leader']}");
        $this->addLabel("§eMembers: {$clan['tm']}/{$clan['maxtm']}");
        $this->addLabel("§eLevel: {$clan['level']}");
        $this->addLabel("§eXP: {$clan['xp']}/{$clan['nex']}");
        $this->addLabel("§eKDR: {$clan['kills']}/{$clan['deaths']}");
	}

	/**
	* @return callable
	*/
	public function getCallable() :callable{
		$callable = function(Player $player, ?array $data){ 
			$form = new ClanForm($player);
			$player->sendForm($form);
		};
		return $callable;
	}
}