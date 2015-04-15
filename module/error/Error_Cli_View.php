<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : BuizCore.com internal only
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class Error_Cli_View extends LibTemplateCli
{

  public function displayException($exception)
  {

    $out = $this->getResponse();

    $out->writeln('Sorry an internal Error occured');
    $out->writeln('');

    $out->writeln($exception->getMessage());
    $out->writeln((string) $exception);

  }

  public function displayEnduserError($exception)
  {

    $out = $this->getResponse();

    $out->writeln('Sorry an internal Error occured');
    $out->writeln('');

    $out->writeln($exception->getMessage());
    $out->writeln((string) $exception);

  }

} // end class ImportIspcats_Subwindow

