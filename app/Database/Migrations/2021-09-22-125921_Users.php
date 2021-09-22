<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
	protected $name = 'users';

	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'BIGINT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'name'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			],
			'surname'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			],
			'address'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			],
			'phone'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			],
            'credential_fk'	=> [
				'type'           => 'BIGINT',
				'constraint'     => 11,
				'unsigned'       => true,
				'null'			 => false
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addField("created_at DATETIME NULL DEFAULT NULL");
		$this->forge->addField("updated_at DATETIME NULL DEFAULT NULL");
		$this->forge->addField("deleted_at DATETIME NULL DEFAULT NULL");
		$this->forge->addForeignKey('credential_fk', 'auth', 'id', 'cascade', 'cascade');
		$this->forge->addUniqueKey('credential_fk');
		$this->forge->createTable($this->name);
	}

	public function down()
	{
		$this->forge->dropTable($this->name);
	}
}
