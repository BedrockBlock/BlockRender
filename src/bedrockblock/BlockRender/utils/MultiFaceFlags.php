<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\utils;

final class MultiFaceFlags{

	private function __construct(){
		//NOOP
	}

	public const ENCODE_DOWN = 0x01;
	public const ENCODE_UP = 0x02;
	public const ENCODE_NORTH = 0x04;
	public const ENCODE_SOUTH = 0x08;
	public const ENCODE_WEST = 0x10;
	public const ENCODE_EAST = 0x20;

	public const DECODE_DOWN = 0x01;
	public const DECODE_UP = 0x02;
	public const DECODE_SOUTH = 0x04;
	public const DECODE_WEST = 0x08;
	public const DECODE_NORTH = 0x10;
	public const DECODE_EAST = 0x20;

}