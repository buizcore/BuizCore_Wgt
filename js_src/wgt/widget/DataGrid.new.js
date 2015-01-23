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


  $S.widget( "wgt.grid", {

    /**
     * Standard Options
     */
    options: {

      // technische Eigenschaften
      body_resize_able: false, // flag ob der Databody resizeable ist
      cols_resize_able: true,  // flag ob die Cols Resizeable sind
      select_able: true,      // flag ob die Einträge selektiert werden können

      load_urls: {}, // urls zum nachladen von content

      // Sort Daten und Optionen
      icon_sort_asc: 'fa fa-sort-asc',    // Icon für das absteigenden sortieren
      icon_sort_desc: 'fa fa-sort-desc',   // Icon für das aufsteigenden sortieren
      icon_sort_none: 'fa fa-sort',   // noch nicht sortiert

      // open / closed
      icon_opened: 'fa fa-caret-down',   // Icon für einen geschlossenen abschnitt
      icon_closed: 'fa fa-caret-right',   // Icon für einen offenen abschnitt

      // Eigenschaften für die Suchleiste
      search_able: false,   // flag ob die Einträge selektiert werden können
      search_form: null,    // ID des Suchformulars / Paging / Datenquelle

      // Treeeigenschaften des Grids
      expandable: false, // Flag ob der Baum colapsable ist

      onChange: {}, // event für das ganze data grid on change
      onInsert: {}, // event für das ganze grid on insert
      onUpdate: {}, // event für das ganze grid on update (Datensatz/Suche)
      onDelete: {}, // event für das ganze grid on delete
      onRowChange: {}, // event auf ein zeile
      

      // statefull elements (werden nicht per parameter übergeben)
      _headCols: [], // header columns
      _footerCols: [], // footer columns (soweit nötig)
      _dragBars: [], // drag bar elements
      _gridCont: null, // container
      _elId: null,
      _tableWidth: 0,
      _numCols: 0// die HTML ID des elements
    },
    

    /**
     * Setup / Constructor methode des Widgets
     */
    _create: function() {

      this.buildGrid();

    },//end _create

    /**
     * Die Standardmethode in welcher eine normale Tabelle zum Gridelement
     * umgebaut wird
     */
    buildGrid: function(){

      // erst mal alle benötigten variablen deklarieren
      var self = this,
        ge = this.element,  // shortcut aufs das element
        geNode = this.element.get(0),
        opt = this.options; // shortcut für die options
      
      opt._gridCont = ge.parentX('.wgt-grid-container');
      opt.elId =  ge.attr('id');
      opt._headCols = ge.find('thead tr:first th');
      opt._numCols = opt._headCols.length;
      
      this.addResizeEvents();
      this.recalcXPosDragHelper();
      

    },//end buildGrid
    
    /**
     * Die Resize Events hinzufügen
     */
    addResizeEvents: function(  ){
      
      var self=this,
        ge = this.element,
        opt = this.options,
        dragMapper = '<div class="wgt-grid-drag-mapper" >',
        dragBars = [];

      
      for (var pos=0; pos<=opt._numCols; pos++) {
          dragMapper += '<div class="wgt-grid-drag-bar" ></div>';
      }
      
      dragMapper += '</div>';
      
      opt._gridCont.append(dragMapper);
      opt._dragBars = opt._gridCont.find('.wgt-grid-drag-bar'); 
      
      opt._headCols.each(function(){
          var outerWidth = $S(this).outerWidth();
          $S(this).attr('data-width',outerWidth);
          opt._tableWidth += outerWidth;
      });
      ge.css('width', opt._tableWidth);
      
      opt._headCols.each( function( idx ){

        var actualCol = $S(this),
          nextPos = actualCol.outerWidth()+actualCol.offset().left + 2, //-2
          startPos = null,
          mover = null;

        
        $S( opt._dragBars.get(idx) )
          //.css( {top:headOff.top} )
          .offset( {left:nextPos} )
          .height('30px')//.height( tbodyHeight+'px' )
          .draggable({
            axis: "x",
            start: function( event, ui ){
              mover = $S(this);
              
              //console.log('idx '+idx);

              startPos = mover.position().left;                
              //console.log('startpos '+startPos);

            },
            drag: function( event, ui ){


            },
            stop: function(){
     

              //var tw = actualCol.width();
              //var mover = $S(this);
              var newPos = mover.position().left,
                oldWith = parseInt(actualCol.attr('data-width')),
                newWidth = oldWith + (newPos-startPos);
              
              opt._tableWidth += (newPos-startPos);
              ge.css('width', opt._tableWidth);
              
              //console.log('new table width '+opt._tableWidth );
              //console.log( oldWith +"+ ("+newPos+"-"+startPos+")" );
              

              actualCol.attr('data-width',newWidth);//.parentX('th').attr('data-width',newWidth);
              actualCol.css('width',newWidth+'px');
              //alert('new width : '+newWidth);

              self.recalcXPosDragHelper();
            }
          });

      });
      

    },

    /**
     * Berechnen der korrekten position für die Drag Bar Elemente
     * Werden für das Resizing der Cols benötigt
     */
    recalcXPosDragHelper: function(){

      var self = this,
          el = this.element,
          opt = this.options;

      if ( opt._headCols ) {
        opt._headCols.each(function (idx) {

          var actualCol = $S(opt._headCols.get(idx));
          var mover = $S(opt._dragBars.get(idx));
          var tmpPos = actualCol.outerWidth()+actualCol.offset().left-2;
          mover.offset({left:tmpPos});
          
        });
        
      }
      
    },//end recalcXPosDragHelper

    /**
     * Injizieren der Sortelements in den Tabellenhead
     *
     * @param jHeadTab jQuery Objekt mit der Head Tabelle
     */
    injectSortControls: function( jHeadTab ){

      var opt = this.options;

      jHeadTab.find('i.sort').each( function(){

         var imgNode = $S(this);

         imgNode.bind("click.grid", function() {

          var nIcon = $S(this),
            pIcon = nIcon.parent();

          if( pIcon.hasClass('sort-asc') ){
            pIcon.removeClass('sort-asc').addClass('sort-desc');
            nIcon.removeClass().addClass( opt.icon_sort_desc+' sort' );
            nIcon.next().val('desc').change();
          } else if( pIcon.hasClass('sort-desc') ){
            pIcon.removeClass('sort-desc');
            nIcon.removeClass().addClass( opt.icon_sort_none+' sort' );
            nIcon.next().val('').change();
          } else {
            pIcon.addClass('sort-asc');
            nIcon.removeClass().addClass( opt.icon_sort_asc+' sort' );
            nIcon.next().val('asc').change();
          }

        });
      });

      jHeadTab.find('input.wcm_req_search,select.wcm_req_search').each(function(){
        $R.callAction( 'req_search', $S(this) );
      });
      
      jHeadTab.find('select.wcm_ui_multiselect_search').each(function(){
        $R.callAction( 'ui_multiselect_search', $S(this) );
      });

    },//end injectSortControls

    /**
     * Sc
     * @param cNode jQuery jQuery Object des th nodes
     * @param tmpWidth int Weite der aktuellen col
     * @param opt Object Options Object
     */
    renderSearchCell: function( cNode, tmpWidth, opt  ){

      var searchBox = '',
        searchName = cNode.attr('wgt_search'),
        defVal = '<span>&nbsp;</span>',
        defClass = '';
      
      if( cNode.is('.pos') ){
        defVal = ' <i class="icon-search" ></i> ';
        defClass = ' class="pos" ';
      }

      if( searchName ){

        var tmp = searchName.split(':'),
          sType = '',
          sName = '';

        if( 2 === tmp.length ){
          
          sType = tmp[0];
          sName = tmp[1];

        } else {
          
          sType = 'text';
          sName = searchName;

        }
        
        if( 'select' == sType ){
          
          var selectData = $S('#'+cNode.attr('wgt_ms_key'));
          
          //width:'+(tmpWidth-opt.hpad)+'px;
          searchBox = ''.concat(
              '<td style="text-align:center;" >',
              '<select id="',cNode.attr('wgt_ms_key'),'-el" name="',sName,'" multiple="multiple" class="wcm_ui_multiselect_search search wgt-no-save fparam-',opt.search_form,'" style="width:100%" >',
              selectData.text(),
              '</select>',
              '</td>'
          );
          
        } else {
          //width:'+(tmpWidth-opt.hpad)+'px;
          searchBox = ''.concat(
              '<td style="text-align:center;" >',
              '<input type="',sType,'" name="',sName,'" class="wcm_req_search search wgt-no-save fparam-',opt.search_form,'" style="width:100%" />',
              '</td>'
          );
        }


      } else {

        //width:'+(tmpWidth-opt.hpad)+'px;
        searchBox = '<td '+defClass+' style="text-align:center;" >'+defVal+'</td>';

      }

      return searchBox;

    },//end renderSearchCell

     /**
     * Render einer Head Label Cell bei Bedarf mit Order Feld
     *
     * @param node DOMNode
     * @param cNode jQuery of DOMNode
     * @param tmpWidth int
     * @param opt Object Options Object
     */
    renderHeadCell: function( node, cNode, tmpWidth, opt  ){

      var nodeName = cNode.attr('wgt_sort_name'),
        headTab = '',
        tmpNewWdth = null,
        headClass = '';
      
        if( cNode.is('.pos') ){
          headClass = ' class="pos" ';
        }

      if( nodeName ){

        var sortIcon = opt.icon_sort_none, 
          sortClass = '',
          sortVal = '',
          sortDir = cNode.attr('wgt_sort');
        
        if( sortDir ){

          sortIcon = opt['icon_sort_'+sortDir] === undefined? opt.icon_sort_none: opt['icon_sort_'+sortDir] ;
          sortClass = ' sort-'+sortDir;
          sortVal = sortDir;
        }
        
        tmpNewWdth = tmpWidth-opt.hpad;
        headTab += "<th "+headClass+"  data-o-width=\""+tmpNewWdth+"\"  ><div style=\"width:100%;\"  data-width=\""+tmpNewWdth+"\" >";
        headTab += "<p class=\"label\" >"+node.innerHTML+"</p>";
        headTab += "<p class=\"order"+sortClass+"\" >";
        headTab += "<i class=\""+sortIcon+" sort\" ></i>";
        headTab += '<input type="hidden" name="'+nodeName+'" value="'+sortVal+'" class="wcm wcm_req_search wgt-no-save fparam-'+opt.search_form+'" />';
        headTab += "</p>";
        headTab += "</div></th>";

      }
      else{

        tmpNewWdth = tmpWidth-opt.hpad;
        headTab += "<th "+headClass+"  data-o-width=\""+tmpNewWdth+"\"  >"
          +"<div style=\"width:100%;\"  data-width=\""+tmpNewWdth+"\" ><p class=\"label\" >"+node.innerHTML+"</p></div>"
          +"</th>";
      }

      return headTab;

    },//end renderHeadCell

    /**
     * Die Listeneinträge selektierbar machen
     * Diese Funktion ermöglicht es primär die rows mit wgt-selected zu tagen
     * Wie diese Information verwendet wird ist in der spezifischen Logik
     * der Multi Action zu definieren.
     */
    makeSelectable: function( lElem ){
        
      /* wird jetzt durch checkboxes geregelt
      lElem.find('tbody>tr>td.pos').not('.ini')
        .click(function(){

          $S(this).parent().toggleClass( 'wgt-selected' );

      }).addClass('ini');
      */
        
    },//end makeSelectable

    /**
     * entfernen eines Datensatzes aus dem Datagrid
     */
    removeRowById: function( rowId ){

      $S(rowId).remove();
      this.syncColWidth();

    },

    /**
     * entfernen mehrerer rows
     * @param rowIds Array mit den Ids der zu entfernenden Datensätze
     */
    removeRowsById: function( rowIds, relative ){

      if(undefined === relative){
        relative = true;
      }


      if(relative){
        for (var pos in rowIds) {
          if( rowIds.hasOwnProperty( pos ) ) {
            $S('#'+rowIds[pos]).remove();
          }
        }
      } else {
        for (var pos in rowIds) {
          if( rowIds.hasOwnProperty( pos ) ) {
            $S(rowIds[pos]).remove();
          }
        }
      }


      this.syncColWidth();

    },

    addRow: function(rowAsString, prepend){

      if(undefined === prepend){
        prepend = true;
      }

      if(prepend){
        this.options._gridCont.find('tbody').prepend(rowAsString);
      } else {
        this.options._gridCont.find('tbody').append(rowAsString);
      }

      this.syncColWidth();
    },

    updateRow: function(rowId, rowAsString){

      if(prepend){
        this.options._gridCont.find('#'+rowId).replace(rowAsString);
      }

      for (var prop in obj) {
        if( obj.hasOwnProperty( prop ) ) {
          result += objName + "." + prop + " = " + obj[prop] + "\n";
        }
      }

      this.syncColWidth();
    },
      
    update: function(recalcNums){
      


      this.syncColWidth();
    },
    
    /**
     * Synchronisation von Head und Body Breite
     */
    syncColWidth: function(){
      
      console.log('syncColWidth ');

      var self = this,
          opt= this.options,
          tatsSize = null;
      
    
      if( opt.firstRow ){


      }

      this.recalcXPosDragHelper();

    },

    /**
     * Einen Teil der Tabelle nachladen
     */
    triggerLoad: function( key, append, triggerNode ){

      if( triggerNode && triggerNode.is('state-loaded') ){
        
        return;
      }

      if( undefined !== this.loadUrls[key]  ){
        
        $R.get( this.loadUrls[key]+append );

        if( triggerNode ){
          triggerNode.addClass('state-loaded');
        }
      }
    },

    /**
     * Events zum nachladen
     */
    initLoaderEvent: function(){

      var el = this.element,
        opts = this.options,
        self = this;

      el.click( function( e ){

        var cTarget = $S( e.target );

        if (!cTarget.is('.wgt-loader')) {
          cTarget = cTarget.parentX('.wgt-loader');
        }

        if (!cTarget || !cTarget.is('.wgt-loader') ){
          return;
        }

        if (cTarget.is('.state-loaded')) {
          return;
        }

        var loadUrl = opts.load_urls[cTarget.attr('wgt_source_key')];

        if (cTarget.attr('wgt_eid')) {
          loadUrl += '&objid='+cTarget.attr('wgt_eid');
        }

        if (cTarget.attr('wgt_param')) {
          loadUrl += cTarget.attr('wgt_param');
        }

        var parentTr = cTarget.parentX('tr');

        if (parentTr) {
          loadUrl += '&p_row_id='+parentTr.attr('id')+'&p_row_pos='+parentTr.find('td.pos').text();
        }

        //console.log("data "+cTarget.attr('wgt_source_key')+" "+loadUrl );

        $R.get(loadUrl);

        cTarget.addClass('state-loaded');
        cTarget.find('i').attr( 'class','').addClass(opts.icon_opened);

        parentTr.bind( 'rowclose', function(){
          cTarget.find("i").attr('class', '').addClass(opts.icon_closed);
          $S('.c-'+parentTr.attr('id')).hide().trigger('rowclose');
          parentTr.removeClass('state-open');
        });

        parentTr.addClass('state-open');


        cTarget.bind( 'click', function(){

          if( parentTr.hasClass('state-open') ) {

            parentTr.trigger('rowclose');
            self.syncColWidth();
            
          } else {

            cTarget.find("img").attr('src', $G.$C.WEB_ICONS+"xsmall/"+opts.icon_opened);
            $S('.c-'+parentTr.attr('id')).show();
            parentTr.addClass('state-open');
            self.syncColWidth();
          }

        });

      });

    },


    /**
     * Filtern der Datensätze im client
     * @param colId int, the numeric index of the col
     * @param input Object, named params array
     */
    filter: function(colId , input){

      ///TODO mit detache arbeiten

      var rows = this.element.find( 'tbody > tr' ),
        reg = new RegExp("("+escapearg(htmlspecialchars(input.toUpperCase()))+")",'g');

      rows.each(function(){

        var row = $S(this);
        var col = row.find('td').get(colId);
        if( reg.test( $S(col).text().toUpperCase() ) ){
          
          row.show();
          
        } else {
          
          row.hide();
        }
      });


    },//end this.filter

    /**
     * Filter leeren, wieder alle Zeilen anzeigen
     */
    cleanFilter: function( ){

      var rows = this.element.find( 'tbody > tr' );
      rows.each(function(){
        $S(this).show();
      });

    },//end this.cleanFilter


    /**
     * Inkrementieren der Anzahl gelisteter Einträge
     */
    incEntries: function(){

      var fNum = this.element.parent().parent().parent().find('.wgt-num-entry');

      if (!fNum.length) {
        return;
      }

      var numVal = Number(fNum.text());
      ++numVal;
      fNum.text(numVal);

    },//end incEntries

    /**
     * Dekrementieren der Anzahl gelisteter Einträge
     */
    decEntries: function(){


    },//end decEntries

    /**
     * Setzen der Anzahl gelisteter Einträge
     */
    setNumEntries: function(num){


    },//end setNumEntries

    /**
     * Selectieren alle entries
     */
    selectAll: function(){

      this.element.find('tr').addClass( 'wgt-selected' );

    },//end selectAll

    /**
     * Deselect all selected entries
     */
    deSelectAll: function(){

      this.element.find('tr').removeClass( 'wgt-selected' );

    },//end deSelectAll

    /**
     * Toggle Body
     */
    toggle: function( ){

      this.element.find('tbody').toggle();

    },//end this.toggle

    /**
    *
    */
   renderRowLayout: function(){
       
     // nur auf dem ersten body
     var rows = this.element.find( 'tbody:first > tr' ).not('.wgt-block-appear');

     rows.find('>td.pos').not('.ini').click(function(){
       $S(this).parent().toggleClass( 'wgt-selected' );
     }).addClass('ini');


   },//end renderRowLayout

    // _setOptions is called with a hash of all options that are changing
    // always refresh when changing options
    _setOptions: function() {
      // in 1.9 would use _superApply
      $S.Widget.prototype._setOptions.apply( this, arguments );
      this._refresh();
    },

    // Use the _setOption method to respond to changes to options
    /**
     *
     */
    _setOption: function( key, value ) {

      $S.Widget.prototype._setOption.apply( this, arguments );

    },

    // called when created, and later when changing options
    _refresh: function() {

      // trigger a callback/event
      this._trigger( "change" );
    },

    /**
     * Use the destroy method to clean up any modifications your
     * widget has made to the DOM
     */
    destroy: function() {

      $S.Widget.prototype.destroy.call( this );
    },//end destroy




  });


}( jQuery, window ) );

