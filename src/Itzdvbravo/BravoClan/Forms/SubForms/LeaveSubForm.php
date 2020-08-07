<?php

namespace Itzdvbravo\BravoClan\Forms\SubForms;

use pocketmine\Player;

use jojoe77777\FormAPI\ModalForm;
use Itzdvbravo\BravoClan\Forms\ClanForm;
use Itzdvbravo\BravoClan\Main;

Class DeleteSubForm extends ModalForm{

	/** @var Player */
	private $player;

	public function __construct(Player $player){
		$this->player = $player;
		$callable = $this->getCallable();
		parent::__construct($callable);
	}

	/**
	* @return void
	*/
	public function setForm() :void{
		$this->setContent("Do you want leave clan?");
		$this->setButton1("Yes");
		$this->setButton2("No");
	}

	/**
	* @return callable
	*/
	public function getCallable() :callable{
		$callable = function(Player $player, ?bool $data){
			if(is_null($data)){
				$form = new ClanForm($player);
				$player->sendForm($form);				
			}
			if($data){
				Server::getInstance()->getCommandMap()->dispatch($player, "clan leave");
			} 
		};
		return $callable;
	}
}