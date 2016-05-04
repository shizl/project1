

jQuery(document).ready(function(){
		jQuery('.menu-toggle').text('MENU');


jQuery('.view-blog-list .views-field-nothing .like i').click(function(){


//jQuery(this).css('color','#d10000');
var number= jQuery(this).parent().find('.number').html();
var newnumber = parseInt(number) + 1;
jQuery(this).parent().find('.number').html(newnumber);

var nodeid = jQuery(this).parent().parent().parent().parent().find('.views-field-nid .field-content').html();

jQuery.post("/celerie", { newnumber : newnumber,nodeid:nodeid },
             function(data){
           
                jQuery(this).find('.number').html(data.status);
            },"json");

});

//jQuery(document).click(function(evt){
	//if(!jQuery(evt.target).parent('a').hasClass("share") && !jQuery(evt.target).hasClass("views-field-nothing-1"))
	//{
	
		//jQuery('.view-blog-list .views-field-nothing-1').hide();
	//}else{
		//jQuery('.view-blog-list .views-field-nothing-1').hide();
		//jQuery(evt.target).parent().parent().parent().parent().find('.views-field-nothing-1').show();
	//}	
//});

jQuery('.view-blog-list .views-field-nothing .share').click(function(){

if(jQuery(this).parent().parent().parent().find('.views-field-nothing-1').is(':hidden')){
	jQuery('.view-blog-list .views-field-nothing-1').hide();
	jQuery(this).parent().parent().parent().find('.views-field-nothing-1').show();
}else{
	jQuery('.view-blog-list .views-field-nothing-1').hide();
}
});



jQuery('.view-press-lists .views-row .views-col .views-field-field-press-image').each(function(){

jQuery(this).click(function(){
var content111 = jQuery(this).parent().find('.views-field-field-press-image-1').html();
var width = jQuery(window).width();
//alert(width);
   if(parseInt(width) > 568){
   
       if (jQuery('#new-content .new-style').length > 0){

       if(jQuery('#new-content .new-style').html() == content111){
           jQuery('#new-content').hide(300);
           jQuery('#new-content').remove();
       }else{
             jQuery('#new-content').hide(300);
             jQuery('#new-content').remove();
            
             jQuery(this).parent().parent().append('<div id="new-content"><div class="new-close"></div><div class="new-style"></div></div>');
             jQuery('#new-content').show(300);
             jQuery('#new-content .new-style').html(content111);
                   
            var ss = jQuery(this).offset().top;
            if (jQuery('#toolbar-item-administration-tray').length > 0){
                  var pp = parseInt(ss) - 80;
            }else{
                  var pp = parseInt(ss) - 30   
                 }
                
            jQuery(document).scrollTop(pp);
          
             }
}else{

         jQuery(this).parent().parent().append('<div id="new-content"><div class="new-close"></div><div class="new-style"></div></div>');
         jQuery('#new-content').show(300);
         jQuery('#new-content .new-style').html(content111);

}
         jQuery('.new-close').click(function(){
         var ss = jQuery(this).parent().parent().offset().top;
        if (jQuery('#toolbar-item-administration-tray').length > 0){
                  var pp = parseInt(ss) - 80;
            }else{
                  var pp = parseInt(ss) - 30   
                 }
                
         jQuery(document).scrollTop(pp);
         jQuery('.new-close').hide(1000);
         jQuery('#new-content').hide('300');
         jQuery('#new-content').remove();
});

 }else{


                if (jQuery('#new-content .new-style').length > 0){

       if(jQuery('#new-content .new-style').html() == content111){
           jQuery('#new-content').hide(300);
           jQuery('#new-content').remove();
       }else{
             jQuery('#new-content').hide(300);
             jQuery('#new-content').remove();
            
             jQuery(this).parent().append('<div id="new-content"><div class="new-close"></div><div class="new-style"></div></div>');
             jQuery('#new-content').show(300);
             jQuery('#new-content .new-style').html(content111);
              var ss = jQuery(this).offset().top;
            var pp = parseInt(ss) - 10;
            jQuery(document).scrollTop(pp);
          
             }
}else{

         jQuery(this).parent().append('<div id="new-content"><div class="new-close"></div><div class="new-style"></div></div>');
         jQuery('#new-content').show(300);
         jQuery('#new-content .new-style').html(content111);

}
         jQuery('.new-close').click(function(){
         var ss = jQuery(this).parent().parent().offset().top;
         var pp = parseInt(ss) - 10;
         jQuery(document).scrollTop(pp);
         jQuery('.new-close').hide(1000);
         jQuery('#new-content').hide('300');
         jQuery('#new-content').remove();
});
        

  
 }

});

});


jQuery('.filter-content').flexImages({rowHeight: 250});

jQuery('#see_more_work').flexImages({rowHeight: 250});


  jQuery('.flex-images .item').click(function(){

 	elements = jQuery(this);
    id = elements.attr('data-id');

 	jQuery.post("/coverajax", {id:id},
             function(data){           
              // jQuery('#cover').html(data);
      //         jQuery('#cover').show();


 r = elements.attr('data-ri');

  w = 0;
  w2 = 0; 
  num = 0;
  i = 0;
  k = 0;
  j = 0;

  jQuery('.flex-images .item').each(function(){
	       
	if(i<=r){
	  w += parseInt(jQuery('.flex-images .item-'+i).width());
	}

        i++;
  });

  	row = Math.ceil(w/jQuery('.flex-images').width());
//jQuery('#cover').animate({'top':(row*244)+20+'px'});


  jQuery('.flex-images .item').each(function(){
	
	w2 += parseInt(jQuery('.flex-images .item-'+j).width());
	if(w2>=parseInt(row*jQuery('.flex-images').width())){
	  num = j;
 	  return false;
	}
 	  j++;
  });

jQuery('.cover-region').remove();
  jQuery('.flex-images .item').each(function(){
	if(k == num){
	    jQuery('.flex-images .item-'+(num-1)).after('<div class="cover-region">'+data+'</div>');
	}
 	k++;
 });

 if(num == 0){
	    jQuery('.flex-images .item:last').after('<div class="cover-region">'+data+'</div>');
 }


            },"text");
  });


  init_width=0;
  init_rows = 3;
  jQuery('.filter-content .item').each(function(){
	  init_width += parseInt(jQuery(this).width());

	 if(init_width>parseInt(init_rows*jQuery('.filter-content').width())){
		jQuery(this).hide();
         } 
	 

  });






  jQuery('#filter #load_more span').click(function(){

      init_rows = init_rows+2;
		cre_width = 0;
  		jQuery('.flex-images .item').each(function(){
			cre_width += parseInt(jQuery(this).width());

	 		if(cre_width<parseInt(init_rows*jQuery('.flex-images').width())){
				jQuery(this).fadeIn(800);			
         		}
		
       		 });   
			if(jQuery('.flex-images .item:last').is(":visible")){
				jQuery('#load_more span').hide();
			}


  });
  jQuery('#see_more_work .item').each(function(){
	  init_width += parseInt(jQuery(this).width());

	 if(init_width>parseInt(jQuery('#see_more_work').width())){
		jQuery(this).hide();
         } 
	 

  });

if(jQuery('.flex-images .item:last').is(":visible")){
	jQuery('#load_more span').hide();
}

   jQuery(window).resize(function (){


  init_width=0;
  init_rows = 3;

	  jQuery('.filter-content .item').each(function(){
		  init_width += parseInt(jQuery(this).width());

		 if(init_width>parseInt(init_rows*jQuery('.filter-content').width())){
			jQuery(this).hide();
		 } 
		 

	  });

	  jQuery('#see_more_work .item').each(function(){
		  init_width += parseInt(jQuery(this).width());

		 if(init_width>parseInt(jQuery('#see_more_work').width())){
			jQuery(this).hide();
		 } 
		 

	  });

	if(jQuery('.flex-images .item:last').is(":visible")){
		jQuery('#load_more span').hide();
	}else{
		jQuery('#load_more span').show();
	}

   });


  init_see_more_rows = 1;
  jQuery('.block-see-more-work-block #load_more span').click(function(){

      init_see_more_rows = init_see_more_rows+3 ;
		cre_width = 0;
  		jQuery('#see_more_work .item').each(function(){
			cre_width += parseInt(jQuery(this).width());

	 		if(cre_width<parseInt(init_see_more_rows*jQuery('#see_more_work').width())){
				jQuery(this).fadeIn(800);			
         		}
		
       		 });   
			if(jQuery('#see_more_work .item:last').is(":visible")){
				jQuery('#load_more span').hide();
			}

  });


views_row = 1;
jQuery('.view-product-list .views-row').each(function(){

   if(views_row>4){
	jQuery(this).hide();
    }
 views_row++;

});

press_views_row = 1;
jQuery('.view-press-lists .views-row').each(function(){

   if(press_views_row>3){
	jQuery(this).hide();
    }
 press_views_row++;

});


jQuery('.view-product-list .more-link a').attr('href','javascript:');
jQuery('.view-blog-list .more-link a').attr('href','javascript:');
jQuery('.view-press-lists .more-link a').attr('href','javascript:');


init_views_row = 8;


if(jQuery('.view-product-list .views-row:last').is(":visible")){
		jQuery('.view-product-list .more-link').html('');
	}

jQuery('.view-product-list .more-link').click(function(){

 i = 0;
jQuery('.view-product-list .views-row').each(function(){
   if(i<init_views_row){
	jQuery(this).fadeIn(800);	
    }
 i++;
});

init_views_row = init_views_row+4;
	if(jQuery('.view-product-list .views-row:last').is(":visible")){
		jQuery('.view-product-list .more-link').html('');
	}

});
	if(jQuery('.view-press-lists .views-row:last').is(":visible")){
		jQuery('.view-press-lists .more-link').html('');
	}
init_press_row = 6;

jQuery('.view-press-lists .more-link').click(function(){

 i = 0;
jQuery('.view-press-lists .views-row').each(function(){
   if(i<init_press_row){
	jQuery(this).fadeIn(800);	
    }
 i++;
});

init_press_row = init_press_row+3;
	if(jQuery('.view-press-lists .views-row:last').is(":visible")){
		jQuery('.view-press-lists .more-link').html('');
	}

});



init_blog_row = 3;

jQuery('.view-blog-list .more-link').click(function(){

 i = 0;
jQuery('.view-blog-list .views-row').each(function(){
   if(i<init_blog_row){
	jQuery(this).fadeIn(800);	
    }
 i++;
});

init_blog_row++;

	if(jQuery('.view-blog-list .views-row:last').is(":visible")){
		jQuery('.view-blog-list .more-link').html('');
	}


});



/*
jQuery('.tool-menu a').click(function(){
	text = jQuery(this).text();
   	jQuery.post("/filterajax", {text:text},function(data){ 
		if(data=='1'){
		 window.location.reload(true);
		}
	     },'text');
	 

 });
*/

 if(jQuery('body.page-node-type-work .field--name-field-other-images').html()==undefined){
    jQuery('body.page-node-type-work #block-seemoreworkblock').css({'margin-top':'33%'});
 }


});



