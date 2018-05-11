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
    'description' => 'Address handling for TYPO3 (since 6.2, estab. 2014)',
    'category' => 'plugin',
    'author' => 'Heiko Westermann',
    'author_email' => 'hwt3@gmx.de',
    'author_company' => 'tie-up media',
    'shy' => '',
    'dependencies' => 'cms',
    'conflicts' => '',
    'priority' => '',
    'module' => '',
    'state' => 'alpha',
    'internal' => '',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'author_company' => '',
    'version' => '0.2.0-rc.1',
    'constraints' => array(
        'depends' => array(
            'typo3' => '8.7.0-9.2.99',
            'php' => '7.0.0-7.2.99',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
            'ke_search' => '2.5.0-2.7.0',
        ),
    ),
);