<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\utils;

trait GrawingAgeTrait{

	protected int $age = 0;
	
	public function getAge() : int{
		return $this->age;
	}

	public function setAge(int $age) : self{
		$this->age = $age;
		return $this;
	}

}