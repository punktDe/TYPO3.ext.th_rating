<?php
declare(strict_types = 1);

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Configuration\Extbase\Persistence;

return [
    \Thucke\ThRating\Domain\Model\Voter::class => [
        'tableName' => 'fe_users',
    ],
    \Thucke\ThRating\Domain\Model\Stepname::class => [
        'tableName' => 'tx_thrating_domain_model_stepname',
        'properties' => [
            'sysLanguageUid' => [
                'fieldName' => 'sys_language_uid'
            ]
        ]
    ],
    \TYPO3\CMS\Extbase\Domain\Model\FrontendUser::class => [
        'subclasses' => [
            'Tx_ThRating_Domain_Model_Voter' => \Thucke\ThRating\Domain\Model\Voter::class
        ]
    ]
];
