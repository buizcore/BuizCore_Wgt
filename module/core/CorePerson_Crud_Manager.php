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


class CorePerson_Crud_Manager extends ManagerCrud
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

    
    /**
     * Key für die Domain
     * @var string
     */
    public $domainKey = 'CorePerson';

    /**
     * Setzen der Default Daten
     * @param Entity $dset
     */
    public function setDefaultData($dset)
    {
        
        // per default ist es einen natürliche person
        if ('' === trim($dset->type))
            $dset->type = EPersonType::HUMAN_PERSON;
    
    }//end public function setDefaultData */
    
}// end class CorePerson_Crud_Manager
