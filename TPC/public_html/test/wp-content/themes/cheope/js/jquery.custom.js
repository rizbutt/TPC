function isIE8(){return jQuery.browser.msie&&"8.0"==jQuery.browser.version}function isIE10(){return jQuery.browser.msie&&"10.0"==jQuery.browser.version}function isViewportBetween(c,a){"undefinied"==a&&(a=0);return a?jQuery(window).width()<c&&jQuery(window).width()>a:jQuery(window).width()<c}function isLowResMonitor(){return 1200>jQuery(window).width()}
function isTablet(){var c=jQuery("body").hasClass("responsive")||jQuery("body").hasClass("iPad")||jQuery("body").hasClass("Blakberrytablet")||jQuery("body").hasClass("isAndroidtablet")||jQuery("body").hasClass("isPalm"),a=1024>=jQuery(window).width()&&768<=jQuery(window).width();return c&&a}
function isPhone(){var c=jQuery("body").hasClass("responsive")||jQuery("body").hasClass("isIphone")||jQuery("body").hasClass("isWindowsphone")||jQuery("body").hasClass("isAndroid")||jQuery("body").hasClass("isBlackberry"),a=480>=jQuery(window).width()&&320<=jQuery(window).width();return c&&a}function isMobile(){return isTablet()||isPhone()}
if("undefined"===typeof console){var console={};console.log=console.error=console.info=console.debug=console.warn=console.trace=console.dir=console.dirxml=console.group=console.groupEnd=console.time=console.timeEnd=console.assert=console.profile=function(){}}
(function(c){jQuery(document).ready(function(a){a("body").removeClass("no_js").addClass("yes_js");isIE8()&&a("*:last-child").addClass("last-child");isIE10()&&a("html").attr("id","ie10").addClass("ie");a("input[placeholder], textarea[placeholder]").placeholder();a("input[placeholder], textarea[placeholder]").each(function(){a(this).focus(function(){a(this).data("placeholder",a(this).attr("placeholder"));a(this).attr("placeholder","")}).blur(function(){a(this).attr("placeholder",a(this).data("placeholder"))})});
a(".ch-item").bind("hover",function(a){});a('form input[type="text"], form textarea').focus(function(){a(this).parent().find("label.hide-label").hide()});a('form input[type="text"], form textarea').blur(function(){""==a(this).val()&&a(this).parent().find("label.hide-label").show()});a('form input[type="text"], form textarea').each(function(){""!=a(this).val()&&a(this).parents("li").find("label.hide-label").is(":visible")&&a(this).parent().find("label.hide-label").hide()});a('.contact-form [type="text"], .contact-form textarea').focus(function(){a(this).parents("li").find("label.hide-label").hide()});
a('.contact-form [type="text"], .contact-form textarea').blur(function(){""==a(this).val()&&a(this).parents("li").find("label.hide-label").show()});a("#map-handler a").click(function(){a("#map iframe").slideToggle(400,function(){a("#map iframe").is(":visible")?a("#map-handler a").text(l10n_handler.map_close):a("#map-handler a").text(l10n_handler.map_open)})});a("div.fade-socials a, div.fade-socials-small a").hide();a("div.fade-socials, div.fade-socials-small").hover(function(){a(this).children("a").fadeIn("slow")},
function(){a(this).children("a").fadeOut("slow")});var c=function(){var b;containerWidth=a("#header").width();marginRight=a("#nav ul.level-1 > li").css("margin-right");submenuWidth=a(this).find("ul.sub-menu").outerWidth();offsetMenuRight=a(this).position().left+submenuWidth;leftPos=-18;b=offsetMenuRight>containerWidth?{left:leftPos-(offsetMenuRight-containerWidth)}:{};a("ul.sub-menu:not(ul.sub-menu li > ul.sub-menu), ul.children:not(ul.children li > ul.children)",this).css(b).stop(!0,!0).fadeIn(300)};
a("#nav ul > li").hover(c,function(){a("ul.sub-menu:not(ul.sub-menu li > ul.sub-menu), ul.children:not(ul.children li > ul.children)",this).fadeOut(300)});a("#nav ul > li").each(function(){0<a("ul",this).length&&a(this).children("a").append('<span class="sf-sub-indicator"> &raquo;</span>').css({paddingRight:parseInt(a(this).children("a").css("padding-right"))+16})});a("#nav li:not(.megamenu) ul.sub-menu li, #nav li:not(.megamenu) ul.children li").hover(function(){0<a(this).closest(".megamenu").length||
(containerWidth=a("#header").width(),containerOffsetRight=a("#header").offset().left+containerWidth,submenuWidth=a("ul.sub-menu, ul.children",this).parent().width(),offsetMenuRight=a(this).offset().left+2*submenuWidth,leftPos=-10,offsetMenuRight>containerOffsetRight&&a(this).addClass("left"),a("ul.sub-menu, ul.children",this).stop(!0,!0).fadeIn(300))},function(){0<a(this).closest(".megamenu").length||a("ul.sub-menu, ul.children",this).fadeOut(300)});a("#nav .megamenu").mouseover(function(){var b=
a(".container").width(),m=a(".container").offset(),c=a(this),f=a(this).children("ul.sub-menu"),g=f.outerWidth(),h=f.offset();c.position().left+g>b&&f.offset({top:h.top,left:m.left+(b-g)})});!a("body").hasClass("isMobile")||a("body").hasClass("iphone")||a("body").hasClass("ipad")||a(".sf-sub-indicator").parent().click(function(){a(this).parent().toggle(c,function(){document.location=a(this).children("a").attr("href")})});0!=a(".slider").length&&""==a.trim(a("#primary *, #page-meta").text())&&(a(".slider").attr("style",
"margin-bottom:0 !important;"),a("#primary").remove());(function(){jQuery("a.thumb.video, a.thumb.img, img.thumb.img, img.thumb.project, .work-thumbnail a, .three-columns li a, .onlytitle, .overlay_a img, .nozoom img").hover(function(){jQuery(this).next(".overlay").fadeIn(500);jQuery(this).next(".overlay").children(".lightbox, .details, .lightbox-video").animate({bottom:"40%"},300);jQuery(this).next(".overlay").children(".title").animate({top:"30%"},300)});a("a.thumb.video, a.thumb.img, a.thumb.videos, a.thumb.imgs, a.related_detail, a.related_proj, a.related_video, a.related_title, a.project, a.onlytitle").hover(function(){a('<a class="zoom"></a>').appendTo(this).css({dispay:"block",
opacity:0,height:a(this).children("img").height(),width:a(this).children("img").width(),top:a(this).parents(".portfolio-filterable").length?"-1px":a(this).css("padding-top"),left:a(this).parents(".portfolio-filterable").length?"-1px":a(this).css("padding-left"),padding:0}).append('<span class="title">'+a(this).attr("title")+"</span>").append('<span class="subtitle">'+a(this).attr("data-subtitle")+"</span>").animate({opacity:0.7},500)},function(){a(".zoom").fadeOut(500,function(){a(this).remove()})});
a(".zoom").live("click",function(){a.browser.msie&&a(this).attr("href",a(this).parent().attr("href"))});a.colorbox&&(jQuery("body").hasClass("isMobile")?(jQuery("a.thumb.img, .overlay_img, .section .related_proj, a.ch-info-lightbox").colorbox({transition:"elastic",rel:"lightbox",fixed:!0,maxWidth:"100%",maxHeight:"100%",opacity:0.7}),jQuery(".section .related_lightbox").colorbox({transition:"elastic",rel:"lightbox2",fixed:!0,maxWidth:"100%",maxHeight:"100%",opacity:0.7})):(jQuery("a.thumb.img, .overlay_img, .section.portfolio .related_proj, a.ch-info-lightbox, a.ch-info-lightbox").colorbox({transition:"elastic",
rel:"lightbox",fixed:!0,maxWidth:"80%",maxHeight:"80%",opacity:0.7}),jQuery(".section.portfolio .related_lightbox").colorbox({transition:"elastic",rel:"lightbox2",fixed:!0,maxWidth:"80%",maxHeight:"80%",opacity:0.7})),jQuery("a.thumb.video, .overlay_video, .section.portfolio .related_video, a.ch-info-lightbox-video").colorbox({transition:"elastic",rel:"lightbox",fixed:!0,maxWidth:"60%",maxHeight:"80%",innerWidth:"60%",innerHeight:"80%",opacity:0.7,iframe:!0,onOpen:function(){a("#cBoxContent").css({"-webkit-overflow-scrolling":"touch"})}}),
jQuery(".section.portfolio .lightbox_related_video").colorbox({transition:"elastic",rel:"lightbox2",fixed:!0,maxWidth:"60%",maxHeight:"80%",innerWidth:"60%",innerHeight:"80%",opacity:0.7,iframe:!0,onOpen:function(){a("#cBoxContent").css({"-webkit-overflow-scrolling":"touch"})}}))})();0<a(".portfolio-filterable").length&&a(".gallery-categories-disabled, .portfolio-categories-disabled").addClass("gallery-categories-quicksand");a(".gallery-wrap .internal_page_item .overlay, .section .related_project .overlay").css({opacity:0});
a(".gallery-wrap .internal_page_item, .section .related_project > div").live("mouseover mouseout",function(b){"mouseover"==b.type&&a(".overlay",this).show().stop(!0,!1).animate({opacity:0.7},"fast");"mouseout"==b.type&&a(".overlay",this).animate({opacity:0},"fast",function(){a(this).hide()})});a(".picture_overlay").hover(function(){var b=a(this).find(".overlay div").innerWidth(),c=a(this).find(".overlay div").innerHeight();a(this).find(".overlay div").css({"margin-top":-c/2,"margin-left":-b/2});isIE8()&&
a(this).find(".overlay > div").show()},function(){isIE8()&&a(this).find(".overlay > div").hide()}).each(function(){var b=a(this).find(".overlay div").innerWidth(),c=a(this).find(".overlay div").innerHeight();a(this).find(".overlay div").css({"margin-top":-c/2,"margin-left":-b/2})});if(a.fn.masonry){var d=a("#pinterest-container");d.imagesLoaded(function(){d.masonry({itemSelector:".post"})});a(window).resize(function(){a("#pinterest-container").masonry({itemSelector:".post"})});var n=a("#page-meta").outerHeight();
a("#pinterest-container .post").each(function(b){2<b||a(this).css("margin-top",n+20+"px")})}a(".yit_toggle_menu ul.menu.open_first > li:first-child, .yit_toggle_menu ul.menu.open_all .dropdown, .yit_toggle_menu ul.menu.open_active > li.current-menu-parent").addClass("opened");a(".yit_toggle_menu ul li.dropdown > a").click(function(b){b.preventDefault();b=a(this).next("ul");var c=b.parent(".dropdown");b.width(c.width());c.width(c.parent().width());c.hasClass("opened")?c.removeClass("opened"):c.addClass("opened");
b.slideToggle()});a("ul.products li.product.classic a.thumb").on({mouseenter:function(){a(this).find("img").animate({opacity:0.75},500)},mouseleave:function(){a(this).find("img").stop().animate({opacity:1},500)}});a(document).on("hover","ul.products li.product.grid:not(.classic), ul.products li.product.list .thumbnail-wrapper",function(b){if("mouseenter"==b.type){b=a(this);b.hasClass("thumbnail-wrapper")&&(b=b.parents("li"));var c=b.find(".thumbnail-wrapper").width(),e=b.find(".thumbnail-wrapper").height(),
f=b.find(".product-meta").height(),g=2*parseInt(b.find(".product-thumbnail").css("padding-left").replace("px","")),h=2*parseInt(b.find(".product-thumbnail").css("padding-top").replace("px",""));b.removeClass("no-transition");b.find("img").css("box-shadow","#000 0em 0em 0em").animate({opacity:0.48},500);b.find(".thumbnail-wrapper div.product-actions").fadeIn(500);b.filter(".grid").not(".added").find("div.product-meta").fadeIn(500);b.filter(".grid").css({width:c+g+2,height:e+h+1,overflow:"visible"});
b.find(".thumbnail-wrapper .product-actions").css({height:e});b.filter(".grid").not(".added").find(".product-thumbnail").css({position:"absolute",width:c,height:e+f,"z-index":"15"});b.filter(".grid").find(".onsale").css({right:-1,top:-1})}else"mouseleave"==b.type&&(b=a(this),b.hasClass("thumbnail-wrapper")&&(b=b.parents("li")),parseInt(b.find(".product-thumbnail").css("padding-top").replace("px","")),b.find("img").stop().animate({opacity:1},500),b.find(".thumbnail-wrapper div.product-actions").stop().fadeOut(500),
b.filter(".grid").not(".added").find("div.product-meta").stop().fadeOut(500),b.filter(".grid").not(".added").find(".product-thumbnail").css({height:b.find(".thumbnail-wrapper").height(),"z-index":"1"}))});a(window).resize(function(){a("ul.products li.product.grid:not(.classic), ul.products li.product.list .thumbnail-wrapper").each(function(){var b=a(this);b.hasClass("thumbnail-wrapper")&&(b=b.parents("li"));b.addClass("no-transition").css({height:"auto",width:""});b.find(".product-thumbnail").css({height:"auto",
width:"auto",position:"static"})})});var k=!1;a("ul.products li.product:not(.classic) .add_to_cart_button").live("click",function(){var b=a(this).parents("li.product"),c=2*parseInt(b.find(".product-thumbnail").css("padding-top").replace("px",""));b.filter(".grid").find(".product-thumbnail").block({message:null,overlayCSS:{background:"#fff url("+woocommerce_params.plugin_url+"/assets/images/ajax-loader.gif) no-repeat center",opacity:0.3,cursor:"none"}});k=a(this);b.filter(".grid").find("div.product-meta").stop().fadeOut(500);
b.filter(".grid").find(".product-thumbnail").css({height:b.height()-c-2,"z-index":"1"})});a("ul.products li.product.classic .add_to_cart_button").live("click",function(){k=a(this)});a("body").on("added_to_cart",function(){if(!1!=k){var a=k.parents("li.product");if(a.hasClass("classic"))a=k.parents("li.product.classic");else{var c=a.filter(".grid").find(".product-meta"),e=2*parseInt(a.find(".product-thumbnail").css("padding-left").replace("px","")),f=2*parseInt(a.find(".product-thumbnail").css("padding-top").replace("px",
""));a.find(".product-thumbnail").unblock();c.find(".added").show().css("display","inline-block");c.find("h3, .price").hide();var g=a.find(".thumbnail-wrapper").width(),h=a.find(".thumbnail-wrapper").height(),c=c.height()-2;a.find(".product-actions .add_to_cart_button").removeClass("added");a.addClass("added").filter(".grid").css({width:g+e+2,height:h+f+2,overflow:"visible"});a.find(".product-actions").css({height:h});a.filter(".grid").find(".product-thumbnail").css({position:"absolute",width:g,height:h+
c+2,"z-index":"15"});a.filter(".grid").find(".onsale").css({right:-1,top:-1})}a.find(".added").fadeIn(500)}});a(".list-or-grid a").on("click",function(){var b=a(this).attr("class").replace("-view","");isIE8()&&(b=b.replace(" last-child",""));a("ul.products li:not(.category)").removeClass("list grid").addClass(b);a(this).parent().find("a").removeClass("active");a(this).addClass("active");switch(b){case "list":a("ul.products li").css({width:"auto",height:"auto"});a("ul.products li .product-thumbnail").css({width:"auto",
height:"auto",position:"static"});a("ul.products li .product-thumbnail .onsale").css({right:0,top:0});a("ul.products li .product-meta").css({display:"block"});a("ul.products li.added").find("h3, .price").css({display:"block"});break;case "grid":a("ul.products li").css({width:"",height:""}),a("ul.products li:not(.classic) .product-meta").css({display:"none"}),a("ul.products li.added:not(.classic)").find("h3, .price").css({display:"none"})}a.cookie(yit_shop_view_cookie,b);return!1});a(window).load(function(){a.elastislide&&
a(".products-slider-wrapper:visible").elastislide(elastislide_defaults)});a(document).on("feature_tab_opened",function(){a.elastislide&&a(".products-slider-wrapper:visible").elastislide(elastislide_defaults)});a(".opera .quantity input.input-text.qty").replaceWith(function(){a(this).attr("value");return'<input type="text" class="input-text qty text" name="quantity" value="'+a(this).attr("value")+'" />'});a("#back-top").hide();a(function(){a(window).scroll(function(){100<a(this).scrollTop()?a("#back-top").fadeIn():
a("#back-top").fadeOut()});a("#back-top a").click(function(){a("body,html").animate({scrollTop:0},800);return!1})});var l;a(".product .woo_bt_compare_this").on("click",function(){l=a(this).parents(".product");l.block({message:null,overlayCSS:{background:"#fff url("+woocommerce_params.plugin_url+"/assets/images/ajax-loader.gif) no-repeat center",opacity:0.6,cursor:"none"}})});a("body").on("woo_update_total_compare_list",function(){l.unblock();var b=a("a.woo_bt_view_compare_link").attr("href");window.open(b,
"'.__('Product_Comparison', 'woo_cp').'","scrollbars=1, width=980, height=650")});"undefined"==typeof jQuery.fn.live&&(jQuery.fn.live=function(a,c,e){jQuery(this.context).on(a,this.selector,c,e);return this})})})(jQuery);
(function(c){var a;c.fn.extend({stickyFooter:function(p){function d(){var d=c(document.body).height()-c("#sticky-footer-push").height();d<c(window).height()&&(d=c(window).height()-d,0<!c("#sticky-footer-push").length&&c(a).before('<div id="sticky-footer-push"></div>'),c("#sticky-footer-push").height(d))}a=this;d();c(window).scroll(d).resize(d)}})})(jQuery);(function(c){c("#header-sidebar li.dropdown").hover(function(){c("ul",this).fadeIn()},function(){c("ul",this).fadeOut()})})(jQuery);