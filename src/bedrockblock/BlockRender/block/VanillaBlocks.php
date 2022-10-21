<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\{
	Block,
	BlockBreakInfo as BreakInfo,
	BlockIdentifier as BID,
	BlockTypeInfo as Info,
	BlockToolType as ToolType
};
use pocketmine\item\ToolTier;
use pocketmine\utils\CloningRegistryTrait;

/**
 * @method static Allow ALLOW()
 * @method static AmethystCluster AMETHYST_CLUSTER()
 * @method static Azalea AZALEA()
 * @method static AzaleaLeaves AZALEA_LEAVES()
 * @method static AzaleaLeavesFlowered AZALEA_LEAVES_FLOWERED()
 * @method static BeeNest BEE_NEST()
 * @method static Beehive BEEHIVE()
 * @method static BigDripleaf BIG_DRIPLEAF()
 * @method static BorderBlock BORDER_BLOCK()
 * Chain CHAIN()
 * @method static CrimsonFungus CRIMSON_FUNGUS()
 * @method static Deny DENY()
 * @method static Dispenser DISPENSER()
 * @method static Dropper DROPPER()
 * @method static EndGateway END_GATEWAY()
 * @method static MossCarpet MOSS_CARPET()
 * @method static Piston PISTON()
 * @method static PistonArmCollision PISTON_ARM_COLLISION()
 * @method static PowderSnow POWDER_SNOW()
 * @method static ReinforcedDeepslate REINFORCED_DEEPSLATE()
 * @method static SculkShrieker SCULK_SHRIEKER()
 * @method static SeaGrass SEAGRASS()
 * @method static WarpedFungus  WARPED_FUNGUS()
 */
final class VanillaBlocks{
	use CloningRegistryTrait;

	private function __construct(){
		//NOOP
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
		self::registerAzaleas();
		self::registerFungus();
		self::registerPiston();
		self::registerWall();

		self::register('allow', new Allow(
			new BID(Allow::TYPE_ID()),
			'Allow',
			new Info(BreakInfo::indestructible())
		));
		self::register('amethyst_cluster', new AmethystCluster(
			new BID(AmethystCluster::TYPE_ID()),
			'Amethyst Cluster',
			new Info(BreakInfo::pickaxe(1.5))
		));
		self::register('bee_nest', new BeeNest(
			new BID(BeeNest::TYPE_ID()),
			'Bee Nest',
			new Info(BreakInfo::axe(0.3))
		));
		self::register('beehive', new Beehive(
			new BID(Beehive::TYPE_ID()),
			'Beehive',
			new Info(BreakInfo::axe(0.6))
		));
		self::register('big_dripleaf', new BigDripleaf(
			new BID(BigDripleaf::TYPE_ID()),
			'Big Dripleaf',
			new Info(BreakInfo::axe(0.1))
		));
		/*self::register('chain', new Chain(
			new BID(Chain::TYPE_ID()),
			'Chain',
			new Info(BreakInfo::pickaxe(5, ToolTier::WOOD(), 6))
		));*/
		self::register('deny', new Allow(
			new BID(Deny::TYPE_ID()),
			'Deny',
			new Info(BreakInfo::indestructible())
		));
		self::register('dispenser', new Dispenser(
			new BID(Dispenser::TYPE_ID()),
			'Dispenser',
			new Info(BreakInfo::pickaxe(3.5))
		));
		self::register('dropper', new Dropper(
			new BID(Dropper::TYPE_ID()),
			'Dropper',
			new Info(BreakInfo::pickaxe(3.5))
		));
		self::register('end_gateway', new EndGateway(
			new BID(EndGateway::TYPE_ID()),
			'End Gateway',
			new Info(BreakInfo::indestructible())
		));
		self::register('moss_carpet', new MossCarpet(
			new BID(MossCarpet::TYPE_ID()),
			'moss carpet',
			new Info(new BreakInfo(0.1))
		));
		self::register('powder_snow', new PowderSnow(
			new BID(PowderSnow::TYPE_ID()),
			'Powder Snow',
			new Info(new BreakInfo(0.25))
		));
		self::register('reinforced_deepslate', new ReinforcedDeepslate(
			new BID(ReinforcedDeepslate::TYPE_ID()),
			'Reinforced Deepslate',
			new Info(new BreakInfo(55))
		));
		self::register('sculk_shrieker', new SculkShrieker(
			new BID(SculkShrieker::TYPE_ID()),
			'Sculk Shrieker',
			new Info(self::blockToolHoe(3.0))
		));
		self::register('seagrass', new SeaGrass(
			new BID(SeaGrass::TYPE_ID()),
			'Seagrass',
			new Info(self::blockToolShears(0.0))
		));
	}

	private static function registerWall() : void{
		self::register('border_block', new BorderBlock(
			new BID(BorderBlock::TYPE_ID()),
			'Border Block',
			new Info(BreakInfo::indestructible())
		));
	}

	private static function registerPiston() : void{
		$pistonInfo = new Info(BreakInfo::pickaxe(1.5));
		self::register('piston', new Piston(
			new BID(Piston::TYPE_ID()),
			'Piston',
			$pistonInfo
		));
		self::register('piston_arm_collision', new PistonArmCollision(
			new BID(PistonArmCollision::TYPE_ID()),
			'Piston Arm Collision',
			$pistonInfo
		));
	}

	private static function registerFungus() : void{
		$fungusInfo = new Info(self::anyZero());
		self::register('warped_fungus', new WarpedFungus(
			new BID(WarpedFungus::TYPE_ID()),
			'Warped Fungus',
			$fungusInfo
		));
		self::register('crimson_fungus', new CrimsonFungus(
			new BID(CrimsonFungus::TYPE_ID()),
			'Crimson Fungus',
			$fungusInfo
		));
	}

	private static function registerAzaleas() : void{
		$info = new Info(self::anyZero());
		self::register('azalea', new Azalea(
			new BID(Azalea::TYPE_ID()),
			'Azalea',
			$info
		));
		self::register('azalea_leaves', new AzaleaLeaves(
			new BID(AzaleaLeaves::TYPE_ID()),
			'Azalea Leaves',
			$info
		));
		self::register('azalea_leaves_flowered', new AzaleaLeavesFlowered(
			new BID(AzaleaLeavesFlowered::TYPE_ID()),
			'Azalea Leaves Flowered',
			$info
		));
	}

	private static function anyZero() : BreakInfo{
		return new BreakInfo(0);
	}

	private static function blockToolHoe(float $hardness, ?ToolTier $toolTier = null, ?float $blastResistance = null) : BreakInfo{
		return new BreakInfo($hardness, ToolType::HOE, $toolTier?->getHarvestLevel() ?? 0, $blastResistance);
	}

	private static function blockToolShears(float $hardness, ?ToolTier $toolTier = null, ?float $blastResistance = null) : BreakInfo{
		return new BreakInfo($hardness, ToolType::SHEARS, $toolTier?->getHarvestLevel() ?? 0, $blastResistance);
	}
}