<?php

namespace Libraries\Tests;

/**
 * SetTest class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class SetTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * Provides data for testing subsetOf.
     * 
     * @return  array   data
     */
    public function providerSubsetOf() {
        return array(
            array(
                array(1,2),
                array(1,2),
                TRUE,
            ),
            array(
                array(1,2),
                array(1,2,3),
                TRUE,
            ),
        );
    }
    
    /**
     * Tests the subsetOf method.
     * 
     * @test
     * @dataProvider providerSubsetOf
     * @param   array   subset
     * @param   array   superset
     * @param   bollean expected
     */
    public function testSubsetOf($subset, $superset, $expected) {
        $subset = new \Libraries\Set($subset);
        $superset = new \Libraries\Set($superset);
        
        $this->assertSame($expected, $subset->subsetOf($superset));
    }
    
    /**
     * Provides data for testing subsetOf.
     * 
     * @return  array   data
     */
    public function providerUnion() {
        return array(
            array(
                array(1,2),
                array(3,4),
                array(1,2,3,4),
            ),
            array(
                array(1,2,3),
                array(3,4),
                array(1,2,3,4),
            ),
        );
    }
    
    /**
     * Tests the subsetOf method.
     * 
     * @test
     * @dataProvider providerUnion
     * @param   array   first
     * @param   array   second
     * @param   bollean expected
     */
    public function testUnion($first, $second, $expected) {
        $first = new \Libraries\Set($first);
        $second = new \Libraries\Set($second);
        
        $this->assertSame($expected, $first->union($second)->asArray());
    }
    
    /**
     * Provides data for testing powerSet.
     * 
     * @return  array   data
     */
    public function providerPowerSet() {
        return array(
            array(
                array(1,2,3),
                array(array(1,2,3), array(2,3), array(2), array(3), array(1,3), array(1), array(2,3))
            ),
        );
    }
    
    /**
     * Tests the powerSet method.
     * 
     * @test
     * @dataProvider providerPowerSet
     * @param   array   first
     * @param   array   second
     * @param   bollean expected
     */
    public function testPowerSet($set, $powerset) {
        $set = new \Libraries\Set($set);
        
        $this->assertSame($powerset, $set->powerSet()->asArray());
    }
}
    