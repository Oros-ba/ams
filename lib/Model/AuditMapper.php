<?php

namespace OCA\AMS\Model;


use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;
use OCP\AppFramework\Db\QBMapper;
use OCP\DB\Exception;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;

/**
 * @method Audit mapRowToEntity(array $row)
 * @method Audit findEntity(IQueryBuilder $query)
 * @method list<Audit> findEntities(IQueryBuilder $query)
 * @template-extends QBMapper<Audit>
 */
class AuditMapper extends QBMapper {

	public function __construct(IDBConnection $db) {
		parent::__construct($db, 'ams_audit', Audit::class);
	}

	/**
	 * @param int $id
	 * @return Audit
	 * @throws DoesNotExistException
	 * @throws MultipleObjectsReturnedException|Exception
	 */
	public function getAudit(int $id): Audit {
		$qb = $this->db->getQueryBuilder();
		$qb->select('*')
			->from($this->getTableName())
			->where(
				$qb->expr()->eq('id', $qb->createNamedParameter($id, IQueryBuilder::PARAM_INT))
			);
		return $this->findEntity($qb);
	}


	/**
	 * @param string $name
	 * @param string $type
	 * @param \DateTime $startDate
	 * @param \DateTime $endDate
	 * @return Audit
	 * @throws Exception
	 */
	public function createAudit(string $name, string $type, \DateTime $startDate, \DateTime $endDate): Audit {
		$audit = new Audit();
		$audit->setName($name);
		$audit->setType($type);
		$audit->setStartDate($startDate);
		$audit->setEndDate($endDate);
		return $this->insert($audit);
	}

	/**
	 * @param int $id
	 * @param string $userId
	 * @param string|null $name
	 * @param string|null $type
	 * @param \DateTime|null $startDate
	 * @param \DateTime|null $endDate
	 * @return Audit|null
	 * @throws Exception
	 */
	public function updateAudit(int        $id,
								?string    $name = null,
								?string    $type = null,
								?\DateTime $startDate = null,
								?\DateTime $endDate = null): ?Audit {
		if ($name === null && $type === null && $startDate === null && $endDate === null) {
			return null;
		}
		try {
			$audit = $this->getAudit($id);
		} catch (DoesNotExistException|MultipleObjectsReturnedException $e) {
			return null;
		}
		if ($name !== null) {
			$audit->setName($name);
		}
		if ($type !== null) {
			$audit->setType($type);
		}
		if ($startDate !== null) {
			$audit->setStartDate($startDate);
		}
		if ($endDate !== null) {
			$audit->setEndDate($endDate);
		}
		return $this->update($audit);
	}

	/**
	 * @param int $id
	 * @return Audit|null
	 * @throws Exception
	 */
	public function deleteAudit(int $id): ?Audit {
		try {
			$audit = $this->getAudit($id);
		} catch (DoesNotExistException|MultipleObjectsReturnedException $e) {
			return null;
		}
		return $this->delete($audit);
	}


}
