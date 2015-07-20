/*!
 * jQuery UI Accordion @VERSION
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Accordion
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 */

(function(d,n){d.widget("ui.accordion",{options:{active:0,animated:"slide",autoHeight:!0,clearStyle:!1,collapsible:!1,event:"click",fillSpace:!1,header:"> li > :first-child,> :not(li):even",icons:{header:"ui-icon-triangle-1-e",headerSelected:"ui-icon-triangle-1-s"},navigation:!1,navigationFilter:function(){return this.href.toLowerCase()===location.href.toLowerCase()}},_create:function(){var a=this,b=a.options;a.running=0;a.element.addClass("ui-accordion ui-widget ui-helper-reset").children("li").addClass("ui-accordion-li-fix");
a.headers=a.element.find(b.header).addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all").bind("mouseenter.accordion",function(){b.disabled||d(this).addClass("ui-state-hover")}).bind("mouseleave.accordion",function(){b.disabled||d(this).removeClass("ui-state-hover")}).bind("focus.accordion",function(){b.disabled||d(this).addClass("ui-state-focus")}).bind("blur.accordion",function(){b.disabled||d(this).removeClass("ui-state-focus")});a.headers.next().addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom");
if(b.navigation){var c=a.element.find("a").filter(b.navigationFilter).eq(0);if(c.length){var f=c.closest(".ui-accordion-header");a.active=f.length?f:c.closest(".ui-accordion-content").prev()}}a.active=a._findActive(a.active||b.active).addClass("ui-state-default ui-state-active").toggleClass("ui-corner-all").toggleClass("ui-corner-top");a.active.next().addClass("ui-accordion-content-active");a._createIcons();a.resize();a.element.attr("role","tablist");a.headers.attr("role","tab").bind("keydown.accordion",
function(b){return a._keydown(b)}).next().attr("role","tabpanel");a.headers.not(a.active||"").attr({"aria-expanded":"false","aria-selected":"false",tabIndex:-1}).next().hide();a.active.length?a.active.attr({"aria-expanded":"true","aria-selected":"true",tabIndex:0}):a.headers.eq(0).attr("tabIndex",0);d.browser.safari||a.headers.find("a").attr("tabIndex",-1);b.event&&a.headers.bind(b.event.split(" ").join(".accordion ")+".accordion",function(b){a._clickHandler.call(a,b,this);b.preventDefault()})},_createIcons:function(){var a=
this.options;a.icons&&(d("<span></span>").addClass("ui-icon "+a.icons.header).prependTo(this.headers),this.active.children(".ui-icon").toggleClass(a.icons.header).toggleClass(a.icons.headerSelected),this.element.addClass("ui-accordion-icons"))},_destroyIcons:function(){this.headers.children(".ui-icon").remove();this.element.removeClass("ui-accordion-icons")},destroy:function(){var a=this.options;this.element.removeClass("ui-accordion ui-widget ui-helper-reset").removeAttr("role");this.headers.unbind(".accordion").removeClass("ui-accordion-header ui-accordion-disabled ui-helper-reset ui-state-default ui-corner-all ui-state-active ui-state-disabled ui-corner-top").removeAttr("role").removeAttr("aria-expanded").removeAttr("aria-selected").removeAttr("tabIndex");
this.headers.find("a").removeAttr("tabIndex");this._destroyIcons();var b=this.headers.next().css("display","").removeAttr("role").removeClass("ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content ui-accordion-content-active ui-accordion-disabled ui-state-disabled");(a.autoHeight||a.fillHeight)&&b.css("height","");return d.Widget.prototype.destroy.call(this)},_setOption:function(a,b){d.Widget.prototype._setOption.apply(this,arguments);"active"==a&&this.activate(b);"icons"==a&&(this._destroyIcons(),
b&&this._createIcons());if("disabled"==a)this.headers.add(this.headers.next())[b?"addClass":"removeClass"]("ui-accordion-disabled ui-state-disabled")},_keydown:function(a){if(!(this.options.disabled||a.altKey||a.ctrlKey)){var b=d.ui.keyCode,c=this.headers.length,f=this.headers.index(a.target),g=!1;switch(a.keyCode){case b.RIGHT:case b.DOWN:g=this.headers[(f+1)%c];break;case b.LEFT:case b.UP:g=this.headers[(f-1+c)%c];break;case b.SPACE:case b.ENTER:this._clickHandler({target:a.target},a.target),a.preventDefault()}return g?
(d(a.target).attr("tabIndex",-1),d(g).attr("tabIndex",0),g.focus(),!1):!0}},resize:function(){var a=this.options,b;if(a.fillSpace){if(d.browser.msie){var c=this.element.parent().css("overflow");this.element.parent().css("overflow","hidden")}b=this.element.parent().height();d.browser.msie&&this.element.parent().css("overflow",c);this.headers.each(function(){b-=d(this).outerHeight(!0)});this.headers.next().each(function(){d(this).height(Math.max(0,b-d(this).innerHeight()+d(this).height()))}).css("overflow",
"auto")}else a.autoHeight&&(b=0,this.headers.next().each(function(){b=Math.max(b,d(this).height("").height())}).height(b));return this},activate:function(a){this.options.active=a;a=this._findActive(a)[0];this._clickHandler({target:a},a);return this},_findActive:function(a){return a?"number"===typeof a?this.headers.filter(":eq("+a+")"):this.headers.not(this.headers.not(a)):!1===a?d([]):this.headers.filter(":eq(0)")},_clickHandler:function(a,b){var c=this.options;if(!c.disabled)if(a.target){var f=d(a.currentTarget||
b),g=f[0]===this.active[0];c.active=c.collapsible&&g?!1:this.headers.index(f);if(!(this.running||!c.collapsible&&g)){var k=this.active,e=f.next(),h=this.active.next(),m={options:c,newHeader:g&&c.collapsible?d([]):f,oldHeader:this.active,newContent:g&&c.collapsible?d([]):e,oldContent:h},l=this.headers.index(this.active[0])>this.headers.index(f[0]);this.active=g?d([]):f;this._toggle(e,h,m,g,l);k.removeClass("ui-state-active ui-corner-top").addClass("ui-state-default ui-corner-all").children(".ui-icon").removeClass(c.icons.headerSelected).addClass(c.icons.header);
g||(f.removeClass("ui-state-default ui-corner-all").addClass("ui-state-active ui-corner-top").children(".ui-icon").removeClass(c.icons.header).addClass(c.icons.headerSelected),f.next().addClass("ui-accordion-content-active"))}}else if(c.collapsible){this.active.removeClass("ui-state-active ui-corner-top").addClass("ui-state-default ui-corner-all").children(".ui-icon").removeClass(c.icons.headerSelected).addClass(c.icons.header);this.active.next().addClass("ui-accordion-content-active");var h=this.active.next(),
m={options:c,newHeader:d([]),oldHeader:c.active,newContent:d([]),oldContent:h},e=this.active=d([]);this._toggle(e,h,m)}},_toggle:function(a,b,c,f,g){var k=this,e=k.options;k.toShow=a;k.toHide=b;k.data=c;var h=function(){if(k)return k._completed.apply(k,arguments)};k._trigger("changestart",null,k.data);k.running=0===b.size()?a.size():b.size();if(e.animated){c={};c=e.collapsible&&f?{toShow:d([]),toHide:b,complete:h,down:g,autoHeight:e.autoHeight||e.fillSpace}:{toShow:a,toHide:b,complete:h,down:g,autoHeight:e.autoHeight||
e.fillSpace};e.proxied||(e.proxied=e.animated);e.proxiedDuration||(e.proxiedDuration=e.duration);e.animated=d.isFunction(e.proxied)?e.proxied(c):e.proxied;e.duration=d.isFunction(e.proxiedDuration)?e.proxiedDuration(c):e.proxiedDuration;f=d.ui.accordion.animations;var m=e.duration,l=e.animated;!l||f[l]||d.easing[l]||(l="slide");f[l]||(f[l]=function(a){this.slide(a,{easing:l,duration:m||700})});f[l](c)}else e.collapsible&&f?a.toggle():(b.hide(),a.show()),h(!0);b.prev().attr({"aria-expanded":"false",
"aria-selected":"false",tabIndex:-1}).blur();a.prev().attr({"aria-expanded":"true","aria-selected":"true",tabIndex:0}).focus()},_completed:function(a){this.running=a?0:--this.running;this.running||(this.options.clearStyle&&this.toShow.add(this.toHide).css({height:"",overflow:""}),this.toHide.removeClass("ui-accordion-content-active"),this.toHide.length&&(this.toHide.parent()[0].className=this.toHide.parent()[0].className),this._trigger("change",null,this.data))}});d.extend(d.ui.accordion,{version:"@VERSION",
animations:{slide:function(a,b){a=d.extend({easing:"swing",duration:300},a,b);if(a.toHide.size())if(a.toShow.size()){var c=a.toShow.css("overflow"),f=0,g={},k={},e,h=a.toShow;e=h[0].style.width;h.width(h.parent().width()-parseFloat(h.css("paddingLeft"))-parseFloat(h.css("paddingRight"))-(parseFloat(h.css("borderLeftWidth"))||0)-(parseFloat(h.css("borderRightWidth"))||0));d.each(["height","paddingTop","paddingBottom"],function(b,c){k[c]="hide";var e=(""+d.css(a.toShow[0],c)).match(/^([\d+-.]+)(.*)$/);
g[c]={value:e[1],unit:e[2]||"px"}});a.toShow.css({height:0,overflow:"hidden"}).show();a.toHide.filter(":hidden").each(a.complete).end().filter(":visible").animate(k,{step:function(b,c){"height"==c.prop&&(f=0===c.end-c.start?0:(c.now-c.start)/(c.end-c.start));a.toShow[0].style[c.prop]=f*g[c.prop].value+g[c.prop].unit},duration:a.duration,easing:a.easing,complete:function(){a.autoHeight||a.toShow.css("height","");a.toShow.css({width:e,overflow:c});a.complete()}})}else a.toHide.animate({height:"hide",
paddingTop:"hide",paddingBottom:"hide"},a);else a.toShow.animate({height:"show",paddingTop:"show",paddingBottom:"show"},a)},bounceslide:function(a){this.slide(a,{easing:a.down?"easeOutBounce":"swing",duration:a.down?1E3:200})}}})})(jQuery);
