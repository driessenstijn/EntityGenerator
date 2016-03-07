<?php
/**
 * EntityGenerator
 * 
 * EntityGenerators will provide you the required files for applications that uses entities, such as ZF2.
 * 
 * @author Stijn Driessen <driessen.stijn@gmail.com>
 * @license MIT
 * 
 */

namespace EntityGenerator;

/**
 * Class Waper
 * 
 * This class returns the logo of the website that you provide inside the construct
 * 
 * @category HourPendulum
 * @package HourPendulum\EntityGenerator
 * 
 * Need to create Entity\<name>.php
 * Need to create Entity\<name>Interface.php
 * 
 */

class EntityGenerator
{
   /*
    * @param array $properties properties that we need to convert
    * @param string $seperation whatever seperates first entity from second entity
    * @return $array mixed result
    */
    public function create($tableName, $columns, $seperation = '/\s+/') 
    {
		$result = array();
		$properties = '';
		$gettersSetters = ''; $gettersSettersInterface = '';
        foreach(preg_split("/((\r?\n)|(\r\n?))/", $columns) as $property){
            // do something
			$data = preg_split($seperation, $property);
			$column = $this->camelCase($data[0]);
			$type = $this->getVariableType($data[1]);
			
			$properties .= $this->createProperties($column, $type);
			$gettersSetters .= $this->createGettersSetters($column, $type);
			$gettersSettersInterface .= $this->createGettersSettersInterface($column, $type);
        }
		
		$tableName = $this->camelCase($tableName);
		
		// First base file
		$entity = '<?php&#13;&#10;&#13;&#10;namespace Module\Entity;&#13;&#10;&#13;&#10;class '.ucfirst($tableName).' implements '.ucfirst($tableName).'Interface&#13;&#10;{'.$properties.$gettersSetters.'&#13;&#10;}';
        $result[ucfirst($tableName).'.php'] = $entity;
		
		// Interface file
		$entity = '<?php&#13;&#10;&#13;&#10;namespace Module\Entity;&#13;&#10;&#13;&#10;interface '.ucfirst($tableName).'Interface&#13;&#10;{'.$gettersSettersInterface.'&#13;&#10;}';
		$result[ucfirst($tableName).'Interface.php'] = $entity;
		
		
		return $result;
    }
	
	/*
	* @param string $name property to get camelcasing
	* @return string
	*/
	public function camelCase($name)
	{
		return preg_replace('/_(.?)/e',"strtoupper('$1')",$name); 
	}
	
	/*
	* @param string $type property of database to get translated to value for PHP
	* @return string
	*/
 	public function getVariableType($type) 
	{
		if(strpos($type, 'int') !== false) {
			return 'integer';
		}
		
		if(strpos($type, 'char') !== false) {
			return 'string';
		}		

		if(strpos($type, 'timestamp') !== false) {
			return 'timestamp';
		}	
		
		return 'string';
	}
	
	public function createProperties($column, $type)
	{
		return '&#13;&#10;&#13;&#10;  /*&#13;&#10;  *&#13;&#10;  * @var '.$type.'&#13;&#10;  */&#13;&#10;  private $'.$column.';';
	}
	
	public function createGettersSetters($column, $type, $property)
	{
		return '&#13;&#10;&#13;&#10;  public function get'.ucfirst($column).'() {&#13;&#10;    return $this->'.$column.';&#13;&#10;  }'.
			   '&#13;&#10;&#13;&#10;  public function set'.ucfirst($column).'($'.$column.') {&#13;&#10;    $this->'.$column.' = $'.$column.';&#13;&#10;    return $this;&#13;&#10;  }';
    }

	public function createGettersSettersInterface($column, $type)
	{
		return '&#13;&#10;&#13;&#10;  public function get'.ucfirst($column).'();'.
			   '&#13;&#10;&#13;&#10;  public function set'.ucfirst($column).'($'.$column.');';
    }

}