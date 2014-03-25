<?php
/**
 *  Copyright 2013 - 2014 David Stutz
 *
 *  The library is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  @see <http://www.gnu.org/licenses/>.
 */

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
     * Check whether this functionalDependency equals another.
     * 
     * @return boolean equals
     */
    public function equals($functionalDependency) {
        new \Libraries\Assertion($functionalDependency instanceof \Libraries\FunctionalDependency, 'Tried to compare functional dependeny with object not instance of FunctionalDependency.');
    
        if (!$this->getRightAttributes()->equals($functionalDependency->getRightAttributes())) {
            return FALSE;
        }
        
        if (!$this->getLeftAttributes()->equals($functionalDependency->getLeftAttributes())) {
            return FALSE;
        }
        
        return TRUE;
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
