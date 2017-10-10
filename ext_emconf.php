<?php

########################################################################
# Extension Manager/Repository config file for ext "hwt_address".
#
# Auto generated 23-11-2012 14:26
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Modern Address',
    'description' => 'Address handling für TYPO3 (since 6.2)',
    'category' => 'plugin',
    'author' => 'Heiko Westermann',
    'author_email' => 'hwt3@gmx.de',
    'author_company' => 'tie-up media',
    'shy' => '',
    'dependencies' => 'cms',
    'conflicts' => '',
    'priority' => '',
    'module' => '',
    'state' => 'excludeFromUpdates',
    'internal' => '',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'author_company' => '',
    'version' => '0.1.0-feature',
    'constraints' => array(
        'depends' => array(
            'typo3' => '7.6.0-8.7.99',
            'php' => '5.3.0-7.1.99',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
            'ke_search' => '',
        ),
    ),
);