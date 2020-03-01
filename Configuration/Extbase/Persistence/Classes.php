<?php
declare(strict_types = 1);
namespace Thucke\ThRating\Configuration\Extbase\Persistence;

return [
    \Thucke\ThRating\Domain\Model\Voter::class => [
        'tableName' => 'fe_users',
    ],
    \Thucke\ThRating\Domain\Model\Stepname::class => [
        'tableName' => 'tx_thrating_domain_model_stepname',
        'properties' => [
            'languageUid' => [
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
