<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH
* @project     : BuizCore - The Business Core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package net.buizcore.wgt
 */
class WgtItemTreemenu extends WgtItemAbstract
{

  /** Parser zum generieren eines Treemenus
   *
   * @return

   */
  public function build()
  {
    $this->genMenuroot();

    return $this->html;
  } // end of member function build

  /**
  * Hauptfunktion zum generieren des Baums
  *
  * Diese Funktion generiert die Rootordner und Rootbookmarks der kompletten
  * Bookmarkstruktur.
  * @return void
  */
  public function genMenuroot()
  {

    $idlang = $this->SYS->getSysStatus("idlang");

    $this->html .= "<ul>\n
                    <li>\n";
    $this->genSubmenu($idlang , 0);
    $this->html .= "</li>\n
                    </ul>\n";

  } // Ende function  genMenuroot()

  /**
  * Funktion zum rekursiven generieren von Menueinträgen
  *
  * Durch Rekursives aufrufen dieser Funktion werden alle Menüpunkte generiert
  *
  * @param Int Lang Die Id des Vaterordners
  * @param Int Pos Die Id des Vaterordners
  * @return void
  */
  public function genSubmenu($Lang , $Pos)
  {

    if (isset($this->data[$Lang][$Pos])) {
      $Data = $this->data[$Lang][$Pos];
        asort($Data);
        $this->html .= "<ul>\n";
        foreach ($Data as $obj) {
          if (is_object($obj)) {

          $id = $obj->getId();
          $titel = " title=\"Id: $id Titel: ". $obj->getData("menutext")."\" " ;

          $src = trim($obj->getData("menuicon"));
          if ($src != "") {
            $icon = "<img src=\"".$obj->getData("menuicon")."\" alt=\"".
              $obj->getData("menuiconalt")."\" class=\"xsmall\" />";
          } else {
            $icon = "";
          }

          $url = trim($obj->getData("menulink"));
          if ($url != "") {
            $text = "<a href=\"".$obj->getData($url)."\">".
              $obj->getData("menutext")."</a>";
          }
          $text = "<a $titel href=\"".$obj->getData($url)."\">".
            $obj->getData("menutext")."$icon</a>";

          $workon = "<a title=\"Eintrag bearbeiten\" href=\"./sys,action-".
            "WorkonMenu-identry-$id,Eintrag-bearbeiten.html\">workon</a>";

          $delete = "<a title=\"Eintrag löschen\" href=\"./sys,action-".
            "DeleteEntry-identry-$id,Eintrag-loeschen.html\">delete</a>";

          $this->html .= "<li>\n";
          $this->html .= "$text \n $workon \n $delete \n";

          $this->genSubmenu($Lang , $obj->getId());
          $this->html .= "</li>\n";
          }
        } // Ende Foreach
        $this->html .= "</ul>\n";
    }

  } // Ende  function Submenu($id)

} // end class WgtItemTreemenu

