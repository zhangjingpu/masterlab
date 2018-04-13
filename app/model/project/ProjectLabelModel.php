<?php
namespace main\app\model\project;
use main\app\model\CacheModel;
/**
 *   项目标签模型
 */
class ProjectLabelModel extends CacheModel
{
	public $prefix = 'project_';

	public  $table = 'label';
	
	const   DATA_KEY = 'project_label/';
	
	function __construct( $uid ='',$persistent=false )
	{
		parent::__construct( $uid,$persistent );
	
		$this->uid = $uid;
			
	}

    public function getAll(){

        return $this->getRows(  $fields="id as k,*", $conditions=array() , $append=null,$orderBy='id',
            $sort = 'asc', $limit = null, $primary_key=true );
    }


    public function getByProject( $project_id  )
    {
        $fields	=	"*,{$this->primary_key} as k";
        $where = ['project_id' => $project_id];
        $rows	=	$this->getRows($fields, $where );
        return  $rows;
    }

    public function getByProjectIdName( $project_id  ,$name )
    {
        $fields	=	"*,{$this->primary_key} as k";
        $where = ['project_id' => $project_id,'name'=>$name];
        $row	=	$this->getRow($fields, $where );
        return  $row;
    }

 

    public function deleteByLabeloId($project_id, $version_id  )
    {
        $where = ['project_id'=>$project_id, 'id'=>$version_id];
        $row	=	$this->delete(  $where );
        return  $row;
    }

    public function deleteByProject( $project_id  )
    {
        $where = ['project_id' => $project_id];
        $row	=	$this->delete(  $where );
        return  $row;
    }

    public function checkNameExist( $project_id  ,$name )
    {
        $table = $this->getTable();
        $conditions['project_id '] = $project_id ;
        $conditions['name'] = $name;
        $sql = "SELECT count(*) as cc  FROM {$table} Where project_id=:project_id AND name=:name  ";
        $count = $this->db->getOne( $sql,$conditions );
        return $count>0;
    }

    public function checkNameExistExcludeCurrent( $id, $project_id  ,$name )
    {
        $table = $this->getTable();
        $conditions['id '] = $id ;
        $conditions['project_id '] = $project_id ;
        $conditions['name'] = $name;
        $sql = "SELECT count(*) as cc  FROM {$table} Where id!=:id AND  project_id=:project_id AND name=:name  ";
        $count = $this->db->getOne( $sql,$conditions );
        return $count>0;
    }


}