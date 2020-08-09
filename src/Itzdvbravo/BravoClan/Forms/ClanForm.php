<?php

namespace Itzdvbravo\BravoClan\Forms;

use pocketmine\Player;

use jojoe77777\FormAPI\SimpleForm;
use Itzdvbravo\BravoClan\Main;
use Itzdvbravo\BravoClan\Forms\SubForms\{
	CreateSubForm,
	TopSubForm,
	InfoSubForm,
	ManagerSubForm
};

use onebone\economyapi\EconomyAPI;

Class ClanForm extends SimpleForm{

	/** @var Player*/
	private $player; 

	public function __construct(Player $player){
		$this->player = $player;
		$callable = $this->getCallable();
		$this->setForm();
		parent::__construct($callable);
	}

	/**
	* @return void
	*/
	public function setForm() :void{
		if(!Main::$file->isInClan(strtolower($this->player->getName()))){
			$this->setContent("You don't have clan");
			$this->addButton("Create new clan");
			$this->addButton("Top Clans");
		}else{
			$clan = Main::$file->getClan(Main::$clan->player[strtolower($this->player->getName())]);
			$this->setContent("Your level clan: ". $clan["level"]);
			$this->addButton("Info clan");
			$this->addButton("Top Clans");
			$this->addButton("Clan Manager");
		}
	}


	/**
	* @return callable
	*/
	public function getCallable() :?callable{
		$callable = function(Player $player, ?int $data){
			if(is_null($data)) return;
			$lowname = strtolower($player->getName());
			if(!Main::$file->isInClan($lowname)){
				if($data == 0){
					$form = new CreateSubForm($player);
					$form->setTitle("CREATE FORM");
					$form->setForm();
					$player->sendForm($form);
				} 
				if($data == 1){
					$form = new TopSubForm($player);
					$form->setForm();
					$form->setTitle("TOP FORM");
					$player->sendForm($form);
				}
			}else{
				if($data == 0){
					$form = new InfoSubForm($player);
					$form->setForm();
					$form->setTitle("INFO FORM");
					$player->sendForm($form);
				}
				if($data == 1){
					$form = new TopSubForm($player);
					$form->setTitle("TOP FORM");
					$form->setForm();
					$player->sendForm($form);
				}
				if($data == 2){
					$form = new ManagerSubForm($player);
					$form->setTitle("MANAGER FORM");
					$form->setForm();
					$player->sendForm($form);
				}
			}
		};
		return $callable;
	}
}
