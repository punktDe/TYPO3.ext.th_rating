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

    /**
     * @param AcceptanceTester $I
     */
    public function showTimezoneIsRendered(AcceptanceTester $I): void
    {
        $currentTimezone = new \IntlDateFormatter(null, \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $I->amOnPage('/show-timezone');
        $I->see('Your current timezone is set to:');
        // check for default timezone abbrevation
        $I->see($currentTimezone->formatObject(new \DateTime(), 'zzzz', 'en_US'));
    }

    /**
     * @param AcceptanceTester $I
     */
    public function selectTimezoneIsRendered(AcceptanceTester $I): void
    {
        $currentTimezone = new \IntlDateFormatter(null, \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $I->resetCookie('tx_timezones_pi1');
        $I->amOnPage('/select-timezone');
        $I->see('Please select:');
        // check for default timezone abbrevation
        $I->see($currentTimezone->getTimeZoneId());
    }

    /**
     * @param AcceptanceTester $I
     */
    public function submitTimezoneIsPersistent(AcceptanceTester $I): void
    {
        $currentTimezone = new \IntlDateFormatter(null, \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $I->resetCookie('tx_timezones_pi1');
        $I->amOnPage('/select-timezone');

        $form = [
            'tx_timezones_pi1[timezone]' => 'America/Los_Angeles'
        ];
        $I->submitForm('#tzset', $form);
        // check for default timezone abbrevation
        $I->seeInFormFields('#tzset', $form);
        $I->seeCookie('tx_timezones_pi1');

        //check change of timezone also on other page and confirm cookie functionality
        $I->amOnPage('/');
        $I->assertSame('America%2FLos_Angeles', $I->grabCookie('tx_timezones_pi1'));
        $I->see('Pacific Daylight Time');
    }
}
