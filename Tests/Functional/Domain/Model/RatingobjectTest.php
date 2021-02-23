<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Tests\Functional\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Thucke\ThRating\Domain\Model\Ratingobject;

/**
 * Testcases for Ratingobject
 *
 * @version 	$Id:$
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		alpha
 * @entity
 */
class RatingobjectTest extends UnitTestCase
{
    /**
     * @var Ratingobject
     */
    protected $fixture;

    public function setUp():void
    {
        parent::setUp();
        $this->fixture = new Ratingobject('tt_news', 'uid');
    }

    public function tearDown():void
    {
        unset($this->fixture);
        parent::tearDown();
    }

    /**
     * Checks construction of a new rating object
     */
    public function testConstructor(): void
    {
        static::assertEquals('tt_news', $this->fixture->getRatetable());
        static::assertEquals('uid', $this->fixture->getRatefield());
    }
}
