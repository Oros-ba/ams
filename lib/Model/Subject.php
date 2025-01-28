<?php

namespace OCA\AMS\Model;

use OCP\AppFramework\Db\Entity;

/**
 * @method string getId()
 * @method string getName()
 * @method void setName(string $name)
 * @method string getAddress()
 * @method void setAddress(string $address)
 */
class Subject extends Entity implements \JsonSerializable {
	/** @var string */
	protected $name;
	/** @var string */
	protected $address;

	public function __construct() {
		$this->addType('name', 'string');
		$this->addType('address', 'string');
	}

	#[\ReturnTypeWillChange]
	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'address' => $this->address,
		];
	}
}
