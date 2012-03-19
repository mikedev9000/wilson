<?php

namespace wilson\data;

/**
 * Model to be used within applications. Separated from lithium so that
 * it can be customized
*/
class Model extends \lithium\data\Model {

    public function getObjectType( $entity ){
        return get_called_class();
    }
    
    protected $_fieldOptions = array();
    
    /**
     * Retreives an array suitable for use as options when creating a form element for a given field name.
     * @param lithium\data\Entity $entity
     * @param string $field 
     */
    public function getFieldOptions( $entity, $field ){
        
        if( !isset( $this->_fieldOptions ) || !isset( $this->_fieldOptions[ $field ]) )
            return array();
        else
            return $this->_fieldOptions[ $field ];
    }
    
    /**
     * Creates an entity using the given data and relationship name.
     * @param type $entity
     * @param type $relation_name
     * @param array $data
     * @return type 
     */
    public function addRelated( $entity, $relation_name, $data ){
        $self = get_called_class();
        
        if( !isset( $this->hasMany[ $relation_name ] ) )
            throw new \lithium\data\model\QueryException( "{$self} does not have a hasMany $relation_name relationship defined.");
            
        $related_class = $this->hasMany[ $relation_name ]['class'];
        
        $related_entity = $related_class::create();
        
        
        $data[ $self::key() ] = $entity->{$self::key()};
        
        $result = $related_entity->save( $data );
        
        if( !$result )
            $entity->errors( $related_entity->errors() );
        
        return $result;
    }
    
    /**
     * Loads the entity with the given relationship, then
     * @param type $entity
     * @param type $relation_name 
     */
    public function getRelated( $entity, $relation_name ){
        
        $self = get_called_class();
        
        $key = $self::key();
        
        $entity = $self::first( array(
            'conditions' => array(
                "{$self::alias()}.{$key}" => $entity->$key
            ),
            'with' => $relation_name
        ));
                
        $with = "\\app\\models\\{$relation_name}";
        
        return $entity->{$with::source()};
        
    }
    
    /**
     * Fetches the alias used in queries. Inflects this from the class name.
     * @return type 
     */
    public static function alias(){
        
        $self = get_called_class();
        
        return str_replace( "app\\models\\", "", $self );
        
    }
    
    /**
     * Provies a public interface to retrieve the $_meta['source'].
     * @return type 
     */
    public static function source()
    {
        $self = get_called_class();
        
        $self = new $self();
        
        return $self->_meta['source'];
    }

}
