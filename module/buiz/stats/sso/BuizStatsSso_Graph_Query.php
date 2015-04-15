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
class BuizStatsSso_Graph_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// query elements table
/*////////////////////////////////////////////////////////////////////////////*/

 /**
   * Loading the tabledata from the database
   * @param date $start
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch($start)
  {

    $db = $this->getDb();

    $matrix = [];

    $dateStart = new DateTime($start);
    $dateEnd = new DateTime($start);
    $dateEnd->add(new DateInterval('P1Y'));

    $interval = new DateInterval('P1M');
    $periods = new DatePeriod($dateStart, $interval , $dateEnd);

    // fillup
// date_trunc('month', usage.m_time_created)::date as period,
// date_trunc('month', usage.m_time_created)::date,

    $sql = <<<SQL
  select

    count(usage.flag_sso) as num_sso,
    coalesce(flag_sso,false) as flag_sso
  FROM
    buiz_protocol_usage usage

  where
    usage.m_time_created >= '{$dateStart->format('Y-m-d')}'
    and usage.m_time_created < '{$dateEnd->format('Y-m-d')}'
  group by
    coalesce(flag_sso,false)

  ;
SQL;

    $data = $db->select($sql)->getAll();
    foreach ($data as $row) {
      $matrix[$row['flag_sso']] = $row['num_sso'];
    }

    Debug::dumpFile('sso_dump.html', $matrix);

    $this->data = $matrix;

  }//end public function fetch */

}// end class BuizStatsBrowser_Graph_Query

