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
 * @method static BubbleColumn BUBBLE_COLUMN()
 * @method static BuddingAmethyst BUDDING_AMETHYST()
 * @method static Camera CAMERA()
 * @method static Campfire CAMPFIRE()
 * @method staric CaveVines CAVE_VINES()
 * @method static CaveVinesHeadWithBerries CAVE_VINES_HEAD_WITH_BERRIES()
 * @method static Chain CHAIN()
 * @method static CaveVinesBodyWithBerries CAVE_VINES_BODY_WITH_BERRIES()
 * @method static ChainCommandBlock CHAIN_COMMAND_BLOCK()
 * @method static ClientRequestPlaceholderBlock CLIENT_REQUEST_PLACEHOLDER_BLOCK()
 * @method static CrimsonFungus CRIMSON_FUNGUS()
 * @method staric CommandBlock COMMAND_BLOCK()
 * @method static Deny DENY()
 * @method static Dispenser DISPENSER()
 * @method static Dropper DROPPER()
 * @method static EndGateway END_GATEWAY()
 * @method static MossCarpet MOSS_CARPET()
 * @method static Piston PISTON()
 * @method static PistonArmCollision PISTON_ARM_COLLISION()
 * @method static PowderSnow POWDER_SNOW()
 * @method static ReinforcedDeepslate REINFORCED_DEEPSLATE()
 * @method static RepeatingCommandBlock REPEATING_COMMAND_BLOCK()
 * @method static SculkShrieker SCULK_SHRIEKER()
 * @method static SeaGrass SEAGRASS()
 * @method static SoulCampfire SOUL_CAMPFIRE()
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
		self::registerAmethysts();
		self::registerAzaleas();
		self::registerCampfire();
		self::registerCommandBlock();
		self::registerFungus();
		self::registerPiston();
		self::registerWall();
		self::registerVines();

		self::register('allow', new Allow(
			new BID(Allow::TYPE_ID()),
			'Allow',
			new Info(BreakInfo::indestructible())
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
		self::register('bubble_column', new BubbleColumn(
			new BID(BubbleColumn::TYPE_ID()),
			'Bubble Column',
			new Info(self::anyZero())
		));
		self::register('camera', new Camera(
			new BID(Camera::TYPE_ID()),
			'Camera',
			new Info(self::anyZero())
		));
		self::register('chain', new Chain(
			new BID(Chain::TYPE_ID()),
			'Chain',
			new Info(BreakInfo::pickaxe(5, ToolTier::WOOD(), 6))
		));
		self::register('client_request_placeholder_block', new ClientRequestPlaceholderBlock(
			new BID(ClientRequestPlaceholderBlock::TYPE_ID()),
			'Client Request Placeholder Block',
			new Info(BreakInfo::indestructible())
		));
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

	private static function registerAmethysts() : void{
		$info = new Info(BreakInfo::pickaxe(1.5));
		self::register('amethyst_cluster', new AmethystCluster(
			new BID(AmethystCluster::TYPE_ID()),
			'Amethyst Cluster',
			$info
		));
		self::register('budding_amethyst', new BuddingAmethyst(
			new BID(BuddingAmethyst::TYPE_ID()),
			'Budding Amethyst',
			$info
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

	private static function registerCampfire() : void{
		$info = new Info(BreakInfo::axe(2.0));
		self::register('campfire', new Campfire(
			new BID(Campfire::TYPE_ID()),
			'Campfire',
			$info
		));
		self::register('soul_campfire', new SoulCampfire(
			new BID(SoulCampfire::TYPE_ID()),
			'Soul Campfire',
			$info
		));
	}

	private static function registerCommandBlock() : void{
		$info = new Info(BreakInfo::indestructible());
		self::register('chain_command_block', new ChainCommandBlock(
			new BID(ChainCommandBlock::TYPE_ID()),
			'Chain Command Block',
			$info
		));
		self::register('command_block', new CommandBlock(
			new BID(CommandBlock::TYPE_ID()),
			'Command Block',
			$info
		));
		self::register('repeating_command_block', new RepeatingCommandBlock(
			new BID(RepeatingCommandBlock::TYPE_ID()),
			'Repeating Command Block',
			$info
		));
	}

	private static function registerFungus() : void{
		$info = new Info(self::anyZero());
		self::register('warped_fungus', new WarpedFungus(
			new BID(WarpedFungus::TYPE_ID()),
			'Warped Fungus',
			$info
		));
		self::register('crimson_fungus', new CrimsonFungus(
			new BID(CrimsonFungus::TYPE_ID()),
			'Crimson Fungus',
			$info
		));
	}

	private static function registerPiston() : void{
		$info = new Info(BreakInfo::pickaxe(1.5));
		self::register('piston', new Piston(
			new BID(Piston::TYPE_ID()),
			'Piston',
			$info
		));
		self::register('piston_arm_collision', new PistonArmCollision(
			new BID(PistonArmCollision::TYPE_ID()),
			'Piston Arm Collision',
			$info
		));
	}

	private static function registerVines() : void{
		$info = new Info(self::anyZero());
		self::register('cave_vines', new CaveVines(
			new BID(CaveVines::TYPE_ID()),
			'Cave Vines',
			$info
		));
		self::register('cave_vines_head_with_berries', new CaveVinesHeadWithBerries(
			new BID(CaveVinesHeadWithBerries::TYPE_ID()),
			'Cave Vines Head With Berries',
			$info
		));
		self::register('cave_vines_body_with_berries', new CaveVinesBodyWithBerries(
			new BID(CaveVinesBodyWithBerries::TYPE_ID()),
			'Cave Vines Body With Berries',
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