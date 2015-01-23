<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH
* @project     : BuizCore - The Business Core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * Template Areas ermöglichen das Ersezten von HTML Blöcken im Browser anhand
 * von JQery kompatiblen Selectoren.
 * @see http://api.jquery.com/category/selectors/
 *
 * @example
 * set content direct
 * <code>
 * // create new area from the active view
 * $area = $view->newArea('keyToIdentifyAreaInTheTpl');
 * $area->action = 'html';
 * $area->position = '#jueryId';
 * $area->setContent('<p>new content if the node with the id: jueryId</p>');
 * <code>
 *
 * @example
 * use as template container
 * <code>
 * // create new area from the active view
 * $area = $view->newArea('keyToIdentifyAreaInTheTpl');
 * $area->action = 'html';
 * $area->position = '#jueryId';
 *
 * // here you have all possibilities from LibTemplate
 * $area->setTemplate('some/template');
 * $area->addVar('some','Var');
 * <code>
 *
 * @package net.buizcore.wgt
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class LibTemplateArea extends LibTemplateAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * type wird intern verwendet
   * DONT CHANGE as long you don't know what the hell you are doing
   * @var string
   */
  public $type = 'area';

} // end class LibTemplateArea

