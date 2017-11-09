<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}


// enable "sysfolder" field
$GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['sysfolder']['displayCond'] .= ',hwtaddressindexer';