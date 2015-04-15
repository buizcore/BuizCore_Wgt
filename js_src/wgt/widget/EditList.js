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
 * @author dominik bonsch <db@webfrap.net>
 */
(function( $S, $G, undefined ) {

  "use strict";

  $S.widget( "wgt.editList", {
      
      /**
      * Standard Options
      */
      options: {
          elId: null,
          initLoad: false, // sollen die inhalte vom server geladen werden?
          read_url: null, // lesen eines einzellnen Datensatzes
          save_url: null, // save url wenn keine expliziten insert oder update urls verwendet werden müssen
          save_all_url:  null, // multisave
          insert_url: null, // hinzufügen eines neuen Datensatzes
          update_url: null, // ändern eines datensatzes
          delete_url: null, // löschen eines datensatzes
          search_url: null, // suche / paging etc
          read_only: false,
          new_counter: 0,
          type_field: 'id_type',
          tpls: {}
      },


      /**
      * Setup / Constructor methode des Widgets
      */
      _create: function() {

          var opts = this.options;

          // das aktuelle element mit "hello world" ersetzen
          // tag ist konfigurierbar
          opts.elId = this.element.attr('id');

          if (opts.initLoad) {
              this.loadFromServer();
          }

          this.initEvents();

      },//end _create

    /**
     *
     */
    initEvents: function(){

        var self = this, 
          opts = this.options,
          el = this.element;


        if (opts.read_only) {

            // controls entfernen
            el.find('.item-act-add,.block.controls').remove();


        } else {

            /*
            el.on('dblclick','.entry:not(.edit)', function(){
                var formNode = $S(this),
                    data = self.readViewData(formNode),
                    editTpl = self.loadTemplate('edit');
                formNode.replaceWith(editTpl(data));
                $R.eventAfterAjaxRequest();
            });
            */

            // ein element editieren
            el.on('click','.item-act-edit',function(){
                
                var formNode = $S(this).parentX('.entry'),
                    data = self.readViewData(formNode),
                    editTpl = self.loadTemplate('edit');
                
                formNode.replaceWith(editTpl(data));
                $R.eventAfterAjaxRequest();
            });

            // ein element editieren
            el.on('click','.item-act-edit-all',function(){
                
                el.removeClass('view-mode');
                el.addClass('edit-mode');
                
                var formNodes = el.find('.entry'),
                    formNode = null,
                    data = null,
                    editTpl = self.loadTemplate('edit');
                
                formNodes.each(function(){
                    formNode = $S(this);
                    data = self.readViewData(formNode);
                    $S(this).replaceWith(editTpl(data));
                });
                
                $R.eventAfterAjaxRequest();
            });

            // ein element editieren
            el.on('click','.item-act-save-all',function(){
                
                self.saveAll();
            });

            // ein element editieren
            el.on('click','.item-act-save',function(){

                var formNode = $S(this).parentX('.entry'),
                    data = self.readData(formNode),
                    showTpl = self.loadTemplate('view'),
                    respData = null;

                respData = $R.post(opts.save_url+formNode.attr('data-eid'), formNode.find(':input').not('.ign').serialize());

                data['rowid'] = respData.data.rowid;

                formNode.replaceWith(showTpl(data));
                $R.eventAfterAjaxRequest();

            });

            // ein neues Element hinzufügen
            el.on('click','.item-act-add',function(){
                self.formNewEntry();
                $R.eventAfterAjaxRequest();
            });
            
            
            $S('#'+opts.elId+'-select-create').on('change', function(evt, params) {
                var type = $S(this).val(),
                    data = {},
                    typeField = opts.type_field;
                    
                    data[opts.type_field] = type;

                self.formNewEntry( data );
                $R.eventAfterAjaxRequest();
            });


            // ein element löschen
            el.on('click','.item-act-remove',function(){

                $R.del(opts.delete_url+$S(this).parentX('.entry').attr('data-eid'));
                $S(this).parentX('.entry').remove();
            });

            // noch nicht gespeichertes element zurücksetzen
            el.on('click','.item-act-reset',function(){

                var formNode = $S(this).parentX('.entry'),
                    data = self.readData(formNode),
                    showTpl = self.loadTemplate('view'),
                    rowid = formNode.attr('data-eid');

                if(rowid && '' != rowid){

                    data['rowid'] = rowid;
                    formNode.replaceWith(showTpl(data));
                    $R.eventAfterAjaxRequest();

                } else {

                    $S(this).parentX('.entry').remove();
                }

            });
        }

        
    },//end this.initEvents
    
    /**
     * @var replace boolean
     */
    saveAll: function() {
        
        if (!this.element.is('.edit-mode')) {
            return;
        }

        var opts = this.options,
            el = this.element,
            self = this,
            formNodes = $S('#'+opts.elId+' > ul.root > li.entry'),
            formNode = null,
            data = null,
            dataBody = '',
            showTpl = self.loadTemplate('view'),
            respData = null,
            inputs = formNodes.find(':input').not('.ign');
    

        if (formNodes.find(':input.state-warn').length) {
            return;
        }
    
        el.removeClass('edit-mode');
        el.addClass('view-mode');
        respData = $R.post(opts.save_all_url, inputs.serialize() );
        
        formNodes.remove();
        self.loadFromServer();
        
        $R.eventAfterAjaxRequest();
        
    },//end this.saveAll */

      /**
       * @var replace boolean
       */
      loadFromServer: function(replace){

          var self = this,
              opts = this.options,
              el = this.element,
              listTpl = self.loadTemplate('list'),
              listData = $R.get( opts.search_url );

          if (undefined === replace) {
              el.find('ul').append(listTpl(listData.data));
          } else {
              el.find('ul').html(listTpl(listData.data));
          }

      },//end this.loadFromServer */

     /**
      * @var vars array 
      */
      formNewEntry: function( vars ){

          if (undefined === vars) {
              vars = {};
          }
          
          var self = this,
              el = this.element,
              opts = this.options,
              tpl = this.loadTemplate('edit');

          vars['rowid'] = 'new-'+opts.new_counter;
          
          ++opts.new_counter; 

          el.find('>ul').append(tpl(vars));

      },//end this.initEvents

    
      /**
      * @param key :string key des zu ladenten templates
      */
      loadTemplate: function( key ){

          var tpls = this.options.tpls;

          if (tpls[key] === undefined) {
              var baseSource = $S("#"+this.options.elId+"-"+key+"-tpl").html();
              tpls[key] = Handlebars.compile(baseSource);
          }

          return tpls[key];

      },//end this.loadTemplate

      /**
       * @param key :string key des zu ladenten templates
       */
      readData: function( entryNode ){

          var data = {};

          data.rowid = entryNode.attr('data-eid');

          entryNode.find(':input').not('input[type="radio"]').each(function(){

              var ln = $S(this);
              if(ln.is('select')){
                  data[ln.attr('data-label-key')] = ln.find('option:selected').text();
                  data[ln.attr('data-key')] = ln.val();

                  console.log( 'got select data: '+ln.attr('data-key')+' '+ln.val() );
              } else if(ln.is('input[type="checkbox"]')){
                  data[ln.attr('data-key')] = ln.is(':checked');

                  console.log( 'got select data: '+ln.attr('data-key')+' '+ln.val() );
              } else {
                  data[ln.attr('data-key')] = ln.val();
                  console.log( 'got inp data: '+ln.attr('data-key')+' '+ln.val() );
              }

          });

          entryNode.find('.radio-group').each(function(){

              var selected = $S(this).find('input[type="radio"]:checked');

              if (!selected) {
                  selected = $S(this).find('input[type="radio"]:first');
              }
                  
              data[selected.attr('data-key')] = selected.val();

          });

          return data;

      },//end this.readData

      /**
       * @param key :string key des zu ladenten templates
       */
      readViewData: function( entryNode ){

          var data = {};
          data = $WGT.robustParseJSON(entryNode.find('>var').text());
          return data;

      },//end this.readViewData
    

      /**
      * Die Destroymethode kann dazu verwendet werden um Änderungen welche
      * Durch das Widget erstellt wurde rückgängig zu machen.
      *
      */
      destroy: function() {

          $S.Widget.prototype.destroy.call( this );
      }//end destroy

  });


}( jQuery, window ) );

