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
class BuizTextBlock_Table_ByType_Filter_Postgresql extends LibSqlFilter
{

    /**
     *
     * @param LibSqlCriteria $criteria            
     * @param TFlag $params            
     * @return LibSqlCriteria
     */
    public function inject($criteria, $params)
    {
        $acl = $this->getAcl();
        $orm = $this->getOrm();
        
        // need a better solution for that
        $request = $this->getRequest();
        
        // Custom Filter Flag
        $types = $request->param('cff', Validator::CKEY, 'tt');
        
        if (! $types) {
            return $criteria;
        }
        
        $ids = $orm->getIdsByKeys('BuizTextBlockType', $types);
        
        $criteria->filter("buiz_text_block.id_type  IN(".implode(',',$ids).") ");

        return $criteria;
        
    } // end public function inject */
    
} //end class BuizText_Table_ByType_Filter_Postgresql */

