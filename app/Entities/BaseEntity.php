<?php
namespace App\Entities;

use App\Classes\Exception\DbException;
use App\Interfaces\IEntity;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Entity;

class BaseEntity{

    protected $db;
    protected $builder;
    protected $fields;
    protected $table;
    public function __construct()
    {
        helper(['date','helper','paging','inflector']);
        $this->table = strtolower(plural(str_replace("Entity", "", explode("\\",static::class)[2])));
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table($this->table);
        $this->fields = $this->db->getFieldNames($this->table);
    }
    
    /**
     * map to models
     */

    private static function getModel(){
        return str_replace(["Entities", "Entity"], ["Models", "Model"], static::class);
    }


    /**
     * @param array $filter
     * @return bool
     * check if data exist
     */
    public function isDataExit(array $filter){
        
        $data = static::getAll($filter);
        if(count($data) > 0){
            return true;
        }
        return false;
    }

    /**
     * @param int $id
     * @return App\Entities|null
     * get data from table by Id
     */
    public static function get($id){
        $where = [
            'where' => [
                "Id" => $id
            ]
        ];
        $data = static::getAll($where);
        if(count($data) > 0){
            return $data[0];
        }
        return null;

    }

    /**
     * @param int $id
     * @return App\Entities
     * get data from table by Id or return new object
     */

    public static function getOrNew($id){
       
        $where = [
            'where' => [
                "Id" => $id
            ]
        ];
        $data = static::getAll($where);
        if(empty($data))
            return new static;
        return $data[0];
    }
    
    /**
     * @param int $id
     * @return App\Entities
     * @throws DbException
     * get data from table by Id or return throw error
     */
    public static function getOrFail($id){
        $where = [
            'where' => [
                "Id" => $id
            ]
        ];
        $data = static::getAll($where);
        if(count($data) == 0)
            throw new DbException("Cannot find data with id:$id");
        return $data[0];
    }

    /**
     * @param array $filter
     * @return App\Entity
     * get first data of result from table   
     */
    public static function getOne(array $filter = null){
       
        $data = static::getAll($filter);
        if(empty($data))
            return null;
        return $data[0];
    }

    /**
     * @param array $filter
     * @return App\Entity
     * get first data of result from table   
     */
    public static function getOneOrNew(array $filter = null){
       
        $data = static::getAll($filter);
        if(empty($data))
            return new static;
        return $data[0];
    }

    /**
     * @param array $filter
     * @return App\Entity
     * get first data of result from table or throw error  
     */
    public static function getOneOrFail(array $filter = null){
       
        $data = static::getAll($filter);
        if(empty($data))
            return new DbException("Cannot find any data");
        return $data[0];
    }

    /**
     * @param array $filter
     * @return array of App\Entity
     * get all data of result from table
     */
    public static function getAll(array $filter = null){
        $entity = new static;
        $result = $entity->findAll($filter);
        if(count($result) > 0 ){
            return $result;
        }
        return null;
    }

    /**
     * @param array $filter
     * @return array of App\Entity
     * get all data of result from table or throw error
     */
    public static function getAllOrFail(array $filter = null){
        $entity = new static;
        $result = $entity->findAll($filter);
        if(count($result > 0)){
            return $result;
        }
        throw new DbException("Cannot find any data");
    }

    /**
     * @param array $filter
     * @return array of App\Entity
     * get all data of result from table
     */
    private function findAll(array $filter = null){

        $join = (isset($filter['join']) ? $filter['join'] : FALSE);
        $where = (isset($filter['where']) ? $filter['where'] : FALSE);
        $wherein = (isset($filter['whereIn']) ? $filter['whereIn'] : FALSE);
        $orwhere = (isset($filter['orWhere']) ? $filter['orWhere'] : FALSE);
        $wherenotin = (isset($filter['whereNotIn']) ? $filter['whereNotIn'] : FALSE);
        $like = (isset($filter['like']) ? $filter['like'] : FALSE);
        $orlike = (isset($filter['orLike']) ? $filter['orLike'] : FALSE);
        $order = (isset($filter['order']) ? $filter['order'] : FALSE);
        $limit = (isset($filter['limit']) ? $filter['limit'] : FALSE);
        $group = (isset($filter['group']) ? $filter['group'] : FALSE);

        if ($where)
            $this->builder->where($where);
        
        if ($wherenotin){
            foreach($wherenotin as $key => $v){
                $this->builder->whereNotIn($key, $v);
            }
        }
        if ($limit)
            $this->builder->limit($limit['size'], ($limit['page'] - 1) *  $limit['size']);

        $result = $this->builder->get()->getResult(static::class);

        return $result;
        
    }

    /**
     * will be executed before save function
     */
    public function beforeSave(){
        $this->CreatedBy = null;
        $this->Created = null;
        $this->ModifiedBy = null;
        $this->Modified = null;
    }

    /**
     * @return bool
     * insert new data to table if $Id is empty or null other wise update the data
     */

    public function save(){
        $data = [];
        foreach($this->fields as $field){
            $data[$field] = $this->$field;
        }
        if(empty($this->Id) || is_null($this->Id)){
            if($this->builder->set($data, true)->insert()){
                $this->Id = $this->db->insertID();
                return true;
            }
        } else{
            $this->builder->where('Id',$this->Id);
            $this->builder->update($data);
        }
        return false;
    }

    public function __call($name, $argument)
    {
        if (substr($name, 0, 4) == 'get_' && substr($name, 4, 5) != 'list_' && substr($name, 4, 6) != 'first_') {
            $sufixColumn = isset($argument[0]) ? "_{$argument[0]}" : null;
            $entity = 'App\\Entities\\' . substr($name, 4)."Entity";
            $field = substr($name, 4) . '_Id'. $sufixColumn;
            $entityobject = $entity;
            if (!empty($this->$field)) {
                $result = $entityobject::getOrNew($this->$field);
                return $result;
            } else {
                return new $entityobject;
            }
        } else if (substr($name, 0, 4) == 'get_' && substr($name, 4, 5) == 'list_') {

            $params = isset($argument[0]) ? $argument[0] : null;

            $entity = 'App\\Entities\\' .substr($name, 9)."Entity";
            $field = str_replace("Entity", "" ,explode("\\",static::class)[2]) . '_Id';
            $id = !empty($this->primaryKey) ? $this->{$this->primaryKey} : $this->Id;
            if (!empty($id)) {
                $entityobject = $entity;

                if (isset($params['where'])) {
                    $params['where'][$field] = $id;
                } else {
                    $params['where'] = [
                        $field => $id 
                    ];
                }

                $result = $entityobject::getAll($params);
                return $result;
            }
            return array();
        } else if (substr($name, 0, 4) == 'get_' && substr($name, 4, 6) == 'first_') {

            $params = isset($argument[0]) ? $argument[0] : null;
            $entity = 'App\\Entities\\' .substr($name, 10)."Entity";
            $field = str_replace("Entity", "" , explode("\\",static::class)[2]) . '_Id';

            $entityobject = $entity;
            $id = !empty($this->primaryKey) ? $this->{$this->primaryKey} : $this->Id;
            if (!empty($id)) {

                if (isset($params['where'])) {
                    $params['where'][$field] = $id;
                } else {
                    $params['where'] = [
                        $field => $id
                    ];
                }
                $result = $entityobject::getOneOrNew($params);
                return $result;
            }

            return new $entityobject;
        } else {
            trigger_error('Call to undefined method ' . __CLASS__ . '::' . $name . '()', E_USER_ERROR);
        }
    }
}