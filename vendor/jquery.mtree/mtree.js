

// mtree.js
// Requires jquery.js and velocity.js (optional but recommended).
// Copy the below function, add to your JS, and simply add a list <ul class=mtree> ... </ul>
;(function ($, window, document, undefined) {
    
    $.fn.mtree = function() {
        
        var mtrees = $('ul.mtree');
        
        // Settings
        var collapsed = true; // Start with collapsed menu (only level 1 items visible)
        var close_same_level = true; // Close elements on same level when opening new node.
        var duration = 200; // Animation duration should be tweaked according to easing.
        var listAnim = true; // Animate separate list items on open/close element (velocity.js only).
        var easing = 'easeOutQuart'; // 'easeOutQuart'; // Velocity.js only, defaults to 'swing' with jquery animation.
        
        $(mtrees).each(function(){
            
            var localTree = $(this);
            
            // Set initial styles 
            localTree.find('ul').css({
                'overflow':'hidden', 
                'height': (collapsed) ? 0 : 'auto', 'display': (collapsed) ? 'none' : 'block' }
            );
            
            // Get node elements, and add classes for styling
            var node = localTree.find('li:has(ul)');  
            node.each(function(index, val) {
              var that = $(this);
              that.children(':first-child').css('cursor', 'pointer')
              that.addClass('mtree-node mtree-' + ((collapsed) ? 'closed' : 'open'));
              that.children('ul').addClass('mtree-level-' + (that.parentsUntil($('ul.mtree'), 'ul').length + 1));
            });
            
            // Set mtree-active class on list items for last opened element
            localTree.find('li > *:first-child').on('click.mtree-active', function(e){
                var that = $(this),
                    thatParent = that.parent();
                
              if(thatParent.hasClass('mtree-closed')) {
                localTree.find('.mtree-active').not(thatParent).removeClass('mtree-active');
                thatParent.addClass('mtree-active');
              } else if(thatParent.hasClass('mtree-open')){
                  thatParent.removeClass('mtree-active'); 
              } else {
                localTree.find('.mtree-active').not(thatParent).removeClass('mtree-active');
                thatParent.toggleClass('mtree-active'); 
              }
            });
            
            
            // Set node click elements, preferably <a> but node links can be <span> also
            node.children(':first-child').on('click.mtree', function(e){
              
              // element vars
              var that = $(this),
                  elPar = $(this).parent(),
                  el = elPar.children('ul').first(),
                  isOpen = elPar.hasClass('mtree-open');
              
              // close other elements on same level if opening 
              if((close_same_level || $('.csl').hasClass('active')) && !isOpen) {
                  
                var close_items = that.closest('ul').children('.mtree-open').not(elPar).children('ul');
                
                // Velocity.js
                if($.Velocity) {
                  close_items.velocity({
                    height: 0
                  }, {
                    duration: duration,
                    easing: easing,
                    display: 'none',
                    delay: 100,
                    complete: function(){
                      setNodeClass(elPar, true);
                    }
                  });
                  
                // jQuery fallback
                } else {
                  close_items.delay(100).slideToggle(duration, function(){
                    setNodeClass(elPar, true);
                  });
                }
              }
              
              // force auto height of element so actual height can be extracted
              el.css({'height': 'auto'}); 
              
              // listAnim: animate child elements when opening
              if(!isOpen && $.Velocity && listAnim) 
                  el.find(' > li, li.mtree-open > ul > li').css({'opacity':0}).velocity('stop').velocity('list');
              
              // Velocity.js animate element
              if($.Velocity) {
                el.velocity('stop').velocity({
                  //translateZ: 0, // optional hardware-acceleration is automatic on mobile
                  height: isOpen ? [0, el.outerHeight()] : [el.outerHeight(), 0]
                },{
                  queue: false,
                  duration: duration,
                  easing: easing,
                  display: isOpen ? 'none' : 'block',
                  begin: setNodeClass(elPar, isOpen),
                  complete: function(){
                    if(!isOpen) 
                        $(this).css('height', 'auto');
                  }
                });
              
              // jQuery fallback animate element
              } else {
                setNodeClass(elPar, isOpen);
                el.slideToggle(duration);
              }
              
              // We can't have nodes as links unfortunately
              e.preventDefault();
            });
            
            // Function for updating node class
            function setNodeClass(el, isOpen) {
              if(isOpen) {
                el.removeClass('mtree-open').addClass('mtree-closed');
              } else {
                el.removeClass('mtree-closed').addClass('mtree-open');
              }
            }
            
            // List animation sequence
            if($.Velocity && listAnim) {
              $.Velocity.Sequences.list = function (element, options, index, size) {
                $.Velocity.animate(element, { 
                  opacity: [1,0],
                  translateY: [0, -(index+1)]
                }, {
                  delay: index*(duration/size/2),
                  duration: duration,
                  easing: easing
                });
              };
            }
              
            // Fade in mtree after classes are added.
            // Useful if you have set collapsed = true or applied styles that change the structure so the menu doesn't jump between states after the function executes.
            if(localTree.css('opacity') == 0) {
                if($.Velocity) {
                    localTree.css('opacity', 1).children().css('opacity', 0).velocity('list');
                } else {
                    localTree.show(200);
                }
            }
            
        });
        
    };

}(jQuery, this, this.document));