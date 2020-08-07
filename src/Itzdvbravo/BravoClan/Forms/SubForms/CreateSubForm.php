<?php

namespace Itzdvbravo\BravoClan\Forms\SubForms;

use pocketmine\Player;

use jojoe77777\FormAPI\CustomForm;
use Itzdvbravo\BravoClan\Main;
use onebone\economyapi\EconomyAPI;
use Itzdvbravo\BravoClan\Forms\ClanForm;

Class CreateSubForm extends CustomForm{

	/*** @var Player*/
	private $player;

	public function __construct(Player $player){
		$this->player = $player;
		$callable = $this->getCallable();
		parent::__construct($callable);
	}
	/**
	* @return void
	*/
	public function setForm() :void {
		$player = $this->player;
		$this->setTitle("Create new Clan");
		$this->addLabel("Clan creation fee: 10000$");
		$money = EconomyAPI::getInstance()->myMoney($player);
		$this->addLabel("Your money: ". $money);
		if($money >= 10000){
			$this->addInput("Name clan:", "Nap tien di");
		}else{
			$this->addLabel("You do not have enough money to create a clan");
		}
	}

	/**
	* @return callable
	*/
	public function getCallable() :callable{
		$callable = function(Player $player, ?array $data){
			if(is_null($data)){
				$form = new ClanForm($player);
				$player->sendForm($form);
				return;
			}
			if($money = EconomyAPI::getInstance()->myMoney($player) >= 10000){
				Main::$file->setClan($data[2], $player->getName());
                Main::$clan->player[strtolower($player->getName())] = $data[2];
                EconomyAPI::getInstance()->reduceMoney($player, 10000);
			}
		};
		return $callable;
	}
}