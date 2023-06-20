<?php

use MST\MstReloadtrigger\Hooks\ReloadFrontendSignal;
use TYPO3\CMS\Core\Core\Environment;
/**
 *
 */
(static function (): void {
    $extensionKey = 'mst_reloadtrigger';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][$extensionKey] = ReloadFrontendSignal::class . '->clearCachePostProc';
    $GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$extensionKey] = ReloadFrontendSignal::class;
    $GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][$extensionKey] = ReloadFrontendSignal::class;
})();
