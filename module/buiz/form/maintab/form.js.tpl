
<script type="application/javascript" >

var baseSource = $S("#tpl-buiz-form-designer-base").html();
var baseTemplate = Handlebars.compile(baseSource);
var pos = 1;

$S('#buiz-fdes-slices-container').sortable({ 
    cursor: "move",
    delay: 350
});

var appendBaseFunctions = function(jNode){
    jNode.find('.wgac-sub-delete').on('click',function(){
        $S(this).parentX('.wgt-content_box.tpl-box').remove();
    });

    jNode.find('.wgac-sub-edit').on('click',function(){
        jNode.find('.content.preview').hide();
        jNode.find('.content.editor').show();
    });

    jNode.find('.type-changer').on('change',function(){
        var 
          jThis = $S(this),
          key = jThis.val(),
          pBox = jThis.parentX('.wgt-content_box.tpl-box'),
          nodeSource = null,
          nodeTemplate = null,
          newBlock = null;
          
        nodeSource = $S("#tpl-buiz-form-designer-"+key).html();
        nodeTemplate = Handlebars.compile(nodeSource);
        newBlock = nodeTemplate({});

        pBox.find('.cnt-cont').html(newBlock);
    });

    jNode.find('.content.preview').on('click',function(){
        jNode.find('.content.preview').hide();
        jNode.find('.content.editor').show();
    });

};

var typeFunctions = { 
    'text': function(jNode){

        jNode.find('.wgac-sub-finished').on('click',function(){
            var pBox = $S(this).parentX('.wgt-content_box.tpl-box');

            var editor = pBox.find('.content.editor');

            editor.hide();

            var data = {
              'title': editor.find('.f-title').val(),
              'helptext': editor.find('.f-helptext').val(),
              'required': editor.find('.f-required').is(':checked')
            };

            var nodeSource = $S("#tpl-buiz-form-designer-preview-text").html();
            var nodeTemplate = Handlebars.compile(nodeSource);
            var previewBlock = nodeTemplate(data);

            pBox.find('.content.preview').html(previewBlock);
            pBox.find('.content.preview').show();
            
        });
        
    },
    'textarea': function(jNode){
        
        jNode.find('.wgac-sub-finished').on('click',function(){
            var pBox = $S(this).parentX('.wgt-content_box.tpl-box');

            pBox.find('.content.editor').hide();

            var nodeSource = $S("#tpl-buiz-form-designer-preview-textarea").html();
            var nodeTemplate = Handlebars.compile(nodeSource);
            var previewBlock = nodeTemplate({
                'title':'label'
            });

            pBox.find('.content.preview').html(previewBlock);
            pBox.find('.content.preview').show();
            
        });
        
    },
    'checkboxes': function(jNode){
    
    },
    'radios': function(jNode){
    
    },
    'range': function(jNode){

    },
    'money': function(jNode){
    
    },
    'matrix': function(jNode){
    
    },
    'list': function(jNode){
    
    },
    'file': function(jNode){
    
    },
    'image': function(jNode){
    
    },
    'photo': function(jNode){
    
    },
    'date': function(jNode){
    
    },
    'rating': function(jNode){
    
    },
    'location': function(jNode){
    
    },
    'address': function(jNode){
    
    },
};

$S( ".wgt-buiz-form-designer-cntrl" ).on('click',function(){

    var key = $S(this).attr('data-key');
    
    var nodeSource = $S("#tpl-buiz-form-designer-"+key).html();
    var nodeTemplate = Handlebars.compile(nodeSource);

    var baseData = {
      'pos':pos,
      'formid':'<?php echo $form->id ?>',
      'title':'',
      type:{},
      'helptext':'',
      'cnt': nodeTemplate({})
    };
    baseData.type[key] = key;

    $S('#buiz-fdes-slices-container').append(
      baseTemplate(baseData)
    );

    var newNode = $S('#wgt-box-buiz-form-designer-pos-'+pos);
    appendBaseFunctions(newNode);
    typeFunctions[key](newNode);
    ++pos;
    
});

</script>
