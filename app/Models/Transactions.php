<?php

namespace App\Models;

use CodeIgniter\Model;

class Transactions extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'transactions';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = \App\Entities\Transactions::class;
    protected $useSoftDeletes       = true;
    protected $protectFields        = true;
    protected $allowedFields        = ['transaction', 'quantity', 'description', 'operator_fk', 'account_fk'];

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

    //functions

    public function getAll()
    {
        return $this->select('
        transactions.id, 
        transactions.`transaction`, 
        transactions.quantity, 
        transactions.description, 
        transactions.created_at, 
        nature.nature, 
        accounts.account, 
        operator.operator
    ')
            ->join('operator', 'transactions.operator_fk = operator.id')
            ->join('accounts', 'transactions.account_fk = accounts.id')
            ->join('nature', 'accounts.nature_fk = nature.id')
            ->findAll();
    }

    public function getOne($id)
    {
        return $this->select('
        transactions.id, 
        transactions.`transaction`, 
        transactions.quantity, 
        transactions.description, 
        transactions.created_at, 
        nature.nature, 
        accounts.account, 
        operator.operator,
        transactions.account_fk as account_id, 
        transactions.operator_fk as operator_id
    ')
            ->join('operator', 'transactions.operator_fk = operator.id')
            ->join('accounts', 'transactions.account_fk = accounts.id')
            ->join('nature', 'accounts.nature_fk = nature.id')
            ->where('transactions.id', $id)
            ->first();
    }

    public function getLast()
    {
        return $this->select('
        transactions.id, 
        transactions.`transaction`, 
        transactions.quantity, 
        transactions.description, 
        transactions.created_at, 
        nature.nature, 
        accounts.account, 
        operator.operator,
        transactions.account_fk as account_id, 
        transactions.operator_fk as operator_id
    ')
            ->join('operator', 'transactions.operator_fk = operator.id')
            ->join('accounts', 'transactions.account_fk = accounts.id')
            ->join('nature', 'accounts.nature_fk = nature.id')
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
