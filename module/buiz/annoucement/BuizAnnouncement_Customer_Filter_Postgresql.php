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
class BuizAnnouncement_Customer_Filter_Postgresql extends LibSqlFilter
{

    /**
     * @param LibSqlCriteria $criteria
     * @param TFlag $params
     * @return LibSqlCriteria
     */
    public function inject($criteria, $params)
    {
        
        $acl = $this->getAcl();
        $db = $this->getDb();

        $request = BuizCore::$env->getRequest();

        $persId = $request->param('pers_id', Validator::EID);

        if ($persId) {

            $criteria->leftJoinOn(
                'buiz_announcement',
                'rowid',
                'buiz_person_announcement_r',
                'id_announcement',
                null,
                'buiz_person_announcement'
            );// attribute reference buiz_role_user profile  by alias buiz_profile attribute reference buiz_role_user profile


            $criteria->where( 'buiz_person_announcement.id_person = '.$persId );
        }


        return $criteria;

    }//end public function inject */

}//end class BuizAnnouncement_Customer_Filter

