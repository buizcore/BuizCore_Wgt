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
class Acl_Consistency extends DataContainer
{
    /*////////////////////////////////////////////////////////////////////////////*/
    // Attributes
    /*////////////////////////////////////////////////////////////////////////////*/

    /*////////////////////////////////////////////////////////////////////////////*/
    // Methoden
    /*////////////////////////////////////////////////////////////////////////////*/

    /**
     * @return void
     */
    public function run()
    {
        $this->fixAccess();
    }

    //end public function run */

    /**
     *
     */
    protected function fixAccess()
    {
        $db = $this->getDb();

        $queries = [];
        $queries[] = 'UPDATE buiz_security_access set message_level = 0 WHERE message_level is null; ';
        $queries[] = 'UPDATE buiz_security_access set priv_message_level = 0 WHERE priv_message_level is null; ';
        $queries[] = 'UPDATE buiz_security_access set meta_level = 0 WHERE meta_level is null; ';
        $queries[] = 'UPDATE buiz_security_access set partial = 0 WHERE partial is null; ';

        foreach ($queries as $query) {
            $db->exec($query);
        }
    }
    //end protected function fixAccess */

}//end class BuizMessage_Consistency

