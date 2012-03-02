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

}
