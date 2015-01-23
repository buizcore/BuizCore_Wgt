/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
/**
 * WGT Web Gui Toolkit
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
 * dropdown Widget
 * @author dominik alexander bonsch <db@webfrap.net>
 *
 * @todo mit der Contextbox verheiraten
 *
 */
(function( jQuery) {

  "use strict";
  jQuery.widget( "bcp.dropdown", {

    // These options will be used as defaults
    options: {
      clear         : null,
      align         : 'left',    // soll das overlay nach links oder rechts positionieren?
      valign        : 'bottom',  // soll das overlay über oder unter dem element erscheinen
      triggerEvent  : 'click',
      menuMode      : true,
      overlayStyle  : {width:200},
      closeOnLeave  : false,
      closeScroll   : false,
      onOpen        : function(){},
      onClose       : function(){}
    },


    // Set up the widget
    _create: function() {

      var self = this,
        ge = this.element,
        opts = this.options,
        dropBoxId = ge.attr( 'data-drop_box' ),
        dropBox = jQuery( '#'+dropBoxId );
      
      // leere menüs direkt verstecken
      if( opts.menuMode ){
          if( dropBox.find('li').length == 0 ){
            ge.hide();
            return;
          }
      }
      
      if( opts.triggerEvent ){
        ge.bind( opts.triggerEvent+'.dropdown' ,function(){
          self.open();
        });
      }

    },

    // Set up the widget
    init: function(  ){

      var self = this,
        ge = this.element,
        opts = this.options;

      if( ge.hasClass('wgt-dpm-init') )
        return;

      ge.addClass('wgt-dpm-init')

      var dropBoxId = ge.attr( 'data-drop_box' ),
          dropBox = jQuery( '#'+dropBoxId );
      
      // leere menüs direkt verstecken
      if (opts.menuMode) {
          if( dropBox.find('li').length == 0 ){
              ge.hide();
              return;
          }
      }


      // browser contextmenü deaktivieren
      dropBox.bind('contextmenu', function() { return false;});

      // verhindern, dass der text selectiert werden kann
      //dropBox.disableSelection();

      if (jQuery("#"+dropBoxId+'-init').length === 0){
        jQuery("body").append( dropBox );
      }
      else{
        jQuery("#"+dropBoxId+'-init').replaceWith( dropBox );
      }

      dropBox.attr( 'id', dropBoxId+'-init'  );

      // schliesen des Overlays wenn es verlassen wird
      if( true === opts.closeOnLeave || 'true' === opts.closeOnLeave  ){

        var dEnter = null;
        var dClose = null;

        setTimeout( function(){

            if( !dropBox.hasClass('mouse_in') && !dropBox.hasClass('mouse_in') ){
              self.close();
            }

          },
          600
        );

        dropBox.bind( 'mouseenter.dropdown', function(){

          dropBox.addClass('mouse_in');
          dropBox.removeClass('mouse_in');
        }).bind( 'mouseleave.dropdown', function(){

          dropBox.removeClass('mouse_in');
        });


        dropBox.bind( 'mouseenter.dropdown', function(){

          dEnter = new Date().getTime();
          dropBox.addClass('mouse_in');
          //$target.removeClass('mouse_in');

          dropBox.bind( 'mouseleave.dropdown', function(){

            dClose = new Date().getTime();
            dropBox.unbind('mouseleave.dropdown');
            dropBox.removeClass('mouse_in');

            setTimeout( function(){
                if( (dClose - 400) > dEnter ){
                  self.close();
                }
              },
              450
            );

          });
        });


      }//end if( true === opts.closeOnLeave || 'true' === opts.closeOnLeave  )

      if (opts.menuMode) {
          this.initFolding( ge, dropBox );
      } else {
          ge.find(':input').on('click',function(){$(this).focus();});
      }

    },
    
    /**
     * Menu folding
     */
    initFolding: function( el, dropBox ){

      dropBox.find( 'li' ).bind( 'mouseover.dropdown', function(){
        jQuery(this).addClass( 'hover' ).find('>span').css('display','block');
      }).bind( 'mouseout.dropdown', function(){
        jQuery(this).removeClass( 'hover' ).find('>span').css('display','none');
      });

    },

    setKeyCommands: function(  ge,  dropBox ){

      var self = this;

      jQuery(document).bind( 'mousedown.dropdown',function( evt ){
        console.log( 'dropdown global click' );
        
        if (jQuery(evt.target).is(':input')) {
          jQuery(evt.target).focus();
          return true;
        }
        
        if( !jQuery(evt.target).parentX( dropBox ) ){
          self.close();
        }
        return true;
      });
      
      dropBox.find('.bcpa-close').on('mouseup',function(){self.close();});
      
      if (!this.options.menuMode) {
          return false;
      }

      // Elemente des dropmenüs per tastatur selectierbar machen
      jQuery(document).bind( 'keypress.dropdown',  function(e) {

        switch( e.keyCode ) {

          case 38: // up


            if( dropBox.find('li.hover').length === 0 ) {

              dropBox.find('li:last').addClass('hover');
            } else {

              var act = dropBox.find('li.hover');

              var bef = dropBox.find('li.hover').not('.disabled').before();

              if( bef.is('li') ){
                dropBox.find('li.hover').not('.disabled').next().addClass('hover').css('backgroundColor',"black");
              }

              act.remove('hover');

              if( dropBox.find('li.hover').length === 0 ){
                dropBox.find('li:last').addClass('hover').css('backgroundColor',"blue");
              }
            }
          break;

          case 40: // down

            console.log('key down');

            if( dropBox.find('li.hover').length === 0 ) {

              dropBox.find('li:first').addClass('hover').css('backgroundColor',"green");
            }
            else {

              dropBox.find('li.hover').removeClass('hover').not('.disabled').eq(0).addClass('hover').css('backgroundColor',"olive");

              if( dropBox.find('li.hover').length === 0 ){
                dropBox.find('li:first').addClass('hover').css('backgroundColor',"yellow");
              }
            }
          break;

          /*
          case 13: // enter
            console.log('key enter');
            dropBox.find('li.hover a').trigger('click');
          break;
          */

          case 27: // esc
            console.log('key esc');
            self.close();
          break;

        }// end switch

      });

    },

    /**
     * Key Commands wieder deaktivieren
     */
    removeKeyCommands: function(){

      jQuery(document).unbind( 'keypress.dropdown' ).unbind( 'mousedown.dropdown' );

    },

    // Set up the widget
    open: function(  ){

      var self = this,
        ge = this.element, //das element auf welches geklickt wurde
        opts = this.options,
        doc = jQuery(document);

      self.init();
      
      ge.parent().addClass('open');

      var dropBoxId = ge.attr( 'data-drop_box' ),
        dropBox = jQuery( '#'+dropBoxId+'-init' );

      // leere menüs nicht öffnen
      /*
      if( 0 == dropBox.find('li').length ){
         return false;
      }*/

      //$target.addClass('flag-menu-overlay');
      // Die ausrichtung und position des Overlays berechnen
      // sicher stellen, dass es nicht über die Ränder hinaus floatet
      var style = ge.offset(),
        tStyleW = ge.outerWidth(),
        oStyleH = dropBox.outerHeight(),
        oStyleW = dropBox.outerWidth(),
        winW = doc.width(),
        winH = doc.height()-40;

      // Get options of the element
      this.closeAll();


      // check if we need a try/catch here
      if( opts.onOpen ){
        opts.onOpen( ge );
      }

      if( !style ){

        console.error( 'Dropbox is missing the style' );

        if( console.trace ){
          console.trace();
        }

        return;
      }

      if( 'right' === opts.align ){

        style.left =  style.left + tStyleW - oStyleW;

        if( ( style.left + opts.overlayStyle.width ) > winW ){
          style.left = winW - opts.overlayStyle.width;
        }

      }
      else if( 'middle' === opts.align ){

        style.left = style.left + ( ( tStyleW - oStyleW ) / 2 ) ;

        if( ( style.left + opts.overlayStyle.width ) > winW ){
          style.left = winW - opts.overlayStyle.width;
        }

      }
      else{

        if( ( style.left + opts.overlayStyle.width ) > winW ){
          style.left = winW - opts.overlayStyle.width;
        }
      }

      if( style.left < 0 ){
        style.left = 10;
      }

      style['z-index'] = '6000';

      // adjust top coordinate

      if(  'bottom' === opts.valign  ){

        if( ( style.top + oStyleH ) > winH ){
          style.top = winH - oStyleH;
        }

        style.top = style.top + ge.outerHeight();
      }
      else{

        style.top = style.top - oStyleH ;

        if( style.top < 0 ){
          style.top = 0;
        }

      }

      style.position = 'absolute';
      dropBox.css(style);
      dropBox.addClass('opened');
      
      this.setKeyCommands( ge, dropBox );
      dropBox.show( );

    },

    /**
     * globales schliesen aller drowpdown boxes
     */
    closeAll: function(){

      jQuery('.wgt-dropdownbox.opened').removeClass('opened').hide();

      this.removeKeyCommands( );

    },

    /**
     * schliesen des aktuellen dropdowns
     */
    close: function(){

      var dropBox = null,
        opts = this.options,
        elem = this.element;
      
      elem.parent().removeClass('open');

      // callback
      if( opts.onClose ){
        opts.onClose( elem );
      }


      dropBox = jQuery( '#'+elem.attr( 'data-drop_box' )+'-init' );
      dropBox.removeClass('opened').hide();

      this.removeKeyCommands( );

    },

    /**
     * schliesen des aktuellen dropdowns
     */
    remove: function(){

      jQuery(document).unbind('keypress.dropdown');
      jQuery( '#'+this.element.attr( 'data-drop_box' )+'-init' ).remove();

    },

    /*
     * Use the destroy method to clean up any modifications your
     * widget has made to the DOM
     */
    destroy: function() {

      // remove the overlay
      this.remove();
      jQuery.Widget.prototype.destroy.call( this );
    }

  });

}( jQuery ) );

