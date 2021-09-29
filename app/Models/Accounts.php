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
    protected $allowedFields        = ['account', 'code', 'nature_fk'];

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
        $data = $this->select('
        accounts.id,
        nature.nature,
        nature.`code` AS general,
        accounts.`code`,
        accounts.account,
        accounts.nature_fk 
    ')
            ->join('nature', 'accounts.nature_fk = nature.id')
            ->findAll();
        if (!$data) throw new \Exception('Could not find post for specified ID');
        return $data;
    }

    public function getOne($id)
    {
        $data = $this->select('
        accounts.id,
        nature.nature,
        nature.`code` AS general,
        accounts.`code`,
        accounts.account,
        accounts.nature_fk 
    ')
            ->join('nature', 'accounts.nature_fk = nature.id')
            ->where('accounts.id', $id)
            ->first();
        if (!$data) throw new \Exception('Could not find for specified ID');
        return $data;
    }
}
