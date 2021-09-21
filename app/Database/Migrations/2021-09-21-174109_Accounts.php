<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Accounts extends Migration
{
	protected $name = 'accounts';

	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'BIGINT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'account'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			],
			'code'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			],
			'type_fk'	=> [
				'type'       => 'BIGINT',
				'unsigned'       => true,
				'constraint' => 11,
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->addField("created_at DATETIME NULL DEFAULT NULL");
		$this->forge->addField("updated_at DATETIME NULL DEFAULT NULL");
		$this->forge->addField("deleted_at DATETIME NULL DEFAULT NULL");
		$this->forge->addForeignKey('type_fk', 'taccount', 'id', 'cascade', 'cascade');
		$this->forge->createTable($this->name);
	}

	public function down()
	{
		$this->forge->dropTable($this->name);
	}
}
