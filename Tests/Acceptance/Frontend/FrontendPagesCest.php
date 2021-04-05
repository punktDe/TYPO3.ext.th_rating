<?php
declare(strict_types = 1);

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\Timezones\Tests\Acceptance\Frontend;

use Thucke\Timezones\Tests\Acceptance\Support\AcceptanceTester;

class FrontendPagesCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function firstPageIsRendered(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Acceptance test first header');
        $currentTimezone = new \IntlDateFormatter(null, \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        // check for default timezone abbrevation
        //$I->see($currentTimezone->formatObject(new \DateTime(), 'zzzz', 'en_US'));
        /**$I->click('Customize');
        $I->see('Incredible flexible'); */
    }
}
