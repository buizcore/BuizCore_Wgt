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
class BuizBookmark_Controller extends Controller
{

  /**
   * @var array
   */
  protected $options = array
  (
    'add' => array
    (
      'method' => array('POST'),
      'views' => array('ajax')
    ),
  );

/*////////////////////////////////////////////////////////////////////////////*/
// Base Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_add($request, $response)
  {

    /* @var $modelBookmark BuizBookmark_Model */
    //$modelBookmark = $this->loadModel('BuizBookmark');

    $userId = $this->getUser()->getId();

    $title = $request->data('buiz_bookmark', Validator::TEXT, 'title');
    $url = $request->data('buiz_bookmark', Validator::TEXT, 'url');
    $vid = $request->data('buiz_bookmark', Validator::EID, 'vid');

    $orm = $this->getOrm();
    $bookmark = $orm->newEntity('BuizBookmark');
    $bookmark->id_role = $userId;
    $bookmark->title = $title;
    $bookmark->url = $url;
    $bookmark->vid = $vid;

    $orm->insertIfNotExists($bookmark, array('id_role', 'url'));

    $response->addMessage($this->getI18n()->l('Created bookmark','wbf.message'));

  }//end public function service_add */

} // end class BuizBookmark_Controller

