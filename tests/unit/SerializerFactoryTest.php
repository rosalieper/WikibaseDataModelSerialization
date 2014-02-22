<?php

namespace Tests\Wikibase\DataModel;

use DataValues\Serializers\DataValueSerializer;
use Wikibase\DataModel\Claim\Claim;
use Wikibase\DataModel\Claim\Claims;
use Wikibase\DataModel\Entity\Item;
use Wikibase\DataModel\Entity\Property;
use Wikibase\DataModel\Reference;
use Wikibase\DataModel\ReferenceList;
use Wikibase\DataModel\SerializerFactory;
use Wikibase\DataModel\SiteLink;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\SnakList;

/**
 * @licence GNU GPL v2+
 * @author Thomas Pellissier Tanon
 */
class SerializerFactoryTest extends \PHPUnit_Framework_TestCase {

	private function buildSerializerFactory() {
		return new SerializerFactory( new DataValueSerializer() );
	}

	public function testNewEntitySerializer() {
		$this->assertTrue( $this->buildSerializerFactory()->newEntitySerializer()->isSerializerFor(
			Item::newEmpty()
		) );
		$this->assertTrue( $this->buildSerializerFactory()->newEntitySerializer()->isSerializerFor(
			Property::newEmpty()
		) );
	}

	public function testNewSiteLinkSerializer() {
		$this->assertTrue( $this->buildSerializerFactory()->newSiteLinkSerializer()->isSerializerFor(
			new SiteLink( 'enwiki', 'Nyan Cat' )
		) );
	}

	public function testNewClaimsSerializer() {
		$this->assertTrue( $this->buildSerializerFactory()->newClaimsSerializer()->isSerializerFor(
			new Claims()
		) );
	}

	public function testNewClaimSerializer() {
		$this->assertTrue( $this->buildSerializerFactory()->newClaimSerializer()->isSerializerFor(
			new Claim( new PropertyNoValueSnak( 42 ) )
		) );
	}

	public function testNewReferencesSerializer() {
		$this->assertTrue( $this->buildSerializerFactory()->newReferencesSerializer()->isSerializerFor(
			new ReferenceList()
		) );
	}

	public function testNewReferenceSerializer() {
		$this->assertTrue( $this->buildSerializerFactory()->newReferenceSerializer()->isSerializerFor(
			new Reference()
		) );
	}

	public function testNewSnaksSerializer() {
		$this->assertTrue( $this->buildSerializerFactory()->newSnaksSerializer()->isSerializerFor(
			new SnakList( array() )
		) );
	}

	public function testNewSnakSerializer() {
		$this->assertTrue( $this->buildSerializerFactory()->newSnakSerializer()->isSerializerFor(
			new PropertyNoValueSnak( 42 )
		) );
	}
}