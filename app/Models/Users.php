<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'users';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = \App\Entities\Users::class;
    protected $useSoftDeletes       = true;
    protected $protectFields        = true;
    protected $allowedFields        = ['name', 'surname', 'address', 'phone', 'credential_fk'];

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
                users.id, 
                users.`name`, 
                users.surname, 
                users.address, 
                users.phone, 
                users.credential_fk AS credentials, 
                auth.email, 
                auth.username, 
                auth.`password`, 
                users.created_at, 
                users.updated_at, 
                users.deleted_at
			')
            ->join('auth', 'users.credential_fk = auth.id')
            ->findAll();
    }

    public function getOne($id)
    {
        return $this->select('
                users.id, 
                users.`name`, 
                users.surname, 
                users.address, 
                users.phone, 
                users.credential_fk AS credentials, 
                auth.email, 
                auth.username, 
                auth.`password`, 
                users.created_at, 
                users.updated_at, 
                users.deleted_at
			')
            ->join('auth', 'users.credential_fk = auth.id')
            ->where('users.credential_fk', $id)
            ->first();
    }
}
