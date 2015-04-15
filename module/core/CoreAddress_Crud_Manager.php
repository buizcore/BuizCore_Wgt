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
 * @author dbonsch
 */
class CoreAddress_Crud_Manager extends ManagerCrud
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

    
    /**
     * Key für die Domain
     * @var string
     */
    public $domainKey = 'CoreAddress';
    
    /**
     * @param Entity $dset
     */
    public function setDefaultData($dset)
    {
    
        $orm = $this->getOrm();
    
    
        if ('' === trim($dset->id_type))
            $dset->id_type = $orm->getByKey('BusinessCustomerType', 'private');
    
    
    
    }//end public function setDefaultData */

    
}// end class CoreAddress_Crud_Manager
