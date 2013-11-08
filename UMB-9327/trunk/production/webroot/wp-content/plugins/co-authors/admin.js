

(function(){
var coauthors_table = null;
//var coauthors_select_count = 1;

//When there is only one author select, make sure that the associated delete button is disabled; otherwise, enable it
function coauthors_check_first_delete_disabled_state(){
	var btn = jQuery('#authordiv td.delete button, #pageauthordiv td.delete button');
	if(jQuery('#authordiv select').length == 1){
		jQuery(btn).attr('disabled','disabled')
		           .parent().addClass('disabled');
	}
	else {
		jQuery(btn).removeAttr('disabled')
		           .parent().removeClass('disabled');
	}
}


var coauthors_select_onchange = function(event){
	//Prevent there from the same author from being listed multiple times; facilitate position swapping
	//  If there are any other select lists that have the same selectedIndex, then set that select's selectedIndex to this select's previous one
	if(this.selectedIndex != -1){
		var thisSelect = this;
		jQuery(coauthors_table).find('select').each(function(){
			if(thisSelect != this && thisSelect.selectedIndex == this.selectedIndex){
				if(this.id == 'post_author_override' && thisSelect.previousSelectedIndex == -1)
					this.selectedIndex = 0;
				else
					this.selectedIndex = thisSelect.previousSelectedIndex;
				this.previousSelectedIndex = this.selectedIndex;
			}
		});
	}
	this.previousSelectedIndex = this.selectedIndex;
};

var coauthors_delete_onclick = function(event){
	var tr = this.parentNode.parentNode;
	var select = tr.getElementsByTagName('select')[0];
	
	if(select.selectedIndex != -1 && !confirm(coauthors_confirm_delete_label.replace(/%s/, select.options[select.selectedIndex].text)))
		return false;
	
	//Shift up all of the values in the subsequent select lists and delete the last one
	if(select.id == 'post_author_override'){
		var lastSelect = select;
		jQuery(tr.parentNode).find('select').each(function(){
			if(this != select){
				//Ensure that post_author_override always has a value 
				if(lastSelect == select && this.selectedIndex == -1)
					lastSelect.selectedIndex = 0;
				else
					lastSelect.selectedIndex = this.selectedIndex;
				jQuery(lastSelect).change();
			}
			lastSelect = this;
		});
		jQuery(lastSelect).parents('tr:first').remove();
	}
	//Simply delete the row
	else {
		tr.parentNode.removeChild(tr);
	}
	////--coauthors_select_count;
	
	//Make sure that the delete button for the first row is enabled
	//if(coauthors_select_count == 1){
	//	var btns = $('post_author_override').parentNode.parentNode.getElementsByTagName('button');
	//	btns[btns.length-1].disabled = true;
	//}
	coauthors_check_first_delete_disabled_state();
	
	return true;
};

function coauthors_insert_author_edit_cells(tr){
	var td;
	
	////Move down button
	//var moveDown = document.createElement('button');
	//moveDown.setAttribute('type', 'button');
	//moveDown.appendChild(document.createTextNode("\u2193"));
	//moveDown.onclick = function(){
	//	alert('move down');
	//};
	//td = document.createElement('td');
	//td.className = 'move-down';
	//td.appendChild(moveDown);
	//tr.appendChild(td);
	//
	////Move up button
	//var moveUp = document.createElement('button');
	//moveUp.setAttribute('type', 'button');
	//moveUp.appendChild(document.createTextNode("\u2191"));
	//moveUp.onclick = function(){
	//	alert('move up');
	//};
	//td = document.createElement('td');
	//td.className = 'move-up';
	//td.appendChild(moveUp);
	//tr.appendChild(td);
	
	//Delete button
	var deleteBtn = document.createElement('button');
	deleteBtn.setAttribute('type', 'button');
	deleteBtn.appendChild(document.createTextNode("\u00D7"));
	deleteBtn.onclick = coauthors_delete_onclick;
	td = document.createElement('td');
	td.className = 'delete';
	td.appendChild(deleteBtn);
	tr.appendChild(td);
}

function coauthors_add_coauthor(authorID){
	var selectedIndex = -1;
	var tr = document.createElement('tr');
	
	//Clone author list and append it to a new row
	var select = jQuery('#post_author_override').clone(true)
	                                            .attr('id', '')
	                                            .attr('name', 'coauthors[]');
	
	if(authorID){
		//Find the provided author ID
		select.find("option").each(function(i){
			if(this.value == authorID){
				selectedIndex = i;
				return false;
			}
			return true;
		});
		
		//The coauthor post meta refers to a deleted author, so abandon
		if(selectedIndex == -1)
			return false;
	}
	
	var td = document.createElement('td');
	td.className = 'select';
	td.appendChild(select[0]);
	select.change(coauthors_select_onchange);
	select[0].previousSelectedIndex = -1;
	tr.appendChild(td);
	
	//Add buttons to row
	coauthors_insert_author_edit_cells(tr);
	
	coauthors_table.appendChild(tr);
	///++coauthors_select_count;
	select[0].selectedIndex = selectedIndex;
	select[0].previousSelectedIndex = selectedIndex;
	
	if(!authorID)
		select.focus();
	
	////Make sure that the delete button for the first row is enabled
	coauthors_check_first_delete_disabled_state();
	return true;
}


if(document.getElementById('post_author_override')){
	if(!coauthors_can_edit_others_posts){
		jQuery('#authordiv, #pageauthordiv').remove();
		return;
	}
	
	//Note that there can be co-authors (changes dbx title from "Post Author" to "Post Author(s)")
	var h3 = jQuery('#authordiv :header, #pageauthordiv :header').html(
			/page[^\/]+$/.test(window.location.href) ?
				coauthors_dbx_page_title
			:
				coauthors_dbx_post_title
	);
	
	//Add the controls to add co-authors
	var div = jQuery('#authordiv div, #pageauthordiv div').filter(function(){
		if(jQuery(this).is('.inside') || jQuery(this).is('.dbx-content'))
			return true;
		return false;
	})[0];
	if(div){
		var table = document.createElement('table');
		table.id = "coauthors-table";
		//table.setAttribute('cellspacing', 0);
		
		coauthors_table = table.appendChild(document.createElement('tbody'));
		var tr, td;
		
		tr = document.createElement('tr');
		td = document.createElement('td');
		td.className = 'select';
		var select = jQuery('#post_author_override')[0];
		td.insertBefore(select, null);
		jQuery(select).change(coauthors_select_onchange);
		select.previousSelectedIndex = select.selectedIndex;
		tr.appendChild(td);
		coauthors_insert_author_edit_cells(tr);
		
		coauthors_table.appendChild(tr);
		div.appendChild(table);
		
		var addBtn = document.createElement('button');
		addBtn.setAttribute('type', 'button');
		addBtn.className = 'addAuthorBtn';
		addBtn.appendChild(document.createTextNode(coauthors_add_author_label));
		jQuery(addBtn).click(function(){
			coauthors_add_coauthor(null); //add blank
		});
		div.appendChild(addBtn);
		
		var presenceInput;
		try {
			//For MSIE
			presenceInput = document.createElement('<input name="coauthors_plugin_is_active" type="hidden" value="1" />');
			if(!presenceInput || presenceInput.name != 'coauthors_plugin_is_active')
				throw Error();
		}
		catch(e){
			presenceInput = document.createElement('input');
			presenceInput.name = "coauthors_plugin_is_active";
			presenceInput.value = 1;
			presenceInput.type = 'hidden';
		}
		div.appendChild(presenceInput);
	}
	
	var addedAlready = {};
	
	//This is no longer needed because using "_coauthor" instead of "coauthor"
	jQuery('#the-list tr').each(function(){
		var userID = jQuery(this).find('textarea').val();
		if(jQuery(this).find("input[value='_coauthor']").length && !addedAlready[userID]){
			coauthors_add_coauthor(userID);
			addedAlready[userID] = true;
		}
		else if(jQuery(this).find("input[value='coauthor']").length && !addedAlready[userID]){
			coauthors_add_coauthor(userID);
			addedAlready[userID] = true;
			jQuery(this).hide();
		}
	});

	//Remove coauthor post meta select option
	//jQuery("#metakeyselect option[value='coauthor']").remove();
	coauthors_check_first_delete_disabled_state();
	
}


})();