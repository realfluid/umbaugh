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

function write(elm, what, clear_first, style, prepend){
    if(clear_first){
        while(elm.childNodes.length > 0 && elm.childNodes[0]){
            elm.removeChild(elm.childNodes[0]);
        }
    }
    newdiv = document.createElement('div');
    if(style){
        if(style.indexOf('^') > -1){
            arr = style.split('^');
            for(w=0;w<arr.length;w++){
                temp = arr[w].split('=');
                if(temp[0]=='style'){
            		temp2 = temp[1].split(':');
            		//correct hyphenated
            		styleName = temp2[0];
            		if(styleName.indexOf('-')>-1){
						x = styleName.split('-');
						styleName = x[0]+x[1].substr(0,1).toUpperCase()+x[1].substr(1);
            		}
					eval('newdiv.style.'+styleName+' = "'+temp2[1].replace(';','')+'";');
	            } else if(temp[0]=='class'){
					newdiv.className = temp[1];
	            } else {
					newdiv.setAttribute(temp[0], temp[1]);
	            }
            }
        } else {
            temp = style.split('=');
            if(temp[0]=='style'){
            	temp2 = temp[1].split(':');
            	styleName = temp2[0];
            	if(styleName.indexOf('-')>-1){
            		temp3 = styleName.split('-');
					styleName = temp3[0]+temp3[1].substr(0,1).toUpperCase()+temp3[1].substr(1);
            	}
				eval('newdiv.style.'+styleName+' = "'+temp2[1].replace(';','')+'";');
            } else if(temp[0]=='class'){
            	newdiv.className = temp[1];
			} else {
				newdiv.setAttribute(temp[0], temp[1]);
            }
        }
    }
    newdiv.innerHTML = what;
    if(prepend && elm.firstChild){
        elm.insertBefore(newdiv,elm.firstChild);
    } else {
        elm.appendChild(newdiv);
    }
}
function empty(mixed_var){
    var key;
    if(mixed_var === "" || mixed_var === 0 || mixed_var === "0" || mixed_var === null || mixed_var === false || typeof(mixed_var) === 'undefined'){return true;}
    if(typeof(mixed_var) == 'object'){
    	if(typeof(mixed_var.length) != 'undefined'){
			if(mixed_var.length < 1){
				return true;
			} else {
				for(i=0;i<mixed_var.length;i++){
					temp = mixed_var[i];
					if(temp !== "" && temp !== 0 && temp !== "0" && temp !== null && temp !== false && typeof(temp) !== 'undefined'){
						return false;
					}
				}
				return true;
			}
    	}
        for(key in mixed_var){
            return false;
        }
        return true;
    }
    return false;
}
function in_array(array,value,atStart){
	for(a=0;a<array.length;a++){
		if(atStart){
			if(array[a].indexOf(value)==0){
				return true;
			}
		} else {
			if(value==array[a]){
				return true;
			}
		}
	}
	return false;
}
function stopPropagation(e){
    e = e || event;
    e.stopPropagation ? e.stopPropagation() : e.cancelBubble=true;
}
function sl_mms_generator(){
    carrier = document.getElementById('sl_mms').value;
    number = prompt('If you would like to receive reports on your mobile device, please enter your cell phone number.\nBe sure you have selected the correct cell phone provider from the list.');
    if(number){
        //strip all but numbers
        numlist = '0123456789';
        realnumber = '';
        for(i=0;i<number.length;i++){
            if(numlist.indexOf(number.charAt(i))>-1){
                realnumber += number.charAt(i);
            }
        }
        //insert realnumber
        if(carrier.indexOf('number')==0){
            fullstring = realnumber + carrier.substr(6);
        } else {
            tempvar = carrier.split('number');
            fullstring = tempvar.join(realnumber);
        }
        //display and ask if should put it
        conf = confirm('Your generated email is:\n\n'+fullstring+'\n\nWould you like to add it to your Reporting Emails?\nNOTE: You must still press the SAVE button at the bottom of the page to save the new email.');
        if(conf){
            elm = document.getElementById('sl_email');
            //check for other emails (to see if comma is needed)
            elm.value = empty(elm.value) ? fullstring : elm.value + ', ' + fullstring;
        }
    }
}
function sl_slider(prefix, low, high, init){
    //init values
    this.prefix = prefix;
    this.dragging = false;
    this.position = 0;
    this.lowval = low;
    this.highval = high;
    //set elements
    this.slider = function(){return document.getElementById(this.prefix+'_slider');}
    this.holder = function(){return document.getElementById(this.prefix+'_slider_holder');}
    this.output = function(){return document.getElementById(this.prefix+'_slider_val');}
    //slider functions
    this.start_drag = function(event){
        event = event ? event : window.event;
        this.dragging = true;
        this.position = event.clientX;
        this.putval();
        return false;
    }
    this.update_drag = function(event){
        event = event ? event : window.event;
        if(this.dragging){
            move = parseInt(this.slider().style.left) + (event.clientX-this.position);
            this.position = event.clientX;
            move = move < -5 ? -5 : move > 195 ? 195 : move;
            this.slider().style.left = move+"px";
            this.putval();
        }
    }
    this.stop_drag = function(event){
    	event = event || window.event;
    	stopPropagation(event);
        this.dragging = false;
        this.putval();
    }
    this.putval = function(num){
        if(num && typeof(num) != 'object'){
            //similar to putslider
            percent = (num-this.lowval)/(this.highval-this.lowval);
            pos = Math.ceil(percent * 200) - 5;
            this.slider().style.left = pos+"px";
            this.output().value = num;
        } else {
            pos = parseInt(this.slider().style.left) + 5;
            percent = pos/200;
            range = this.highval - this.lowval;
            val = Math.floor(range * percent) + this.lowval;
            this.output().value = val;
        }
    }
    this.putslider = function(){
        //basically putval w/ num
        num = this.output().value != '' ? parseInt(this.output().value) : parseInt(this.lowval);
        num = typeof(num) != 'number' ? this.lowval : num;
        if(num < this.lowval){
            num = this.lowval;
        } else if(num > this.highval){
            num = this.highval;
            this.putval();
        }
        percent = (num-this.lowval)/(this.highval-this.lowval);
        pos = Math.ceil(percent * 200) - 5;
        this.slider().style.left = pos+"px";

    }
    this.getval = function(){return this.output().value;}
    //initialize value
    this.putval(init);
    //set actions
    this.slider().onmousedown = this.start_drag.bind(this);
    this.holder().onmousemove = this.update_drag.bind(this);
    this.output().onkeyup = this.putslider.bind(this);
    this.output().onblur = this.putval.bind(this);
    
    jQuery(window).mouseup(this.stop_drag.bind(this));
    jQuery(this.holder()).mouseup(this.stop_drag.bind(this));
}
function sl_calendar(container){
    this.container = document.getElementById(container);
    this.attacks = Array();
    this.month = null;
    this.txt_month = null;
    this.year = null;
    this.day = null;
    this.ajax = null;
    //this.height = null;
    this.write = function(elm, what, clear_first, style){
        if(clear_first){
            while(elm.childNodes[0]){
                elm.removeChild(elm.childNodes[0]);
            }
        }
        newdiv = document.createElement('div');
        if(style){
            newdiv.setAttribute('style', style);
        }
        newdiv.innerHTML = what;
        elm.appendChild(newdiv);
    }
    this.set_date = function(date){
        months = Array('January','February','March','April','May','June','July','August','September','October','November','December');
        if(!date){
            today = new Date();
            this.year = today.getFullYear();
            this.month = today.getMonth();
            this.txt_month = months[this.month];
            this.day = today.getDate();
        } else {
            temp = date.split('~');
            m = temp[0];//0-11
            y = temp[1];
            today = new Date(y,m,1);
            this.year = today.getFullYear();
            this.month = today.getMonth();
            this.txt_month = months[this.month];
            this.day = 0;
        }
    }
    this.get_attacks = function(){
        this.write(this.container, 'Please wait...', true);
        url = sl_url+'/sl_admin.php';
        params = 'sl_page=ajax&what=sl_cal&where='+this.month+'~'+this.year;
        this.ajax = new XMLHttpRequest();
        this.ajax.onreadystatechange = this.resp.bind(this);
        this.ajax.open("POST", url, true);
        this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        this.ajax.setRequestHeader("Content-length", params.length);
        this.ajax.setRequestHeader("Connection", "close");
        this.ajax.send(params);
    }
    this.resp = function(){
        if(this.ajax.readyState==4 && this.ajax.status==200){
            this.attacks = this.ajax.responseText.split("|");
            this.show_cal();
        }
    }
    this.get = function(what, target_day){
        //num_attacks and threat_sum for target day
        if(what==1){
            num_attacks = 0;
            threat_sum = 0;
            for(x=1;x<this.attacks.length-1;x++){
                temp = this.attacks[x].split('~');
                id = temp[0];
                ip = temp[1];
                date = temp[2];
                threat_level = temp[3];
                why = temp[4];

                temp = date.split(' ');
                month = temp[0];
                day = temp[1].substr(0,temp[1].length-1);
                year = temp[2].substr(0,temp[2].length-1);

                //only need to check day b/c server returned only the month you are viewing
                if(day==target_day){
                    num_attacks++;
                    threat_sum += parseInt(threat_level);
                }
            }
            return Array(num_attacks, threat_sum);
        //returns array of attacks on the target day
        } else if(what==2){
            arr = Array();
            for(x=1;x<this.attacks.length-1;x++){
                temp = this.attacks[x].split('~');
                id = temp[0];
                ip = temp[1];
                date = temp[2];
                threat_level = temp[3];
                why = temp[4];

                temp = date.split(' ');
                month = temp[0];
                day = temp[1].substr(0,temp[1].length-1);
                year = temp[2].substr(0,temp[2].length-1);

                //only need to check day b/c server returned only the month you are viewing
                if(day==target_day){
                    arr.push(this.attacks[x]);
                }
            }
            return arr;
        }
    }
    this.change_cal = function(date){
        this.set_date(date);
        this.get_attacks();
    }
    this.show_graph = function(what){
        elm = document.getElementById('sl_month_graph_container');
        //get days in this month
        isLeap = new Date(this.year,1,29).getDate() == 29;
        february = isLeap ? 29 : 28;
        days = Array(31,february,31,30,31,30,31,31,30,31,30,31);
        days_this_month = days[this.month];
        //loop
        data = '';
        labels = '';
        highest = 0;
        total_atx = 0;
        total_threat = 0;
        for(i=1;i<=days_this_month;i++){
            temp = this.get(1, i);
            num_attacks = temp[0];
            threat_sum = temp[1];

            if(what=='atx'){
                data += num_attacks;
                total_atx += num_attacks;
                highest = num_attacks > highest ? num_attacks : highest;
            } else if(what=='threat'){
                data += threat_sum;
                total_threat += threat_sum;
                highest = threat_sum > highest ? threat_sum : highest;
            }

            labels += i;

            if(i<days_this_month){
                data += ',';
                labels += "|";
            }
        }

        if(what=='atx'){

            attackchart = "http://chart.apis.google.com/chart?cht=bvg&chs=435x155&chbh=a&chco=ff5b5b&chxt=x,y&chxl=0:||1:|0|"+highest+"&chds=0,"+highest+"&chd=t:"+data+"&chl="+labels;

            this.write(elm, '<span class="sl_graph_title">'+this.txt_month+' '+this.year+'</span><br/><br/>', true);
            this.write(elm, 'Attacks Per Day - attacks this month: <b>'+total_atx+'</b><br/><br/>', false, 'text-align:center;');
            this.write(elm, '<img src="'+attackchart+'" />', false);
            this.write(elm, '<br/><a href="javascript:void(0);" onclick="sl_cal.show_graph(\'threat\');return false;">Show Threat Levels per day</a>', false, 'text-align:center;');
            this.write(elm, '<div align="right"><a href="javascript:void(0);" onclick="this.parentNode.parentNode.parentNode.style.display=\'none\';return false;">close</a></div>', false, 'position:absolute;bottom:5px;right:5px;');
        } else if(what=='threat'){

            threatchart = "http://chart.apis.google.com/chart?cht=bvg&chs=435x155&chbh=a&chco=ff5b5b&chxt=x,y&chxl=0:||1:|0|"+highest+"&chds=0,"+highest+"&chd=t:"+data+"&chl="+labels;

            this.write(elm, '<span class="sl_graph_title">'+this.txt_month+' '+this.year+'</span><br/><br/>', true);
            this.write(elm, 'Threat Level Per Day - threat total this month: <b>'+total_threat+'</b><br/><br/>', false, 'text-align:center;');
            this.write(elm, '<img src="'+threatchart+'" />', false);
            this.write(elm, '<br/><a href="javascript:void(0);" onclick="sl_cal.show_graph(\'atx\');return false;">Show Attacks per day</a>', false, 'text-align:center;');
            this.write(elm, '<div align="right"><a href="javascript:void(0);" onclick="this.parentNode.parentNode.parentNode.style.display=\'none\';return false;">close</a></div>', false, 'position:absolute;bottom:5px;right:5px;');
        }
        elm.style.display = 'block';

    }
    this.show_day = function(target_day){
        elm = document.getElementById('sl_month_graph_container');
        //get num_attacks for this day
        temp = this.get(1, target_day);
        num_attacks = temp[0];
        threat_sum = temp[1];
        if(num_attacks > 0){
            ret_table = '<div align="center">Click an attack to see more details</div><br/><table cellspacing="0" cellpadding="5px"><tr><td>#</td><td>IP</td><td>When</td><td>Threat</td><td>Why</td></tr>';
            //get array of attacks for this day
            day_arr = this.get(2,target_day);
            for(i=0;i<day_arr.length;i++){
                //number, IP, date, threat, why.substr into clickable row - goes to details w/ ID
                temp = day_arr[i].split('~');
                id = temp[0];
                ip = temp[1];
                date = temp[2];
                threat_level = temp[3];
                why = temp[4];

                ret_table += '<tr style="background-color:#'+(i%2==0 ? 'FFEFEF' : 'F6F6F6')+'" onclick="sl_gateway.open(\'details\',\'id='+id+'~'+ip+'\');">';
                ret_table += '<td>'+(i+1)+'</td>';
                ret_table += '<td>'+ip+'</td>';
                ret_table += '<td>'+date+'</td>';
                ret_table += '<td>'+threat_level+'</td>';
                ret_table += '<td>'+why.substr(0,25)+'...</td>';
                ret_table += '</tr>';

            }
            ret_table += '</table>';

            //write table string into 300 height div with vertical scrolling
            this.write(elm, ret_table, true, 'height:300px;overflow-y:auto;');
            this.write(elm, '<div align="right"><a href="javascript:void(0);" onclick="this.parentNode.parentNode.parentNode.style.display=\'none\';return false;">close</a></div>', false, 'position:absolute;bottom:-4px;right:10px;');
            elm.style.display = 'block';
        }
    }
    this.show_cal = function(){
        this_startday = new Date(this.year, this.month, 1).getDay();

        isLeap = new Date(this.year,1,29).getDate() == 29;
        february = isLeap ? 29 : 28;
        months = Array('January','February','March','April','May','June','July','August','September','October','November','December');
        days = Array(31,february,31,30,31,30,31,31,30,31,30,31);

        //display calendar
        cal_output = '<div id="sl_month_graph_container" style="display:none"></div>';
        cal_output += '<table cellpadding="2px" cellspacing="0px" border="0px"><tr><td colspan="7" align="center">';

        back = '<a class="sl_cal_a" href="javascript:void(0);" onclick="sl_cal.change_cal(\''+(this.month==0 ? '11~'+(this.year-1) : (this.month-1)+'~'+this.year)+'\');return false;">_<_</a>';
        title = '<span class="sl_cal_title">'+months[this.month]+' '+this.year+'</span>';
        forward = '<a class="sl_cal_a" href="javascript:void(0);" onclick="sl_cal.change_cal(\''+(this.month==11 ? '0~'+(this.year+1) : (this.month+1)+'~'+this.year)+'\');return false;">_>_</a>';

        cal_output += back+title+forward+'</td></tr>';
        cal_output += '<tr><td class="cal_toptd">Sunday</td><td class="cal_toptd">Monday</td><td class="cal_toptd">Tuesday</td><td class="cal_toptd">Wednesday</td><td class="cal_toptd">Thursday</td><td class="cal_toptd">Friday</td><td class="cal_toptd">Saturday</td></tr>';
        for(i=1;i<=days[this.month];i+=weeknum){
            weeknum = 0;
            daynum = 0;
            cal_output += '<tr>';
            for(j=0;j<7 && (i+j)<=days[this.month];j++){
                if(i==1 && j<this_startday){
                    //put last months days
                    cal_output += '<td>&nbsp;</td>';
                    daynum++;
                } else {
                    put_day = i+j-daynum;// don't touch
                    // output for each day this month - starts with day number
                    day_output = '<td align="center" onclick="sl_cal.show_day('+put_day+')" class="cal_day_td"><div class="cal_daycontainer"><div class="cal_daynum">';
                    day_output += put_day==this.day ? '<b>'+put_day+'</b>' : put_day;
                    day_output += '</div><div class="cal_daytext">';
                    //need to find total threat level and number of attacks on each day
                    temp = this.get(1, put_day);
                    num_attacks = temp[0];
                    threat_sum = temp[1];
                    if(num_attacks > 0){
                        day_output += 'attacks: '+num_attacks+'<br/>threat: '+threat_sum;
                    }
                    day_output += '</div></div></td>';
                    ///////////////////////// don't touch
                    cal_output += day_output;
                    weeknum++;
                }
            }
            cal_output += '</tr>';
        }
        cal_output += '<tr><td colspan="7" align="right"><a href="javascript:void(0);" onclick="sl_cal.show_graph(\'atx\');return false;">See this month as a bar graph</a></td></tr></table>';
        this.write(this.container, cal_output, true);
    }

    this.set_date();
    this.get_attacks();
}

function sl_confirm_update(){
	check = confirm('You are about to automatically upgrade your SecureLive Server Edition Software to the current version. Press OK to continue.');
	if(check){
		sl_gateway.open('update');
	}
}
sl_force_logout = {
	int:null,
	seconds:5,
	start:function(seconds){
		this.seconds = seconds;
		message = this.seconds+' second'+(this.seconds==1?'':'s');
		jQuery('#sl_force_logout_counter').html(message);
		this.seconds--;
		this.int = setInterval("sl_force_logout.update()",1000);
	},
	now:function(){
		jQuery(window).unbind('mouseup');
		jQuery(window).unbind('beforeunload');
		jQuery('#sl_logout_form_elm').submit();
	},
	update:function(){
		if(this.seconds==0){
			clearInterval(this.int);
			return this.now();
		}
		message = this.seconds+' second'+(this.seconds==1?'':'s');
		jQuery('#sl_force_logout_counter').html(message);
		this.seconds--;
	}
}

function sl_select(what, where){
	//s afe
	//t erms
	//b lack
    if(where=='w'){
        elm = document.getElementById('whitelist_remove');
    } else if(where=='c'){
        elm = document.getElementById('sl_countries');
    } else if(where=='b'){
        elm = document.getElementById('blacklist_remove');
    } else if(where=='s'){
        elm = document.getElementById('safelist_remove');
    } else if(where=='t'){
        elm = document.getElementById('customlist_remove');
    } else if(where=='spamEmail'){
    	elm = document.getElementById('spamEMails_remove');
	} else if(where=='spamUsername'){
    	elm = document.getElementById('spamUsernames_remove');
	} else if(where=='spamIp'){
    	elm = document.getElementById('spamIps_remove');
	} else if(where=='spamTerm'){
    	elm = document.getElementById('spamTerms_remove');
	}

    for(i=0;i<elm.options.length;i++){
        if(what=='all'){
            elm.options[i].selected = true;
        } else if(what=='none'){
            elm.options[i].selected = false;
        }
    }
}
function reset_chkbox_imgs(i){
	if(i=='loop'){
		for(i=1;i<26;i++){
	        elm = document.getElementById("for_e"+i);
	        box = document.getElementById("e"+i);
	        box.blur();
	        elm.className = box.checked==true ? "checked" : "unchecked";
	        if(i==7 && box.checked==true){
	            //safe bots
	            alert("CAUTION!\n\nEnabling the Safe Bots email report option can cause a flood of emails. You will be alerted every time a bot of any kind (such as search engine bots), visits a page on your website.\n\nIt is highly recommended that you disable the Safe Bots email report option.");
	        }
	        if(i==17 && box.checked==true){
	            alert("Attention!\n\nEnabling the Duplicate Blocking email report option can cause a flood of emails. You will be alerted every time a previously banned IP address visits a page on your website.\n\nIt is recommended that you disable the Duplicate Blocking email report option.");
	        }
	    }
	} else {
		elm = document.getElementById("for_e"+i);
	    box = document.getElementById("e"+i);
	    box.blur();
	    elm.className = box.checked==true ? "checked" : "unchecked";
	    if(i==7 && box.checked==true){
	        //safe bots
	        alert("CAUTION!\n\nEnabling the Safe Bots email report option can cause a flood of emails. You will be alerted every time a bot of any kind (such as search engine bots), visits a page on your website.\n\nIt is highly recommended that you disable the Safe Bots email report option.");
	    }
	    if(i==17 && box.checked==true){
	        alert("Attention!\n\nEnabling the Duplicate Blocking email report option can cause a flood of emails. You will be alerted every time a previously banned IP address visits a page on your website.\n\nIt is recommended that you disable the Duplicate Blocking email report option.");
	    }
	}

}
function sl_reset_form(){
    reset_chkbox_imgs('loop');
    email_thresh.putslider();
    flood_limit.putslider();
    mod_block.putslider();
    high_block.putslider();
    crit_block.putslider();
}
function sl_restore_defaults(){
    check = confirm('Are you sure you want to restore your account settings to the default recommended settings?');
    if(check){
        //check if there is a reporting email & alert if none, leave other identification alone
        elm = document.getElementById('sl_email');
        val = elm.value;
        if(val=='' || val.indexOf('@')==-1){
            newval = '';
            thistry = 0;
            while((newval=='' || newval.indexOf('@')==-1) && thistry < 3){
                newval = prompt('You must specify an accurate email address in order to receive incident reports. Please specify one now.');
                thistry++;
            }
            elm.value = newval;
        }
        //email threshold = 0
        document.getElementById('et_slider_val').value = 0;
        email_thresh.putslider();
        //all email options on except safe bots and duplicates and whitelist remove (7,17,19)
        for(i=1;i<22;i++){
            if(i==7 || i==17 || i==21 || i==22){
                elm = document.getElementById("for_e"+i);
                box = document.getElementById("e"+i);
                box.blur();
                box.checked=false;
                box.blur();
                elm.className = box.checked==true ? "checked" : "unchecked";
            } else {
                elm = document.getElementById("for_e"+i);
                box = document.getElementById("e"+i);
                box.blur();
                box.checked=true;
                box.blur();
                elm.className = box.checked==true ? "checked" : "unchecked";
            }
        }
        //bad bots = 1
        elm = document.getElementById("sl_bot_lvl");
        elm[0].selected = true;
        elm[1].selected = false;
        elm[2].selected = false;
        elm = document.getElementById("sl_bot_ban");
        elm[0].selected = true;
        elm[1].selected = false;
        //no 404 page
        elm = document.getElementById("sl_cust404");
        elm.value = '';
        //remove accessword
        elm = document.getElementById("sl_memo_pass");
        elm.value = '';
        //disable cookies = off
        elm = document.getElementById("sl_act_disableCookies");
        elm[0].selected = false;
        elm[1].selected = true;
        //debug off
        elm = document.getElementById("sl_act_debug");
        elm[0].selected = false;
        elm[1].selected = true;
        //frame buster on
        elm = document.getElementById("sl_frame_buster");
        elm[0].selected = true;
        elm[1].selected = false;
        //sl_spamFilterEnabled on
        if(document.getElementById("sl_spamFilterEnabled")){
			elm = document.getElementById("sl_spamFilterEnabled");
	        elm[0].selected = true;
	        elm[1].selected = false;
        }
        //flood limit = 7
        document.getElementById('fl_slider_val').value = 7;
        flood_limit.putslider();
        elm = document.getElementById('flood_switch');
        elm[0].selected = false;
        elm[1].selected = true;
        //mod = 1-d
        document.getElementById('mt_slider_val').value = 1;
        mod_block.putslider();
        elm = document.getElementById("mod_mod");
        elm[0].selected = false;
        elm[1].selected = true;
        elm[2].selected = false;
        elm[3].selected = false;
        //high = 3-d
        document.getElementById('ht_slider_val').value = 3;
        high_block.putslider();
        elm = document.getElementById("high_mod");
        elm[0].selected = false;
        elm[1].selected = true;
        elm[2].selected = false;
        elm[3].selected = false;
        //crit = 7-d
        document.getElementById('ct_slider_val').value = 7;
        crit_block.putslider();
        elm = document.getElementById("crit_mod");
        elm[0].selected = false;
        elm[1].selected = true;
        elm[2].selected = false;
        elm[3].selected = false;
        //remove all country blocks
        elm = document.getElementById("sl_countries");
        for(i=0;i<elm.length;i++){
            elm[i].selected = false;
        }
        //no country 404
        elm = document.getElementById("sl_country404");
        elm.value = '';
        //leave whitelist alone
        //respond
        alert("YOU MUST SAVE!\n\nYou still need to press the save button and submit the new settings to SecureLive.");
    }
}
function sl_bot_alert(val){
    if(val==1){
        check = prompt("You have chosen to ALLOW ALL BOTS. This will make your website vulnerable to attacks from bots!! We are not liable if you get hacked by a bot because of this setting.\n\nIf you are absolutely sure you want to ALLOW ALL BOTS, type SECURELIVE in the box and press OK.");
        if(check!='SECURELIVE'){
            elm = document.getElementById("sl_bot_lvl");
            elm[0].selected = true;
            elm[1].selected = false;
            elm[2].selected = false;
        }
    }
    if(val==2){
        check = prompt("You have chosen to BLOCK ALL BOTS. This will make it impossible for search engines to find your website!!\n\nIf you are absolutely sure you want to BLOCK ALL BOTS, type SECURELIVE in the box and press OK.");
        if(check!='SECURELIVE'){
            elm = document.getElementById("sl_bot_lvl");
            elm[0].selected = true;
            elm[1].selected = false;
            elm[2].selected = false;
        }
    }
    if(val==3){
        check = prompt("You have chosen to BAN BAD BOTS. There is a small chance that you could accidently ban a search engine from crawling your website!!\n\nIf you are absolutely sure you want to BAN BAD BOTS, type SECURELIVE in the box and press OK.");
        if(check!='SECURELIVE'){
            elm = document.getElementById("sl_bot_ban");
            elm[0].selected = true;
            elm[1].selected = false;
        }
    }
    if(val=='debug1'){
		check = confirm('Enabling debug mode will put a SecureLive Debug Header at the top of your pages and enable full error reporting. This could cause a fatal error or change the appearance of your website, depending on your code.\n\nIf you still want to enable debug mode, and understand the risks, press OK.');
		if(!check){
			elm = document.getElementById("sl_act_debug");
            elm[0].selected = false;
            elm[1].selected = true;
		}
    }
}

function sl_js_url_modifier(arr){
    //array is all changes that must be made
    //array values are like "sl_page^details" as variable^value --- if value is blank, remove the variable from the URL
    url = location.href;
    for(href=0;href<arr.length;href++){
        temp = arr[href].split('^');
        variable = temp[0];
        value = temp[1];

        if(url.indexOf("?") == -1){ // no ?
            url = url+'?'+variable+'='+value;
        } else { // has ?
            if(url.indexOf(variable) == -1){ // var not present
                url = url+'&'+variable+'='+value;
            } else { // already has var
                if(empty(value) && value != '0'){ // need to delete var
                    if(url.charAt(url.indexOf(variable)-1)!="?"){ // is &var - remove "&var=val"
                        // remove "&var=val"
                        part1 = url.substr(0, url.indexOf(variable)-1);
                        part2 = url.indexOf('&', url.indexOf(variable))==-1 ? '' : url.substr(url.indexOf('&', url.indexOf(variable)));
                        url = part1+part2;
                    } else { // is ?var...continue
                        if(url.indexOf('&', url.indexOf(variable))==-1){ // is only var - remove ? and all after it
                            //remove ? and all after it
                            url = url.substr(0,url.indexOf("?"));
                        } else { // is first var - remove "var=val&"
                            // remove "var=val&"
                            part1 = url.substr(0, url.indexOf(variable));
                            part2 = url.substr(url.indexOf('&', url.indexOf(variable))+1);
                            url = part1+part2;
                        }
                    }
                } else { // need to change val
                    part1 = url.substr(0, url.indexOf('=',url.indexOf(variable))+1);
                    part2 = url.indexOf('&', url.indexOf(variable))==-1 ? '' : url.substr(url.indexOf('&', url.indexOf(variable)));
                    url = part1+value+part2;
                }
            }
        }
    }
    return url;
}
function sl_bypass_editor(){
	this.top = function(){return document.getElementById('sl_bypass_wizard');}
	this.arr = null;
	this.dirArr = null;
	this.ajax = null;
	this.button = null;
	this.write = function(elm, what, clear_first, style){
        if(clear_first && elm.childNodes.length > 0){
            while(elm.childNodes[0]){
                elm.removeChild(elm.childNodes[0]);
            }
        }
        newdiv = document.createElement('div');
        if(style){
            newdiv.setAttribute('style', style);
        }

        newdiv.innerHTML = what;

        elm.appendChild(newdiv);
    }
	this.display = function(){
		if(!this.arr){
			this.arr = Array(Array('',''));
		}
		if(!this.dirArr){
			this.dirArr = Array('No Directory Bypasses Created');
		}
		form = '';
		//needs to loop arr and display all the ors and ands
		for(var i=0;i<this.arr.length;i++){
			variable = this.arr[i][0];
			value = this.arr[i][1];
			and = 0;

			//begin OR
			form += '<div id="or'+i+'" class="sl_or_box">\n';
			if(typeof(variable)!='string'){
				//loop and add the ANDs
				for(j=0;j<variable.length;j++){
					newvar = variable[j];
					newval = value[j];
					form += this.add_and(i,and++, newvar, newval);
				}
			} else {
				//add the single AND div
				form += this.add_and(i,and++, variable, value);
			}
			//end OR
			form += '</div>\n';
		}




		//add new dir bypass
		form += '<div>\n';
		form += '	<p><b>New:</b> Bypass POST XSS Filter in the following directories:</p>\n';

		form += '	<table>\n';
		form += '		<tbody>\n';
		form += '			<tr>\n';
		form += '				<td>\n';

		form += '					<select id="dir_bypass_select" multiple="multiple" style="height:100px;min-width:200px;">\n';
		for(var i=0;i<this.dirArr.length;i++){
			var dir = this.dirArr[i];
			form += '					<option value="'+dir+'">'+dir+'</option>\n';
		}
		form += '					</select>\n';

		form += '				</td>\n';
		form += '				<td>\n';

		form += '					Enter New Bypass: (entering your domain name will disable the POST XSS Filter)\n';
		form += '					<form onsubmit="sl_wizard.addDir(this);return false;" onreset="sl_wizard.remDir(this);return false;" action="#" method="get">\n';
		form += '						<input type="text" name="dir" style="width:220px;margin:10px 0;" /><br/>\n';
		form += '						<input type="submit" value="Add Directory" />\n';
		form += '						<input type="reset" value="Remove Selected Directories" />\n';
		form += '					</form>\n';

		form += '				</td>\n';
		form += '			</tr>\n';
		form += '		</tbody>\n';
		form += '	</table>\n';
		form += '</div>\n';


		//put the form
		this.write(this.top(),form,true,null);
	}
	this.addDir = function(form){
		//add to dir_bypass_select
		this.dirArr.push(form.dir.value);
		this.display();
	}
	this.remDir = function(form){
		var elm = document.getElementById('dir_bypass_select');
		for(var i=0;i<elm.length;i++){
			if(elm[i].selected){
				//remove it from this.dirArr
				for(var j=0;j<this.dirArr.length;j++){
					if(this.dirArr[j]==elm[i].value){
						break;
					}
				}
				this.dirArr.splice(j,1);
			}
		}
		if(!this.dirArr.length){
			this.dirArr = Array('No Directory Bypasses Created');
		}
		this.display();
	}
	this.add_and = function(or_num, and_num, variable, value){
		//set OR, AND or null based on input
		prefix = or_num>0 ? '<b>OR</b>' : '';
		prefix = and_num>0 ? '<b>AND</b>' : prefix;
		//returns an AND div for the OR div like this...
		//	AND variable ___ must equal ___		(add an AND)
		return '<div id="or'+or_num+'_and'+and_num+'" class="sl_and_box">'+prefix+' variable <input type="text" value="'+variable+'" onkeyup="this.value=sl_wizard.filter(this.value)" /> must equal <input type="text" value="'+value+'" onkeyup="this.value=sl_wizard.filter(this.value)" /> <a href="javascript:void(0)" onclick="sl_wizard.new_and('+or_num+');return false;">(add AND)</a></div>';
	}
	this.new_and = function(or_num){
		//find how many inputs are under the given or
		and_num = (document.getElementById('or'+or_num).getElementsByTagName('input').length) / 2;
		this.write(document.getElementById('or'+or_num),this.add_and(or_num,and_num,'',''),false);
	}
	this.new_or = function(){
		//finds where to put the next or and puts it w/ correct numbers
		or_num = 0;
		while(elm = document.getElementById('or'+or_num)){or_num++;}
		str = '<div id="or'+or_num+'" class="sl_or_box">'+this.add_and(or_num,0, '', '')+'</div>';
		this.write(this.top(),str,false);
	}
	this.save = function(button){
		button.value = 'Please Wait...';
		this.button = button;
		/*
		send post data like...
		sl_bp_arr[]=var^val&sl_bp_arr[]=var^val|var^val|var^val&sl_bp_arr[]=var^val
		*/
		bypass_string = '';
		or_num = 0;
		//check all fields and if one is left blank it will be omitted
		while(elm = document.getElementById('or'+or_num)){
			inputs = elm.getElementsByTagName('input');
			//loop through inputs (2 at a time) and add the non-empty vals
			bypass_string += '&sl_bp_arr[]=';
			for(i=0;i<inputs.length;i+=2){
				variable = inputs[i].value;
				value = inputs[i+1].value;
				if(variable.length>0 && value.length>0){
					bypass_string += variable+'^'+value;
					if(inputs[i+2] && inputs[i+3] && inputs[i+2].value.length>0 && inputs[i+3].value.length>0){
						bypass_string += '|';
					}
				}
			}
			or_num++;
		}

		// dir_bypass_select
		for(var i=0;i<this.dirArr.length;i++){
			bypass_string += '&sl_dir_arr[]='+escape(this.dirArr[i]);
		}



		params = 'sl_page=ajax&what=edit_bypass'+bypass_string;
		if(this.ajax){
			this.ajax.abort();
        }
        this.ajax = new XMLHttpRequest();
        this.ajax.onreadystatechange = this.save_resp.bind(this);
        this.ajax.open("POST", sl_url+'/sl_admin.php', true);
        this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        this.ajax.setRequestHeader("Content-length", params.length);
        this.ajax.setRequestHeader("Connection", "close");
        this.ajax.send(params);
	}
	this.save_resp = function(){
		if(this.ajax.readyState==4 && this.ajax.status==200){
			this.button.value = 'Save Bypass';
			
			if(this.ajax.responseText=='1'){
				sl_gateway.refresh('acct_form');
			} else {
				alert('Your settings could not be saved because of a write error. The server said:\n'+this.ajax.responseText);
			}
        }
	}
	this.filter = function(txt){
		ok = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_^|/.+~- @&=';
		clean = '';
		for(x=0;x<txt.length;x++){
			if(ok.indexOf(txt.charAt(x))>-1){
				clean += txt.charAt(x);
			}
		}
		return clean;
	}
	this.start = function(page){
		//starts the wizard
		if(page==1){
			str = '<b>What is the Post XSS filter?</b><br/>';
			str += '&nbsp;&nbsp;&nbsp;&nbsp;This filter will strip coding from the POST method of sending data to your website, such as PHP, HTML, and Javascript. This will prevent many of the most dangerous attacks, but can also interfere with website editing (such as article editing from the front of your website for Joomla users).<br/><br/>';
			str += '<b>What is the bypass editor?</b><br/>';
			str += '&nbsp;&nbsp;&nbsp;&nbsp;This editor will allow you to create a secure way of bypassing this XSS filter. Do not bypass the XSS filter unless you are sure that this is the cause of your problem. If you are not experiencing any problems, please do not use this feature.<br/><br/>';
			str += '<div><a href="javascript:void(0);" onclick="sl_wizard.start(2);return false;" style="float:right;">NEXT</a></div><br/><br/>';
			write(document.getElementById('sl_bypass_wizard_container'),str,true,null,false);
		}
		else if(page==2){
			str = '<b>What information do I need?</b><br/>';
			str += '&nbsp;&nbsp;&nbsp;&nbsp;In order to bypass the Post XSS Filter, you will need some consistent information. This information being the POST variable names being sent to the page you want to bypass, and their expected values. For example, in Joomla, article edits are sent with the variable "option" being set to "com_content"<br/><br/>';
			str += '<b>How can I make sure this only bypasses the pages I want?</b><br/>';
			str += '&nbsp;&nbsp;&nbsp;&nbsp;This is a VERY important question. In the last example, we mentioned "option=com_content". Adding this to the bypass editor would bypass the XSS Filter on almost every page, so we need to find something else we can use. The ideal situation is to add a custom field to your forms that contains a password that you must enter. If the password is omitted or wrong, the XSS Filter will protect you.<br/><br/>';
			str += '<div><a href="javascript:void(0);" onclick="sl_wizard.start(1);return false;" style="float:left;">BACK</a><a href="javascript:void(0);" onclick="sl_wizard.start(3);return false;" style="float:right;">NEXT</a></div><br/><br/>';
			write(document.getElementById('sl_bypass_wizard_container'),str,true,null,false);
		}
		else if(page==3){
			str = '<b>How do I use the Bypass Editor?</b><br/>';
			str += '&nbsp;&nbsp;&nbsp;&nbsp;The bypass function is designed so that you can use programming logic to bypass. This means that you can establish as many conditions for bypassing as you wish. If you want to require 10 passwords or a single password, it can be done very easily. You will be started with a single, blank variable and value pair that you must complete. If you would like to require more than this single variable-value pair, you can click on "add an AND" to require another match for the bypass to be valid.<br/><br/>';
			str += '<b>How do I create more conditions for bypassing?</b><br/>';
			str += '&nbsp;&nbsp;&nbsp;&nbsp;As you have just learned, you can require a single match or multiple matches. But what if you need to bypass many different pages? This is where the "add an OR" button comes in. With this, you will be given a new variable-value pair to complete, which can have AND statements of its own. This means you could easily say:<br/>"page" must equal "home" AND "password" must equal "mypass"<br/>OR "page" must equal "protected_area".<br/><br/>';
			str += '<b>How do I begin?</b><br/>';
			str += '&nbsp;&nbsp;&nbsp;&nbsp;When you have decided that you need to bypass the XSS Filter, and you have the needed data, press NEXT to go to the editor. You will have a blank slate to create your conditions. Please use caution so that you do not accidently disable the XSS Filter on vulnerable pages.<br/><br/>';
			str += '<div><a href="javascript:void(0);" onclick="sl_wizard.start(2);return false;" style="float:left;">BACK</a><a href="javascript:void(0);" onclick="sl_wizard.start(4);return false;" style="float:right;">NEXT</a></div><br/><br/>';
			write(document.getElementById('sl_bypass_wizard_container'),str,true,null,false);
		}
		else if(page==4){
			if(!this.arr){
				this.arr = Array(Array('',''));
			}
			if(!this.dirArr){
				this.dirArr = Array('No Directory Bypasses Created');
			}
			str = '<div>You have established the following bypasses: (to remove something, leave it blank and click Save Bypass, or <a href="javascript:void(0)" onclick="sl_wizard.display();return false;">click to reset</a>)<a href="javascript:void(0)" onclick="sl_wizard.new_or();return false;" style="float:right">Add an OR statement</a></div><br/>';
			str += '<div id="sl_bypass_wizard"></div><br/>';
	        str += '<input type="button" value="Save Bypass" onclick="sl_wizard.save(this)" /> (this does not save anything you may have modified in your account or program settings)';
	        str += '<br/><br/>Or you can <a href="javascript:void(0)" onclick="sl_wizard.start(1);return false;">click here to start the wizard.</a>';

			write(document.getElementById('sl_bypass_wizard_container'),str,true,null,false);

			this.display();
		}
	}
}
function sl_memos(){
	this.dnum = 10;
    this.toggle = function(id){
		if(jQuery('#'+id).css('display')!='table-row'){
			jQuery('#'+id).css('display','table-row');
		} else {
			jQuery('#'+id).css('display','none');
		}
    }
    this.ajax = null;
    this.get_resp = function(){
		if(this.ajax.readyState==4 && this.ajax.status==200){
            this.write(document.getElementById('please_wait'), '', true, null, false);
            this.write(document.getElementById('stats_div'), this.ajax.responseText, true, null, false);
        }
    }
    this.get = function(what, where, back){
        //what = inbox, outbox, thread, trash, new
        if(!this.ajax || this.ajax.readyState==4){
            params = 'sl_page=ajax&what='+what;
            if(where){
            	temp = where.indexOf('^')>-1 ? where.split('^') : Array(where);
            	for(i=0;i<temp.length;i++){
            		temp2 = temp[i].split('~');
					params += '&'+temp2[0]+'='+temp2[1];
            	}
            }
            if(back){
				params += '&back='+back;
            }
            this.write(document.getElementById('please_wait'), 'please wait...', true, null, false);
            this.ajax = new XMLHttpRequest();
            this.ajax.onreadystatechange = this.get_resp.bind(this);
            this.ajax.open("POST", sl_url+'/sl_admin.php', true);
            this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            this.ajax.setRequestHeader("Content-length", params.length);
            this.ajax.setRequestHeader("Connection", "close");
            this.ajax.send(params);
        }
    }
    this.send_resp = function(){
    	if(this.ajax.readyState==4 && this.ajax.status==200){
    		if(this.ajax.responseText=='true'){
    			/*
				if(document.getElementById('refresh_tickets')){
                    this.write(document.getElementById('please_wait'), '', true, null, false);
					code = document.getElementById('refresh_tickets').value;
					eval('memos.'+code);
				} else {
					alert('refresh command missing...');
				}
				*/
				sl_gateway.refresh();
			} else {
				alert(this.ajax.responseText);
                this.write(document.getElementById('please_wait'), '', true, null, false);
			}
		}
    }
    this.send = function(action, data){
        //what = ajax
        //action = add, mod, del
        //data = id^set/toggle^field^val
        if(!this.ajax || this.ajax.readyState==4){
            params = 'sl_page=ajax&what=ajax&action='+action+'&data='+data;
            this.write(document.getElementById('please_wait'), 'please wait...', true, null, false);
            this.ajax = new XMLHttpRequest();
            this.ajax.onreadystatechange = this.send_resp.bind(this);
            this.ajax.open("POST", sl_url+'/sl_admin.php', true);
            this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            this.ajax.setRequestHeader("Content-length", params.length);
            this.ajax.setRequestHeader("Connection", "close");
            this.ajax.send(params);
        }
    }

    this.remove_selected = function(where){
		ids = Array();
    	i=0;
    	while(elm = document.getElementById('remove_'+i++) || i<this.dnum){
			if(elm && elm.checked){
				ids.push(elm.value);
			}
    	}
    	// CONFIRM REMOVAL
    	if(ids.length > 0){
            txt = ids.length > 1 ? 'messages' : 'message';
            check = confirm('Do you want to remove the '+ids.length+' selected '+txt+'?');
			if(check){
				memos.send('remove', ids.join('~'));
			}
    	}
    	else {
			alert('You did not select anything you can remove.');
    	}
    }
    this.restore_selected = function(where){
    	ids = Array();
    	i=0;
    	while(elm = document.getElementById('restore_'+i++) || i<this.dnum){
			if(elm && elm.checked){
				ids.push(elm.value);
			}
    	}
    	// CONFIRM RESTORATION
    	if(ids.length > 0){
    		txt = ids.length > 1 ? 'messages' : 'message';
			check = confirm('Do you want to restore the '+ids.length+' selected trashed '+txt+'?');
			if(check){
				memos.send('restore', ids.join('~'));
			}
    	}
    	else {
			alert('You did not select anything you can restore.');
    	}
    }

    this.new_memo = function(domain, subject, replyID, urgency, back){
    	domain = domain || '';
    	if(subject){
			memos.get('new','domain~'+domain+'^subject~'+subject+'^replyID~'+replyID+'^urgency~'+urgency, back);
    	} else {
			memos.get('new','domain~'+domain, back);
    	}
    }
    this.save_new_memo = function(form){
        urgency = form.urgency.value;
        subject = form.subject.value;
        message = form.message.value;
        replyID = form.replyID.value;
        arr = Array(urgency,subject,message,replyID);
        for(i=0;i<arr.length;i++){
            while(arr[i].indexOf('&')>-1){
                arr[i] = arr[i].replace('&','#sl_amp#');
            }
        }
		data = '&urgency='+arr[0];
		data += '&subject='+arr[1];
		data += '&message='+arr[2];
		data += '&replyID='+arr[3];
		this.send('add',data);
		return false;
    }

    this.forward_resp = function(){
		if(this.ajax.readyState==4 && this.ajax.status==200){
			this.write(document.getElementById('please_wait'), '', true, null, false);
    		alert(this.ajax.responseText);
		}
    }
    this.forward = function(id){
		to = prompt('Please enter the email address you would like to forward this ticket to.\nAll previous messages will be attached if possible.\nSeparate multiple emails by a comma.');
		if(to){
			to = to.replace(' ','');
			to2 = to.indexOf(',')>-1 ? to.split(',') : Array(to);
			email_ok = true;
			filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
			for(i=0;i<to2.length;i++){
				if(!filter.test(to2[i]) || to.indexOf('&')>-1){
					email_ok = false;
				}
			}
			if(!email_ok){
				alert(to+' is invalid!');
			} else {
				if(!this.ajax || this.ajax.readyState==4){
		            params = 'sl_page=ajax&what=forward&id='+parseInt(id)+'&to='+to;
		            this.write(document.getElementById('please_wait'), 'please wait...', true, null, false);
		            this.ajax = new XMLHttpRequest();
		            this.ajax.onreadystatechange = this.forward_resp.bind(this);
		            this.ajax.open("POST", sl_url+'/sl_admin.php', true);
		            this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		            this.ajax.setRequestHeader("Content-length", params.length);
		            this.ajax.setRequestHeader("Connection", "close");
		            this.ajax.send(params);
		        } else {
					alert('Ticket ajax is busy. Try again.');
		        }
			}
		}
    }

    this.write = function(elm, what, clear_first, style, prepend){
        if(clear_first){
            while(elm.childNodes[0]){
                elm.removeChild(elm.childNodes[0]);
            }
        }
        newdiv = document.createElement('div');
        if(style){
            if(style.indexOf('^') > -1){
                arr = style.split('^');
                for(w=0;w<arr.length;w++){
                    temp = arr[w].split('=');
                    newdiv.setAttribute(temp[0], temp[1]);
                }
            } else {
                temp = style.split('=');
                newdiv.setAttribute(temp[0], temp[1]);
            }
        }
        newdiv.innerHTML = what;
        if(prepend){
            elm.insertBefore(newdiv,elm.firstChild);
        } else {
            elm.appendChild(newdiv);
        }
    }
    this.add_menu = function(name, id, erase, style){
        if(!style){
            style = "style=display:inline;";
        }
        this.write(document.getElementById('portal_menu'), name, erase, style, false);

        //check for trashed messages (set restore image)
        if(document.getElementById('restore_selected_memos_img')){
			hide_restore = true;
			i=0;
    		while(document.getElementById('restore_'+i) || i<memos.dnum){
				if(document.getElementById('restore_'+i)){
					hide_restore = false;
				}
				i++;
    		}
			if(!hide_restore){
				document.getElementById('restore_selected_memos_img').style.opacity = 1;
				if(document.getElementById('restore_selected_memos_img').style.filters){
					document.getElementById('restore_selected_memos_img').style.filters.alpha.opacity = 100;
				}
			} else {
				document.getElementById('restore_selected_memos_img').style.opacity = 0.4;
				if(document.getElementById('restore_selected_memos_img').style.filters){
					document.getElementById('restore_selected_memos_img').style.filters.alpha.opacity = 40;
				}
			}
        }
    }
}
function MemoSlider(){
	this.slide = null;
	this.home = function(){
		elm = document.getElementById('reply_container');
		width = document.getElementById('memo_shift').value;
		elm.style.left = '0px';
	}
	this.prev = function(){
		//add to left
		elm = document.getElementById('reply_container');
		width = document.getElementById('memo_shift').value;
		if(parseInt(elm.style.left)<=-895){
			elm.style.left = (parseInt(elm.style.left)+895)+'px';
		}
	}
	this.next = function(){
		//subtract from left
		elm = document.getElementById('reply_container');
		width = document.getElementById('memo_shift').value;
		if(parseInt(elm.style.left)>0-width){
			elm.style.left = (parseInt(elm.style.left)-895)+'px';
		}
	}
}

function sl_clear_header_classes(){
	jQuery('#sl_scorecard_menulink').removeClass('setMenuHover');
	jQuery('#sl_overview_menulink').removeClass('setMenuHover');
	jQuery('#sl_tools_menulink').removeClass('setMenuHover');
	jQuery('#sl_stats_menulink').removeClass('setMenuHover');
	jQuery('#sl_attacklog_menulink').removeClass('setMenuHover');
	jQuery('#sl_diagnostics_menulink').removeClass('setMenuHover');
	jQuery('#sl_tickets_menulink').removeClass('setMenuHover');
	jQuery('#sl_addons_menulink').removeClass('setMenuHover');
	jQuery('#sl_help_menulink').removeClass('setMenuHover');
}
function sl_Attacks_toggleSelectAll(sender){
	var elms = document.getElementsByName("selected_attacks[]");
	for(var i = 0; i < elms.length; i++)
		elms[i].checked = sender.checked;
}

memoAlert = {
	animate:function(){
		this.anim_dir = 'down';
	    this.num = 3;
	    if(this.int){
			clearInterval(this.int);
	    }
	    this.int = setInterval("memoAlert.move()",70);
	    this.div().style.top = '0px';
	},
	div:function(){
		return document.getElementById('animate');
	},
	move:function(){
		if(!this.div()){return null;}
		cur = parseInt(this.div().style.top);
	    if(this.anim_dir=='down'){
	        if(cur >= 5){
	            this.anim_dir = 'up';
	            this.num = -3;
	        } else if(cur <= -5){
				this.anim_dir = 'down';
	            this.num = 3;
	        }
	        this.div().style.top = (cur + this.num--) + 'px';
	    } else if(this.anim_dir=='up'){
	        if(cur <= -5){
	            this.anim_dir = 'down';
	            this.num = 3;
	        } else if(cur >= 5){
				this.anim_dir = 'up';
	            this.num = -3;
	        }
	        this.div().style.top = (cur + this.num++) + 'px';
	    }
	}
}
Validator = {
	ajax:null,
	div:function(){
		return document.getElementById('validator_output');
	},
	text:function(){
		return document.getElementById('sl_text').value;
	},
	validate:function(){
		if(empty(this.text())){
			alert('You have not entered anything to validate.');
		} else {
			if(this.ajax){
        		this.ajax.abort();
			}
	        params = 'sl_page=validator&text='+escape(this.text());
	        write(this.div(), 'please wait...<br/><br/>', false, null, true);
	        this.ajax = new XMLHttpRequest();
	        this.ajax.onreadystatechange = this.validateResp.bind(this);
	        this.ajax.open("POST", sl_url+'/inc/helper.php', true);
	        this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	        this.ajax.setRequestHeader("Content-length", params.length);
	        this.ajax.setRequestHeader("Connection", "close");
	        this.ajax.send(params);
		}
	},
	validateResp:function(){
		if(this.ajax.readyState==4 && this.ajax.status==200){
            str = 'Results:<br/><br/>'+this.ajax.responseText+'<br/><br/>';
            write(this.div(),str,true,null,false);
        }
	}
}
SL_Test = {
	ajax:null,
	button:null,
	div:function(){
		return document.getElementById('sl_test_output');
	},
	test:function(elm){
		elm.value = 'Testing...';
		this.button = elm;
		if(this.ajax){
        	this.ajax.abort();
		}
	    this.ajax = new XMLHttpRequest();
	    this.ajax.onreadystatechange = this.testResp.bind(this);
	    this.ajax.open("GET", sl_url+'/sl_admin.php?xsecurelivex', true);
	    this.ajax.send(null);
	},
	testResp:function(){
		if(this.ajax.readyState==4){
			if(this.ajax.status==404){
				str = '<b>Success!</b> You are currently protected. You should verify that you now have an email report of this test. If not, add securemember@securelive.net to your contacts and try again. If you still do not get any reports, contact your hosting provider for assistance getting your server email to send.';
			} else {
				str = '<b>Failure!</b> But you may still be protected. You should verify that you now have an email report of this test. If you have the report, you are protected. If not, there are many factors that could make this test fail:<br/><br/>';
				str += '1) This button tests your home page. Is SecureLive installed on your public_html directory? If not, navigate to your site and add the querystring "?xsecurelivex" to your page URL and see if you are blocked and get a report.<br/><br/>';
				str += '2) Is your homepage an HTML page? HTML is not scanned because HTML does not take any dynamic input. Try the test (?xsecurelivex) on a dynamic (PHP) page<br/><br/>';
				str += '3) Is the plugin enabled? Double check to verify that your plugin is turned on and try the test again.<br/><br/>';
				str += '4) Do you have a custom 404 page set that does not send a 404 header? This test button looks for a 404 header, as this will deter many malicious scripts from trying again.<br/><br/>';
				str += '5) Does the Account verification show that you are active and using the latest version?<br/><br/>';
				str += 'If you are unable to get the test trigger report, and have verified with your host that your emails are working properly, contact us for assistance at 888-300-4546 or support@securelive.net .';
			}
			this.button.value = 'Click to Test';
            write(this.div(),str,true,null,false);
        }
	}
}
SL_Tutorial = {
	ajax:null,
	div:function(){return document.getElementById('tutorial_output');},
	div_inner:function(){return document.getElementById('tutorial_output_inner');},
	start:function(tcode){
		if(tcode=='u'){
			video = '<iframe src="http://player.vimeo.com/video/14215025?title=0&amp;byline=0&amp;portrait=0" width="679" height="384" frameborder="0"></iframe>';
		} else {
			video = '<iframe src="http://player.vimeo.com/video/14210954?title=0&amp;byline=0&amp;portrait=0" width="679" height="384" frameborder="0"></iframe>';
		}
		str = video+'<br/><br/><div width="100%"><a style="float:left;" href="javascript:void(0)" onclick="SL_Tutorial.addCookie();return false;">Close and show on next visit</a><a style="float:right;" href="javascript:void(0)" onclick="SL_Tutorial.turnOff();return false;">Close and disable tutorial</a></div><br/><br/>(you can view the tutorials at any time under the Help section)';
		this.div().style.display = 'block';
		write(this.div_inner(),str,true,null,false);
	},
	addCookie:function(){
		document.cookie = 'sl_tutorial=hide;';
		/*while(this.div().childNodes[8]){
			this.div().removeChild(this.div().childNodes[8]);
		}*/
		this.div().style.display = 'none';
	},
	removeCookie:function(){
		document.cookie = 'sl_tutorial=show;';
		/*while(this.div().childNodes[8]){
			this.div().removeChild(this.div().childNodes[8]);
		}*/
		this.div().style.display = 'none';
	},
	turnOff:function(){
        params = 'sl_page=ajax&what=tutorial&which=off';
        this.ajax = new XMLHttpRequest();
        this.ajax.onreadystatechange = this.resp.bind(this);
        this.ajax.open("POST", sl_url+'/sl_admin.php', true);
        this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        this.ajax.setRequestHeader("Content-length", params.length);
        this.ajax.setRequestHeader("Connection", "close");
        this.ajax.send(params);
	},
	turnOn:function(){
		params = 'sl_page=ajax&what=tutorial&which=on';
        this.ajax = new XMLHttpRequest();
        this.ajax.onreadystatechange = this.resp.bind(this);
        this.ajax.open("POST", sl_url+'/sl_admin.php', true);
        this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        this.ajax.setRequestHeader("Content-length", params.length);
        this.ajax.setRequestHeader("Connection", "close");
        this.ajax.send(params);
	},
    resp:function(){
        if(this.ajax.readyState==4 && this.ajax.status==200){
            alert(this.ajax.responseText);
            /*while(this.div().childNodes[8]){
				this.div().removeChild(this.div().childNodes[8]);
			}*/
            this.div().style.display = 'none';
        }
    }
}
base64 = {
	_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
	encode : function (input) {
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;

		input = this._utf8_encode(input);

		while (i < input.length) {

			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);

			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;

			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}

			output = output +
			this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
			this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

		}

		return output;
	},
	decode : function (input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;

		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

		while (i < input.length) {

			enc1 = this._keyStr.indexOf(input.charAt(i++));
			enc2 = this._keyStr.indexOf(input.charAt(i++));
			enc3 = this._keyStr.indexOf(input.charAt(i++));
			enc4 = this._keyStr.indexOf(input.charAt(i++));

			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;

			output = output + String.fromCharCode(chr1);

			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}

		}

		output = this._utf8_decode(output);

		return output;

	},
	_utf8_encode : function (string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";

		for (var n = 0; n < string.length; n++) {

			var c = string.charCodeAt(n);

			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}

		}

		return utftext;
	},
	_utf8_decode : function (utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;

		while ( i < utftext.length ) {

			c = utftext.charCodeAt(i);

			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			}
			else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			}
			else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}

		}

		return string;
	}
}
SL_Scanner = {
	//vars
	excludeList:null,
	docRoot:null,
	lastScan:null,
	rootContents:null,
	ajax:null,
	ajaxElmHolder:null,
	malDirs:Array(),
	malFiles:Array(),
	malTerms:Array(),
	customTerms:Array(),
	currentFile:null,
	totalScanned:0,
	dirsOpened:1,
	startTime:null,
	malInt:null,
	ajaxObj:{},
	fileAjax:null,
	openedFile:null,
	paused:false,
	pausedFile:null,
	pausedTime:null,
	fileCount:0,
	dirCount:0,
	fileCountAjax:null,
	scanAfterCountUpdate:false,
	base64Ajax:null,
	base64Results:'',
	base64Text:'',
	pageBody:null,
	simulscan:null,
	tmp:null,
	safeFiles:Array(),
	standAlone:true,

	//shared
	showMenu:function(ok, lastscan, root, rootContents, exclude, scanner){
		scanner = scanner || '';
		if(ok=='unwritableFile'){
			//file exists but is not writable
			msg = 'This error happens when the file "sl_scan_helper.php" already exists in the folder "'+root+'" without proper file permissions. These permissions could be caused by the ownership of the file, or its permission value. If you have suPHP running, the file permission should be 755 with your username as the owner and group. If you are not running suPHP, then the file permission should be 777, although this will make the file writeable by anyone with any credentials, which is a very large security risk. Once you have changed the file to 777 and made the changes necessary please change the file back to 644.';
			write(this.div(),msg,true,null,false);
		}
		else if(ok=='unwritableFolder'){
			//folder exists but is not writable
			msg = 'This error happens when trying to write the file "sl_scan_helper.php" in the folder "'+root+'" without proper folder permissions. These permissions could be caused by the ownership of the file, or its permission value. If you have suPHP running the folder permission should be 755 with your username as the owner and group. If you are not running suPHP, then the folder permission should be 777, although this will make the folder writeable by anyone with any credentials this is a very large security risk. Once you have changed the folder to 777 and made the changes necessary please change the folder back to 755.';
			write(this.div(),msg,true,null,false);
		}
		else if(ok=='ok'){
			//file is created and writable
			this.docRoot = root;
			this.lastScan = lastscan;
			this.excludeList = exclude.indexOf("|")>-1 ? exclude.split("|") : (empty(exclude) ? Array() : Array(exclude));
			this.rootContents = rootContents.indexOf("|")>-1 ? rootContents.split("|") : (empty(rootContents) ? Array() : Array(rootContents));

			this.standAlone = document.getElementById('sl_view_reports') ? true : false;

			if(scanner=='timeScan'){
				//time scan

				header = '<div style="display:inline;position:absolute;top:3px;"><span style="min-width:100px;_width:100px;display:inline-block;">Root Directory:</span><input id="scanner_root" type="text" value="'+this.docRoot+'" class="fancyInput" style="width:275px;" /></div> <img src="'+sl_url2+'images/changeDir.png" border="0" onclick="SL_Scanner.reset(this, \'val\')" style="cursor:pointer;margin-left:385px;" alt="Change Directory" title="Change Directory" /> <img src="'+sl_url2+'images/home.png" border="0" onclick="SL_Scanner.reset(this, \'doc_root\')" style="cursor:pointer;" alt="Reset Directory" title="Reset Directory" />';

				write(document.getElementById('headerBarStatus'),header,true,null,false);

				mainBody = '<h3 align="center">File Change Scanner</h3>';
				mainBody += '<table width="100%" style="font-size:14px;">';
				mainBody += '	<tr>';
				mainBody += '		<td width="60%" style="border-right:2px solid #ccc;" valign="top">';
				mainBody += '			'+this.rootDirTree();
				mainBody += '		</td>';
				mainBody += '		<td style="padding:10px" valign="top">';
				mainBody += '			<div><span style="float:left;">File Count <img id="file_count_img" src="'+sl_url2+'images/page_white_stack.png" border="0" /> <div id="file_count" style="display:inline;"></div></span><span style="float:right;">Folder Count <img id="dir_count_img" src="'+sl_url2+'images/navigate_down.png" border="0" /> <div id="dir_count" style="display:inline;"></div></span></div><br/><br/>';
				mainBody += '			<span style="min-width:130px;_width:130px;display:inline-block;">Last Scan:</span>'+this.lastScan+'<br/>';
				mainBody += '			<span style="min-width:130px;_width:130px;display:inline-block;">Email To:</span><input id="scanner_email" type="text" style="width:200px;" /><br/><br/>';
				mainBody += '			<table width="100%" style="font-size:14px;">';
				mainBody += '				<tr>';
				mainBody += '					<td width="40%" align="center"><img width="100px" src="'+sl_url2+'images/start.png" onclick="SL_Scanner.startFileScan()" border="0" alt="Click to Scan" title="Click to Scan" style="cursor:pointer;" /><div id="start_scan_text">Scan for File Changes</div></td>';
				mainBody += '					<td align="center">&nbsp;</td>';
				mainBody += '				</tr>';
				mainBody += '			</table><br/>';
				mainBody += '			<div id="more_info"></div>';
				mainBody += '		</td>';
				mainBody += '	</tr>';
				mainBody += '</table>';

				write(this.div(),mainBody,true,null,false);

			}
			else if(scanner=='nameScan'){
				//name scan
				this.excludeList = Array();

				header = '<div style="display:inline;position:absolute;top:3px;"><span style="min-width:100px;_width:100px;display:inline-block;">Root Directory:</span><input id="scanner_root" type="text" value="'+this.docRoot+'" class="fancyInput" style="width:275px;" /></div> <img src="'+sl_url2+'images/changeDir.png" border="0" onclick="SL_Scanner.reset(this, \'val\')" style="cursor:pointer;margin-left:385px;" alt="Change Directory" title="Change Directory" /> <img src="'+sl_url2+'images/home.png" border="0" onclick="SL_Scanner.reset(this, \'doc_root\')" style="cursor:pointer;" alt="Reset Directory" title="Reset Directory" />';

				write(document.getElementById('headerBarStatus'),header,true,null,false);

				mainBody = '<h3 align="center">File Name Scanner</h3>';
				mainBody += '<table width="100%" style="font-size:14px;">';
				mainBody += '	<tr>';
				mainBody += '		<td width="60%" style="border-right:2px solid #ccc;" valign="top">';
				mainBody += '			'+this.rootDirTree();
				mainBody += '		</td>';
				mainBody += '		<td style="padding:10px" valign="top">';
				mainBody += '			<div><span style="float:left;">File Count <img id="file_count_img" src="'+sl_url2+'images/page_white_stack.png" border="0" /> <div id="file_count" style="display:inline;"></div></span><span style="float:right;">Folder Count <img id="dir_count_img" src="'+sl_url2+'images/navigate_down.png" border="0" /> <div id="dir_count" style="display:inline;"></div></span></div><br/><br/>';
				mainBody += '			<table width="100%" style="font-size:14px;">';
				mainBody += '				<tr>';
				mainBody += '					<td width="40%" align="center"><img width="100px" src="'+sl_url2+'images/start.png" onclick="SL_Scanner.startNameScan()" border="0" alt="Click to Scan" title="Click to Scan" style="cursor:pointer;" /><div id="start_scan_text">Scan for File Names</div></td>';
				mainBody += '					<td align="center" valign="bottom"><img width="60px" src="'+sl_url2+'images/switch_on.png" vspace="20px" border="0" style="cursor:pointer;" onclick="SL_Scanner.toggleCustomOnly(this)" alt="Click to Toggle" title="Click to Toggle" /><br/><div id="customOnlyText">SecureLive Terms are ON</div><input type="hidden" value="0" id="only_custom_scan" /></td>';
				mainBody += '				</tr>';
				mainBody += '			</table><br/>';
				mainBody += '			<span style="min-width:130px;_width:130px;display:inline-block;font-size:12px;">File Name Search:</span><input id="custom_scan_0" type="input" /> <a href="javascript:void(0);" onclick="SL_Scanner.addCustomTerm();return false;" style="font-size:12px;">Add More</a><br/>';
				mainBody += '			<div id="more_custom_terms" style="padding-left:130px;"></div>';
				mainBody += '			<div id="more_info"></div>';
				mainBody += '		</td>';
				mainBody += '	</tr>';
				mainBody += '</table>';

				write(this.div(),mainBody,true,null,false);

			}
			else if(scanner=='dbScan'){
				//db scan
				mainBody = '<h3 align="center">Database Scanner</h3>';
				mainBody += '<table width="100%" style="font-size:14px;">';
				mainBody += '	<tr>';
				mainBody += '		<td colspan="2" align="center">Scan a database for specified terms. All fields are required.</td>';
				mainBody += '	</tr>';
				mainBody += '	<tr>';
				mainBody += '		<td width="40%" align="right" style="padding-right:10px;">';
				mainBody += '			<img width="100px" src="'+sl_url2+'images/start.png" onclick="SL_Scanner.startDBScan(document.getElementById(\'dbscanform\'))" border="0" alt="Click to Scan" title="Click to Scan" style="cursor:pointer;" /><div id="start_scan_text">Scan the Database</div></td>';
				mainBody += '		<td>';
				mainBody += '			<form id="dbscanform" action="#" method="post" onsubmit="return SL_Scanner.startDBScan(this)">';
				mainBody += '			<table>';
				mainBody += '				<tr>';
				mainBody += '					<td>Host: </td>';
				mainBody += '					<td><input name="host" type="text" value="localhost" style="width:200px;" /></td>';
				mainBody += '				</tr>';
				mainBody += '				<tr>';
				mainBody += '					<td>Database: </td>';
				mainBody += '					<td><input name="db" type="text" style="width:200px;" /></td>';
				mainBody += '				</tr>';
				mainBody += '				<tr>';
				mainBody += '					<td>User: </td>';
				mainBody += '					<td><input name="user" type="text" style="width:200px;" /></td>';
				mainBody += '				</tr>';
				mainBody += '				<tr>';
				mainBody += '					<td>Password: </td>';
				mainBody += '					<td><input name="pass" type="password" style="width:200px;" /></td>';
				mainBody += '				</tr>';
				mainBody += '			</table>';
				mainBody += '			</form>';
				mainBody += '		</td>';
				mainBody += '	</tr>';
				mainBody += '	<tr>';
				mainBody += '		<td>&nbsp;</td>';
				mainBody += '		<td>';
				mainBody += '			<span style="min-width:130px;_width:130px;display:inline-block;font-size:12px;">Find in Database:</span><input id="custom_scan_0" type="input" /> <a href="javascript:void(0);" onclick="SL_Scanner.addCustomTerm();return false;" style="font-size:12px;">Add More</a><br/>';
				mainBody += '			<div id="more_custom_terms" style="padding-left:130px;"></div>';
				mainBody += '		</td>';
				mainBody += '	</tr>';
				mainBody += '</table>';

				write(this.div(),mainBody,true,null,false);

			}
			else {
				//mal scan
				this.excludeList = Array();

				header = '<div style="display:inline;position:absolute;top:3px;"><span style="min-width:100px;_width:100px;display:inline-block;">Root Directory:</span><input id="scanner_root" type="text" value="'+this.docRoot+'" class="fancyInput" style="width:275px;" /></div> <img src="'+sl_url2+'images/changeDir.png" border="0" onclick="SL_Scanner.reset(this, \'val\')" style="cursor:pointer;margin-left:385px;" alt="Change Directory" title="Change Directory" /> <img src="'+sl_url2+'images/home.png" border="0" onclick="SL_Scanner.reset(this, \'doc_root\')" style="cursor:pointer;" alt="Reset Directory" title="Reset Directory" />';
				header += '<div style="position:absolute;padding:4px 270px 0 0;top:0px;right:-5px;">Simultaneous Files:';
				header += '		<div style="position: absolute;right:50px;top:-2px;">';
				header += '			<input disabled="disabled" type="text" style="color:black;width: 30px; font-size: 13px; position: absolute; top: 3px;right:-40px;border:none;background-color:transparent;" value="0" id="ss_slider_val">';
				header += '			<div class="sl_slider_holder" id="ss_slider_holder">';
				header += '				<div style="left: -5px;" class="sl_slider" id="ss_slider"></div>';
				header += '			</div>';
				header += '		</div>';
				header += '</div>';

				write(document.getElementById('headerBarStatus'),header,true,null,false);

				mainBody = '<h3 align="center">Malicious Code Scanner</h3>';
				mainBody += '<table width="100%" style="font-size:14px;">';
				mainBody += '	<tr>';
				mainBody += '		<td width="60%" style="border-right:2px solid #ccc;" valign="top">';
				mainBody += '			'+this.rootDirTree();
				mainBody += '		</td>';
				mainBody += '		<td style="padding:10px" valign="top">';
				mainBody += '			<div><span style="float:left;">File Count <img id="file_count_img" src="'+sl_url2+'images/page_white_stack.png" border="0" /> <div id="file_count" style="display:inline;"></div></span><span style="float:right;">Folder Count <img id="dir_count_img" src="'+sl_url2+'images/navigate_down.png" border="0" /> <div id="dir_count" style="display:inline;"></div></span></div><br/><br/>';
				mainBody += '			<table width="100%" style="font-size:14px;">';
				mainBody += '				<tr>';
				mainBody += '					<td width="40%" align="center"><img width="100px" src="'+sl_url2+'images/start.png" onclick="SL_Scanner.startMalScan()" border="0" alt="Click to Scan" title="Click to Scan" style="cursor:pointer;" /><div id="start_scan_text">Start Scan</div></td>';
				mainBody += '					<td align="center" valign="bottom"><img width="60px" src="'+sl_url2+'images/switch_on.png" vspace="20px" border="0" style="cursor:pointer;" onclick="SL_Scanner.toggleCustomOnly(this)" alt="Click to Toggle" title="Click to Toggle" /><br/><div id="customOnlyText">SecureLive Terms are ON</div><input type="hidden" value="0" id="only_custom_scan" /></td>';
				mainBody += '				</tr>';
				mainBody += '			</table><br/>';
				mainBody += '			<span style="min-width:130px;_width:130px;display:inline-block;font-size:12px;">Custom Scan Terms:</span><input id="custom_scan_0" type="input" /> <a href="javascript:void(0);" onclick="SL_Scanner.addCustomTerm();return false;" style="font-size:12px;">Add More</a><br/>';
				mainBody += '			<div id="more_custom_terms" style="padding-left:130px;"></div>';
				mainBody += '			<div id="more_info"></div>';
				mainBody += '		</td>';
				mainBody += '	</tr>';
				mainBody += '</table>';

				write(this.div(),mainBody,true,null,false);
				
				//cancel any window mouseups for any sliders before creating it
				jQuery(window).unbind('mouseup');
				this.simulscan = new sl_slider("ss", 1, 10, 2);
			}

			this.updateFileCount();
		}
	},
	div:function(){
		return document.getElementById('sl_scanner_output');
	},
	reset:function(img,where){
		this.tmp = img.src;
		this.ajaxElmHolder = img;
		img.src = sl_url2+'images/spinner24.gif';

		//ajax call to get dir contents
		if(where=='doc_root'){
			params = 'sl_page=ajax&what=new_dir_tree';
		} else {
			params = 'sl_page=ajax&what=new_dir_tree&where='+this.remTrailingSlash(document.getElementById('scanner_root').value);
		}
		if(this.ajax){
	       this.ajax.abort();
	    }
	    this.ajax = new XMLHttpRequest();
	    this.ajax.onreadystatechange = this.reset_resp.bind(this);
	    this.ajax.open("POST", sl_url3+'sl_scanner.php', true);
	    this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    this.ajax.setRequestHeader("Content-length", params.length);
	    this.ajax.setRequestHeader("Connection", "close");
	    this.ajax.send(params);
	},
	reset_resp:function(){
		if(this.ajax.readyState==4 && this.ajax.status==200){
			this.docRoot = this.remTrailingSlash(document.getElementById('scanner_root').value);
            resp = this.ajax.responseText;
            eval('SL_Scanner.'+resp);
		}
	},
	extensionOK:function(str){
		for(x=0;x<this.safeFiles.length;x++){
			ext = this.safeFiles[x];
			sub = str.substr(str.length-ext.length,ext.length).toLowerCase();
			if(sub==ext){
				this.totalScanned++;
				return false;
			}
		}
		return true;
	},
	remTrailingSlash:function(str){
		if(str.substr(str.length-1,1)=='/'){
			while(str.substr(str.length-1,1)=='/'){
				str = str.substr(0,str.length-1);
			}
		}
		return str;
	},
	closePopUp:function(){
		if(this.ajax){
	       this.ajax.abort();
	    }
		elm = document.getElementById('sl_popup');
		write(elm,'',true,null,false);
		elm.style.display = 'none';
	},
	rem:function(elm,num){
		if(num==1){
			elm.parentNode.parentNode.removeChild(elm.parentNode);
		}
		else if(num==2){
			remove = elm.parentNode.parentNode.parentNode;
			remove.parentNode.removeChild(remove);
		}
	},
	updateFileCount:function(){
		//put spinner
		if(document.getElementById('file_count_img') && document.getElementById('dir_count_img')){
			document.getElementById('file_count_img').src = sl_url2+'images/spinner.gif';
			document.getElementById('dir_count_img').src = sl_url2+'images/spinner.gif';
		}
		if(this.excludeList && this.excludeList.length > 0){
			params = 'sl_page=ajax&what=count_files&root='+this.docRoot+'&exclude='+this.excludeList.join("|");
		} else {
			params = 'sl_page=ajax&what=count_files&root='+this.docRoot;
		}
		if(this.fileCountAjax){
	       this.fileCountAjax.abort();
	    }
	    this.fileCountAjax = new XMLHttpRequest();
	    this.fileCountAjax.onreadystatechange = this.updateFileCountResp.bind(this);
	    this.fileCountAjax.open("POST", sl_url3+'sl_scanner.php', true);
	    this.fileCountAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    this.fileCountAjax.setRequestHeader("Content-length", params.length);
	    this.fileCountAjax.setRequestHeader("Connection", "close");
	    this.fileCountAjax.send(params);
	},
	updateFileCountResp:function(){
		if(this.fileCountAjax.readyState==4 && this.fileCountAjax.status==200){
            resp = this.fileCountAjax.responseText.split("|");
            badDirs = resp[0];
            this.fileCount = parseInt(resp[1]);
            this.dirCount = parseInt(resp[2])+1;//adding one for current dir

			if(badDirs!='' && document.getElementById('more_info')){
				write(document.getElementById('more_info'),'<br/><b>Unreadable Directories:</b><br/>'+badDirs,true,'style=font-size:13px;',false);
			}

            if(document.getElementById('file_count') && document.getElementById('dir_count')){
				write(document.getElementById('file_count'),this.fileCount,true,'style=display:inline;',false);
				write(document.getElementById('dir_count'),this.dirCount,true,'style=display:inline;',false);
            }
            //remove spinner
			if(document.getElementById('file_count_img') && document.getElementById('dir_count_img')){
				document.getElementById('file_count_img').src = sl_url2+'images/page_white_stack.png';
				document.getElementById('dir_count_img').src = sl_url2+'images/navigate_down.png';
			}
            this.fileCountAjax = null;
            if(this.scanAfterCountUpdate){
				this.startMalScan();
            }
		} else if(this.fileCountAjax.readyState==4){
			this.fileCountAjax = null;
		}
	},
	addCustomTerm:function(){
		count = 0;
		while(document.getElementById('custom_scan_'+(count+1))){
			count++;
		}
		str = '<input id="custom_scan_'+(count+1)+'" type="text" /> <img src="'+sl_url2+'images/delete2.png" border="0" onclick="SL_Scanner.remCustomTerm(this)" style="cursor:pointer;" alt="Remove" title="Remove" />';
		write(document.getElementById('more_custom_terms'),str,false,null,false);
	},
	remCustomTerm:function(img){
		img.parentNode.parentNode.removeChild(img.parentNode);
		//reassign ids
		parentDiv = document.getElementById('more_custom_terms');
		for(i=0;i<parentDiv.childNodes.length;i++){
			parentDiv.childNodes[i].childNodes[0].id = 'custom_scan_'+(i+1);
		}
	},
	urlReplace:function(insert){
		temp = insert.split('=');
		variable = temp[0];
		value = temp[1];
		now = location.href;
		if(now.indexOf(variable+'=')==-1){
			//add it
			if(now.indexOf('?')==-1){
				return now+'?'+variable+'='+value;
			} else {
				return now+'&'+variable+'='+value;
			}
		} else {
			//replace it
			begin = now.indexOf(variable+'=');
			if(now.indexOf('&',begin)==-1){
				return now.substr(0,begin)+variable+'='+value;
			} else {
				end = now.indexOf('&',begin);
				return now.substr(0,begin)+variable+'='+value+now.substr(end);
			}
		}
	},
	goTo:function(loc){
		//see if scan running - not anymore, gateway does it
		sl_gateway.open('tools',loc);
	},
	toggleCustomOnly:function(img){
		if(document.getElementById('only_custom_scan').value == 1){
			document.getElementById('only_custom_scan').value = 0;
			img.src = sl_url2+'images/switch_on.png';
			str = 'SecureLive Terms are ON';
		} else {
			document.getElementById('only_custom_scan').value = 1;
			img.src = sl_url2+'images/switch_off.png';
			str = 'SecureLive Terms are OFF';
		}
		write(document.getElementById('customOnlyText'),str,true,null,false);
	},
	openFile:function(file,line){
		this.openedFile = file;
		//do ajax
		if(this.fileAjax){
	       this.fileAjax.abort();
	    }
	    params = 'sl_page=ajax&what=file_editor&action=open&file='+escape(file);
	    if(line){
			params += '&line='+line;
	    }
	    this.fileAjax = new XMLHttpRequest();
	    this.fileAjax.onreadystatechange = this.openFileResp.bind(this);
	    this.fileAjax.open("POST", sl_url3+'sl_scanner.php', true);
	    this.fileAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    this.fileAjax.setRequestHeader("Content-length", params.length);
	    this.fileAjax.setRequestHeader("Connection", "close");
	    this.fileAjax.send(params);
	},
	openFileResp:function(){
		if(this.fileAjax.readyState==4 && this.fileAjax.status==200){
			str = '<div class="tl_shadow"></div>';
			str += '<div class="t_shadow"></div>';
			str += '<div class="tr_shadow"></div>';
			str += '<div class="r_shadow"></div>';
			str += '<div class="br_shadow"></div>';
			str += '<div class="b_shadow"></div>';
			str += '<div class="bl_shadow"></div>';
			str += '<div class="l_shadow"></div>';
			str += '<div id="edit_container_header"></div>';
			response = str+this.fileAjax.responseText;
			elm = document.getElementById('sl_popup');
			elm.style.display = 'block';
			write(elm,response,true,'class=shadow_div',false);
			header = 'File: '+this.openedFile+'<a href="javascript:void(0);" onclick="SL_Scanner.closePopUp();return false;" style="float:right;">Close</a>';
			write(document.getElementById('edit_container_header'),header,true,null,false);
		}
	},

	//dir tree
	rootDirTree:function(){
		tree = '<div id="'+this.docRoot+'" style="overflow-x:auto;width:520px;">';
		for(i=0;i<this.rootContents.length;i++){
			dir = this.rootContents[i].replace(this.docRoot,'');
			if(in_array(this.excludeList,this.rootContents[i].replace(this.docRoot,''),true) && !in_array(this.excludeList,this.rootContents[i].replace(this.docRoot,''),false)){
				//something under this dir is excluded
				scanIMG = 'half.png';//determines image
			} else if(in_array(this.excludeList,this.rootContents[i].replace(this.docRoot,''),false)){
				//this directory is excluded along with everything below it
				scanIMG = 'empty.png';
			} else {
				//this and all subdirectories are to be scanned
				scanIMG = 'full.png';
			}
			tree += '<div id="'+this.rootContents[i]+'" class="tree">';
			tree += '<img src="'+sl_url2+'images/navigate_right.png" border="0" style="cursor:pointer;" onclick="SL_Scanner.openOrCloseDiv(this);stopPropagation(event);" />';
			tree += '<img src="'+sl_url2+'images/'+scanIMG+'" border="0" style="cursor:pointer;" onclick="SL_Scanner.toggleExcluded(this);stopPropagation(event);" />';
			tree += '<span style="position:absolute;padding:1px 0 0 5px; font-size: 13px; color: blue;cursor:pointer;font-weight: bold;" onclick="SL_Scanner.openOrCloseDiv(this.parentNode.childNodes[0]);">'+dir.replace('/','')+'</span>';
			tree += '</div>';

		}
		tree += '</div>';
		tree += '<br/><div><a href="javascript:void(0);" onclick="SL_Scanner.select(\'all\');return false;">Select All</a> | <a href="javascript:void(0);" onclick="SL_Scanner.select(\'none\');return false;">Select None</a></div>';
		return tree;
	},
	openOrCloseDiv:function(img){
		closing = (img.src.indexOf('navigate_down.png')==-1) ? false : true;
		if(closing){
			//simply delete dir div contents
			elm = img.parentNode;
			while(elm.childNodes[3]){
				elm.removeChild(elm.childNodes[3]);
			}
			//swap image
			closedIMG = sl_url2+'images/navigate_right.png';
			img.src = closedIMG;
		} else {
			//loading image
			img.src = sl_url2+'images/spinner.gif';
			//do ajax call to get dir contents
			this.ajaxElmHolder = img;
			where = img.parentNode.id;//dir to get
			params = 'sl_page=ajax&what=dir_tree&where='+where;
			if(this.ajax){
	           this.ajax.abort();
	        }
	        this.ajax = new XMLHttpRequest();
	        this.ajax.onreadystatechange = this.openDivResponse.bind(this);
	        this.ajax.open("POST", sl_url3+'sl_scanner.php', true);
	        this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	        this.ajax.setRequestHeader("Content-length", params.length);
	        this.ajax.setRequestHeader("Connection", "close");
	        this.ajax.send(params);
		}
	},
	openDivResponse:function(){
		//if got dir contents, put the content and swap image
		if(this.ajax.readyState==4 && this.ajax.status==200){
            resp = this.ajax.responseText;
            dirContents = resp.indexOf("|")>-1 ? resp.split("|") : (empty(resp) ? Array() : Array(resp));
            for(i=0;i<dirContents.length;i++){
            	put = '';
				dir = dirContents[i].replace(this.ajaxElmHolder.parentNode.id,'');
				if(in_array(this.excludeList,dirContents[i].replace(this.docRoot,''),true) && !in_array(this.excludeList,dirContents[i].replace(this.docRoot,''),false)){
					//something under this dir is excluded
					scanIMG = 'half.png';//determines image
				} else if(in_array(this.excludeList,dirContents[i].replace(this.docRoot,''),false)){
					//this directory is excluded along with everything below it
					scanIMG = 'empty.png';
				} else {
					//this and all subdirectories are to be scanned - unless parent is empty
					if(this.ajaxElmHolder.parentNode.childNodes[1].src.indexOf('empty.png')==-1){
						scanIMG = 'full.png';
					} else {
						scanIMG = 'empty.png';
					}

				}
				//put += '<div id="'+dirContents[i]+'" class="tree2">';
				put += '<img src="'+sl_url2+'images/navigate_right.png" border="0" style="cursor:pointer;" onclick="SL_Scanner.openOrCloseDiv(this);stopPropagation(event);" />';
				put += '<img src="'+sl_url2+'images/'+scanIMG+'" border="0" style="cursor:pointer;" onclick="SL_Scanner.toggleExcluded(this);stopPropagation(event);" />';
				put += '<span style="position:absolute;padding:1px 0 0 5px; font-size: 13px; color: blue;cursor:pointer;font-weight: bold;" onclick="SL_Scanner.openOrCloseDiv(this.parentNode.childNodes[0]);">'+dir.replace('/','')+'</span>';
				//put += '</div>';
				style = 'id='+dirContents[i]+'^class=tree';
				if(i<1){
					style += '^style=padding-top:5px;';
				}
				write(this.ajaxElmHolder.parentNode,put,false,style,false);
			}
			//swap image
			if(empty(resp)){
				openIMG = sl_url2+'images/navigate_down.png';
				this.ajaxElmHolder.src = openIMG;
				this.ajaxElmHolder.style.cursor = 'default';
			} else {
				openIMG = sl_url2+'images/navigate_down.png';
				this.ajaxElmHolder.src = openIMG;
			}
        }
	},
	checkSiblings:function(img){
		//return excluded = all, none, some, or FALSE if this is root
		thisDiv = img.parentNode;
		parentDiv = thisDiv.parentNode;
		if(parentDiv.id == this.docRoot){
			return false;
		} else {
			excluded = 0;
			total = parentDiv.childNodes.length;
			for(x=3;x<parentDiv.childNodes.length;x++){
				current = parentDiv.childNodes[x];
				excluded += (current.childNodes[1].src.indexOf('full.png')>-1) ? 0 : 1;
			}
			if(excluded==0){
				return 'none';
			} else if(excluded==total){
				return 'all';
			} else {
				return 'some';
			}
		}
	},
	toggleExcluded:function(img){
		//alert(this.excludeList.join("\n"));
		excluding = (img.parentNode.childNodes[1].src.indexOf('full.png')>-1) ? true : false;
		if(excluding){
			//add this to list
			this.excludeList.push(img.parentNode.id.replace(this.docRoot,''));
			//remove children from list
			dir = img.parentNode.id.replace(this.docRoot,'');
			newList = Array();
			for(i=0;i<this.excludeList.length;i++){
				ex = this.excludeList[i];
				if(ex.indexOf(dir)!=0 || ex==dir){
					newList.push(ex);
				}
			}
			this.excludeList = newList;
			//change image
			img.src = sl_url2+'images/empty.png';
			//close div and switch arrow if needed
			//while(img.parentNode.childNodes[3]){
				//img.parentNode.removeChild(img.parentNode.childNodes[3]);
			//}
			//if(img.parentNode.childNodes[0].src.indexOf('navigate_down.png')>-1){
				//img.parentNode.childNodes[0].src = 'images/navigate_right.png';
			//}

			//make children show excluded
			find_arr = [];
			for(j=3;j<img.parentNode.childNodes.length;j++){
				find_arr.push(img.parentNode.childNodes[j]);
			}
			while(find_arr.length > 0){
				dir = find_arr.shift();
				if(dir.childNodes.length > 3){
					for(j=3;j<dir.childNodes.length;j++){
						find_arr.push(dir.childNodes[j]);
					}
				}
				dir.childNodes[1].src = sl_url2+'images/empty.png'
			}
			//update parent images
			while(siblingsExcluded = this.checkSiblings(img)){
				if(siblingsExcluded=='all'){
					//add parent list entry and remove all sibling entries
					parentDiv = img.parentNode.parentNode;
					this.excludeList.push(parentDiv.id.replace(this.docRoot,''));
					for(y=0;y<parentDiv.childNodes.length;y++){
						remove = parentDiv.childNodes[y].id.replace(this.docRoot,'');
						newList = Array();
						for(z=0;z<this.excludeList.length;z++){
							ex = this.excludeList[z];
							if(ex.indexOf(remove)!=0 || ex==dir){
								newList.push(ex);
							}
						}
						this.excludeList = newList;
					}
					img.parentNode.parentNode.childNodes[1].src = sl_url2+'images/empty.png';
				} else if(siblingsExcluded=='some') {
					img.parentNode.parentNode.childNodes[1].src = sl_url2+'images/half.png';
				} else {
					//none - this should be impossible..just excluded one
					'full.png';
				}
				img = img.parentNode.parentNode.childNodes[1];
			}

		} else {
			//remove children from list
			dir = img.parentNode.id.replace(this.docRoot,'');
			newList = Array();
			for(i=0;i<this.excludeList.length;i++){
				ex = this.excludeList[i];
				if(ex.indexOf(dir)!=0 || ex==dir){
					newList.push(ex);
				}
			}
			this.excludeList = newList;
			//adjust siblings
			parentDiv = (img.parentNode.parentNode.id!=this.docRoot);
			if(parentDiv){
				parentExcluded = (img.parentNode.parentNode.childNodes[1].src.indexOf('empty.png') > -1);
				if(parentExcluded){
					parentID = img.parentNode.parentNode.id.replace(this.docRoot,'');;
					//loop siblings and add exclude if not this
					for(i=3;i<img.parentNode.parentNode.childNodes.length;i++){
						ex = img.parentNode.parentNode.childNodes[i].id.replace(this.docRoot,'');
						if(ex!=dir){
							this.excludeList.push(ex);
						}
					}
					//remove parent entry
					newList = Array();
					for(i=0;i<this.excludeList.length;i++){
						ex = this.excludeList[i];
						if(ex!=parentID){
							newList.push(ex);
						}
					}
					this.excludeList = newList;
				} else {
					//remove this exclude
					newList = Array();
					for(i=0;i<this.excludeList.length;i++){
						ex = this.excludeList[i];
						if(ex!=dir){
							newList.push(ex);
						}
					}
					this.excludeList = newList;
				}
			} else {
				//remove this exclude
				newList = Array();
				for(i=0;i<this.excludeList.length;i++){
					ex = this.excludeList[i];
					if(ex!=dir){
						newList.push(ex);
					}
				}
				this.excludeList = newList;
			}
			//change image
			img.src = sl_url2+'images/full.png';
			//close div and switch arrow if needed
			//while(img.parentNode.childNodes[3]){
				//img.parentNode.removeChild(img.parentNode.childNodes[3]);
			//}
			//if(img.parentNode.childNodes[0].src.indexOf('navigate_down.png')>-1){
				//img.parentNode.childNodes[0].src = 'images/navigate_right.png';
			//}

			//make children show included
			find_arr = [];
			for(j=3;j<img.parentNode.childNodes.length;j++){
				find_arr.push(img.parentNode.childNodes[j]);
			}
			while(find_arr.length > 0){
				dir = find_arr.shift();
				if(dir.childNodes.length > 3){
					for(j=3;j<dir.childNodes.length;j++){
						find_arr.push(dir.childNodes[j]);
					}
				}
				dir.childNodes[1].src = sl_url2+'images/full.png';
			}
			//update parent images
			while(siblingsExcluded = this.checkSiblings(img)){
				if(siblingsExcluded=='all'){
					img.parentNode.parentNode.childNodes[1].src = sl_url2+'images/empty.png';
				} else if(siblingsExcluded=='some') {
					img.parentNode.parentNode.childNodes[1].src = sl_url2+'images/half.png';
				} else {
					img.parentNode.parentNode.childNodes[1].src = sl_url2+'images/full.png';
				}
				img = img.parentNode.parentNode.childNodes[1];
			}

		}
		//alert(this.excludeList.join("\n"));
		this.updateFileCount();
	},
	select:function(what){
		//add all to exclude list and reset images
		this.excludeList = Array();
		//loop docroot div to add to exclude
		elm = document.getElementById(this.docRoot);
		stack = Array();
		//exclude
		for(i=0;i<elm.childNodes.length;i++){
			stack.push(elm.childNodes[i]);
			if(what=='none'){
				this.excludeList.push(elm.childNodes[i].id.replace(this.docRoot,''));
			}
		}
		//images
		while(stack.length > 0){
			div = stack.shift();
			img = div.childNodes[1];
			img.src = what=='none' ? sl_url2+'images/empty.png' : sl_url2+'images/full.png';
			numChilds = div.childNodes.length - 3;
			while(numChilds > 0){
				stack.push(div.childNodes[2+numChilds--]);
			}
		}
		this.updateFileCount();
	},

	//time scanner
	startFileScan:function(){
		//clean trailing slash off root
		this.docRoot = this.remTrailingSlash(this.docRoot);
		//this will begin the filetime scanner function w/ email (that can also be cronjob)
		params = 'exclude='+this.excludeList.join('|');
		extra = '';
		if(document.getElementById('scanner_email').value.indexOf('@')>-1){
			extra += '&email='+document.getElementById('scanner_email').value;
		}
		if(this.docRoot){
			extra += '&root='+this.docRoot;
		}
		if(this.ajax){
	       this.ajax.abort();
	    }

	    write(document.getElementById('start_scan_text'),'Scanning...',true,null,false);

	    this.ajax = new XMLHttpRequest();
	    this.ajax.onreadystatechange = this.fileScanResp.bind(this);
	    this.ajax.open("POST", sl_url3+'sl_scanner.php?what=timestamp'+extra, true);
	    this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    this.ajax.setRequestHeader("Content-length", params.length);
	    this.ajax.setRequestHeader("Connection", "close");
	    this.ajax.send(params);
	},
	fileScanResp:function(){
		if(this.ajax.readyState==4 && this.ajax.status==200){
            resp = this.ajax.responseText;
            write(this.div(),resp,true,null,false);
		}
	},

	//mal scanner
	startMalScan:function(){
		if(this.fileCountAjax){
			check = confirm('The scanner is busy calculating the size of the current scan list. Do you want to scan as soon as this is done?');
			if(check){
				if(this.fileCountAjax){
					this.scanAfterCountUpdate = true;
					write(document.getElementById('start_scan_text'),'Please wait...',true,null,false);
				} else {
					this.startMalScan();
				}
			} else {
				write(document.getElementById('start_scan_text'),'Start Scan',true,null,false);
				this.scanAfterCountUpdate = false;
			}
			return false;
		}
		//fix the slider error
		jQuery(window).unbind('mouseup');
		//make sure display is not running
		if(this.malInt){
			clearInterval(this.malInt);
		}
		
		//clean trailing slash off root
		this.docRoot = this.remTrailingSlash(this.docRoot);
		//check if custom terms only
		onlyCustom = document.getElementById('only_custom_scan').value==1 ? 1 : 0;
		//needs to get terms, and dirs and files in root
		if(this.ajax){
	       this.ajax.abort();
	    }
	    write(document.getElementById('start_scan_text'),'Please wait...',true,null,false);
	    //this.ajaxElmHolder = button;
	    params = 'sl_page=ajax&what=initMalScan&onlyCustom='+onlyCustom+'&root='+this.docRoot;
	    this.ajax = new XMLHttpRequest();
	    this.ajax.onreadystatechange = this.firstMalResp.bind(this);
	    this.ajax.open("POST", sl_url3+'sl_scanner.php', true);
	    this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    this.ajax.setRequestHeader("Content-length", params.length);
	    this.ajax.setRequestHeader("Connection", "close");
	    this.ajax.send(params);
	},
	firstMalResp:function(){
		if(this.ajax.readyState==4 && this.ajax.status==200){
			//set variables - check for blank terms, or dirs && files
			resp = this.ajax.responseText.split('#sl#');
            this.malDirs = resp.shift().split("|");
            this.malDirs = empty(this.malDirs) ? Array() : this.malDirs;
            this.malFiles = resp.shift().split("|");
            this.malFiles = empty(this.malFiles) ? Array() : this.malFiles;
            this.malTerms = empty(resp) ? Array() : resp;
            //unpause to restart
            this.paused = false;

            //get custom scan terms
            this.customTerms = Array();
            count = 0;
            while(elm = document.getElementById('custom_scan_'+(count++))){
				value = elm.value;
				if(value.length > 2 && value != '   '){
					//turn it into a regex
					value = '/'+value+'/i';
					//replace +, maybe more??
					value = value.replace(/\+/g,'%2B');
					value = value.replace(/&/g,'%26');
					value = value.replace(/\?/g,'%3F');
					value = value.replace(/=/g,'%3D');
					this.customTerms.push(value);
				}
			}

            if((empty(this.malTerms) && empty(this.customTerms)) || (empty(this.malDirs) && empty(this.malFiles))){
				alert('Either '+this.docRoot+' is empty or the scanning terms could not be loaded. Please try again later or try another directory.');
				write(document.getElementById('start_scan_text'),'Start Scan',true,null,false);
            } else {
				//start scan
				this.startTime = new Date().getTime();
				//clear out old ajax objects
				this.ajaxObj = {};
				//get number of scans to execute and put them in an object
				num = parseInt(document.getElementById('ss_slider_val').value);
				num = num < 1 ? 1 : num;
				while(0<(num)){
					this.ajaxObj['scanner'+(num--)] = {
						ajax:null,
						lastFile:null,
						isScanningDir:false,
						malScan:function(){
							//remove excluded dirs from malDirs
							newDirs = Array();
							for(i=0;i<SL_Scanner.malDirs.length;i++){
								nextDir = SL_Scanner.malDirs[i].replace(SL_Scanner.docRoot,'');
								excluded = false;
								for(j=0;j<SL_Scanner.excludeList.length;j++){
									excludedDir = SL_Scanner.excludeList[j];
									if(nextDir.indexOf(excludedDir)==0 && !empty(excludedDir)){
										excluded = true;
										break;
									}
								}
								if(!excluded){
									newDirs.push(SL_Scanner.malDirs[i]);
								}
							}
							SL_Scanner.malDirs = newDirs;
							//files - remove any with a given extension (images)
							newFiles = Array();
							for(i=0;i<SL_Scanner.malFiles.length;i++){
								nextFile = SL_Scanner.malFiles[i].replace(SL_Scanner.docRoot,'');
								if(SL_Scanner.extensionOK(nextFile)){
									newFiles.push(SL_Scanner.malFiles[i]);
								}
							}
							SL_Scanner.malFiles = newFiles;

							//check if paused
							if(SL_Scanner.paused){
								return false;
							}

							//scan the next file - set vars
							if(SL_Scanner.malFiles.length==1){
								//last file, get next dir
								if(this.ajax){
								   this.ajax.abort();
								}
								file = SL_Scanner.malFiles.shift();
								if(SL_Scanner.malDirs.length>0){
									dir = SL_Scanner.malDirs.shift();
									SL_Scanner.dirsOpened++;
									//mark as scanning a dir
									this.isScanningDir = true;
									params = 'what=mal_scan&dir='+dir+'&file='+escape(file)+'&terms='+(SL_Scanner.malTerms.join('#sl#')+'#sl#'+SL_Scanner.customTerms.join('#sl#'));
								} else {
									//mark as not scanning a dir
									this.isScanningDir = false;
									params = 'what=mal_scan&file='+escape(file)+'&terms='+(SL_Scanner.malTerms.join('#sl#')+'#sl#'+SL_Scanner.customTerms.join('#sl#'));
								}
								this.ajax = new XMLHttpRequest();
								this.ajax.onreadystatechange = this.malResp.bind(this);
								this.ajax.open("POST", sl_url3+'sl_scanner.php', true);
								this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
								this.ajax.setRequestHeader("Content-length", params.length);
								this.ajax.setRequestHeader("Connection", "close");

								SL_Scanner.currentFile = file;
								this.lastFile = file;
								SL_Scanner.totalScanned++;
								this.ajax.send(params);
							}
							else if(SL_Scanner.malFiles.length>0){
								//not last file, just scan it
								file = SL_Scanner.malFiles.shift();
								if(this.ajax){
								   this.ajax.abort();
								}
								params = 'what=mal_scan&file='+escape(file)+'&terms='+(SL_Scanner.malTerms.join('#sl#')+'#sl#'+SL_Scanner.customTerms.join('#sl#'));
								this.ajax = new XMLHttpRequest();
								this.ajax.onreadystatechange = this.malResp.bind(this);
								this.ajax.open("POST", sl_url3+'sl_scanner.php', true);
								this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
								this.ajax.setRequestHeader("Content-length", params.length);
								this.ajax.setRequestHeader("Connection", "close");
								SL_Scanner.currentFile = file;
								this.lastFile = file;
								SL_Scanner.totalScanned++;
								//mark as not scanning a dir
								this.isScanningDir = false;
								this.ajax.send(params);
							}
							else if(SL_Scanner.malDirs.length>0) {
								//no file to scan, just get next dir
								dir = SL_Scanner.malDirs.shift();
								if(this.ajax){
								   this.ajax.abort();
								}
								params = 'what=mal_scan&dir='+dir;
								this.ajax = new XMLHttpRequest();
								this.ajax.onreadystatechange = this.malResp.bind(this);
								this.ajax.open("POST", sl_url3+'sl_scanner.php', true);
								this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
								this.ajax.setRequestHeader("Content-length", params.length);
								this.ajax.setRequestHeader("Connection", "close");

								SL_Scanner.currentFile = 'Scanning for more files...';
								//increase dirsopened
								SL_Scanner.dirsOpened++;
								//mark as scanning a dir
								this.isScanningDir = true;
								this.ajax.send(params);
							}
							else {
								//mark as not scanning a dir
								this.isScanningDir = false;
								//check if anything still scanning new dirs
								wait = false;
								for(key in SL_Scanner.ajaxObj){
									if(SL_Scanner.ajaxObj[key].isScanningDir && SL_Scanner.ajaxObj[key].ajax !== null){
										wait = true;
										break;
									}
								}
								if(wait){
									//try again in 250ms
									setTimeout(this.malScan.bind(this),250);
								} else {
									//done - clear ajax object
									this.ajax = null;
								}
							}
						},
						malResp:function(){
							if(this.ajax.readyState==4 && this.ajax.status==200){
								resp = this.ajax.responseText.split('#sl#');
								if(resp.length<3){
									this.malScan();
									return false;
								}
								newDirDirs = resp[0].split("|");
								newDirFiles = resp[1].split("|");
								fileWarnings = resp[2].split("^sl^");
								//add new contents
								if(newDirDirs.length>0){
									for(i=0;i<newDirDirs.length;i++){
										dir = newDirDirs[i];
										if(!empty(dir)){
											SL_Scanner.malDirs.push(dir);
										}
									}
								}
								if(newDirFiles.length>0){
									for(i=0;i<newDirFiles.length;i++){
										file = newDirFiles[i];
										if(!empty(file)){
											SL_Scanner.malFiles.push(file);
										}
									}
								}
								//remove any empty warnings
								newWarns = Array();
								for(i=0;i<fileWarnings.length;i++){
									warn = fileWarnings[i];
									if(!empty(warn)){
										newWarns.push(warn);
									}
								}
								fileWarnings = newWarns;
								//add warnings
								if(fileWarnings.length>0){
									//put the file in a file list
									if(document.getElementById('malscan_files').childNodes.length==0){
										write(document.getElementById('malscan_files'),'<br/>Possibly Infected Files List:',false,null,false);
									}
									if(!document.getElementById(this.lastFile+'|file')){
										//create it
										str = this.lastFile+' <a href="javascript:void(0)" onclick="SL_Scanner.rem(this,1);return false;"><img src="'+sl_url2+'images/delete2.png" border="0" alt="Click to remove this notice" title="Click to remove this notice" /></a>';
										write(document.getElementById('malscan_files'),str,false,'id='+this.lastFile+'|file',false);
									}
									//add to malscan_warnings or inserting into parent div with the id of the file
									if(document.getElementById(this.lastFile)){
										//add to it
										for(i=0;i<fileWarnings.length;i++){
											write(document.getElementById(this.lastFile),fileWarnings[i],false,null,false);
										}
									} else {
										//create it
										str = '';
										for(i=0;i<fileWarnings.length;i++){
											str += '<div>'+fileWarnings[i]+'</div>';
										}
										write(document.getElementById('malscan_warnings'),str,false,'id='+this.lastFile,false);
									}
								}
								//update total - updated on send so not adding empty dirs

								//call malscan
								this.malScan();
							} else if(this.ajax.readyState==4 && this.ajax.status!=200){
								this.malScan();
							}
						}
					};
				}
				//put pause button
				document.getElementById('titleButton').style.backgroundImage = 'url("'+sl_url2+'images/titleButton_Scanning.png")';
				document.getElementById('titleButton').onclick = SL_Scanner.pause.bind(this);
				//put output divs
            	str = '<div id="malscan_summary"></div><div id="malscan_files"></div><div id="malscan_warnings"></div>';
            	write(this.div(),str,true,null,false);
				//loop the object and start each scan
				for(v in this.ajaxObj){
					this.ajaxObj[v].malScan();
				}
				//start update interval
				this.malInt = setInterval(this.malIntDisplay.bind(this),1000);
				this.malIntDisplay();
            }
		}
	},
	findOpenFile:function(elm){
		//get line number & file name
		lineContainer = elm.parentNode.childNodes[elm.parentNode.childNodes.length-6].innerHTML;
		fileLine = lineContainer.substr(lineContainer.indexOf('#')+1);
		fileName = elm.parentNode.parentNode.parentNode.parentNode.id;
		this.openFile(fileName,fileLine);
	},
	pause:function(){
		//put resume button
		document.getElementById('titleButton').style.backgroundImage = 'url("'+sl_url2+'images/titleButton_Pause.png")';
		document.getElementById('titleButton').onclick = SL_Scanner.resume.bind(this);
		this.pausedTime = new Date().getTime();
		this.paused = true;
		clearInterval(this.malInt);
		this.pausedFile = this.currentFile;
		this.currentFile = 'Paused...';
		this.malIntDisplay();
	},
	resume:function(){
		//put pause button
		document.getElementById('titleButton').style.backgroundImage = 'url("'+sl_url2+'images/titleButton_Scanning.png")';
		document.getElementById('titleButton').onclick = SL_Scanner.pause.bind(this);
		//find out how long it was paused and add it to the start time
		this.startTime += (new Date().getTime()-this.pausedTime);
		this.currentFile = this.pausedFile;
		this.paused = false;
		for(key in this.ajaxObj){
			this.ajaxObj[key].malScan();
		}
		//start update interval
		this.malInt = setInterval(this.malIntDisplay.bind(this),1000);
		this.malIntDisplay();
	},
	malIntDisplay:function(){
		//see if scan completed
		complete = true;
		for(v in this.ajaxObj){
			if(this.ajaxObj[v].ajax !== null){
				complete = false;
				break;
			}
		}
		if(complete){
			//remove pause button
			document.getElementById('titleButton').style.backgroundImage = 'url("'+sl_url2+'images/titleButton.png")';
			document.getElementById('titleButton').setAttribute('onclick','');
			clearInterval(this.malInt);
			if(document.getElementById('sl_view_reports')){
				this.currentFile = 'Scan Complete! - <a href="javascript:void(0);" onclick="SL_Scanner.savePage();return false;">Click here to save the current report</a>';
			} else {
				this.currentFile = 'Scan Complete!';
			}

		}
		//continue
		file = this.currentFile ? this.currentFile : 'About to begin...';
		//get time elapsed
		secondsPast = Math.floor((new Date().getTime()-this.startTime)/1000);
		hoursPast = Math.floor(secondsPast/60/60);
		secondsPast -= hoursPast*60*60;
		minutesPast = Math.floor(secondsPast/60);
		secondsPast -= minutesPast*60;
		//format the minutes and seconds
		minutesPast = minutesPast<10 ? '0'+minutesPast : minutesPast;
		secondsPast = secondsPast<10 ? '0'+secondsPast : secondsPast;
		time = hoursPast+':'+minutesPast+':'+secondsPast;

		//correct if php warnings
		this.totalScanned = this.totalScanned > this.fileCount ? this.fileCount : this.totalScanned;
		this.dirsOpened = this.dirsOpened > this.dirCount ? this.dirCount : this.dirsOpened;

		//get file and dir %
		if(this.fileCount==0){
			filePercent = 100;
		} else {
			filePercent = Math.floor((this.totalScanned / (this.fileCount))*100);
		}
		if(this.dirCount==0){
			dirPercent = 100;
		} else {
			dirPercent = Math.floor((this.dirsOpened / (this.dirCount))*100);
		}

		//time remaining
		if(this.totalScanned==0){
			estimate = '0:00:00';
		} else {
			millisecondsPast = Math.floor(new Date().getTime()-this.startTime);
			avgScanMilliSeconds = millisecondsPast / this.totalScanned;
			milliSecondsRemaining = (this.fileCount - this.totalScanned) * avgScanMilliSeconds;
			secondsRemaining = Math.floor(milliSecondsRemaining / 1000);

			hoursRemaining = Math.floor(secondsRemaining/60/60);
			secondsRemaining -= hoursRemaining*60*60;
			minutesRemaining = Math.floor(secondsRemaining/60);
			secondsRemaining -= minutesRemaining*60;
			//format the minutes and seconds
			minutesRemaining = minutesRemaining<10 ? '0'+minutesRemaining : minutesRemaining;
			secondsRemaining = secondsRemaining<10 ? '0'+secondsRemaining : secondsRemaining;
			estimate = hoursRemaining+':'+minutesRemaining+':'+secondsRemaining;
		}


		//get px for percentbar
		FP = Math.floor((filePercent/100)*121)-120;
		DP = Math.floor((dirPercent/100)*121)-120;

		str = '<table width="100%">';
		str += '	<tr>';
		str += '		<td width="50%">Files: <img src="'+sl_url2+'images/percentImage.png" border="0" class="percentImage1" style="background-position:'+FP+'px 0;" /> '+filePercent+'%</td>';
		str += '		<td width="50%">Directories: <img src="'+sl_url2+'images/percentImage.png" border="0" class="percentImage1" style="background-position:'+DP+'px 0;" /> '+dirPercent+'%</td>';
		str += '	</tr>';
		str += '	<tr>';
		str += '		<td>'+this.totalScanned+' of '+(this.fileCount)+' files scanned</td>';
		str += '		<td>'+this.dirsOpened+' of '+(this.dirCount)+' directories opened</td>';
		str += '	</tr>';
		str += '	<tr>';
		str += '		<td>Time Elapsed: '+time+'</td>';
		str += '		<td>Time Remaining: '+estimate+'</td>';
		str += '	</tr>';
		str += '</table>';

		//put disclaimer
		str += '<div style="margin:4px;padding:4px;border:thin solid #ccc;"><b style="color:red;">Warning: Results will typically show files that are not harmful to your system. Do not delete any files unless you are sure they are malware. If you need assistance with a site cleanup, see <a href="http://www.securelive.net/rescue-article.html" target="_blank">www.securelive.net</a> for cleanup services.</b></div>';


		write(document.getElementById('headerBarStatus'),'Current File: '+file,true,'style=padding-top:3px;',false);
		write(document.getElementById('malscan_summary'),str,true,null,false);

		if(complete && this.standAlone){
			this.savePage();
		}
	},

	//base64
	openBase64Converter:function(){
		str = '<div class="tl_shadow"></div>';
		str += '<div class="t_shadow"></div>';
		str += '<div class="tr_shadow"></div>';
		str += '<div class="r_shadow"></div>';
		str += '<div class="br_shadow"></div>';
		str += '<div class="b_shadow"></div>';
		str += '<div class="bl_shadow"></div>';
		str += '<div class="l_shadow"></div>';
		str += '<div id="edit_container_header"></div>';
		str += '<div><br/>Input:<br/><textarea id="base64_input" style="height:100px;width:870px;">'+this.base64Text+'</textarea></div><br/>';
		str += '<input type="button" value="Decode from Base64" onclick="SL_Scanner.getBase64(this,\'decode\')" /> <input type="button" value="Encode to Base64" onclick="SL_Scanner.getBase64(this,\'encode\')" /><br/><br/>';
		str += 'Output:<br/><br/><div style="overflow:auto;height:270px;border:thin solid #ccc;padding:6px;">'+(this.base64Results)+'</div>';

		elm = document.getElementById('sl_popup');
		elm.style.display = 'block';
		write(elm,str,true,'class=shadow_div',false);
		header = '<a href="javascript:void(0);" onclick="SL_Scanner.closePopUp();return false;" style="float:right;">Close</a><b>Base64 Decoder / Encoder</b>';
		write(document.getElementById('edit_container_header'),header,true,null,false);
	},
	getBase64:function(button,which){
		button.value = 'Please wait...';
		if(which=='decode'){
			params = 'sl_page=ajax&what=base64decode&text='+escape(document.getElementById('base64_input').value.replace(/\+/,'%2B'));
		} else if(which=='encode') {
			params = 'sl_page=ajax&what=base64encode&text='+escape(document.getElementById('base64_input').value.replace(/\+/,'%2B'));
		}
		this.base64Text = document.getElementById('base64_input').value;

		if(this.base64Ajax){
	       this.base64Ajax.abort();
	    }
	    this.base64Ajax = new XMLHttpRequest();
	    this.base64Ajax.onreadystatechange = this.getBase64Resp.bind(this);
	    this.base64Ajax.open("POST", sl_url3+'sl_scanner.php', true);
	    this.base64Ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    this.base64Ajax.setRequestHeader("Content-length", params.length);
	    this.base64Ajax.setRequestHeader("Connection", "close");
	    this.base64Ajax.send(params);
	},
	getBase64Resp:function(){
		if(this.base64Ajax.readyState==4 && this.base64Ajax.status==200){
            this.base64Results = this.base64Ajax.responseText;
			this.openBase64Converter();
		} else if(this.base64Ajax.readyState==4 && this.base64Ajax.status!=200){
			this.openBase64Converter();
		}
	},

	//filename scan
	startNameScan:function(){
		write(document.getElementById('start_scan_text'),'Scanning...',true,null,false);
		//get custom scan terms as name searches
        this.customTerms = Array();
        count = 0;
        while(elm = document.getElementById('custom_scan_'+(count++))){
			value = elm.value;
			if(value.length > 2 && value != '   '){
				value = value.replace(/\?/g,'%3F');
				this.customTerms.push(value);
			}
		}

		//check if custom terms only
		onlyCustom = document.getElementById('only_custom_scan').value==1 ? 1 : 0;

		if((onlyCustom && !empty(this.customTerms)) || !onlyCustom){
			params = 'sl_page=ajax&what=fileNameScan&onlyCustom='+onlyCustom+'&root='+this.docRoot+'&exclude='+this.excludeList.join('|');
			for(i=0;i<this.customTerms.length;i++){
				term = this.customTerms[i];
				params += '&names[]='+term;
			}
			if(this.ajax){
		       this.ajax.abort();
		    }
		    this.ajax = new XMLHttpRequest();
		    this.ajax.onreadystatechange = this.nameScanResp.bind(this);
		    this.ajax.open("POST", sl_url3+'sl_scanner.php', true);
		    this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		    this.ajax.setRequestHeader("Content-length", params.length);
		    this.ajax.setRequestHeader("Connection", "close");
		    this.ajax.send(params);
		} else {
			alert('You have selected to scan only for Custom File Search but have not provided anything valid to search for. Search terms must be at least 3 characters long.');
			write(document.getElementById('start_scan_text'),'Scan for File Names',true,null,false);
		}
	},
	nameScanResp:function(){
		if(this.ajax.readyState==4){
            resp = this.ajax.responseText;
            write(this.div(),resp,true,null,false);
		}
	},

	//db scan
	startDBScan:function(form){
		ready = true;
		//check form - host db user pass
		host = form.host.value;
		db = form.db.value;
		user = form.user.value;
		pass = form.pass.value;
		if(host.length<3 || host=='   ' || empty(db) || empty(user) || empty(pass)){
			ready = false;
		}
		//check terms
		this.customTerms = Array();
        count = 0;
        while(elm = document.getElementById('custom_scan_'+(count++))){
			value = elm.value;
			if(value.length > 2 && value != '   '){
				this.customTerms.push(value);
			}
		}
		if(this.customTerms.length<1){
			ready = false;
		}
		if(ready){
			write(document.getElementById('start_scan_text'),'Scanning...',true,null,false);

			params = 'sl_page=ajax&what=dbScan';
			params += '&host='+base64.encode(host).replace(/\+/,'%2B');
			params += '&db='+base64.encode(db).replace(/\+/,'%2B');
			params += '&user='+base64.encode(user).replace(/\+/,'%2B');
			params += '&pass='+base64.encode(pass).replace(/\+/,'%2B');
			for(i=0;i<this.customTerms.length;i++){
				term = this.customTerms[i];
				params += '&terms[]='+base64.encode(term).replace(/\+/,'%2B');
			}
			if(this.ajax){
		       this.ajax.abort();
		    }
		    this.ajax = new XMLHttpRequest();
		    this.ajax.onreadystatechange = this.dbScanResp.bind(this);
		    this.ajax.open("POST", sl_url3+'sl_scanner.php', true);
		    this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		    this.ajax.setRequestHeader("Content-length", params.length);
		    this.ajax.setRequestHeader("Connection", "close");
		    this.ajax.send(params);
		} else {
			alert('You have errors in the form. All fields are required.\n\nThe terms you search for must be at least 3 characters long.');
		}
		return false;
	},
	dbScanResp:function(){
		if(this.ajax.readyState==4){
            resp = this.ajax.responseText;
            write(this.div(),resp,true,null,false);
		}
	},

	//save page
	savePage:function(){
		//send the contents of body

		this.pageBody = base64.encode(document.body.innerHTML).replace(/\+/g,'%2B');
		params = 'sl_page=ajax&what=savePage&content='+this.pageBody;

		//send to scanner file for saving
		if(this.ajax){
	       this.ajax.abort();
	    }
	    this.ajax = new XMLHttpRequest();
	    this.ajax.onreadystatechange = this.savePageResp.bind(this);
	    this.ajax.open("POST",sl_url3+'sl_scanner.php', true);
	    this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    this.ajax.setRequestHeader("Content-length", params.length);
	    this.ajax.setRequestHeader("Connection", "close");
	    this.ajax.send(params);
	},
	retrySavePage:function(button){
		button.value = 'Please wait...';
		params = 'sl_page=ajax&what=savePage&content='+this.pageBody;

		//send to scanner file for saving
		if(this.ajax){
	       this.ajax.abort();
	    }
	    this.ajax = new XMLHttpRequest();
	    this.ajax.onreadystatechange = this.savePageResp.bind(this);
	    this.ajax.open("POST",sl_url3+'sl_scanner.php', true);
	    this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    this.ajax.setRequestHeader("Content-length", params.length);
	    this.ajax.setRequestHeader("Connection", "close");
	    this.ajax.send(params);
	},
	savePageResp:function(){
		if(this.ajax.readyState==4 && this.ajax.status==200){
            resp = this.ajax.responseText;
			str = '<div class="tl_shadow"></div>';
			str += '<div class="t_shadow"></div>';
			str += '<div class="tr_shadow"></div>';
			str += '<div class="r_shadow"></div>';
			str += '<div class="br_shadow"></div>';
			str += '<div class="b_shadow"></div>';
			str += '<div class="bl_shadow"></div>';
			str += '<div class="l_shadow"></div>';
			str += '<div><a href="javascript:void(0);" onclick="SL_Scanner.closePopUp();return false;" style="float:right;">Close</a></div>'+resp;

			elm = document.getElementById('sl_popup');
			elm.style.display = 'block';
			write(elm,str,true,'class=shadow_div',false);
		}
	},

	//reports list
	openReportsList:function(){
		str = '<div class="tl_shadow"></div>';
		str += '<div class="t_shadow"></div>';
		str += '<div class="tr_shadow"></div>';
		str += '<div class="r_shadow"></div>';
		str += '<div class="br_shadow"></div>';
		str += '<div class="b_shadow"></div>';
		str += '<div class="bl_shadow"></div>';
		str += '<div class="l_shadow"></div>';
		str += '<div id="edit_container_header"></div>';
		str += '<br/>Please wait while we gather your reports...';


		elm = document.getElementById('sl_popup');
		elm.style.display = 'block';
		write(elm,str,true,'class=shadow_div',false);
		header = '<a href="javascript:void(0);" onclick="SL_Scanner.closePopUp();return false;" style="float:right;">Close</a><b>Malicious Code Scan Reports:</b>';
		write(document.getElementById('edit_container_header'),header,true,null,false);

		if(this.ajax){
	       this.ajax.abort();
	    }
	    params = 'sl_page=ajax&what=sl_reports';
	    this.ajax = new XMLHttpRequest();
	    this.ajax.onreadystatechange = this.openReportsListResp.bind(this);
	    this.ajax.open("POST",sl_url3+'sl_scanner.php', true);
	    this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    this.ajax.setRequestHeader("Content-length", params.length);
	    this.ajax.setRequestHeader("Connection", "close");
	    this.ajax.send(params);
	},
	openReportsListResp:function(){
		if(this.ajax.readyState==4 && this.ajax.status==200){
			resp = this.ajax.responseText;
			str = '<div class="tl_shadow"></div>';
			str += '<div class="t_shadow"></div>';
			str += '<div class="tr_shadow"></div>';
			str += '<div class="r_shadow"></div>';
			str += '<div class="br_shadow"></div>';
			str += '<div class="b_shadow"></div>';
			str += '<div class="bl_shadow"></div>';
			str += '<div class="l_shadow"></div>';
			str += '<div id="edit_container_header"></div><br/>';
			str += resp;


			elm = document.getElementById('sl_popup');
			elm.style.display = 'block';
			write(elm,str,true,'class=shadow_div',false);
			header = '<b>Malicious Code Scan Reports:</b> <a href="javascript:void(0);" onclick="SL_Scanner.closePopUp();return false;" style="float:right;">Close</a>';
			write(document.getElementById('edit_container_header'),header,true,null,false);
		}
	},
	deleteReport:function(file,img){
		start = 10;
		len = file.length - start - 5;
		temp = file.substr(start,len).split('-');
		date1 = temp[0];
		time1 = temp[1];
		date = date1.substr(0,2)+'/'+date1.substr(2,2)+'/'+date1.substr(4,2);
		time = time1.substr(0,2)+':'+time1.substr(2,2)+':'+time1.substr(4,2);
		check = confirm('Are you sure you want to delete the report from '+date+' at '+time+' called '+file+'?');
		if(check){
			img.src = 'images/spinner.gif';
			if(this.ajax){
		       this.ajax.abort();
		    }
		    params = 'sl_page=ajax&what=delete_report&file='+file;
		    this.ajax = new XMLHttpRequest();
		    this.ajax.onreadystatechange = this.deleteReportResp.bind(this);
		    this.ajax.open("POST",sl_url3+'sl_scanner.php', true);
		    this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		    this.ajax.setRequestHeader("Content-length", params.length);
		    this.ajax.setRequestHeader("Connection", "close");
		    this.ajax.send(params);
		}
	},
	deleteReportResp:function(){
		if(this.ajax.readyState==4 && this.ajax.status==200){
			resp = this.ajax.responseText;
			str = '<div class="tl_shadow"></div>';
			str += '<div class="t_shadow"></div>';
			str += '<div class="tr_shadow"></div>';
			str += '<div class="r_shadow"></div>';
			str += '<div class="br_shadow"></div>';
			str += '<div class="b_shadow"></div>';
			str += '<div class="bl_shadow"></div>';
			str += '<div class="l_shadow"></div>';
			str += '<div id="edit_container_header"></div>';
			str += '<br/>';
			str += resp;


			elm = document.getElementById('sl_popup');
			elm.style.display = 'block';
			write(elm,str,true,'class=shadow_div',false);
			header = '<b>Malicious Code Scan Reports:</b> <a href="javascript:void(0);" onclick="SL_Scanner.closePopUp();return false;" style="float:right;">Close</a>';
			write(document.getElementById('edit_container_header'),header,true,null,false);
		}
	}
}
sl_scoreTabs = {
	done1:false,
	done2:false,
	init:function(){
		jQuery('#tab1btn').click(function(){
			sl_scoreTabs.change(1);
			return false;
		});
		jQuery('#tab2btn').click(function(){
			sl_scoreTabs.change(2);
			return false;
		});
		
		//
		jQuery('#tab1').addClass('active');
		jQuery('#tab2').addClass('active');
		
		jQuery('#tab1').height(jQuery('#badlist').height()+30);
		jQuery('#tab2').height(0);
		
	},
	change:function(tabNumber){
		if(tabNumber==1){
			this.done1 = false;
			this.done2 = false;
			jQuery('#tab1btn').addClass('active');
			jQuery('#tab2btn').removeClass('active');
			//delete the alert div
			jQuery('#sl_module_content_alerts').empty();
			jQuery('#tab1').animate({
				height: jQuery('#badlist').height()+30
			},'slow', function() {
				sl_scoreTabs.done1 = true;
				if(sl_scoreTabs.done1 && sl_scoreTabs.done2){
					jQuery('#sl_module_content_alerts').html(sl_gateway.cache.alerts.html);
					//do onload
					if(sl_gateway.pages[sl_gateway.currentPage].alerts.onload){
						sl_gateway.pages[sl_gateway.currentPage].alerts.onload();
					}
				}
			});
			jQuery('#tab2').animate({
				height: 0
			},'slow', function() {
				sl_scoreTabs.done2 = true;
				if(sl_scoreTabs.done1 && sl_scoreTabs.done2){
					jQuery('#sl_module_content_alerts').html(sl_gateway.cache.alerts.html);
					//do onload
					if(sl_gateway.pages[sl_gateway.currentPage].alerts.onload){
						sl_gateway.pages[sl_gateway.currentPage].alerts.onload();
					}
				}
			});
		} else {
			this.done1 = false;
			this.done2 = false;
			jQuery('#tab1btn').removeClass('active');
			jQuery('#tab2btn').addClass('active');
			
			jQuery('#sl_module_content_alerts').empty();
			jQuery('#tab2').animate({
				height: jQuery('#goodlist').height()+30
			},'slow', function() {
				sl_scoreTabs.done2 = true;
				if(sl_scoreTabs.done1 && sl_scoreTabs.done2){
					jQuery('#sl_module_content_alerts').html(sl_gateway.cache.alerts.html);
					//do onload
					if(sl_gateway.pages[sl_gateway.currentPage].alerts.onload){
						sl_gateway.pages[sl_gateway.currentPage].alerts.onload();
					}
				}
			});
			jQuery('#tab1').animate({
				height: 0
			},'slow', function() {
				sl_scoreTabs.done1 = true;
				if(sl_scoreTabs.done1 && sl_scoreTabs.done2){
					jQuery('#sl_module_content_alerts').html(sl_gateway.cache.alerts.html);
					//do onload
					if(sl_gateway.pages[sl_gateway.currentPage].alerts.onload){
						sl_gateway.pages[sl_gateway.currentPage].alerts.onload();
					}
				}
			});
		}
	}
}
