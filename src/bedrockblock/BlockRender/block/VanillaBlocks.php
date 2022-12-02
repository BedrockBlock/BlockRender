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
 * @method static CaveVines CAVE_VINES()
 * @method static CaveVinesHeadWithBerries CAVE_VINES_HEAD_WITH_BERRIES()
 * @method static Chain CHAIN()
 * @method static CaveVinesBodyWithBerries CAVE_VINES_BODY_WITH_BERRIES()
 * @method static ChainCommandBlock CHAIN_COMMAND_BLOCK()
 * @method static ClientRequestPlaceholderBlock CLIENT_REQUEST_PLACEHOLDER_BLOCK()
 * @method static CommandBlock COMMAND_BLOCK()
 * @method static Composter COMPOSTER()
 * @method static Conduit CONDUIT()
 * @method static CrimsonFungus CRIMSON_FUNGUS()
 * @method static CrimsonNylium CRIMSON_NYLIUM()
 * @method static CrimsonRoots CRIMSON_ROOTS()
 * @method static Deny DENY()
 * @method static Dispenser DISPENSER()
 * @method static DripstoneBlock DRIPSTONE_BLOCK()
 * @method static Dropper DROPPER()
 * @method static EndGateway END_GATEWAY()
 * @method static EndPortal END_PORTAL()
 * @method static FloweringAzalea FLOWERING_AZALEA()
 * @method static FrogSpawn FROG_SPAWN()
 * @method static MossCarpet MOSS_CARPET()
 * @method static Piston PISTON()
 * @method static PistonArmCollision PISTON_ARM_COLLISION()
 * @method static PowderSnow POWDER_SNOW()
 * @method static ReinforcedDeepslate REINFORCED_DEEPSLATE()
 * @method static RepeatingCommandBlock REPEATING_COMMAND_BLOCK()
 * @method static Kelp KELP()
 * @method static Sculk SCULK()
 * @method static SculkCatalyst SCULK_CATALYST()
 * @method static SculkSensor SCULK_SENSOR()
 * @method static SculkShrieker SCULK_SHRIEKER()
 * @method static SeaGrass SEAGRASS()
 * @method static SoulCampfire SOUL_CAMPFIRE()
 * @method static GlowLichen GLOW_LICHEN()
 * @method static GrindStone GRINDSTONE()
 * @method static HoneyBlock HONEY_BLOCK()
 * @method static InfestedDeepslate INFESTED_DEEPSLATE()
 * @method static LargeAmethystBud LARGE_AMETHYST_BUD()
 * @method static Lodestone LODESTONE()
 * @method static WarpedFungus WARPED_FUNGUS()
 * @method static WarpedNylium WARPED_NYLIUM()
 * @method static WarpedRoots WARPED_ROOTS()
 */
final class VanillaBlocks{
	use CloningRegistryTrait;

	private function __construct(){
		//NOOP
	}

	protected static function register(string $name, Block&IBlockState $block) : void{
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
		self::registerNylium();
		self::registerPiston();
		self::registerRoots();
		self::registerWall();
		self::registerSculk();
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
		self::register('composter', new Composter(
			new BID(Composter::TYPE_ID()),
			'Composter',
			new Info(BreakInfo::axe(0.6))
		));
		self::register('conduit', new Conduit(
			new BID(Conduit::TYPE_ID()),
			'Conduit',
			new Info(BreakInfo::pickaxe(3))
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
		self::register('dripstone_block', new DripstoneBlock(
			new BID(DripstoneBlock::TYPE_ID()),
			'Dripstone Block',
			new Info(BreakInfo::pickaxe(1.5))
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
		self::register('end_portal', new EndPortal(
			new BID(EndPortal::TYPE_ID()),
			'End Portal',
			new Info(BreakInfo::indestructible())
		));
		self::register('frog_spawn', new FrogSpawn(
			new BID(FrogSpawn::TYPE_ID()),
			'Frog Spawn',
			new Info(self::anyZero())
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
		self::register('kelp', new Kelp(
			new BID(Kelp::TYPE_ID()),
			'Kelp',
			new Info(BreakInfo::instant())
		));
		self::register('seagrass', new SeaGrass(
			new BID(SeaGrass::TYPE_ID()),
			'Seagrass',
			new Info(self::blockToolShears(0.0))
		));
		self::register('glow_lichen', new GlowLichen(
			new BID(GlowLichen::TYPE_ID()),
			'Glow Lichen',
			new Info(self::anyZero())
		));
		self::register('grindstone', new GrindStone(
			new BID(GrindStone::TYPE_ID()),
			'Grindstone',
			new Info(BreakInfo::pickaxe(2.0))
		));
		self::register('honey_block', new HoneyBlock(
			new BID(HoneyBlock::TYPE_ID()),
			'Honey Block',
			new Info(self::anyZero())
		));
		self::register('infested_deepslate', new InfestedDeepslate(
			new BID(InfestedDeepslate::TYPE_ID()),
			'Infested Deepslate',
			new info(BreakInfo::pickaxe(1.5))
		));
		self::register('lodestone', new Lodestone(
			new BID(Lodestone::TYPE_ID()),
			'Lodestone',
			new Info(BreakInfo::pickaxe(3.5))
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
		self::register('large_amethyst_bud', new LargeAmethystBud(
			new BID(LargeAmethystBud::TYPE_ID()),
			'Large Amethyst Bud',
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
		self::register('flowering_azalea', new FloweringAzalea(
			new BID(FloweringAzalea::TYPE_ID()),
			'Flowering Azalea',
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

	private static function registerNylium() : void{
		$info = new Info(BreakInfo::pickaxe(0.4));
		self::register('crimson_nylium', new CrimsonNylium(
			new BID(CrimsonNylium::TYPE_ID()),
			'Crimson Nylium',
			$info
		));
		self::register('warped_nylium', new WarpedNylium(
			new BID(WarpedNylium::TYPE_ID()),
			'Warped Nylium',
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

	private static function registerRoots() : void{
		$info = new Info(self::anyZero());
		self::register('crimson_roots', new CrimsonRoots(
			new BID(CrimsonRoots::TYPE_ID()),
			'Crimson Roots',
			$info
		));
		self::register('warped_roots', new WarpedRoots(
			new BID(WarpedRoots::TYPE_ID()),
			'Warped Roots',
			$info
		));
	}

	private static function registerSculk() : void{
		$info = new Info(self::blockToolHoe(3.0));
		self::register('sculk', new Sculk(
			new BID(Sculk::TYPE_ID()),
			'Sculk',
			$info
		));
		self::register('sculk_catalyst', new SculkCatalyst(
			new BID(SculkCatalyst::TYPE_ID()),
			'Sculk Catalyst',
			$info
		));
		self::register('sculk_sensor', new SculkSensor(
			new BID(SculkSensor::TYPE_ID()),
			'Sculk Sensor',
			$info
		));
		self::register('sculk_shrieker', new SculkShrieker(
			new BID(SculkShrieker::TYPE_ID()),
			'Sculk Shrieker',
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
