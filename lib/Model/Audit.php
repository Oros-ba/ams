<?php

 declare(strict_types=1);

 namespace OCA\AMS\Model;

 use OCP\AppFramework\Db\Entity;
 use OCP\DB\Types;

 /**
  * @method string getName()
  * @method void setName(string $name)
  * @method string getType()
  * @method void setType(string $type)
  * @method \DateTime getStartDate()
  * @method void setStartDate(\DateTime $startDate)
  * @method \DateTime getEndDate()
  * @method void setEndDate(\DateTime $endDate)
  */
 class Audit extends Entity implements \JsonSerializable {

     /** @var string */
     protected $name;
     /** @var string */
     protected $type;
     /** @var \DateTime */
     protected $startDate;
     /** @var \DateTime */
     protected $endDate;

     public function __construct() {
         $this->addType('name', Types::STRING);
         $this->addType('type', Types::STRING);
         $this->addType('startDate', Types::DATETIME);
         $this->addType('endDate', Types::DATETIME);
     }


	 /**
	  * @return array
	  */
     public function jsonSerialize(): array {
         return [
             'id' => $this->id,
             'name' => $this->name,
             'type' => $this->type,
             'startDate' => $this->startDate,
             'endDate' => $this->endDate,
         ];
     }
 }
