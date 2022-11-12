<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\utils;

final class MultiFaceFlags{

	private function __construct(){
		//NOOP
	}

	public const DOWN = 0x01;
	public const UP = 0x02;
	public const WEST = 0x04;
	public const NORTH = 0x08;
	public const SOUTH = 0x10;
	public const EAST = 0x20;
}