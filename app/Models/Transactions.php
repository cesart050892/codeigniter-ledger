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
        transactions.created_at AS date,
        transactions.`transaction` AS reference,
        taccount.`type-account` AS general,
        accounts.account,
        ttransaction.`type-transaction` AS type,
        transactions.quantity,
        transactions.description 
    ')
            ->join('ttransaction', 'transactions.type_fk = ttransaction.id')
            ->join('accounts', 'transactions.account_fk = accounts.id')
            ->join('taccount', 'accounts.type_fk = taccount.id')
            ->findAll();
    }

    public function getOne($id)
    {
        return $this->select('
        transactions.created_at AS date,
        transactions.`transaction` AS reference,
        taccount.`type-account` AS general,
        accounts.account,
        ttransaction.`type-transaction` AS type,
        transactions.quantity,
        transactions.description,
        transactions.account_fk,
        transactions.type_fk 
    ')
            ->join('ttransaction', 'transactions.type_fk = ttransaction.id')
            ->join('accounts', 'transactions.account_fk = accounts.id')
            ->join('taccount', 'accounts.type_fk = taccount.id')
            ->where('transactions.id', $id)
            ->first();
    }
}
