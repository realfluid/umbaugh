	/****************************************************************************************************
	* This file is part of SecureLive 8.2.04 / 5.2.06													*
	* Copyright 2008 - 2011 SecureLive, LLC																*
	* http://www.securelive.net																			*
	*																									*
	* LICENSE AND USAGE																					*
	* 	This program is free software distributed under the GPL license.  Full terms of this license 	*
	* 	can be found here: http://www.gnu.org/licenses/gpl.html											*
	*																									*
	*	This software requires a SecureLive Domain License to be fully functional.  Although the 		*
	* 	GPL license allows modification of these files, the SecureLive Service Agreement forbids this.	*
	* 	The full SecureLive agreement can be found here: 												*
	* 	http://www.securelive.net/Information/product-terms-of-use.html									*
	* 																									*
	* 	If you are a SecureLive customer and this program causes problems or does not meet your needs,	*
	* 	contact support@securelive.net or call 888-300-4546 for assistance.								*
	****************************************************************************************************/

function preload(images){
    jQuery(images).each(function(){
        new Image().src = this;
    });
}
sl_gateway = {
	//configuration for each page
	pages:{
		scorecard:{
			header:{
				cache:5,
				refresh:0,
				checkRequest:0,
				message:'Checking support tickets and loading header...',
				onload:function(){
					sl_clear_header_classes();
					jQuery('#sl_scorecard_menulink').addClass('setMenuHover');
				}
			},
			scorecard:{
				cache:0,
				refresh:1,
				checkRequest:0,
				message:'Scoring your configuration settings...',
				onload:function(){
					sl_scoreTabs.init();
				}
			},
			alerts:{
				cache:0,
				refresh:1,
				checkRequest:0,
				message:'Checking file permissions...'
			}
		},
		overview:{
			header:{
				cache:5,
				refresh:0,
				checkRequest:0,
				message:'Checking support tickets and loading header...',
				onload:function(){
					sl_clear_header_classes();
					jQuery('#sl_overview_menulink').addClass('setMenuHover');
				}
			},
			last5:{
				cache:0,
				refresh:1,
				checkRequest:0,
				message:'Getting last 5 attacks...'
			},
			acct_form:{
				cache:0,
				refresh:1,
				checkRequest:1,
				message:'Loading account settings...',
				onload:function(){
					//create sliders
					jQuery(window).unbind('mouseup');
					sl_init();
				},
				unload:function(){
					jQuery(window).unbind('mouseup');
				}
			}			
		},
		tools:{
			header:{
				cache:5,
				refresh:0,
				checkRequest:0,
				message:'Checking support tickets and loading header...',
				onload:function(){
					sl_clear_header_classes();
					jQuery('#sl_tools_menulink').addClass('setMenuHover');
				}
			},
			ip_lookup:{
				cache:0,
				refresh:1,
				checkRequest:1,
				message:'Looking up IP data...',
				onload:function(){
					var map_timeout = setTimeout("initialize_map();",500);
				}
			},
			converter_validator:{
				cache:0,
				refresh:1,
				checkRequest:1,
				message:'Converter / Validator loading...'
			},
			alerts:{
				cache:0,
				refresh:1,
				checkRequest:0,
				message:'Checking file permissions...'
			},
			file_scanner:{
				cache:-1,
				refresh:0,
				checkRequest:1,
				message:'Loading file scanner...',
				unload:function(){
					jQuery(window).unbind('mouseup');
				}
			}
		},
		stats:{
			header:{
				cache:5,
				refresh:0,
				checkRequest:0,
				message:'Checking support tickets and loading header...',
				onload:function(){
					sl_clear_header_classes();
					jQuery('#sl_stats_menulink').addClass('setMenuHover');
				}
			},
			map_averages:{
				cache:0,
				refresh:1,
				checkRequest:1,
				message:'Getting attack map and stats...',
				onload:function(){
					var map_timeout = setTimeout("initialize_map();",500);
				}
			},
			charts_calendar:{
				cache:0,
				refresh:1,
				checkRequest:1,
				message:'Generating charts and calendar...',
				onload:function(){
					window['sl_cal'] = new sl_calendar("sl_calendar_holder");
				}
			}
		},
		attacklog:{
			header:{
				cache:5,
				refresh:0,
				checkRequest:0,
				message:'Checking support tickets and loading header...',
				onload:function(){
					sl_clear_header_classes();
					jQuery('#sl_attacklog_menulink').addClass('setMenuHover');
				}
			},
			attack_log:{
				cache:0,
				refresh:1,
				checkRequest:1,
				message:'Loading attack log...'
			}
		},
		diagnostics:{
			header:{
				cache:5,
				refresh:0,
				checkRequest:0,
				message:'Checking support tickets and loading header...',
				onload:function(){
					sl_clear_header_classes();
					jQuery('#sl_diagnostics_menulink').addClass('setMenuHover');
				}
			},
			diagnostics:{
				cache:0,
				refresh:1,
				checkRequest:1,
				message:'Loading diagnostics...'
			}
		},
		tickets:{
			header:{
				cache:0,
				refresh:0,
				checkRequest:0,
				message:'Checking support tickets and loading header...',
				onload:function(){
					sl_clear_header_classes();
					jQuery('#sl_tickets_menulink').addClass('setMenuHover');
				}
			},
			tickets:{
				cache:-1,
				refresh:0,
				checkRequest:1,
				message:'Loading support tickets...'
			}
		},
		addons:{
			header:{
				cache:5,
				refresh:0,
				checkRequest:0,
				message:'Checking support tickets and loading header...',
				onload:function(){
					sl_clear_header_classes();
					jQuery('#sl_addons_menulink').addClass('setMenuHover');
				}
			},
			addons:{
				cache:0,
				refresh:1,
				checkRequest:0,
				message:'Loading addons page...'
			}
		},
		help:{
			header:{
				cache:5,
				refresh:0,
				checkRequest:0,
				message:'Checking support tickets and loading header...',
				onload:function(){
					sl_clear_header_classes();
					jQuery('#sl_help_menulink').addClass('setMenuHover');
				}
			},
			help:{
				cache:0,
				refresh:1,
				checkRequest:1,
				message:'Loading help page...'
			}
		},
		details:{
			header:{
				cache:5,
				refresh:0,
				checkRequest:0,
				message:'Checking support tickets and loading header...'
			},
			details:{
				cache:0,
				refresh:0,
				checkRequest:1,
				message:'Looking up IP data...',
				onload:function(){
					var map_timeout = setTimeout("initialize_map();",500);
				}
			}
		},
		update:{
			header:{
				cache:0,
				refresh:0,
				checkRequest:0,
				message:'Checking support tickets and loading header...'
			},
			update:{
				cache:-1,
				refresh:0,
				checkRequest:0,
				message:'Updating your software...'
			}
		}
	},
	loading:false,
	currentPage:null,
	requestedPage:null,
	requestedRequest:null,
	loader:{
		close:function(){
			jQuery('#sl_black_fade').animate({opacity:0}, 1000, function(){
				//finish closing the div
				jQuery('#sl_black_fade').css('display','none');
				jQuery('#sl_backdrop_content').empty();
			});
		},
		cancel:function(noFade){
			//STOP THE LOADERS
			//mark each cache for requested page as cancelled so it will not display when done
			for(module in sl_gateway.pages[sl_gateway.requestedPage]){
				sl_gateway.cache[module].cancelled = true;
			}
			sl_gateway.loading = false;
			
			//fade out
			if(!noFade || sl_gateway.currentPage==null){
				jQuery('#sl_black_fade').animate({opacity:0}, 1000, function(){
					//finish closing the div
					jQuery('#sl_black_fade').css('display','none');
					jQuery('#sl_backdrop_content').empty();
					//PUT A LOAD BUTTON ON THE PAGE IF NO CURRENT PAGE SET
					if(sl_gateway.currentPage==null){
						btn = '<div align="center"><a href="javascript:void(0);" onclick="sl_gateway.loader.init();return false;"><b style="font-size:14px;">SecureLive Administration loading cancelled. If you wish to access the SecureLive Administration, please click this text to retry the loader.</b></a></div>';
						jQuery('#sl_admin_gateway').html(btn);
					}
				});
			}
		},
		init:function(){
			//preload the backdrop fade image
			preload(['images/blackfade85p.png','images/sl_logo_trans.png']);
			//set up the resize action
			jQuery(window).resize(function() {
				jQuery('#sl_black_fade').css('height',jQuery(window).height());
				jQuery('#sl_black_fade').css('width',jQuery(window).width());
			});
			jQuery(window).bind('beforeunload',function(){
				return 'Are you sure you want to navigate away from the SecureLive Admin?';
			});

			//sl_gateway.update.interval = setInterval('sl_gateway.update.now();',60000);//for future update

			sl_gateway.open('overview');
		}
	},
	cached:function(module,request){
		//if module not cached OR cache == -1 OR cache has expired, load it
		//if request is different, have to reload content
		if(this.cache[module]){
			//see if request is different
			if((this.cache[module].request != request) && this.pages[this.requestedPage][module].checkRequest){
				return false;
			}
			//see if cache disabled
			if(this.pages[this.requestedPage][module].cache == -1){
				return false;
			}
			//see if expired
			if(this.pages[this.requestedPage][module].cache > 0){
				minutesElapsed = ((new Date().getTime()) - this.cache[module].time)/1000/60;
				if(minutesElapsed > this.pages[this.requestedPage][module].cache){
					return false;
				}
			}
			//its good
			return true;
		} else {
			return false;
		}
	},
	makeRequest:function(module,query){
		//request
		request = "sl_page=ajax_module&sl_module="+module;
		
		if(typeof(query)=='string'){
			if(query!=''){
				request += query.indexOf('&')==0 ? query : ('&'+query);
			}
		} else {
			//assume its a form, use anything with a value
			for(var i=0;i<query.elements.length;i++){
				elm = query.elements[i];
				if(elm.type && elm.type.toLowerCase()=='checkbox'){
					if(elm.checked){
						request += '&'+elm.name+'='+escape(elm.value);
					}
				}
				else if(elm.value && elm.name){
					request += '&'+elm.name+'='+escape(elm.value);
				}
				for(var x=0;elm.options && elm.options[x];x++){
					if(elm.options[x].selected){
						request += '&'+elm.name+'='+escape(elm.options[x].value);
					}
				}
			}
			
		}
		return request;
	},
	open:function(page,query,cancelLoader){
		//can only open a page if no page request pending - may need to always give cancel button
		if(this.loading){
			if(confirm('The Admin is busy loading another page, would you like to cancel?')){
				this.loader.cancel();
			}
			return false;
		}
		//check if scanner running!!!!
		if(this.currentPage=='tools' && SL_Scanner){
			complete = true;
			for(v in SL_Scanner.ajaxObj){
				if(SL_Scanner.ajaxObj[v].ajax !== null){
					complete = false;
					break;
				}
			}
			if(!complete){
				if(confirm("A scan is currently in progress. Are you sure you want to leave this page and quit the scan?")){
					SL_Scanner.pause();
					for(v in SL_Scanner.ajaxObj){
						SL_Scanner.ajaxObj[v].ajax.abort();
					}
					for(v in SL_Scanner.ajaxObj){
						SL_Scanner.ajaxObj[v].ajax = null;
					}
				} else {
					return false;
				}
			}
		}
		
		//set some data
		query = query || '';
		cancelLoader = cancelLoader || false;//now you have to choose to disable the loader
		this.requestedPage = page;
		this.requestedQuery = query;
		
		//check caching status of all modules on page
		isCached = Array();
		notCached = Array();
		for(module in this.pages[page]){
			request = this.makeRequest(module,this.requestedQuery);
			if(this.cached(module,request)){
				isCached.push(module);
			} else {
				notCached.push(module);
			}
		}
		
		//empty the loader
		jQuery('#sl_backdrop_content').empty();
		
		//show the loader if requested and entire page is not cached
		if(!cancelLoader && notCached.length>0){
			//fade in backdrop
			jQuery('#sl_black_fade').css('height',jQuery(window).height());
			jQuery('#sl_black_fade').css('width',jQuery(window).width());
			jQuery('#sl_black_fade').css('opacity',0);
			jQuery('#sl_black_fade').css('display','block');
			jQuery('#sl_black_fade').animate({opacity:1}, 1000, function(){
				//start loading the requested page
				sl_gateway.open(sl_gateway.requestedPage,sl_gateway.requestedQuery,1);
			});
			return false;
		}
		//now mark it as loading
		this.loading = true;

		
		
		//CHECK CURRENT PAGE FOR CHANGES, SAVE THEM
		if(this.currentPage){
			for(module in this.pages[this.currentPage]){
				if(this.cache[module]){// && module!='header' ??
					//loop inputs on page, resetting their values
					jQuery('#sl_module_content_'+module+' input').each(function(){
						this.setAttribute('value',this.value);
					});
					//oldHTML = this.cache[module].html;
					newHTML = jQuery('#sl_module_content_'+module).html().replace(/(\r\n|\n\r|\r)/g,'\n');
					this.cache[module].html = newHTML;
				}
			}
		}
		

		//start the ajax loaders
		//need to start notcached first
		for(var i=0;i<notCached.length;i++){
			module = notCached[i];
			
			//get request
			request = this.makeRequest(module,this.requestedQuery);

			//not cached, create or set up the cache object
			if(!this.cache[module]){
				this.cache[module] = {};
			}
			this.cache[module].name = module;
			this.cache[module].request = request;
			this.cache[module].loading = true;
			this.cache[module].cancelled = false;
			this.cache[module].refresh = this.pages[this.requestedPage][module].refresh;

			
			
			//put the modules loading message
			jQuery('#sl_backdrop_content').append('<div id="module_message_'+module+'">'+sl_gateway.pages[page][module].message+'</div>');
			
			jQuery.ajax({
				type: "POST",
				url: sl_url+"/sl_admin.php",
				data: request,
				context:sl_gateway.cache[module],
				success:function(html){
					this.time = new Date().getTime();
					//get any messages from begining of HTML
					if(html.indexOf('*sl^module#message*')>-1){
						html = html.split('*sl^module#message*');
						this.message = html.shift();
						this.html = html.join('*sl^module#message*').replace(/(\r\n|\n\r|\r)/g,'\n');
					} else {
						this.message = '';
						this.html = html.replace(/(\r\n|\n\r|\r)/g,'\n');
					}
					//ADD REFRESH BUTTON
					if(this.refresh){
						this.html += '<a class="gateway_refresh" href="#" onclick="sl_gateway.refresh(\''+this.name+'\');return false;"><img src="'+sl_url+'/images/refresh.png" border="0" width="24px" alt="Refresh" title="Refresh" /></a>';
					}
					
					//now output to the screen that this test is done...
					jQuery('#module_message_'+this.name).append(this.message);
					
					this.loading = false;
					
					//if message requested refresh, stop loading, refresh
					if(this.message=='REFRESH'){
						sl_gateway.loader.cancel(true);
						sl_gateway.refresh(this.name);
						return;
					}
					

					
					
					//see if whole page is done
					done = true;
					for(mod in sl_gateway.pages[sl_gateway.requestedPage]){
						//no cancels, all loading false
						if(sl_gateway.cache[mod].loading){
							done = false;
							break;
						}
					}
					//display the page
					if(done && sl_gateway.loading && !this.cancelled){
						//done loading
						sl_gateway.loading = false;
						//do unload events for current page
						if(sl_gateway.currentPage){
							for(module in sl_gateway.pages[sl_gateway.currentPage]){
								if(sl_gateway.pages[sl_gateway.currentPage][module].unload){
									try {
										sl_gateway.pages[sl_gateway.currentPage][module].unload();
									} catch (error){
										//error.description
									}
								}
							}
						}
						//set the new current page and display it
						sl_gateway.currentPage = sl_gateway.requestedPage;
						sl_gateway.display();
						//close loader
						sl_gateway.loader.close();
					}
				},
				error:function(){
					alert('Ajax failed. Try reloading the page.');
				}
			});
			
		}
		
		

		//marked cached as done and check ajax ones
		for(var i=0;i<isCached.length;i++){
			module = isCached[i];
			this.cache[module].loading = false;
			this.cache[module].cancelled = false;

			//see if whole page is done
			done = true;
			for(mod in this.pages[this.requestedPage]){
				//no cancels, all loading false
				if(this.cache[mod].loading){
					done = false;
					break;
				}
			}
			//display the page
			if(done && this.loading){
				//done loading
				this.loading = false;
				//display & unload if not cancelled
				if(!this.cache[module].cancelled){
					//do unload events for current page
					if(this.currentPage){
						for(module in this.pages[this.currentPage]){
							if(this.pages[this.currentPage][module].unload){
								try {
									this.pages[this.currentPage][module].unload();
								} catch (error){
									//error.description
								}
							}
						}
					}
					//set the new current page and display it
					this.currentPage = this.requestedPage;
					this.display();
				}
				//close loader
				this.loader.close();
			}
		}

	},
	display:function(page){
		page = page || this.currentPage;
		//puts the page from cache
		//empty the page
		jQuery('#sl_admin_gateway').empty();
		//put each module into a module div on the page
		for(module in this.pages[page]){
			if(empty(this.cache[module].html)){
				this.cache[module].html = '<a href="javascript:void(0)" onclick="sl_gateway.refresh();return false;" style="font-size:14px;">Sorry, but this content was unable to load. Click here to try again.</a>';
			}
			jQuery('#sl_admin_gateway').append('<div id="sl_module_content_'+module+'" class="sl_module_class">'+this.cache[module].html+'</div>');
			//do onload
			if(this.pages[page][module].onload){
				try {
					this.pages[page][module].onload();
				} catch (error){
					//error.description
				}
			}
		}		
	},
	refresh:function(module){
		if(this.currentPage=='details'){
			try {
				delete this.cache.attack_log;
			} catch(error){}
			try {
				delete this.cache.last5;
			} catch(error){}
			this.open('attacklog');
			return;
		}
		if(!module){
			//delete all for current page
			for(module in this.pages[this.currentPage]){
				try {
					delete this.cache[module];
				} catch(error){}
			}
		} else {
			try {
				delete this.cache[module];
			} catch(error){}
		}
		this.open(this.currentPage);
	},
	update:{
		interval:null,
		minutes:0,
		now:function(){
			//need to make this more behind-the-scenes
		}
	},
	//holds module data (loading, html, time, request)
	cache:{}
}