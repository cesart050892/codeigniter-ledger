<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Nature extends Migration
{
	protected $name = 'nature';

	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'BIGINT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'nature'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			],
			'code'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->addField("created_at DATETIME NULL DEFAULT NULL");
		$this->forge->addField("updated_at DATETIME NULL DEFAULT NULL");
		$this->forge->addField("deleted_at DATETIME NULL DEFAULT NULL");
		$this->forge->createTable($this->name);
	}

	public function down()
	{
		$this->forge->dropTable($this->name);
	}
}
