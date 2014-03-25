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
 * Assertion class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class Assertion {
    
    /**
     * Constructor: Check the given booealn and throw exception with given message iff not true.
     * 
     * @throws  IllegalArgumentException
     */
    public function __construct($boolean, $message) {
        if (!$boolean) {
            throw new \InvalidArgumentException($message);
        }
    }
}
