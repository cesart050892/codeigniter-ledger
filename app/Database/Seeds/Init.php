<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Init extends Seeder
{
	public function run()
	{
		//
		// With this slash \ works on windows
		// And this command php spark db:seed \API\Database\Seeds\Init
		$this->call('App\Database\Seeds\Data\Ttransaction');
		$this->call('App\Database\Seeds\Data\Taccount');
		$this->call('App\Database\Seeds\Data\Accounts');
		$this->call('App\Database\Seeds\Data\Transactions');
	}
}