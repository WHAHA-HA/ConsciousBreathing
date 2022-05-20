jQuery(document).ready(function(){
         var thumbs = jQuery("ul li div.product-box img");

        for (var i = 0, ii = thumbs.length; i < ii; i++){
            if (thumbs[i].title && thumbs[i].title.length > 0)
            {
                var imgtitle = thumbs[i].title;
                jQuery(thumbs[i]).wrap('<div class="wrapper" />').
                after('<div class=\'caption\'>' + imgtitle + '</div>').
                removeAttr('title');

            }
        }

    jQuery('.product-box-wrapper').hover(
        function(){
        	  jQuery(this).find('img').hide();
        	  jQuery(this).find('.product-details').fadeIn(1000);
        },
        function(){
        	jQuery(this).find('.product-details').hide();
        		jQuery(this).find('img').fadeIn(300);

        }
        );
    jQuery('.mask').click(function(){
    	//alert('hover clicked');
    	var link =jQuery(this).find('a').eq(0).attr('href');
    	window.location.href= link;

    });
    //check out page 'coupon'
    jQuery( '.coupon #coupon_code' ).focus( function() {
		jQuery(this).animate({width:400});
	});
    jQuery( '.coupon #coupon_code' ).blur( function() {
		jQuery(this).animate({width:80});
	});


    jQuery('#form-register').validate({
    	rules:{
    		password:{
    			required: true,
    			minlength:4
    		},
    		email:{
    			required:true,
    			email:true
    		}
    	},
    	messages:{
    		password: "Password should be longer than 4!",
    		email: "Please enter a valid email address"
    	},
    	errorElement :"div",
    	errorPlacement: function(error, element){
    		element.before(error);
    	}
    });
});

function animateScrollTop(target, duration) {
    //duration = duration || 16;
	//alert('in custom');
    var scrollTopProxy = { value: jQuery(window).scrollTop() };
    if (scrollTopProxy.value != target) {
    		jQuery(target).parent().parent().show();
        jQuery(scrollTopProxy).animate(
            { value: target },
            { duration: duration, step: function (stepValue) {
                var rounded = Math.round(stepValue);

                jQuery(window).scrollTop(rounded);
                //jQuery(target).animate({'opacity':0.3,'background-color':'#ff0000'},2000).animate({'opacity':1},2000);
                jQuery(target).fadeTo("slow",0.15).fadeTo("slow",1);
            }
        });
    }
}