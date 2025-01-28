<?php

declare(strict_types=1);

namespace OCA\AMS\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\DB\Types;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

class Version0001Date202501281030 extends SimpleMigrationStep {

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 */
	public function preSchemaChange(IOutput $output, Closure $schemaClosure, array $options) {
	}

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		// Create audit table
		if (!$schema->hasTable('ams_audit')) {
			$table = $schema->createTable('ams_audit');
			$table->addColumn('id', Types::BIGINT, [
				'autoincrement' => true,
				'notnull' => true,
				'length' => 4,
			]);
			$table->addColumn('name', Types::STRING, ['length' => 255, 'notnull' => true]);
			$table->addColumn('type', Types::STRING, ['length' => 255, 'notnull' => true]);
			$table->addColumn('start_date', Types::DATETIME, ['notnull' => true]);
			$table->addColumn('end_date', Types::DATETIME, ['notnull' => true]);
			$table->setPrimaryKey(['id']);
		}

		// Create subject table
		if (!$schema->hasTable('ams_subject')) {
			$table = $schema->createTable('ams_subject');
			$table->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'notnull' => true]);
			$table->addColumn('name', Types::STRING, ['length' => 255, 'notnull' => true]);
			$table->addColumn('address', Types::STRING, ['length' => 255, 'notnull' => true]);
			$table->setPrimaryKey(['id']);
		}

		// Create audit_subject table for many-to-many relationship
		if (!$schema->hasTable('ams_audit_subject')) {
			$table = $schema->createTable('ams_audit_subject');
			$table->addColumn('audit_id', Types::INTEGER, ['notnull' => true]);
			$table->addColumn('subject_id', Types::INTEGER, ['notnull' => true]);
			$table->setPrimaryKey(['audit_id', 'subject_id']);
			$table->addForeignKeyConstraint('ams_audit', ['audit_id'], ['id']);
			$table->addForeignKeyConstraint('ams_subject', ['subject_id'], ['id']);
		}

		return $schema;
	}

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 */
	public function postSchemaChange(IOutput $output, Closure $schemaClosure, array $options) {
	}
}
