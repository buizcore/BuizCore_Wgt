/* Licence see: /LICENCES/wgt/licence.txt */

//Dropzone.autoDiscover = false;

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 * @todo doku, was genau sollte das denn machen?
 */
$R.addAction( 'input_dropzone', function( jNode ){

  jNode.removeClass("wcm_input_dropzone");

  jNode.dropzone({
    url: $S(jNode.attr('data-form')).attr('action'),
    uploadMultiple: true,
    paramName: "file",
    clickable: jNode.attr('data-click_area'),
    //forceFallback: true,
    addRemoveLinks: true,
    maxThumbnailFilesize:5,
    previewsContainer: '.preview-container',
    init: function() {
      this.on("processing", function(file) {
        this.options.url = $S(jNode.attr('data-form')).attr('action')+'&folder='+$S(jNode.attr('data-folder')).val();
        console.log('upload url '+this.options.url );
      });
    },
    accept: function(file, done) {
      if ( !$S(jNode.attr('data-folder')).val() ) {
        done("You can't upload files in this folder");
      } else { 
        done(); 
      }
    },
    success:function(file, response){
      
      $R.handelSuccess($S.parseXML(response));
    }
  });
  
  jNode.find('.dz-default.dz-message').remove();

});

$R.addAction( 'input_dropfile', function( jNode ){

    jNode.removeClass("wcm_input_dropfile");
    
    //console.log('upload form '+$S(jNode.attr('data-form')).attr('action'));
    
    var uploadUrl = $S('#'+jNode.attr('data-form')).attr('action');
    
    if (!uploadUrl) {
        uploadUrl = jNode.attr('data-url');
    }
    
    jNode.dropzone({
      url: uploadUrl,
      uploadMultiple: true,
      paramName: "file",
      clickable: jNode.attr('data-click_area'),
      //forceFallback: true,
      addRemoveLinks: true,
      maxThumbnailFilesize:5,
      previewsContainer: '#wgt-upload-preview',
      init: function() {
        this.on("processing", function(file) {
          //this.options.url = $S(jNode.attr('data-form')).attr('action');
          console.log('upload url '+this.options.url );
        });
      },
      accept: function(file, done) {
          done(); 
      },
      success:function(file, response){
        
        $R.handelSuccess($S.parseXML(response));
      }
    });
    
    jNode.find('.dz-default.dz-message').remove();

});

// upload
$R.addAction( 'input_dropimg', function( jNode ){

    jNode.removeClass("wcm_input_dropimg");

    jNode.dropzone({
        url: jNode.attr('data-url'),
        uploadMultiple: false,
        paramName: jNode.attr('data-param')||'image',
        clickable: true,
        //forceFallback: true,
        addRemoveLinks: true,
        maxThumbnailFilesize: 5,
        previewsContainer: '#wgt-upload-preview',
        drop:function(){
            $S('#wgt-upload-preview').show();  
        },
        init: function() {
          this.on("processing", function(file) {

            $S('#wgt-upload-preview').show();  
            if(jNode.attr('data-params')){
              this.options.url = jNode.attr('data-url')+'&dim='+jNode.attr('data-dim')+'&ajax=true&'+jNode.attr('data-params');
            } else {
              this.options.url = jNode.attr('data-url')+'&dim='+jNode.attr('data-dim')+'&ajax=true';
            }
        
            console.log('upload url '+this.options.url );
          });
        },
        success:function(file, response) {

          $S('#wgt-upload-preview').show();
          //var reqData = $R.handelSuccess($S.parseXML(response));
          
          var defName = jNode.attr('data-defname');
          
          if(defName){
              jNode.attr('src',defName+'?time='+(new Date().getTime()) );
          }
                    
          
            
          //if (jNode.attr('data-callback')) {
            //window.bc_callbacks[jNode.attr('data-callback')](jNode,jsonResp);
          //}
          //$R.handelSuccess($S.parseXML(response));
        }
    });

    jNode.find('.dz-default.dz-message').remove();
});
