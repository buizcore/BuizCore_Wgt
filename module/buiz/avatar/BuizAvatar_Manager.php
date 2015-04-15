<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore
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
 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class BuizAvatar_Manager extends Manager
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * @param BuizAvatar_Upload_Request $usrRqt
     * @return Entity
	 */
    public function getTargetEntity($usrRqt)
    {
        
        $orm = $this->getOrm();
        
        $domainNode = DomainNode::getNode($usrRqt->dKey);
        return $orm->get($domainNode->srcKey, $usrRqt->objid);
        
	}//end public function getTargetEntity */

	/**
	 * @param BuizAvatar_Upload_Request $userRqt
	 * @param Entity $entity
	 */
	public function uploadImage($userRqt, $entity)
	{
	
	    $orm = $this->getOrm();
	    $id = $entity->getId();
	    
	    // upload des images
	    $filePath = PATH_UPLOADS.'attachments/';
	    $filePath .= $userRqt->tSource.'/'.$userRqt->tField.'/';
	    $filePath .= SParserString::idToPath($id);
            
	    $uploadImage = $userRqt->getUpload();
	    
	    if ($uploadImage) {

	        $uploadImage->copy($id, $filePath);
	        
	        // thumbs cleanen
	        $fileTemp = PATH_UPLOADS.'thumbs/';
	        $fileTemp .= $userRqt->tSource.'/'.$userRqt->tField;
	        $fileTemp .= SParserString::idToPath($id).$id;
	        

	        Log::debug( 'clean cache '.$fileTemp );
	        
	        SFilesystem::cleanFolder($fileTemp);
	        $entity->setData($userRqt->tField, $uploadImage->oldname);
	        $orm->update($entity);
	        
	    } else {

	        Log::warn( 'NO UPLOAD IMAGE' );
	    }
	    
	    


	}//end public function deleteSlice */

} // end class BuizAvatar_Manager */

