<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
	
	public function paginateUsers($username, $group)
	{
		if($username != null) $this->like('username', $username);
		if($group != null) $this->like('group', $group);
		$this->select('*');
		$this->orderBy('username', 'ASC');
		return $this->paginate(50);
	}
	
	public function countUsers($username, $group)
	{
		if($username != null) $this->like('username', $username);
		if($group != null) $this->like('group', $group);
		$this->select('username');
		return $this->countAllResults();
	}
	
	public function getGroups()
	{
		$this->select('group');
		$this->distinct();
		$this->orderBy('group', 'ASC');
		return $this->get()->getResult();
	}
}
