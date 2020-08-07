<?php

namespace Itzdvbravo\BravoClan\Forms\SubForms;

use pocketmine\Player;

use jojoe77777\FormAPI\SimpleForm;
use Itzdvbravo\BravoClan\Main;

Class ManagerSubForm extends SimpleForm{

	/** @var Player*/
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
		$this->addButton("Invite Member");
		if($this->isLeader($player)){
			$this->addButton("Kick");
			$this->addButton("Delete");			
		}else{
			$this->addButton("Leave");
		}
	}


	/**
	* @return callable
	*/
	public function getCallable() :callable{
		$callable = function(Player $player, ?int $data){
			if(is_null($data)) return;
			$lowname = strtolower($player->getName());
			$form = $this;
			if($data == 0){
				$form = new InviteSubForm($player);
				$form->setForm();
				$form->setTitle("Invite Form");
				$player->sendForm($form);
			}
			if($this->isLeader($player)){
				if($data == 1){
					$form = new KickSubForm($player);
					$form->setTitle("Kick Form");
					$form->setForm();
					$player->sendForm($form);
				}
				if($data == 2){
					$form = new DeleteSubForm($player);
					$form->setTitle("Delete");
					$form->setForm();
					$player->sendForm($form);
				} 
			}else{
				if($data == 1){
					$form = new LeaveSubForm($player);
					$form->setForm();
					$form->setTitle("Leave");
					$player->sendForm($form);
				} 
			}
			$player->sendForm($form);
		};
		return $callable;
	}

	/**
	* @param Player $player
	*
	* @return bool
	*/
	private function isLeader(Player $player) :bool{
		if(Main::$file->getClan(Main::$file->getMember(strtolower($player->getName()))["clan"])["leader"] === strtolower($player->getName())){
			return true;			
		}
		return false;
	}
}