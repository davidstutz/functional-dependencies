<?php

namespace Libraries;

/**
 * Functional dependency class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class FunctionalDependency {

    /**
     * @var array  left attributes
     */
    private $_leftAttributes;
    
    /**
     * @var array   right attributes
     */
    private $_rightAttributes;
    
    /**
     * Constructor. Create a new relational schema by an array of attributes
     * and an array of functional dependencies (optional).
     * 
     * @param   object   attributes
     * @param   object   function dependencies
     */
    public function __construct(\Libraries\Set $leftAttributes, \Libraries\Set $rightAttributes) {
        $this->_leftAttributes = $leftAttributes;
        $this->_rightAttributes = $rightAttributes->union($this->_leftAttributes);
    }

    /**
     * Get the left attributes.
     * 
     * @return  object   left attributes
     */
    public function getLeftAttributes() {
        return $this->_leftAttributes;
    }
    
    /**
     * Get the right attributes.
     * 
     * @return  object   right attributes
     */
    public function getRightAttributes() {
        return $this->_rightAttributes;
    }
    
    /**
     * toString.
     * 
     * @return  string
     */
    public function __toString() {
        $dependency = '';
        
        foreach ($this->_leftAttributes->asArray() as $attribute) {
            $dependency .= $attribute . ',';
        }
        $dependency = substr($dependency, 0, strlen($dependency) - 1);
        $dependency .= '->';
        
        foreach ($this->_rightAttributes->asArray() as $attribute) {
            $dependency .= $attribute . ',';
        }
        $dependency = substr($dependency, 0, strlen($dependency) - 1);
        
        return $dependency;
    }
}
