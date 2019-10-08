   <?php global $cc_options;?>
   <?php if( !get_field('enable_one_page_scroller', get_the_ID()) ){ ?>
    </div>
   <?php } ?>

   <footer id="colophon" class="site-footer scroll-sec-" role="contentinfo">
    <div class="footer-widgets">
      <div class="vert-wrap">
        <div class="vert-middle">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-md-6 col-lg-6 ">
                <img src="<?php echo $cc_options['footer_logo']['url'];?>" width="337" height="50">
                <div class="cc-footer-site-info">
                  <?php echo $cc_options['site_info'];?>
                </div>
              </div>
              <div class="col-sm-6 col-md-6 col-lg-4 col-lg-push-2">
                <?php //echo cc_special_button(); ?>
                <ul class="address-widget">
                  <li><i class="sprite sprite-icon-phone"></i> <span itemprop="telephone"><?php echo $cc_options['contact_tel']; ?></span> </li>
                  <li><i class="sprite sprite-icon-email"></i> <a href="mailto:<?php echo $cc_options['contact_email'];?>"><span itemprop="email"><?php echo $cc_options['contact_email']; ?></span></a></li>
                  <li><i class="sprite sprite-icon-envelope"></i> <span><?php echo $cc_options['po_box']; ?> </span></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="site-info">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="cc-copyright pull-sm-left">
              <?php //echo '&copy; '.$cc_options['copyright']; ?>
             <span itemprop="copyrightYear"> 2017</span> <span itemprop="name">Carpet Court</span> New Zealand. All Rights Reserved.<br>
		<a href="http://www.jadecreative.co.nz/our-services/web-design.html" target="_blank" title="Christchurch NZ Website Design, Professional Website Designers" style="color:#ffffff;">Website Design</a> by <a href="http://www.jadecreative.co.nz" title="Website Design, Jade Creative" target="_blank" style="color:#ffffff;">Jade Creative</a>
            </div>

            <?php if ( !empty( $cc_options['cc_instagram'] ) ) { ?>
              <div class="pull-sm-right foot-social">
                <a href="<?php echo $cc_options['cc_instagram']; ?>" target="_blank"><i class="fa fa-instagram fa-3"></i></a>
              </div>
             <?php } ?>
             <?php if ( !empty( $cc_options['cc_youtube'] ) ) { ?>
              <div class="pull-sm-right foot-social">
                <a href="<?php echo $cc_options['cc_youtube']; ?>" target="_blank"><i class="fa fa-youtube fa-3"></i></a>
              </div>
             <?php } ?>
            <?php if ( !empty( $cc_options['pinterest'] ) ) { ?>
              <div class="pull-sm-right foot-social">
                <a href="<?php echo $cc_options['pinterest']; ?>" target="_blank"><i class="fa fa-pinterest fa-3" aria-hidden="true" class=""></i></a>
              </div>
            <?php } ?>
            <?php if ( !empty( $cc_options['facebook'] ) ) { ?>
              <div class="pull-sm-right foot-social">
                <a href="<?php echo $cc_options['facebook']; ?>" target="_blank"><i class="sprite sprite-icon-facebook"></i></a>
              </div>
            <?php } ?>
          <?php
          //show custom logo
          if ( isset( $cc_options['show_custom_logo'] ) && !empty( $cc_options['show_custom_logo'] ) && $cc_options['show_custom_logo'] == 1 ) {

              if ( isset( $cc_options['footer_custom_link'] ) ) { ?>
                  <div class="pull-sm-right foot-social">
                    <a href="<?php echo esc_url( $cc_options['footer_custom_link'] ); ?>">
                    <img src="<?php echo $cc_options['footer_custom_logo']['url']; ?>">
                    </a>
                  </div>
                <?php
              }
          }
            //end of custom logo section
          // this is my section
          // $abc = get_my_tax_name('product_color');
          // echo '<pre>';
          // print_r($abc);
          // echo '</pre>';
          ?>

        </div>
      </div>
    </div>
  </div><!-- .site-info -->
</footer><!-- #colophon -->
<div class="g-rel-tags">
<!-- Google Code for Remarketing Tag -->

<!--

Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: https://google.com/ads/remarketingsetup

-->

<script type="text/javascript">

/* <![CDATA[ */

var google_conversion_id = 875595922;

var google_custom_params = window.google_tag_params;

var google_remarketing_only = true;

/* ]]> */

</script>

<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">

</script>

<noscript>

<div style="display:inline;">

<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/875595922/?value=0&amp;guid=ON&amp;script=0"/>

</div>

</noscript>
</div>
<?php wp_footer(); ?>
<script type="text/javascript">
var yourArray = [];
  jQuery(document).ready(function(){


   if (jQuery(window).width() <= 480){
     if ( jQuery('.vc_tta-container').find('.vc_general').hasClass('vc_tta-tabs') ) {
      setTimeout(function(){
        var numItems = jQuery('.vc_tta-tabs .vc_tta-panel').length;
        console.log(numItems);
        if ((jQuery(window).width() < 350) &&  (numItems <= 3)) {
         jQuery('.vc_tta-tabs .vc_tta-panel .vc_tta-panel-body').css('margin-top', '60px');
       }
       if ( !jQuery('body').hasClass('page-id-6626') ) {

        /* var tta_height = jQuery('.vc_tta-panel.vc_active .vc_tta-panel-body').height() + 150;
        jQuery('.vc_tta-container').height(tta_height + 'px'); */
      }
    }, 2000);
    }
  }

  jQuery('.modal_popup').on('click', function(){
    if (jQuery(window).width() <= 480){
      setTimeout(function(){
        var tta_height = jQuery('.vc_tta-panel.vc_active .vc_tta-panel-body').height() + 150;
        jQuery('.vc_tta-tabs .vc_tta-panel .vc_tta-panel-heading').css('float', 'none');
        jQuery('.vc_tta-tabs .vc_tta-panel .vc_tta-panel-body').css('margin-top', '120px');
        jQuery('.vc_tta-panels-container').height(tta_height + 'px');
      }, 2000);
    }
  });


  var url = window.location.href;
  jQuery('body').on('click', '#msform .cc_filter li', function(){
    if (url.indexOf('flooring-finder') > 0) {
      setTimeout(function(){
        jQuery.each(jQuery('.filter-results #accordion .panel .panel-heading .panel-title a'), function(i, val){
          jQuery(this).trigger('click');
        });
      }, 1000);
    }
  });
  if (url.indexOf('flooring-finder') > 0) {
    setTimeout(function(){
      jQuery.each(jQuery('.filter-results #accordion .panel .panel-heading .panel-title a'), function(i, val){
        jQuery(this).trigger('click');
      });
    }, 3000);
  }


  jQuery('.navbar-mobile .ubermenu-retractor ul li').on('click touchstart',function(){
	 jQuery(this).parent().parent().parent().parent().addClass('ubermenu-responsive-collapse');
  });
if (jQuery(window).width() <= 480){
	var showLpa=jQuery('#showLeft').html();

	jQuery('#cpm-filter-results-toggle').prepend('<span id="showLeft" class="active">'+showLpa+'</span>');
	jQuery('.filter-right #showLeft').remove();
	jQuery('.ms-checkbox input').removeClass("filter-checkbox-btn");
	jQuery('.xs-header-grp .cc-finance-cpm').attr('style','display:none');
	jQuery('#cpm-filter-results-toggle #showLeft').html('<div id="accordion" class="panel-group"><div class="panel-heading" role="tab" id="refine">	<h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" href="#collapse-fullfil"><span class="cc-sub-title alt-text">Refine</span><i class="indicator"></i></a></h4><hr></div></div>');

	var fliL=jQuery('#msform .cc_filter li').length;
	var fuL=jQuery('#msform .cc_filter').length;

	console.log(fliL+'---'+fuL);
	if (parseInt(fliL) % 3 == 0) {

 var arrN = [];
for(var i=0; i<parseInt(fuL);i++)
{
	if(parseInt(jQuery('#msform .cc_filter').eq(i).find('li').length % 2) ==1){
		if( jQuery('#msform .cc_filter').eq(i).find('li').length>3 || jQuery('#msform .cc_filter').length>1){
	 //alert(jQuery('#msform .cc_filter').eq(i).length);
	var liht='<li class="col-md-4 col-sm-4 col-xs-12 wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">'+jQuery('#msform .cc_filter').eq(i).find('li:nth-child(3)').html()+"</li>";
	jQuery('#msform .cc_filter').eq(i).find('li:nth-child(3)').remove();
	arrN.push(liht);

}
}

}
//console.log(arrN.join(''));
jQuery("#msform .cc_filter").after('<ul class="cc_filter full-width-filter">'+arrN.join('')+'</ul>');
}
if(jQuery( ".color-palette .container .text-centre" ).length)
{
var colorD=jQuery('.color-palette .container .text-centre').html();

jQuery('#msform .color-palette .cc_filter').after('<div class="text-centre">'+colorD+'</div>');

}


/* jQuery('.cc-icon-collapse').on("click",function(){

	var attri = jQuery('#collapse-specss').attr('aria-expanded');


if (attri=='true') {

	jQuery('head').append('<style>.cc-product-specs .cc-icon-collapse::before{ content:'"\u2193"' }</style>');
	}
	else
	{

			jQuery('head').append('<style>.cc-product-specs .cc-icon-collapse::before{ content:'"\u2191"' }</style>');
	}

}); */

 jQuery('#cpm-filter-results-toggle').addClass( "cpm-filter-result-close" );

 jQuery('#cpm-filter-results-toggle').removeClass( "cpm-filter-result-open" );



/*jQuery('#cpm-filter-results-toggle .filter-left').bind("DOMSubtreeModified",function(){
 jQuery('html,body').find("#cbp-spmenu-s1 .panel-collapse").find("ul li .checkbox-custom").removeClass("filter-checkbox-btn");

});*/




var countee=1;
 jQuery('#showLeft').find('.indicator').addClass( "odd" );

jQuery('#showLeft').on("click",function(){

if(countee % 2==1)
{
	jQuery(this).find('.indicator').addClass('even');
	jQuery(this).find('.indicator').removeClass('odd');
}
else
{
	jQuery(this).find('.indicator').addClass('odd');
	jQuery(this).find('.indicator').removeClass('even');
}

countee++;
  });

}
// jQuery('#cpm-filter-results-toggle .filter-left').bind("DOMSubtreeModified",function(){
//  jQuery('html,body').find("#cbp-spmenu-s1 #collapse-product_feature").find("ul li .checkbox-custom").attr("type","checkbox");
//   jQuery('html,body').find("#cbp-spmenu-s1 #collapse-pa_filter-colour").find("ul li .checkbox-custom").attr("type","checkbox");


// });

	jQuery(".post-11451 .vc_row-has-fill").each(function(){ 
	var hText=jQuery(this).find(".vc_inner .vc_column_container:not(.vc_col-sm-1) .orange-text strong").text();
	yourArray.push(hText);
	});
});
jQuery(window).bind("load resize",function(){
	
	
if(jQuery(window).width()<481){
var a=0;
jQuery(".post-11451 .vc_row-has-fill").each(function(){ 
jQuery(this).find(".vc_inner .vc_col-sm-1").attr("style","display:none;");
var num = jQuery(this).find(".vc_inner .vc_col-sm-1 .orange-text strong").text();
var hText=jQuery(this).find(".vc_inner .vc_column_container:not(.vc_col-sm-1) .orange-text strong").text();
///console.log(yourArray[a]);

if(hText == yourArray[a])
{

jQuery(this).find(".vc_inner .vc_column_container:not(.vc_col-sm-1) .orange-text strong").html(num+". "+hText);
}

a++;
});
}
else
{
jQuery(".post-11451 .vc_row-has-fill").each(function(){ 
jQuery(this).find(".vc_inner .vc_col-sm-1").removeAttr("style","display:none;");
var num = jQuery(this).find(".vc_inner .vc_col-sm-1 .orange-text strong").text();
var hText=jQuery(this).find(".vc_inner .vc_column_container:not(.vc_col-sm-1) .orange-text strong").text();
var preText=jQuery.trim(hText.replace(num+". ", "")); 
jQuery(this).find(".vc_inner .vc_column_container:not(.vc_col-sm-1) .orange-text strong").html(preText);
});
}
});
/* function downloadJSAtOnload() {
var element = document.createElement("script");
element.src = "defer.js";
document.body.appendChild(element);
}
if (window.addEventListener)
window.addEventListener("load", downloadJSAtOnload, false);
else if (window.attachEvent)
window.attachEvent("onload", downloadJSAtOnload);
else window.onload = downloadJSAtOnload; */
</script>
<!-- [embed width="123" height="456"]https://www.youtube.com/watch?v=dQw4w9WgXcQ[/embed] -->
<!-- <button type="button" class="btn btn-info btn-lg hidden" data-toggle="modal" data-target="#video-embed-sec">Open Modal</button> -->
<!-- Modal -->
<div id="video-embed-sec" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body embed-vid-sec">
        <?php echo do_shortcode(apply_filters( 'the_content', '[embed]https://www.youtube.com/watch?v=yE6G87nX9B8[/embed]' )); ?>
      </div>
    </div>

  </div>
</div>
<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 840223342;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/840223342/?guid=ON&amp;script=0"/>
</div>
</noscript>
</body>
</html>
