<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\utils;

use pocketmine\block\Block;
use pocketmine\data\bedrock\block\BlockStateNames;
use pocketmine\data\bedrock\block\convert\{
	BlockStateReader,
	BlockStateWriter
};
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};
use pocketmine\item\Item;
use pocketmine\math\{
	Facing,
	Vector3
};
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

trait MultiDirectionTrait{

	/**
	 * @var bool[]
	 * @phpstan-var array<int, bool>
	 */
	protected array $faces = [
		Facing::DOWN => false,
		Facing::UP => false,
		Facing::NORTH => false,
		Facing::SOUTH => false,
		Facing::WEST => false,
		Facing::EAST => false
	];

	protected function runtimeHelper(RuntimeDataReader|RuntimeDataWriter &$w) : void{
		if($w instanceof RuntimeDataReader){
			$value = false;
			foreach(Facing::ALL as $facing){
				$w->bool($value);
				$this->faces[$facing] = $value;
			}
		}else{
			foreach($this->faces as $face => $value){
				$w->bool($value);
			}
		}
	}

	/**
	 * @return bool[]
	 * @phpstan-return array<int, bool>
	 */
	public function getFaces() : array{
		return $this->faces;
	}

	public function hasFace(int $face) : bool{
		return $this->faces[$face];
	}

	/** @param int[] $faces */
	public function setFaces(array $faces) : self{
		foreach($faces as $face){
			Facing::validate($face);
			$this->faces[$face] = true;
		}
		return $this;
	}

	public function setFace(int $face, bool $value = true) : self{
		Facing::validate($face);
		$this->faces[$face] = $value;
		return $this;
	}

	public function canBeReplaced() : bool{
		return true;
	}

	/** @see Block::place() */
	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($blockReplace instanceof self){
			$this->faces = $blockReplace->getFaces();
		}
		$opposite = match($facing = Facing::opposite($face)){
			Facing::SOUTH => Facing::NORTH,
			Facing::WEST => Facing::SOUTH,
			Facing::NORTH => Facing::WEST,
			default => $facing
		};
		if($this->faces[$opposite]){
			return false;
		}
		$this->faces[$opposite] = true;
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	protected function encodeHelper(BlockStateWriter $writer) : BlockStateWriter{
		return $writer->writeInt(BlockStateNames::MULTI_FACE_DIRECTION_BITS,
			($this->hasFace(Facing::DOWN) ? MultiFaceFlags::ENCODE_DOWN : 0) |
			($this->hasFace(Facing::UP) ? MultiFaceFlags::ENCODE_UP : 0) |
			($this->hasFace(Facing::NORTH) ? MultiFaceFlags::ENCODE_NORTH : 0) |
			($this->hasFace(Facing::SOUTH) ? MultiFaceFlags::ENCODE_SOUTH : 0) |
			($this->hasFace(Facing::WEST) ? MultiFaceFlags::ENCODE_WEST : 0) |
			($this->hasFace(Facing::EAST) ? MultiFaceFlags::ENCODE_EAST : 0)
		);
	}

	public function decodeHelper(self $block, BlockStateReader $reader) : self{
		$flags = $reader->readBoundedInt(BlockStateNames::MULTI_FACE_DIRECTION_BITS, 0, 63);
		$faces = [];
		if(($flags & MultiFaceFlags::DECODE_DOWN) !== 0){
			$faces[] = Facing::DOWN;
		}
		if(($flags & MultiFaceFlags::DECODE_UP) !== 0){
			$faces[] = Facing::UP;
		}
		if(($flags & MultiFaceFlags::DECODE_WEST) !== 0){
			$faces[] = Facing::WEST;
		}
		if(($flags & MultiFaceFlags::DECODE_NORTH) !== 0){
			$faces[] = Facing::NORTH;
		}
		if(($flags & MultiFaceFlags::DECODE_SOUTH) !== 0){
			$faces[] = Facing::SOUTH;
		}
		if(($flags & MultiFaceFlags::DECODE_EAST) !== 0){
			$faces[] = Facing::EAST;
		}
		return $block->setFaces($faces);
	}
}