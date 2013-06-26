<?php

namespace Libraries;

/**
 * Set class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class Set {
    
    /**
     * @var array   data
     */
    private $_data = array();
    
    /**
     * Constructor.
     * 
     * @param   array   data
     */
    public function __construct($data = NULL) {
        if (is_array($data)) {
            // Ignore keys.
            foreach ($data as $value) {
                if (FALSE === $this->contains($value)) {
                    $this->_data[] = $value;
                }
            }
        }
    }
    
    /**
     * Tests whether the set is subset of a given set.
     * 
     * @param   object  set
     */
    public function subsetOf($set) {
        foreach ($this->asArray() as $value) {
            if (!$set->contains($value)) {
                return FALSE;
            }
        }
        
        return TRUE;
    }
    
    /**
     * Checks whether the searched element is contained in this set.
     * 
     * @param   mixed   value
     * @return  boolean contained
     */
    public function contains($searched) {
        if (is_object($searched)) {
            foreach ($this->asArray() as $key => $value) {
                if ($searched->equals($value)) {
                    return TRUE;
                }
            }
            
            return FALSE;
        }
        else {
            return FALSE !== array_search($searched, $this->asArray());
        }
    }
    
    /**
     * Remove the given element.
     * 
     * @param   mixed   value
     * @return  object  this
     */
    public function remove($searched) {
        
        if (is_object($searched)) {
            foreach ($this->asArray() as $key => $value) {
                if ($searched->equals($value)) {
                    unset($this->_data[$key]);
                }
            }
        }
        else {
            if (FALSE !== ($key = array_search($searched, $this->asArray()))) {
                unset($this->_data[$key]);
            }
        }
        return $this;
    }
    
    /**
     * Copy the set.
     * 
     * @return  object  copy
     */
    public function copy() {
        return new \Libraries\Set($this->asArray());
    }
    
    /**
     * Get the set as array.
     * 
     * @return  array   set
     */
    public function asArray() {
        return $this->_data;
    }
    
    /**
     * Add an element.
     * 
     * @param   mixed   value
     */
    public function add($value) {
        // Keep set properties.
        if (FALSE === $this->contains($value)) {
            $this->_data[] = $value;
        }
    }
    
    /**
     * Union with the given set.
     * 
     * @param   object set
     * @return  object  this
     */
    public function union($set) {
        foreach ($set->asArray() as $value) {
            if (FALSE === $this->contains($value)) {
                $this->add($value);
            }
        }
        
        return $this;
    }
    
    /**
     * Get the powerset of the set.
     * 
     * @return  object  powerset
     */
    public function powerSet() {
        return \Libraries\Set::_powerSet($this);
    }
    
    /**
     * Just a wrapper for print_r.
     * 
     * @return  string  print_r
     */
    public function __toString() {
        $set = '';
        
        foreach ($this->asArray() as $value) {
            if ($value instanceof \Libraries\Set) {
                $set .= $value->__toString() . ',';
            }
            else {
                $set .= $value . ',';
            }
        }
        
        return '{' . substr($set, 0, strlen($set) - 1) . '}';
    }
    
    /**
     * Get the size of the set.
     * 
     * @return  int size
     */
    public function size() {
        return sizeof($this->asArray());
    }
    
    /**
     * Check equality.
     * Can not check equality for sets of sets etc. .
     * 
     * @param   object  set
     * @return  boolean equal
     */
    public function equals($set) {
        if ($set->size() != $this->size()) {
            return FALSE;
        }
        
        foreach ($this->asArray() as $value) {
            if (!$set->contains($value)) {
                return FALSE;
            }
        }
        
        foreach ($set->asArray() as $value) {
            if (!$this->contains($value)) {
                return FALSE;
            }
        }
        
        return TRUE;
    }
    
    /**
     * Powerset helper for recursion.
     * 
     * @param   object   set
     */
    private function _powerSet($set) {
        $result = new \Libraries\Set();
        $result->add($set->copy());
        
        if ($set->size() <= 1) {
            $result->add($set);
            
            return $result;
        }
        
        foreach ($set->asArray() as $value) {
            $result->union(\Libraries\Set::_powerSet($set->copy()->remove($value)));
        }
        
        return $result;
    }
}
