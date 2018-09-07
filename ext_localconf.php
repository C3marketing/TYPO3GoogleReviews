<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
	{

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'SteinbauerIT.SitGooglereviews',
            'Googleratings',
            [
                'GoogleReview' => 'show'
            ],
            // non-cacheable actions
            [
                'GoogleReview' => 'show'
            ]
        );

	// wizards
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					googleratings {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Icons/user_plugin_googleratings.svg
						title = LLL:EXT:sit_googlereviews/Resources/Private/Language/locallang_db.xlf:tx_sit_googlereviews_domain_model_googleratings
						description = LLL:EXT:sit_googlereviews/Resources/Private/Language/locallang_db.xlf:tx_sit_googlereviews_domain_model_googleratings.description
						tt_content_defValues {
							CType = list
							list_type = sitgooglereviews_googleratings
						}
					}
				}
				show = *
			}
	   }'
	);
    },
    $_EXTKEY
);
