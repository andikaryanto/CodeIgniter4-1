<?php
namespace App\Models;

use App\Entities\BaseEntity;
use App\Interfaces\IModel;
use CodeIgniter\Model;

class BaseModel extends Model  {
    protected $db;
    protected $allowedFields;
    protected $returnType;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->allowedFields = $this->db->getFieldNames($this->table);
        $this->returnType = str_replace(["Models", "Model"], ["Entities", "Entity"],  static::class);
        parent::__construct();
    }

    public static function get($id){    
        $model = new static;
        $result = $model->find($id);
        return $result;

    }

    public static function getAll(){    
        $model = new static;
        $result = $model->findAll();
        return $result;

    }
}