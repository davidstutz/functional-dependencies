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
    private $_attributes = NULL;
    
    /**
     * @var array   functional dependencies
     */
    private $_functionalDependencies = NULL;
    
    /**
     * @var array cache for candidate and super keys
     */
    private $_cache = array();
    
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
     * Override the current functional dependencies by the new ones.
     * 
     * @param   object  set of functional dependencies
     */
    public function overrideFunctionalDependencies(\Libraries\Set $functionalDependencies) {
        $this->_functionalDependencies = $functionalDependencies;
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
        if (!isset($this->_cache['superKeys'])) {
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
            
            $this->_cache['superKeys'] = $superKeys;
        }
        
        return $this->_cache['superKeys'];
    }
    
    /**
     * Calculates all candidate keys.
     * 
     * @return  object  candidate keys
     */
    public function candidateKeys() {
        if (!isset($this->_cache['candidateKeys'])) {
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
            
            $this->_cache['candidateKeys'] = new \Libraries\Set($superKeys);
        }
        
        return $this->_cache['candidateKeys'];
    }
    
    /**
     * Clear the cache used for super and candidate keys.
     */
    public function clearCache() {
        $this->_cache = array();
    }
    
    /**
     * Check whether the relational schema is in second normal form.
     * 
     * @return  boolean 2NF
     */
    public function secondNormalForm() {
        $candidateKeys = $this->candidateKeys();
        
        $candidateKeyAttributes = new \Libraries\Set();
        foreach ($candidateKeys->asArray() as $candidateKey) {
            $candidateKeyAttributes->union($candidateKey);
        }
        
        foreach ($candidateKeys->asArray() as $candidateKey) {
            foreach ($candidateKey->asArray() as $keyAttribute) {
                $check = $candidateKey->copy()->remove($keyAttribute);
                $closure = $this->closure($check);
                
                foreach ($this->getAttributes()->asArray() as $attribute) {
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
    
    /**
     * Check whether the relational schema is in third normal form.
     * 
     * @return  boolean 3NF
     */
    public function thirdNormalForm() {
        $candidateKeys = $this->candidateKeys();
        $superKeys = $this->superKeys();
        
        // If the schema is not in 2NF its trivial.
        if (TRUE !== ($attribute = $this->secondNormalForm())) {
            return $attribute;
        }
        
        foreach ($this->getFunctionalDependencies()->asArray() as $functionalDependency) {
            // Consider all functional dependency of the form X -> B where X is a set of attributes and B a single attribute.
            foreach ($functionalDependency->getRightAttributes()->asArray() as $attribute) {
                
                // B is in X (trivial dependency).
                $firstCheck = $functionalDependency->getLeftAttributes()->contains($attribute);
                
                // B is part of a candidate key.
                $secondCheck = FALSE;
                foreach ($candidateKeys as $candidateKey) {
                    if ($candidateKey->contains($attribute)) {
                        $seondCheck = TRUE;
                        break;
                    }
                }
                
                // X is super key.
                $thirdCheck = FALSE;
                foreach ($superKeys as $superKey) {
                    if ($superKey->subsetOf($functionalDependency->getLeftAttributes())) {
                        $thirdCheck = TRUE;
                        break;
                    }
                }
                
                // Is in 3NF when for each functional dependency X -> B one of the above conditions hold.
                if (!($firstCheck OR $secondCheck OR $thirdCheck)) {
                    return $attribute;
                }
            }
        }
        
        return TRUE;
    }
    
    /**
     * Calculate the canonical cover.
     * 
     * @return  object  canonical cover
     */
    public function canonicalCover() {
        // Do left reduction for each function dependency.
        foreach ($this->getFunctionalDependencies()->asArray() as $functionalDependency) {
            $this->leftSideReduction($functionalDependency);
        }
        
        // Right side reduction.
        foreach ($this->getFunctionalDependencies->asArray() as $functionalDependency) {
            $this->rightSideReduction($functionalDependency);
        }
        
        // Remove functional dependencies of form X -> empty set.
        foreach ($this->getFunctionalDependencies()->asArray() as $functionalDependency) {
            if ($functionalDependency->getLeftAttributes()->isEmpty()) {
                $this->getFunctionalDependencies()->remove($functionalDependency);
            }
        }
        
        // Combine functional dependencies for X -> A1 ,... , X -> An.
        foreach ($this->getFunctionalDpendencies()->asArray() as $functionalDependency) {
            foreach ($this->getFunctionalDpendencies()->asArray() as $compareFunctionalDependency) {
                if ($compareFunctionalDependency->equals($functionalDependency)) {
                    $functionalDependency->getRightAttributes()->union($compareFunctionalDependency);
                    $this->getFunctionalDependencies()->remove($compareFunctionalDependency);
                }
            }
        }
    }
    
    /**
     * Calculate the base of the schema.
     * The base is calculated by right and left reduction of all dependencies and removing redundant ones.
     * 
     * @return  object  base of functional dependencies
     */
    public function base() {
        $functionalDependencies = new \Libraries\Set();
        
        // Decompose X -> Y := {A1, ..., An} into X -> A1, ..., X -> An.
        foreach ($this->getFunctionalDependencies()->asArray() as $functionalDependency) {
            if ($functionalDependency->getRightAttributes()->size() > 1) {
                foreach ($functionalDependency->getRightAttributes()->asArray() as $attribute) {
                    $functionalDependencies->add(new \Libraries\FunctionalDependency($functionalDependency->getLeftAttributes()->copy(), new \Libraries\Set(array($attribute))));
                }
            }
        }
        
        // Kind of left side reduction.
        foreach ($functionalDependencies->asArray() as $functionalDependency) {
            foreach ($functionalDependency->getLeftAttributes()->asArray() as $leftAttribute) {
                // Beacuse of the step one the should only be on right attribute:
                foreach ($functionalDependency->getRightAttributes()->asArray() as $rightAttribute) {
                    if ($this->closure($functionalDependency->getLeftAttributes()->copy()->remove($attribute))->contains($rightAttribute)) {
                        $functionalDependency->getLeftAttributes()->remove($leftAttribute);
                    }
                }
            }
        }
        
        // Remove redundant functional dependencies.
        foreach ($functionalDependencies->asArray() as $functionalDependency) {
            $reducedFunctionalDependencies = new \Libraries\RelationalSchema($this->getAttributes()->copy(), $functionalDependencies->copy()->remove($functionalDependency));
            
            // There should only be one right hand attribute.
            foreach ($functionalDependency->getRightAttributes()->asArray() as $rightAttribute) {
                if ($reducedFunctionalDependencies->closure($functionalDependency->getLeftAttributes())->contains($rightAttribute)) {
                    $this->getFunctionalDependencies()->remove($functionalDependency);
                }
            }
        }
        
        return $functionalDependencies;
    }
    
    /**
     * Get any relational scheme into third normal form.
     */
    public function thirdNormalFormSynthesis() {
        // We will return a se of new relational schemes.
        $schemes = new \Libraries\Set();
        
        // Get a base of the current scheme.
        $base = $this->base();
        
        foreach ($base->asArray() as $functionalDependency) {
            $attributes = new \Libraries\Set();
            $attributes->union($functionalDependency->getLeftAttributes());
            foreach ($base->asArray() as $additionalAttributes) {
                if ($additionalAttributes->getLeftAttributes()->equals($functionalDependency->getLeftAttributes())) {
                    $attributes->union($additionalAttributes->getRightAttributes());
                }
            }
            
            // Create the new scheme.
            $scheme = new \Libraries\RelationalSchema($attributes);
            
            // Now get all dependencies for this new scheme.
            $functionalDependencies = new \Libraries\Set();
            
        }
    }
    
    /**
     * Copy the schema.
     * 
     * @return  object  schema
     */
    public function copy() {
        return new \Libraries\RelationalSchema($this->getAttributes()->copy(), $this->getFunctionalDependencies()->copy());
    }
}
