<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\{
	Block,
	BlockTypeIds,
	BlockBreakInfo as BreakInfo,
	BlockIdentifier as BID,
	BlockTypeInfo as Info,
	BlockToolType as ToolType
};
use pocketmine\utils\CloningRegistryTrait;

/**
 * @method static Dispenser DISPENSER()
 * @method static Dropper DROPPER()
 * @method static End_Gateway END_GATEWAY()
 * @method static Piston PISTON()
 * @method static Piston_Arm_Collision PISTON_ARM_COLLISION()
 * @method static Powder_Snow POWDER_SNOW()
 * @method static Sculk_Shrieker SCULK_SHRIEKER()
 */
final class VanillaBlocks{
	use CloningRegistryTrait;

	private function __construct(){
		//NOOP
	}

	private static function nextBid() : Bid{
		return new Bid(BlockTypeIds::newId());
	}

	protected static function register(string $name, Block $block) : void{
		self::_registryRegister($name, $block);
	}

	/**
	 * @return Block[]
	 * @phpstan-return array<string, Block>
	 */
	public static function getAll() : array{
		/** @var Block[] $result */
		$result = self::_registryGetAll();
		return $result;
	}

	protected static function setup() : void{
		self::registerPiston();

		self::register('dispenser', new Dispenser(
			self::nextBid(),
			'Dispenser',
			new Info(BreakInfo::pickaxe(3.5))
		));
		self::register('dropper', new Dropper(
			self::nextBid(),
			'Dropper',
			new Info(BreakInfo::pickaxe(3.5))
		));
		self::register('end_gateway', new EndGateway(
			self::nextBid(),
			'End Gateway',
			new Info(BreakInfo::indestructible())
		));
		self::register('powder_snow', new PowderSnow(
			self::nextBid(),
			'Powder Snow',
			new Info(new BreakInfo(0.25))
		));
		self::register('sculk_shrieker', new SculkShrieker(
			self::nextBid(),
			'Sculk Shrieker',
			new Info(self::blockToolHoe(3.0))
		));
	}

	private static function registerPiston() : void{
		$pistonInfo = new Info(BreakInfo::pickaxe(1.5));
		self::register('piston', new Piston(
			self::nextBid(),
			'Piston',
			$pistonInfo
		));
		self::register('piston_arm_collision', new PistonArmCollision(
			self::nextBid(),
			'Piston Arm Collision',
			$pistonInfo
		));
	}

	private static function blockToolHoe(float $hardness, ?ToolTier $toolTier = null, ?float $blastResistance = null) : BreakInfo{
		return new BreakInfo($hardness, ToolType::HOE, $toolTier?->getHarvestLevel() ?? 0, $blastResistance);
	}

}