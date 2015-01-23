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
class WgtBuilderRating extends WgtAbstract
{
    
    /**
     * @var []
     */
    public $colorScheme = [
        0 => ['0, 192, 0','#00C000','#000'],
        1 => ['0, 64, 0','#004000','#fff'],
        2 => ['255, 220, 168','#FFDCA8','#000'],
        3 => ['255, 168, 88','#FFA858','#000'],
        4 => ['255, 128, 0','#FF8000','#fff'],
        5 => ['255, 0, 0','#FF0000','#fff']
    ];
    
    /**
     * @var []
     */
    public $arrows = [
        '2' => 'fa fa-arrow-right fa-rotate-270',
        '1' => 'fa fa-arrow-right fa-rotate-315',
        '0' => 'fa fa-arrow-right',
        '-1' => 'fa fa-arrow-right fa-rotate-45',
        '-2' => 'fa fa-arrow-right fa-rotate-90',
    ];

    
    /**
     * @param int $key
     * @param boolean $hex
     * @return string
     */
    public function getColorScheme($key, $hex = true, $fc = false)
    {
        
        if ($fc) {
            return isset($this->colorScheme[(int)$key][2])?$this->colorScheme[(int)$key][2]:$this->colorScheme[0][2] ;
        }
    
        if ($hex) {
            return isset($this->colorScheme[(int)$key][1])?$this->colorScheme[(int)$key][1]:$this->colorScheme[0][1] ;
        } else {
            return isset($this->colorScheme[(int)$key][0])?$this->colorScheme[(int)$key][0]:$this->colorScheme[0][0];
        }
        
    }//end public function renderArrow */
    
    /**
     * @param int $value
     * @return string
     */
    public function renderArrow($value)
    {
        
        return '<i class="'.$this->arrows[$value].'" ></i>';
        
    }//end public function renderArrow */


} // end class WgtBuilderRating

