<?php
defined('TYPO3_MODE') || die();
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawHeaderHook']['em_sys_note'] =
    \Extrameile\EmSysNote\Hooks\PageLayoutHeader::class . '->render';
