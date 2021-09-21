<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transactions extends Migration
{
	protected $name = 'transactions';

	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'BIGINT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'transaction'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
            ],
            'quantity'	=> [
				'type'       => 'DOUBLE',
                'constraint' => '11,2',
				'null' => FALSE,
				'default' => 0.00
			],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
        	],
			'account_fk'	=> [
				'type'       => 'BIGINT',
				'unsigned'       => true,
				'constraint' => '11',
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
		$this->forge->addForeignKey('account_fk', 'accounts', 'id', 'cascade', 'cascade');
		$this->forge->addForeignKey('type_fk', 'ttransaction', 'id', 'cascade', 'cascade');
		$this->forge->createTable($this->name);
	}
	public function down()
	{
		$this->forge->dropTable($this->name);
	}
}
