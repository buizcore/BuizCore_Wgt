/**
 * WGT Web Gui Toolkit
 *
 * http://buizcore.net/WGT
 *
 * @author Dominik Bonsch <db@webfrap.net>
 *
 * Depends:
 *   - jQuery
 *   - jQuery widget factory
 *   - web/core/bcp.desktop.js
 *
 * License:
 * Dual licensed under the MIT and GPL licenses:
 * @license http://www.opensource.org/licenses/mit-license.php
 * @license http://www.gnu.org/licenses/gpl.html
 *
 */

/**
 * 
 * 
 */
(function( jQuery) {

  "use strict";
  
  jQuery.widget( "bcp.cmsEditor", {

    // These options will be used as defaults
    options: {
      clear         : null,
      lang: 'de',
      toolbars: {
    	  'line' : {
    		  'plugins' : "",
    		  'toolbar' : false
    	  },
    	  'text-only' : {
    		  'plugins' : "",
    		  'toolbar' : 'undo redo'
    	  },
    	  'simple' : {
    		  'plugins' : "",
    		  'toolbar' : 'undo redo'
    	  },
    	  'advanced' : {
    		  'plugins' : "link lists image code fullscreen",
    		  'toolbar' : 'undo redo  | bold italic link image | bullist numlist | alignleft aligncenter alignright alignjustify | code fullscreen'
    	  }
      }
    },


    // Set up the widget
    _create: function() {
    	
    	this.init();

    },
    
    init: function(){
    	
    	this.initWysiwyg();
    	this.initDropzone();
    	this.initEvents();
    },

    // Set up the widget
    initWysiwyg: function(  ){

    	var self = this,
    		opts = this.options;
    	
		tinymce.init({
		    selector: ".ec",
		    theme: "modern",
		    add_unload_trigger: false,
		    schema: "html5",
		    inline: true,
		    valid_elements: "@[id|class|title|style|data-options|data*]," 
    		    + "a[name|href|target|title],hr,br,figure,div,img[src|alt],i,button,ol,ul,li,"
    		    + "#p,-b,-u,"
    		    + "-span[data-mce-type]",
	        noneditable_leave_contenteditable: true,
		    plugins: "link lists image bcpimage bcpblocks code fullscreen noneditable",
		    forced_root_block : false,
	        force_p_newlines : false,
            force_br_newlines : true,
		    language : opts.lang,
		    toolbar: "undo redo  | bold italic link bcpimage | bcpblocks2 bcpblocks3 |  bullist numlist | alignleft aligncenter alignright alignjustify | code fullscreen ", //
		    statusbar: false,
		    menubar : false,
		    setup: function (editor) {
              editor.on ('change', function (e) {
                  jQuery(window).on("beforeunload",  self.checkClose);
              });
          }
		});

        $('.ec').addClass('bcp-e-text');

        tinymce.init({
          selector: ".ecl",
          theme: "modern",
          add_unload_trigger: false,
          schema: "html5",
          inline: true,
          forced_root_block : false,
          language : opts.lang,
          toolbar: "undo redo",
          statusbar: false,
          menubar : false,
          setup: function (editor) {
              editor.on ('change', function (e) {
                  jQuery(window).on("beforeunload",  self.checkClose);
              });
          }

        });

        $('.ecl').addClass('bcp-e-text');

    },

    initDropzone: function(){
    	
    	var self = this;
    	
        // image upload with cropping feature
        $('.dz').not('.state-editor-initialized').each(function(){

          var jNode = $(this),
              figureNode = null,
              containerId = jNode.attr('id');
          
          jNode.addClass('state-editor-initialized');

          jNode.dropzone({
            url: jNode.attr('data-dz-target'),
            uploadMultiple: false,
            paramName: jNode.attr('data-p_name')||'image',
            clickable: true,
            //forceFallback: true,
            addRemoveLinks: true,
            maxThumbnailFilesize:5,
            previewsContainer: '#bcp-upload-preview',
            drop:function(){
                $('#bcp-upload-preview').show();  
            },
            init: function() {
              this.on("processing", function(file) {
            	  	
				if(jNode.attr('data-dz-params')){
				  this.options.url = jNode.attr('data-dz-target')+'&ajax=true&'+jNode.attr('data-dz-params');
				} else {
				  this.options.url = jNode.attr('data-dz-target')+'&ajax=true';
				}

                console.log('upload url '+this.options.url );
              });
            },
            success:function(file, response){
                
            	//var jsonResp = $.parseJSON(response);
            	self.setNewImage(jNode,response);
            	jQuery(window).on("beforeunload",  self.checkClose);
            	
				if (jNode.attr('data-callback')) {
					window.bc_callbacks[jNode.attr('data-callback')](jNode,response);
				}
              //$R.handelSuccess($S.parseXML(response));
            }
          });

          jNode.find('.dz-default.dz-message').remove();
          
          // add the cropping functions
          
          figureNode = jNode.parentX('figure');
          figureNode.find('.bcpa-active-crop').on( 'click', function(){
              
              var btnNode = $(this);
              
              var pos = {},
              imgWidth = 0,
              imgHeight = 0,
              jcrop_api = null,
              
              removeCrop = function(){
                  $('#panel-crop-controls').remove();
                  jcrop_api.destroy();
                  $('#'+containerId+'-image').css({'width':'auto','height':'auto'});
                  $('body').off('click',clickCrop);
              },          
              clickCrop = function(evt){
                  
                 var clckTarget = $(evt.target);
                  
                 if( !clckTarget.parentX(figureNode) 
                         && !clckTarget.parentX('div#panel-crop-controls') 
                         && !clckTarget.is('div#panel-crop-controls') ){
                     removeCrop();
                 } 
              };
              
              pos = jNode.next().offset();
              imgWidth = jNode.outerWidth();
              imgHeight = jNode.outerHeight();
              
              
              var tpl = $('#tpl-crop-menu').html();
              tpl = Handlebars.compile(tpl);
              
              var data = {
                'imgHeight': imgHeight,
                'imgWidth': imgWidth,
                'form_target': jNode.attr('data-crop-target') 
              }

              figureNode.append(tpl(data));
              $('body').on('click',clickCrop);
              
              $('#bcp-btn-save-crop').on('click',function(){
                  
                  var imgData = $R.form('form-img-crops-data', {
                      success : function( rqt, data ){
                          $('#'+containerId+'-image').attr('src', data.new_src );
                      }
                  });
                  
                  removeCrop();
              });
              
              $('#bcp-btn-orig-crop').on('click',function(){
                  
                  var parts = $('#'+containerId+'-image').attr('src').split('?');
                  
                  $('#'+containerId+'-image').attr('src',parts[0]+'.orig' );
                  removeCrop();
                  figureNode.find('.bcpa-active-crop').trigger('click');
 
              });
              
              $('#bcp-btn-reset-crop').on('click',function(){
                  removeCrop();
              });
              
              
              jNode.Jcrop({
                  'onSelect': function(cords){

                      $('#inp-img-crops-x').val(cords.x);
                      $('#inp-img-crops-y').val(cords.y);
                      $('#inp-img-crops-x2').val(cords.x2);
                      $('#inp-img-crops-y2').val(cords.y2);
                      
                  },
                  'onRelease': function(){
                      //removeCrop();
                  }
              },function(){
                  jcrop_api = this;
              });
              
          });
          
        });

        /*  dropdown */
        $('.dzl').each(function(){

          jNode = $(this);
          jNode.removeClass('dzl');

          jNode.dropzone({
            url: jNode.attr('data-dz-target')+'?ajax=true',
            uploadMultiple: true,
            paramName: jNode.attr('data-dz-param')||'image',
            clickable: this,
            //forceFallback: true,
            addRemoveLinks: true,
            maxThumbnailFilesize:5,
            previewsContainer: '#bcp-upload-preview',
            drop:function(){
              $('#bcp-upload-preview').show();  
            },
            success:function(file, response){

              //$R.handelSuccess($S.parseXML(response));
            }
          });

          jNode.find('.dz-default.dz-message').remove();
        });
    },
    
    setNewImage: function(jNode,jsonResp){
        jNode.attr('src',jsonResp.body.new_src);
        jNode.attr('data-img-name',jsonResp.body.new_name);
        jNode.attr('data-img-key',jsonResp.body.new_key);
    },
    
    initEvents: function(){
    	
    	var self = this;

        // save the page
        $('#save-page').on('click',function(){
            var button = $(this);
            
            console.log('send data form '+button.attr('data-form'));
            $R.form(button.attr('data-form'));
            jQuery(window).off("beforeunload",  self.checkClose);
        });
        

        $('.bcpa-create').on('click',function(){
            var button = $(this);
            console.log('send data form '+button.attr('data-form'));
            $R.form(button.attr('data-form'));
            window.location='/'+button.attr('data-page-key')+'/edit';
            jQuery(window).off("beforeunload",  self.checkClose);
        });
        
        $('.bcpa-open-textblock-editor').on('click',function(){
            window.location = "/cms/MenuManager.html";
        });
        
        $('.bcpa-open-menu-editor').on('click',function(){
            window.location = "";
        });

        
        
        
    	
    },
    
    checkClose: function(){
        return "Einige Inhalte wurde noch nicht gespeichert. Die Seite trotzdem verlassen?";
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


window.bc_callbacks = {};
//var initEditor = null;



$(document).ready(function(){
    $(document).cmsEditor();
});

	
    /*
    initEditor = function(){
        
    }
    
    */

        // links?
        /*
        $('.ajax').each(function(){

          var jNode = $(this);
          jNode.removeClass('ajax');

          jNode.on('click',function(){
            $.ajax({
              'url':jNode.attr('href'),
              'data': {'ajax':'true'},
              'success':function(data, textStatus, jqXHR){

                if ('string' == typeof data) {
                  data = $.parseJSON(data);
                }

                if (jNode.attr('data-callback')) {
                  window.bc_callbacks[jNode.attr('data-callback')](jNode,data);
                }
              }
            });
            return false;
          });

        });
        */

        
        /* Editierbare Bilder */
        /*
        $('.crop').each(function(){

          var jNode = $(this);
          
          var pos = {},
          imgWidth = 0,
          imgHeight = 0,
          jcrop_api = null,
          
          removeCrop = function(){
              $('#panel-crop-controls').remove();
              $('#main-content').off('click',clickCrop);
              $('#'+containerId+'-image').css({'width':'auto','height':'auto'});
              jcrop_api.release();
          },          
          clickCrop = function(evt){
              
             var clckTarget = $(evt.target);
              
             if( !clckTarget.parentX(jNode.next()) && !clckTarget.parentX('div#panel-crop-controls') && !clckTarget.is('div#panel-crop-controls') ){
                 removeCrop();
             } 
          };
          
          jNode.Jcrop({
              'onSelect': function(cords){
                  
                  if($('#panel-crop-controls').is('#panel-crop-controls')){
                      $('#inp-img-crops-x').val(cords.x);
                      $('#inp-img-crops-y').val(cords.y);
                      $('#inp-img-crops-x2').val(cords.x2);
                      $('#inp-img-crops-y2').val(cords.y2);
                      return;
                  }

                  pos = jNode.next().offset();
                  imgWidth = jNode.outerWidth();
                  imgHeight = jNode.outerHeight();
                  
                  
                  var tpl = $('#tpl-grop-menu').html();
                  tpl = Handlebars.compile(tpl);
                  
                  var data = {
                    'top':(pos.top+imgHeight),
                    'left':pos.left,
                    'width': imgWidth,
                    'imgHeight': imgHeight,
                    'imgWidth': imgWidth,
                    'alt': jNode.attr('alt')
                  }
    
                  $('#main-content').append(tpl(data));
                  
                  $('#inp-img-crops-x').val(cords.x);
                  $('#inp-img-crops-y').val(cords.y);
                  $('#inp-img-crops-x2').val(cords.x2);
                  $('#inp-img-crops-y2').val(cords.y2);
                  
                  $('#main-content').on('click',clickCrop);
                  
              },
              'onRelease': function(){
                  removeCrop();
              }
          },function(){
              jcrop_api = this;
          });

        });

      };
*/


    
      /*
    function reportSuccess(msg){
        alert(msg);
    }
    
    function setNewImage(jNode,jsonResp){
        jNode.attr('src',jsonResp.new_src);
    }*/

    /*
    window.setInterval(function(){$('.mce-resizehandle').hide();},300);
    
    window.setInterval(function(){
        $('#simfi-upload-preview .dz-preview').each(function(){
            var uplPrev = $(this);
            if(uplPrev.find('.dz-upload')){
                
            }
            uplPrev.fadeOut(300);
            uplPrev.remove();
        });
        
        if(!$('#simfi-upload-preview .dz-preview').length){
            $('#simfi-upload-preview').fadeOut(500);
        }
        
    },6000);
	*/
    







