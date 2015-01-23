/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
/**
 * WGT Web Gui Toolkit
 *
 * Copyright (c) 2009 webfrap.net
 *
 * http://webfrap.net/WGT
 *
 * @author Dominik Bonsch <db@webfrap.net>
 *
 * Depends:
 *   - jQuery 1.7.2
 *   - jQuery UI 1.8 widget factory
 *   - WGT 0.9
 *
 * License:
 * Dual licensed under the MIT and GPL licenses:
 * @license http://www.opensource.org/licenses/mit-license.php
 * @license http://www.gnu.org/licenses/gpl.html
 *
 * Code Style:
 *   indent: 2 spaces
 *   codelang: english
 *   identStyle: camel case
 *
 */

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 * @passed http://www.jshint.com
 */
(function( $S, $G, undefined ) {

  "use strict";


  $S.widget( "wgt.mainOverlay", {


    /**
     * Standard Options
     */
    options: {
        script:null // javascript der overlay componente
    },
    

    /**
     * Setup / Constructor methode des Widgets
     */
    _create: function(  ) {

        if (this.options.script) {
            (new Function("self",this.options.script))( this );
            this.options.script = null; // speicher leeren
        }

    },//end _create

    /**
     * Die Standardmethode in welcher eine normale Tabelle zum Gridelement
     * umgebaut wird
     */
    getObject: function(){

        return this.element;

    },//end buildGrid
 

  });


}( jQuery, window ) );

