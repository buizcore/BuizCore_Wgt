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
class ImportGeneric_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = [
    'mask' => [
      'method' => ['GET'],
      'views' => ['maintab']
    ],
    'upload' => [
      'method' => ['GET','POST'],
      'views' => ['ajax']
    ],
  ];

/*////////////////////////////////////////////////////////////////////////////*/
// tab methodes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * @param LibRequestHttp $request
     * @param LibResponseHttp $response
     */
    public function service_mask($request, $response)
    { 
        
        
        $view = $this->loadView(
            'ImportGeneric', 
            'ImportGeneric',
            'displayMask'
        );
        
        $view->displayMask();
        
    }//end public function service_mask */

    /**
     * @param LibRequestHttp $request
     * @param LibResponseHttp $response
     */
    public function service_upload($request, $response)
    {
    
        $context = new ImportGeneric_Upload_Request($request);
        
        /** @var $view ImportGeneric_Ajax_View */
        $view = $this->loadView(
            'ImportGeneric',
            'ImportGeneric',
            'displayUpload'
        );
    
        $view->displayUpload($context);
    
    }//end public function service_upload */

} // end ImportGeneric_Controller */

