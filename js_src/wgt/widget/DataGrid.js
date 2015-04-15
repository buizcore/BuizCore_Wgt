/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
/**
 * WGT Web Gui Toolkit
 *
 * Copyright (c) 2014 BuizCore GmbH
 *
 * http://buizcore.net/WGT
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
     * Array mit den Resize Elementen
     */
    dragBars: [],

    /**
     * Array mit den Head Cols
     */
    headCols: [],
    
    /**
     * Array mit den Cols des Footers, soweit vorhanden
     */
    footCols: [],


    /**
     * Referenz auf die erste row im grid
     */
    firstRow: null,

    /**
     * Standard Options
     */
    options: {

      // technische Eigenschaften
      grid_class: 'wgt-grid', // Klasse für die Deklaration als Grid Element
      hpad: 0,                // Größe des Paddings im Heads ( sollte dynamisch errechnet werden )
      panelH: 36,
      colH: 25,
      border: 'wgt-border',   // Klasse für den Element Rahmen
      body_height: 'large',   // Klasse für die Höhe des bodies
      body_resize_able: false,// flag ob der Databody resizeable ist
      cols_resize_able: true, // flag ob die Cols Resizeable sind
      select_able: true,     // flag ob die Einträge selektiert werden können

      load_urls: {}, // urls zum nachladen von content

      // Sort Daten und Optionen
      icon_sort_asc: 'fa fa-sort-asc',    // Icon für das absteigenden sortieren
      icon_sort_desc: 'fa fa-sort-desc',   // Icon für das aufsteigenden sortieren
      icon_sort_none: 'fa fa-sort',   // noch nicht sortiert

      // open / closed
      icon_opened: 'fa fa-caret-down',   // Icon für einen geschlossenen abschnitt
      icon_closed: 'fa fa-caret-right',   // Icon für einen offenen abschnitt

      // Eigenschaften für die Suchleiste
      search_able: false,     // flag ob die Einträge selektiert werden können
      search_form: null,      // ID des Suchformulars / Paging / Datenquelle

      // Treeeigenschaften des Grids
      expandable: false,       // Flag ob der Baum colapsable ist

      onChange: {}, // event für das ganze data grid on change
      onInsert: {}, // event für das ganze grid on insert
      onUpdate: {}, // event für das ganze grid on update (Datensatz/Suche)
      onDelete: {}, // event für das ganze grid on delete
      onRowChange: {}, // event auf ein zeile
      
      firstRow: null,
      headCols: [],

      // statefull elements (werden nicht per parameter übergeben)
      _gridCont: null,
      _elId: null,
      _numCols: 0// die HTML ID des elements
    },
    

    /**
     * Setup / Constructor methode des Widgets
     */
    _create: function() {

      var self = this;

      //TODO appear funktioniert hier nicht 100%tig
      this.element.appear(function(){
        self.buildGrid();
      });

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
        opt = this.options, // shortcut für die options
        gridBody = null,    // die box in welcher sich die content tabelle befindet
        parentBox = ge.parent(),
        parentHeight = null,
        parentHeightStyle = null,
        scrollHeightStyle = null,
        jHeadTab = null,
        oldHCols = ge.find('thead th'), // der original head
        headTab = "<div class=\"wgt-grid-head\" ><div><table style=\"table-layout: fixed\" ><thead><tr>", // start des neuen heads
        searchBox = '', // Box mit den Suchelementen, wird nur bei Bedarf gefüllt
        resizeBox = '<div class="wgt-drag" >', // die Box mit den resize elementen
        sizes = [],
        fillerColumn = null, // link auf die spalte welchen die volle spaltenbreite einnehmen wird
        fillerColumnIdx = null, // index der filler colum
        colsWidth = 0, // index der filler colum
        _elId = geNode.id; // liste mit den größen

      // setzen der Grid Basisklasse wenn noch nicht vorhanden
      if( !ge.hasClass( opt.grid_class ) ){
        ge.addClass( opt.grid_class );
      }


      opt._numCols = ge.find('tbody>tr').length;
      console.log('got '+opt._numCols+' cols');

      //console.log( 'height '+ge.parent().parent().height() );
      /*
      if ('full' === opt.height) {
        
        parentHeight = parentBox.parent().height();
        parentBox.css('height', parentHeight+'px');
        
        // hier noch ein check für create
          
        parentHeight -= opt.panelH;
        scrollHeightStyle = ' style="height:'+(parentHeight)+'px;" ';
        parentHeight -= opt.panelH;
        
        if (opt.search_able) {
          parentHeight -= opt.panelH;
        }
        if (opt.edit_able && ge.find('tbody.editor').length) {
          parentHeight -= opt.panelH;
        }
        
        parentHeightStyle = ' style="height:'+(parentHeight)+'px;" ';
      }
      */

      // Einträge Selektiebar machen
      if (opt.select_able) {
        this.makeSelectable( ge );
      }

      if (opt.search_able) {
        searchBox += '<tbody><tr>';
      }

      // die tabelle wird mit dem grid element umrahmt
      //ge.wrap('<div class="wgt-grid-body '+opt.height+'" id="'+ge.attr('id')+'-body" '+parentHeightStyle+' />');
      ge.wrap('<div class="wgt-grid-body '+opt.height+'" id="'+ge.attr('id')+'-body"  />');

      gridBody = $S( '#'+ge.attr('id')+'-body' );
      opt._gridCont = gridBody;

      // erstellen einer head zeile + resize bar pro alter col
      oldHCols.each( function() {

        var cNode = $S(this);
        var tmpWidth = this.clientWidth;

        headTab += self.renderHeadCell( this, cNode, tmpWidth , opt  );

        // anhängen der Search Col
        if( opt.search_able ){
          searchBox += self.renderSearchCell( cNode, tmpWidth, opt  );
        }

        resizeBox += '<div></div>';
        sizes.push( tmpWidth );

      });

      // schliesen des heads
      headTab += "</tr></thead>";
      headTab += "</table></div></div>";

      if( opt.search_able ){
        searchBox += '</tr></tbody>';
      }

      // schliesen der resize box
      resizeBox += '<div class="helper" ></div></div>';

      // Sortierelemente im Head anhängen
      jHeadTab = $S(headTab);

      // anhängen der Searchbar wenn gewünscht
      if( opt.search_able ){
        jHeadTab.find('table').append(searchBox);
      }

      this.injectSortControls( jHeadTab );


      // den neuen kopf sowie die resize box vor die tabelle kopieren
      ge.parent().wrap( '<div class="body-scroll" '+scrollHeightStyle+' >' );
      ge.parent().before(jHeadTab);
      ge.parent().before(resizeBox);

      var headHeight = opt.colH;

      if (opt.search_able) {
        headHeight += opt.colH;
      }
      if (opt.edit_able && ge.find('tbody.editor').length) {
        headHeight += opt.colH;
      }
      jHeadTab.css('height',headHeight+'px');
      
      // store the head
      var headBar = ge.parent().parent().find('.wgt-grid-head');
      var footBar = null;

      if (ge.find('tbody.sum').length) {
        ge.parent().after("<div class=\"wgt-grid-foot\" ><div><table>");
        ge.parent().parent().find('div.wgt-grid-foot>div>table').append(ge.find('tbody.sum'));
        
        footBar = ge.parent().parent().find('div.wgt-grid-foot');
        
        self.footCols = ge.parent().parent().find('div.wgt-grid-foot tr:first td');
      }


      // add the scroll events
      var tmpBox = ge.parent(),
        scrolling = false;
      
      tmpBox.get(0).onscroll = function(){
        scrolling = true;
        headBar.scrollLeft(this.scrollLeft);
        
        if (footBar && footBar.length)
          footBar.scrollLeft(this.scrollLeft);
        
      };

      tmpBox.mouseup(function(){

        // only execute after scrolling
        if (scrolling) {

          self.recalcXPosDragHelper();
          scrolling = false;
        }
      });

      // all drag helper divs
      this.dragBars = ge.parent().parent().find('div.wgt-drag>div');

      // the content boxes of the head
      opt.headCols = headBar.find('th>div');

      // the first Row
      var colGroup = '<colgroup>';
      var tmpRows = ge.find('thead th');
      tmpRows.each(function(idx,node){
          
          var hc = $S(opt.headCols.get(idx));
          colGroup += '<col style="width:'+hc.attr('data-width')+'px;max-width:'+hc.attr('data-width')+'px;" data-width="'+hc.attr('data-width')+'" />';
      });
      colGroup += '</colgroup>';
      
      ge.prepend(colGroup);
      jHeadTab.find('table').prepend(colGroup);
      
      opt.firstRow = ge.find('colgroup col');
      opt.headCols = jHeadTab.find('colgroup col');
      ge.find('>thead').remove();
      

      self.addResizeEvents( opt.firstRow, headBar, gridBody );
      
      // nach dem Init nocheinmal sicher stellen das ResizeBars und Size
      // auch in sync sind
      self.syncColWidth();

      if( opt.edit_able && self.startEditMode ){
        self.startEditMode( jHeadTab );
      }
      
      if( opt.calc_able && self.initFormuars ){
        self.initFormuars();
      }

      if( opt.load_urls !== {} ){
        self.initLoaderEvent();
      }

    },//end buildGrid
    
    /**
     * Die Resize Events hinzufügen
     */
    addResizeEvents: function( firstRow, headBar, gridBody, footBar ){
      
      var self=this,
        ge = this.element,
        opt = this.options,
        headOff = headBar.position(),
        tbodyHeight = ge.parent().height() + headBar.height();

      
      // Resize für das Grid implementieren
      //var helper = ge.parent().parent().find('div.wgt-drag>div.helper');
      var helper = ge.parent().parent().find('div.drag');

      helper.css({top:headOff.top})
        .height('30px');//.height(tbodyHeight+'px')
        //.hide();

      gridBody.scroll( function(){

        var gof = gridBody.get(0);

        headBar.css( 'marginLeft', '-'+gof.scrollLeft+'px' );
        
        if(footBar)
          footBar.css( 'marginLeft', '-'+gof.scrollLeft+'px' );
        
        ge.parent().parent().find('div.wgt-drag').css( 'marginLeft', '-'+gof.scrollLeft+'px' );
        
        // on scroll editoverlay schliesen
        $S('#wbf-body').trigger('mousedown.editable_grid');
        $D.scrollTrigger();
        //console.log('scroll '+gof.scrollLeft+'  '+gof.scrollTop);
      });

      
      firstRow.each( function( idx ){

        var actualCol = $S(this),
          actualHead = $S( opt.headCols.get(idx) ),
          nextPos = actualHead.outerWidth()+actualHead.offset().left-2,
          startPos = null,
          mover = null;

        $S( self.dragBars.get(idx) )
          .css( {top:headOff.top} )
          .offset( {left:nextPos} )
          .height('30px')//.height( tbodyHeight+'px' )
          .draggable({
            axis: "x",
            start: function( event, ui ){
              mover = $S(this);
              
              console.log('idx '+idx);

              startPos = mover.position().left;                
              //console.log('actualCol '+actualCol.find('.label').text());
              //console.log('startpos '+startPos);

            },
            drag: function( event, ui ){


            },
            stop: function(){
                
             if(undefined === actualHead){
                 console.log('NO ACTUAL HEAD');
             }

              //var tw = actualCol.width();
              //var mover = $S(this);
              var newPos = mover.position().left,
                oldWith = parseInt(actualHead.attr('data-width')),
                newWidth = oldWith + (newPos-startPos);
              
              console.log('actualCol '+actualCol.find('.label').text());
              console.log(
                'startPos: '+startPos+' newPos: '+newPos+' oldWith: '+oldWith
                  + ' newWidth: '+newWidth +' diff '+(newPos-startPos)
                  + ' actualHead '+actualHead.find('.label').text()
              );
              
              if (newWidth <= 40 && !actualCol.hasClass('pos')) {

                newWidth = 40;
                mover.offset( {left:actualHead.offset().left-40} );
              }

              if (actualCol.hasClass('pos')) {

                newWidth = 60;
                mover.offset( {left:actualHead.offset().left-60} );
              }
              

              actualHead.attr('data-width',newWidth);//.parentX('th').attr('data-width',newWidth);

              self.syncColWidth();

              //self.recalcXPosDragHelper();
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
          opt = this.options;

      ///@todo hier brauchen wir dringend ne fehlerbehandlung
      if( opt.headCols ){

        opt.headCols.each(function (idx){

          var actualHead = $S(opt.headCols.get(idx));
          var mover = $S(self.dragBars.get(idx));
          var tmpPos = actualHead.outerWidth()+actualHead.offset().left-2;
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

         var imgNode = $S(this)

         imgNode.parentX('th').bind("click.grid", function() {

          var nIcon = $S(this).find('i.sort'),
            pIcon = nIcon.parent();

          if( pIcon.hasClass('sort-asc') ){
            pIcon.removeClass('sort-asc').addClass('sort-desc');
            nIcon.removeClass().addClass( opt.icon_sort_desc+' sort' );
            nIcon.next().val('desc').change();
          }
          else if( pIcon.hasClass('sort-desc') ){
            pIcon.removeClass('sort-desc');
            nIcon.removeClass().addClass( opt.icon_sort_none+' sort' );
            nIcon.next().val('').change();
          }
          else{
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
        headTab += '<input type="hidden" data-parent-click="th" name="'+nodeName+'" value="'+sortVal+'" class="wcm wcm_req_search wgt-no-save fparam-'+opt.search_form+'" />';
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
      
      /*
      if (undefined ===recalcNums) {
        recalcNums = false;
      }
      
      // nur auf dem ersten body
      var rows = this.element.find( 'tbody:first > tr' ).not('.wgt-block-appear'),
        fact = 3,
        pos = 2,
        oldNode = $G.$WGT.getClassByPrefix( $S(rows.get(0)).prop('class'), 'node-', false  );

      rows.find('>td.pos').not('.ini').click(function(){
        $S(this).parent().toggleClass( 'wgt-selected' );
      }).addClass('ini');
      
      if (recalcNums) {
          
        rows.each(function(){

          var row = $S(this),
            nodeKey = $G.$WGT.getClassByPrefix( row.prop('class'), 'node-', false  );

          if( nodeKey !== oldNode ){

            row.find('td.pos').text(pos);
            oldNode = nodeKey;
            ++fact;
            ++pos;
          }
        });
      }
      */

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
      
      var theTime = new Date();
    
      if( opt.firstRow ){

          opt.firstRow.each(function(idx, node){

          var actualCol = $S(node);
          var actualHead = $S(opt.headCols.get(idx));

          var cWidth = actualHead.attr('data-width');
          var newWidth = cWidth;//-(self.options.hpad+1);//.parent().css( {'width':newWidth+'px','max-width':newWidth+'px'} );
          //--newWidth;
          actualCol.css({'width':newWidth+'px','max-width':newWidth+'px'});
          
          tatsSize = actualCol.outerWidth();

          actualHead.css({'width':tatsSize+'px','max-width':tatsSize+'px'});
          
          //actualHead.width(cWidth-15);
          
          if (self.footCols.length) {
            var fCell = $S(self.footCols.get(idx));
            fCell.css( {'width':newWidth,'max-width':newWidth} );
          }

        });
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

      var fNum = this.element.parent().parent().parent().find('.wgt-num-entry');

      if (!fNum.length) {
        return;
      }

      var numVal = Number(fNum.text());
      --numVal;
      fNum.text(numVal);

    },//end decEntries

    /**
     * Setzen der Anzahl gelisteter Einträge
     */
    setNumEntries: function(num){

      var fNum = this.element.parent().parent().parent().find( '.wgt-num-entry' );

      if (!fNum.length) {
        console.log('Did not find wgt-num-entry');
        return;
      }

      fNum.text(num);

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

     
     this.syncColWidth();

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
      // In jQuery UI 1.8, you have to manually invoke the _setOption method from the base widget
      //$.Widget.prototype._setOption.apply( this, arguments );

      // In jQuery UI 1.9 and above, you use the _super method instead
      //this._super( "_setOption", key, value );

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


    /**
     * @param formId
     * @param element
     * @deprecated wird über wcm + forms geregelt
     */
    pageSize: function( formId, element  ){

      $S('form#'+formId).data('qsize',$S(element).val());
      $S('form#'+formId).data('start',0);

      $R.form(formId);

    },//end this.pageSize

    /**
     * @param formId
     * @param element
     * @deprecated wird über wcm + forms geregelt
     */
    search: function( formId, element ){

      Console.error('Triggered DataGrid Search!');
      $S('form#'+formId).data('qsize',$S(element).val());
      $S('form#'+formId).data('start',0);

      $R.form(formId);

    }//end this.search

  });


}( jQuery, window ) );

