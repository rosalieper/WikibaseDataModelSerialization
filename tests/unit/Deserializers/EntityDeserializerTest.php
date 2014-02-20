<?php

namespace Tests\Wikibase\DataModel\Deserializers;

use Wikibase\DataModel\Claim\Claim;
use Wikibase\DataModel\Claim\Claims;
use Wikibase\DataModel\Entity\Item;
use Wikibase\DataModel\Entity\ItemId;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;

/**
 * @covers Wikibase\DataModel\Deserializers\EntityDeserializer
 *
 * @licence GNU GPL v2+
 * @author Thomas Pellissier Tanon
 */
class EntityDeserializerTest extends DeserializerBaseTest {

	public function buildDeserializer() {
		$entityIdDeserializerMock = $this->getMock( '\Deserializers\Deserializer' );
		$entityIdDeserializerMock->expects( $this->any() )
			->method( 'deserialize' )
			->with( $this->equalTo( 'Q42' ) )
			->will( $this->returnValue( new ItemId( 'Q42' ) ) );

		$claim = new Claim( new PropertyNoValueSnak( 42 ) );
		$claim->setGuid( 'test' );

		$claimsDeserializerMock = $this->getMock( '\Deserializers\Deserializer' );
		$claimsDeserializerMock->expects( $this->any() )
			->method( 'deserialize' )
			->with( $this->equalTo( array(
				'P42' => array(
					array(
						'mainsnak' => array(
							'snaktype' => 'novalue',
							'property' => 'P42'
						),
						'type' => 'statement',
						'rank' => 'normal'
					)
				)
			) ) )
			->will( $this->returnValue( new Claims( array( $claim ) ) ) );

		$entityDeserializerMock = $this->getMockForAbstractClass(
			'\Wikibase\DataModel\Deserializers\EntityDeserializer',
			array( 'item', $entityIdDeserializerMock, $claimsDeserializerMock )
		);
		$entityDeserializerMock->expects( $this->any() )
			->method( 'getPartiallyDeserialized' )
			->will( $this->returnValue( Item::newEmpty() ) );

		return $entityDeserializerMock;
	}

	public function deserializableProvider() {
		return array(
			array(
				array(
					'type' => 'item'
				)
			),
		);
	}

	public function nonDeserializableProvider() {
		return array(
			array(
				5
			),
			array(
				array()
			),
			array(
				array(
					'type' => 'property'
				)
			),
		);
	}

	public function deserializationProvider() {
		$provider = array(
			array(
				Item::newEmpty(),
				array(
					'type' => 'item'
				)
			),
		);

		$entity = Item::newEmpty();
		$entity->setId( new ItemId( 'Q42' ) );
		$provider[] = array(
			$entity,
			array(
				'type' => 'item',
				'id' => 'Q42'
			)
		);

		$entity = Item::newEmpty();
		$claim = new Claim( new PropertyNoValueSnak( 42 ) );
		$claim->setGuid( 'test' );
		$entity->setClaims( new Claims( array( $claim ) ) );
		$provider[] = array(
			$entity,
			array(
				'type' => 'item',
				'claims' => array(
					'P42' => array(
						array(
							'mainsnak' => array(
								'snaktype' => 'novalue',
								'property' => 'P42'
							),
							'type' => 'statement',
							'rank' => 'normal'
						)
					)
				)
			)
		);

		return $provider;
	}
}
