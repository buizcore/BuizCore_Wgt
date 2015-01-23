/* Licence see: /LICENCES/wgt/licence.txt */


/**
 * @author dominik alexander bonsch <db@webfrap.net>
 */
$R.addAction( 'ui_wysiwyg', function( jNode ){
  
  // laden der wysiwyg konfiguration
  try {
    
    var cfgData = jNode.next();
    var settings = cfgData.is('var#'+jNode.attr('id')+'-cfg-wysiwyg')
      ? $WGT.robustParseJSON(cfgData.text())
      : {};
      
  } catch(err) {
    
    $D.errorWindow( 'UI Error', err.description );
  }
  
  jNode.removeClass('wcm_ui_wysiwyg');
  
  /**
   * define an editor mode, valid modes are:
   * - simple     einfacher editor
   * - rich_text  just text
   * - cms        cms author
   * - full
   */
  if( settings.mode === undefined ){

    var tmpMode = jNode.attr('data-mode');

    if ( undefined !== tmpMode ) {
      settings.mode = tmpMode;
    } else {
        
      tmpMode = jNode.attr('wgt_mode');
       
      if ( undefined !== tmpMode ) {
         settings.mode = tmpMode;
      } else {
         settings.mode = 'simple';
      }
    }

  }
  
  if( jNode.attr('wgt_mode') ){
    
    settings.mode = jNode.attr('wgt_mode');
  }
  
  var parentN = jNode.parent();
  
  if( settings.width === undefined )
    settings.width = parentN.innerWidth();
  
  
  if(settings.height === undefined){
      var parX = jNode.parentX('section.wgt-content_box.form.wysiwyg');
      if (parX) {
          settings.height = 155;
      } else {
          settings.height = parentN.innerHeight();
      }
  }
  
  
  /**
   * Key / Value based variables
   * @example
   * {
   *   username : "Some User",
   *   staffid : "991234"
   * }
   */
  if( settings.template_replace_values === undefined )
    settings.template_replace_values = {};
  
  
  if( 'simple' === settings.mode ){
      
    /*
    settings.selector: "textarea#"+jNode.attr('id');
    settings.theme = 'modern';
    settings.width: jNode.outerWidth();
    settings.height: jNode.outerHeight();
    settings.plugins = '';
    settings.toolbar= "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons";
    settings.style_formats= [];
    */
    
    tinymce.init({
      selector: "textarea#"+jNode.attr('id'),
      theme: "modern",
      width: jNode.outerWidth(),
      height: jNode.outerHeight(),
      statusbar: false,
      menubar : false,
      language: $C.lang,
      plugins: [
           "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
           "searchreplace wordcount visualblocks visualchars  fullscreen insertdatetime media nonbreaking",
           "save table contextmenu directionality emoticons template paste textcolor"
     ],
     //content_css: "css/content.css",
     toolbar: " undo redo |  bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fullpage | forecolor backcolor ", 
     style_formats: []
   }); 
   return;
    
  } else if ( 'embed_line' == settings.mode ) {
      
      tinymce.init({
          selector: "#"+jNode.attr('id'),
          theme: "modern",
          add_unload_trigger: false,
          schema: "html5",
          inline: true,
          language: $C.lang,
          forced_root_block : false,
          toolbar: "undo redo | bold italic underline link",
          statusbar: false,
          menubar : false,
          setup: function (editor) {
              editor.on ('change', function (e) {
              });
          }
       }); 
       return;
      
    } else if ( 'embed' == settings.mode ) {
        
        tinymce.init({
            selector: "#"+jNode.attr('id'),
            theme: "modern",
            add_unload_trigger: false,
            schema: "html5",
            inline: true,
            language: $C.lang,
            plugins: [
              "link lists"
            ],
            forced_root_block : false,
            toolbar: "undo redo | styleselect | bold italic underline link | bullist numlist | alignleft aligncenter alignright alignjustify", //alignleft aligncenter alignright alignjustify |
            statusbar: false,
            menubar : false,
            setup: function (editor) {
              editor.on ('change', function (e) {
              });
            }
         }); 
         return;
        
  } else if ( 'rich_text' == settings.mode ) {
    
    settings.theme = 'modern';
    
    settings.plugins = "pagebreak,"
      + "insertdatetime,preview,searchreplace,"
      + "contextmenu,paste,directionality,fullscreen,noneditable,"
      + "visualchars,nonbreaking,";
    
    settings.theme_advanced_buttons1 = "newdocument,|,bold,italic,underline,strikethrough,|"
      +",sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
      +"fontselect,fontsizeselect,|,forecolor,backcolor";
    settings.theme_advanced_buttons2 = "cut,copy,paste,pastetext,pasteword,|,search,replace,|"
      +",bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,"
      +"cleanup,|,insertdate,inserttime,|,charmap,ltr,rtl,|,hr,removeformat,visualaid";
    settings.theme_advanced_buttons3 = "undo,redo,|,fullscreen,|,code,|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking,pagebreak";
    settings.theme_advanced_buttons4 = null;
    
  } else if ( 'cms' == settings.mode || 'know_how' == settings.mode ) {
    
    settings.theme = 'modern';
    
    settings.plugins = "pagebreak,layer,table,"
      + "insertdatetime,preview,media,searchreplace,print,"
      + "contextmenu,paste,directionality,fullscreen,noneditable,"
      + "visualchars,nonbreaking,template";
    
    settings.theme_advanced_buttons1 = "bold,italic,underline,strikethrough,|,sub,sup,|"
      +",justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,backcolor,|,styleselect,formatselect,"
      +"fontsizeselect";
    
    settings.theme_advanced_buttons2 = "cut,copy,paste,pastetext,pasteword,|,search,replace,|"
      +",bullist,numlist,|,outdent,indent,blockquote,|,ltr,rtl,|,link,unlink,anchor";
    
    settings.theme_advanced_buttons3 = "tablecontrols,|,hr,removeformat,visualaid,|"
      +",charmap,image,|,insertdate,inserttime";
    
    settings.theme_advanced_buttons4 = "undo,redo,|,fullscreen,code,cleanup,|,cite,abbr,acronym,del,ins,"
      +"|,visualchars,nonbreaking,template,pagebreak";

    
  } else if ( 'cms_template' == settings.mode ) {
    
    settings.theme = 'modern';
    
    settings.plugins = "pagebreak,layer,table,"
      + "insertdatetime,preview,media,searchreplace,print,"
      + "contextmenu,paste,directionality,fullscreen,noneditable,"
      + "visualchars,nonbreaking,template";
    
    settings.theme_advanced_buttons1 = "bold,italic,underline,strikethrough,|,sub,sup,|"
      +",justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,"
      +"fontselect,fontsizeselect";
    settings.theme_advanced_buttons2 = "bullist,numlist,|,outdent,indent,blockquote,|,ltr,rtl,|,link,unlink,anchor,"
      +"|,forecolor,backcolor";
    settings.theme_advanced_buttons3 = "tablecontrols,|,hr,removeformat,visualaid,|"
      +",charmap,media,image,|,insertdate,inserttime,|,advhr";
    settings.theme_advanced_buttons4 = "undo,redo,|,fullscreen,code,attribs,styleprops,cleanup,|,insertlayer,moveforward,movebackward,absolute,"
      +"|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking,template,pagebreak";

    
  } else if ( 'full' == settings.mode  ) {
    
    settings.theme = 'modern';
    
    settings.plugins = "pagebreak,layer,table,"
      + "insertdatetime,preview,media,searchreplace,print,"
      + "contextmenu,paste,directionality,fullscreen,noneditable,"
      + "visualchars,nonbreaking,template";
    
    settings.theme_advanced_buttons1 = "newdocument,|,bold,italic,underline,strikethrough,|"
      +",justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,"
      +"fontselect,fontsizeselect";
    settings.theme_advanced_buttons2 = "cut,copy,paste,pastetext,pasteword,|,search,replace,|"
      +",bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,"
      +"cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor";
    settings.theme_advanced_buttons3 = "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|"
      +",charmap,media,|,print,|,ltr,rtl,|,fullscreen";
    settings.theme_advanced_buttons4 = "insertlayer,moveforward,movebackward,absolute,"
      +"|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak";

    
  } else {
    
    settings.theme = 'simple';
    settings.plugins = '';

    $D.errorWindow( 'UI Error', 'Got undefined Editor mode '+settings.mode+', fallback to simple mode.' );
  }
  
  console.log( "w: "+settings.width+" h: "+settings.height );

  //alert(tinymce.editors[jNode.attr('id')]);
  
  if(tinymce.editors[jNode.attr('id')]!== undefined){
	  tinyMCE.execCommand('mceRemoveControl',false, jNode.attr('id')); 
	  tinymce.editors[jNode.attr('id')] = null;
  }
  
  jNode.tinymce({
    
    // Location of TinyMCE script
    script_url : $C.WEB_WGT+'/vendor/tinymce/js/tinymce/tinymce.min.js',
  
    // General options
    theme   : settings.theme,
    plugins : settings.plugins,
    
    width : settings.width,
    height: settings.height,
    
    language: $C.lang,
  
    // Theme options
    theme_advanced_buttons1 : settings.theme_advanced_buttons1,
    theme_advanced_buttons2 : settings.theme_advanced_buttons2,
    theme_advanced_buttons3 : settings.theme_advanced_buttons3,
    theme_advanced_buttons4 : settings.theme_advanced_buttons4,
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,

    //hans: 'wurst',
  
    // Example content CSS (should be your site CSS)
    //content_css : $C.WEB_GW+"theme.php?l=list.cms",
  
    // Drop lists for link/image/media/template dialogs
    //template_external_list_url : "lists/template_list.js",
    //external_link_list_url     : "lists/link_list.js",
    //external_image_list_url    : "lists/image_list.js",
    //media_external_list_url    : "lists/media_list.js",
  
    // Replace values for the template plugin
    //template_replace_values : settings.template_replace_values
  });



});