<?php

declare(strict_types=1);

namespace MST\MstReloadtrigger\Hooks;

use TYPO3\CMS\Core\Core\Environment;

class ReloadFrontendSignal
{
  public function clearCachePostProc(&$params, &$pObj)
  {
    $this->touch();
  }

  public function processCmdmap_postProcess($command, $table, $id, $value, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj)
  {
    $this->touch();
  }

  private function touch()
  {
    touch(Environment::getPublicPath() . '/typo3temp/ReloadFrontend.now');
  }
}
