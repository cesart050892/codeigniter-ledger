<?php

namespace App\Models;

use CodeIgniter\Model;

class Accounts extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'accounts';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = \App\Entities\Accounts::class;
    protected $useSoftDeletes       = true;
    protected $protectFields        = true;
    protected $allowedFields        = ['account', 'code', 'type_fk'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    // functions

    public function getAll()
    {
        return $this->select('
        accounts.id, 
        taccount.`type-account`, 
        taccount.`code` AS `code-general`, 
        accounts.`code`, 
        accounts.account, 
        accounts.type_fk
    ')
            ->join('taccount', 'accounts.type_fk = taccount.id')
            ->findAll();
    }
}
