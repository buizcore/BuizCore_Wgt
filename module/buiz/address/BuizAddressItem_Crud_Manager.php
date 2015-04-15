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
class BuizAddressItem_Crud_Manager extends ManagerCrud
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

    
    /**
     * Key für die Domain
     * @var string
     */
    public $domainKey = 'BuizAddressItem';

    /**
     * @param string $value
     * @param string $type
     * @param string $personId
     * @param int $dsetId
     *
     * @return Entity
     */
    public function saveByType($value, $type, $personId, $dsetId = null)
    {
    
        $orm = $this->getOrm();
    
        if ($dsetId) {
            $dset = $orm->get($this->domainKey, $dsetId);
    
            if (!$dset) {
                throw new Io_Exception('There is no Dataset with the id '.$dsetId );
            }
    
        } else {
            
            $dset = $orm->newEntity($this->domainKey);
        }

        $dset->setByKey('id_type', $type);
        $dset->address_value = $value;
        $dset->vid = $personId;

        $orm->save($dset);
    
        return $dset;
    
    }//end public function saveByArray */
    
}// end class BuizAddressItem_Crud_Manager
