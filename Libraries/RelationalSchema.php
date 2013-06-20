<?php

namespace Libraries;

/**
 * Relational schema class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class RelationalSchema {

    /**
     * @var array  attributes
     */
    private $_attributes;
    
    /**
     * @var array   functional dependencies
     */
    private $_functionalDependencies;
    
    /**
     * Constructor. Create a new relational schema by an array of attributes
     * and an array of functional dependencies (optional).
     * 
     * @param   array   attributes
     * @param   array   function dependencies
     */
    public function __construct(\Libraries\Set $attributes, \Libraries\Set $functionlDependencies = NULL) {
        $this->_attributes = $attributes;
        
        if (!$functionlDependencies instanceof \Libraries\Set) {
            $this->_functionalDependencies = new \Libraries\Set();
        }
    }
    
    // Remove and add attribute methods are provided by the Set.
    
    /**
     * Get attributes.
     * 
     * @return  object   attributes
     */
    public function getAttributes() {
        return $this->_attributes;
    }
    
    // Adding functional dependencies is procided by the Set.
    
    /**
     * Get functional dependencies.
     * 
     * @return   object   functional dependencies
     */
    public function getFunctionalDependencies() {
        return $this->_functionalDependencies;
    }
    
    /**
     * Calculate the closure of a set of attributes.
     * 
     * @param   array   attributes
     * @return  array   closure
     */
    public function closure(\Libraries\Set $attributes) {
        new \Libraries\Assertion($attributes->subsetOf($this->getAttributes()), 'Attributes do not exist within the relational schema.');
        
        $changed = TRUE;
        $result = $attributes->copy();
        
        while (TRUE === $changed) {
            $changed = FALSE;
            $size = $result->size();
            
            foreach ($this->getFunctionalDependencies()->asArray() as $functionalDependency) {
                if ($functionalDependency->getLeftAttributes()->subsetOf($result)) {
                    $result->union($functionalDependency->getRightAttributes());
                }
            }
            
            if ($result->size() > $size) {
                $changed = TRUE;
            }
        }
        
        return $result;
    }
    
    /**
     * Calculates all super keys.
     * 
     * @return  object  super keys
     */
    public function superKeys() {
        $superKeys = new \Libraries\Set();
        
        // Go through all subsets of the attributes.
        foreach ($this->getAttributes()->powerSet()->asArray() as $subset) {
            // The subset is of class Set.
            
            // Calculate the closure to see if this is a possible key.
            $closure = $this->closure($subset);
            if ($this->getAttributes()->subsetOf($closure)) {
                $superKeys->add($subset);
            }
        }
        
        return $superKeys;
    }
    
    /**
     * Calculates all candidate keys.
     * 
     * @return  object  candidate keys
     */
    public function candidateKeys() {
        $superKeys = $this->superKeys()->asArray();
        
        foreach ($superKeys as $key) {
            foreach ($superKeys as $index => $superset) {
                if (!$key->equals($superset)) {
                    if ($key->subsetOf($superset)) {
                        unset($superKeys[$index]);
                    }
                }
            }
        }
        
        return new \Libraries\Set($superKeys);
    }
    
    /**
     * Check whether the realtional schema is in second normal form.
     * 
     * @return  boolean 2NF
     */
    public function secondNormalForm() {
        $candidateKeys = $this->candidateKeys();
        
        $candidateKeyAttributes = new \Libraries\Set();
        foreach ($candidateKeys as $candidateKey) {
            $candidateKeyAttributes->union($candidateKey);
        }
        
        foreach ($candidateKeys as $candidateKey) {
            foreach ($candidateKey->asArray() as $keyAttribute) {
                $check = $candidateKey->copy()->remove($keyAttribute);
                $closure = $this->closure($check);
                
                foreach ($this->_attributes->asArray() as $attribute) {
                    if (!$candidateKeyAttributes->contains($attribute)) {
                        if ($closure->contains($attribute)) {
                            return $attribute;
                        }
                    }
                }
            }
        }
        
        return TRUE;
    }
}
