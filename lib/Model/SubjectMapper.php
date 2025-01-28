<?php

namespace OCA\AMS\Model;


use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;
use OCP\AppFramework\Db\QBMapper;
use OCP\DB\Exception as DBException;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;


/**
 * @method Subject mapRowToEntity(array $row)
 * @method Subject findEntity(IQueryBuilder $query)
 * @method list<Subject> findEntities(IQueryBuilder $query)
 * @template-extends QBMapper<Subject>
 */
class SubjectMapper extends QBMapper {
	public function __construct(IDBConnection $db) {
		parent::__construct($db, 'ams_subject', Subject::class);
	}
	public function getById(int $id): ?Subject {
		$query = $this->db->getQueryBuilder();
		$query->select('*')
			->from($this->getTableName())
			->where($query->expr()->eq('id', $query->createNamedParameter($id, IQueryBuilder::PARAM_INT)));

		return $this->findEntity($query);
	}

	public function findAll()
	{
		$query = $this->db->getQueryBuilder();
		$query->select('*')
			->from($this->getTableName());

		return $this->findEntities($query);
	}

	public function update(?Subject $subject)
	{
		$query = $this->db->getQueryBuilder();
		$query->update($this->getTableName())
			->set('name', $query->createNamedParameter($subject->getName()))
			->set('address', $query->createNamedParameter($subject->getAddress()))
			->where($query->expr()->eq('id', $query->createNamedParameter($subject->getId(), IQueryBuilder::PARAM_INT)));

		$query->execute();
	}


}
