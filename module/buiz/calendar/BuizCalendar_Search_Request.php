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
class BuizCalendar_Search_Request extends ContextListing
{

  public $start = null;

  public $end = null;

  /**
   * Auswerten des Requests
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {

    $this->extSearchValidator = new ValidSearchBuilder();
    parent::interpretRequest($request);

    $this->conditions = [];

    // search free
    $this->conditions['free'] = $request->param('free_search', Validator::SEARCH);

    $start = $request->param('start', Validator::INT);
    if(!$start)
      $start = time();
    $this->start = date('Y-m-d H:i:s',$start );

    $end = $request->param('end', Validator::INT);
    if(!$end)
      $end = time()+2678400; // + 31 tage... gehen wir mal davon aus + ein monat
    $this->end = date('Y-m-d H:i:s',$end );


  }//end public function interpretRequest */

} // end class BuizMessage_Table_Search_Request */

