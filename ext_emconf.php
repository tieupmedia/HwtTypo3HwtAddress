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
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '0.3.3',
    'constraints' => array(
        'depends' => array(
            'typo3' => '10.1.0-11.5.99',
            'php' => '7.0.0-8.1.99',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
            'ke_search' => '2.5.0-2.7.0',
        ),
    ),
);