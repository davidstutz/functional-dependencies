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
    