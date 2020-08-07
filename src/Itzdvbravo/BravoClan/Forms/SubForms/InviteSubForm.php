<?php

namespace Itzdvbravo\BravoClan\Forms\SubForms;

use pocketmine\Player;
use Itzdvbravo\BravoClan\Forms\ClanForm;
use Itzdvbravo\BravoClan\Main;
use onebone\economyapi\EconomyAPI;
use jojoe77777\FormAPI\CustomForm;

Class InviteSubForm extends CustomForm{

	/*** @var Player*/
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
	public function setForm() :void {
		$player = $this->player;
		$this->setTitle("Invite Form");
		$this->addInput("Player name:");
	}

	/**
	* @return callable
	*/
	public function getCallable() :callable{
		$callable = function(Player $player, ?array $data){
			if(is_null($data[0])){
				$form = new ClanForm($player);
				$player->sendForm($form);
				return;
			}
			Server::getInstance()->getCommandMap()->dispatch($player, "clan invite ". $data[0]);
		};
		return $callable;
	}
}