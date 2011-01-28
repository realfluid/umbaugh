<?php
function connectionsShowViewPage()
{
	global $wpdb, $connections;
	
	if ( isset($_GET['action']) )
	{
		$action = $_GET['action'];
	}
	else
	{
		$action = NULL;
	}
	?>
	
	<div class="wrap">
		<div class="icon32" id="icon-connections"><br/></div>
		<h2>Connections</h2>
	
	<?php
	$connections->displayMessages();
	
	switch ($action)
	{
		case 'add_new':
			/*
			 * Check whether current user can add an entry.
			 */
			if (current_user_can('connections_add_entry'))
			{
				add_meta_box('metabox-name', 'Name', array(&$form, 'metaboxName'), $connections->pageHook->manage, 'normal', 'high');
				
				$form = new cnFormObjects();
				$entry = new cnEntry();
				
				echo '<div id="poststuff" class="metabox-holder has-right-sidebar">';
					echo '<h2><a name="new"></a>Add Entry</h2>';
					
						$attr = array(
									 'action' => 'admin.php?page=connections&action=add',
									 'method' => 'post',
									 'enctype' => 'multipart/form-data',
									 );
						
						$form->open($attr);
						
						$form->tokenField('add_entry');
						wp_nonce_field('howto-metaboxes-general');
						wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false );
						wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false );
						
						echo '<input type="hidden" name="action" value="save_howto_metaboxes_general" />';
						
						echo '<div id="side-info-column" class="inner-sidebar">';
							do_meta_boxes($connections->pageHook->manage, 'side', $entry);
						echo '</div>';
						
						
						echo '<div id="post-body" class="has-sidebar">';
							echo '<div id="post-body-content" class="has-sidebar-content">';
								do_meta_boxes($connections->pageHook->manage, 'normal', $entry);
							echo '</div>';
						echo '</div>';
						
						$form->close();
						
				echo '</div>';
				?>
				
				<script type="text/javascript">
				//<![CDATA[
				jQuery(document).ready( function($) {
					// close postboxes that should be closed
					$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
					// postboxes setup
					postboxes.add_postbox_toggles('<?php echo $connections->pageHook->manage ?>');
				});
				//]]>
				</script>
				
				<?php
			
				unset($entry);
			}
			else
			{
				$connections->setErrorMessage('capability_add');
			}
		break;
		
		case 'copy':
			/*
			 * Check whether current user can add an entry.
			 */
			if (current_user_can('connections_add_entry'))
			{
				$id = esc_attr($_GET['id']);
				check_admin_referer('entry_copy_' . $id);
				
				add_meta_box('metabox-name', 'Name', array(&$form, 'metaboxName'), $connections->pageHook->manage, 'normal', 'high');
				
				$form = new cnFormObjects();
				$entry = new cnEntry( $connections->retrieve->entry($id) );
				
				echo '<div id="poststuff" class="metabox-holder has-right-sidebar">';
					echo '<h2><a name="new"></a>Add Entry</h2>';
					
						$attr = array(
									 'action' => 'admin.php?page=connections&action=add&id=' . $id,
									 'method' => 'post',
									 'enctype' => 'multipart/form-data',
									 );
						
						$form->open($attr);
						
						$form->tokenField('add_entry');
						wp_nonce_field('howto-metaboxes-general');
						wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false );
						wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false );
						
						echo '<input type="hidden" name="action" value="save_howto_metaboxes_general" />';
						
						echo '<div id="side-info-column" class="inner-sidebar">';
							do_meta_boxes($connections->pageHook->manage, 'side', $entry);
						echo '</div>';
						
						
						echo '<div id="post-body" class="has-sidebar">';
							echo '<div id="post-body-content" class="has-sidebar-content">';
								do_meta_boxes($connections->pageHook->manage, 'normal', $entry);
							echo '</div>';
						echo '</div>';
						
						$form->close();
						
				echo '</div>';
				?>
				
				<script type="text/javascript">
				//<![CDATA[
				jQuery(document).ready( function($) {
					// close postboxes that should be closed
					$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
					// postboxes setup
					postboxes.add_postbox_toggles('<?php echo $connections->pageHook->manage ?>');
				});
				//]]>
				</script>
				
				<?php
			
				unset($entry);
			}
			else
			{
				$connections->setErrorMessage('capability_add');
			}
		break;
		
		case 'edit':
			/*
			 * Check whether the current user can edit entries.
			 */
			if (current_user_can('connections_edit_entry'))
			{
				$id = esc_attr($_GET['id']);
				check_admin_referer('entry_edit_' . $id);
				
				add_meta_box('metabox-name', 'Name', array(&$form, 'metaboxName'), $connections->pageHook->manage, 'normal', 'high');
				
				$form = new cnFormObjects();
				$entry = new cnEntry( $connections->retrieve->entry($id) );
				
				echo '<div id="poststuff" class="metabox-holder has-right-sidebar">';
					echo '<h2><a name="new"></a>Edit Entry</h2>';
					
						$attr = array(
									 'action' => 'admin.php?page=connections&action=update&id=' . $id,
									 'method' => 'post',
									 'enctype' => 'multipart/form-data',
									 );
						
						$form->open($attr);
						
						$form->tokenField('update_entry');
						wp_nonce_field('howto-metaboxes-general');
						wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false );
						wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false );
						
						echo '<input type="hidden" name="action" value="save_howto_metaboxes_general" />';
						
						echo '<div id="side-info-column" class="inner-sidebar">';
							do_meta_boxes($connections->pageHook->manage, 'side', $entry);
						echo '</div>';
						
						
						echo '<div id="post-body" class="has-sidebar">';
							echo '<div id="post-body-content" class="has-sidebar-content">';
								do_meta_boxes($connections->pageHook->manage, 'normal', $entry);
							echo '</div>';
						echo '</div>';
						
						$form->close();
						
				echo '</div>';
				?>
				
				<script type="text/javascript">
				//<![CDATA[
				jQuery(document).ready( function($) {
					// close postboxes that should be closed
					$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
					// postboxes setup
					postboxes.add_postbox_toggles('<?php echo $connections->pageHook->manage ?>');
				});
				//]]>
				</script>
				
				<?php
				
				unset($entry);
			}
			else
			{
				$connections->setErrorMessage('capability_edit');
			}
		break;
		
		default:
			$form = new cnFormObjects();
			$categoryObjects = new cnCategoryObjects();
			
			/*
			 * Check whether user can view the entry list
			 */
			if(current_user_can('connections_view_entry_list'))
			{
				?>
				
					<?php
						$retrieveAttr['list_type'] = $connections->currentUser->getFilterEntryType();
						$retrieveAttr['category'] = $connections->currentUser->getFilterCategory();
						$retrieveAttr['visibility'] = $connections->currentUser->getFilterVisibility();
						
						$results = $connections->retrieve->entries($retrieveAttr);
						//print_r($connections->lastQuery);
					?>
					
						
						<form action="admin.php?page=connections&action=do" method="post">
						
						<?php $form->tokenField('bulk_action'); ?>
						
						<div class="tablenav">
							
							<div class="alignleft actions">
								<?php
									echo '<select class="postform" id="category" name="category">';
										echo '<option value="-1">Show All Categories</option>';
										echo $categoryObjects->buildCategoryRow('option', $connections->retrieve->categories(), $level, $connections->currentUser->getFilterCategory());
									echo '</select>';
									
									echo $form->buildSelect('entry_type', array('all'=>'Show All Enties', 'individual'=>'Show Individuals', 'organization'=>'Show Organizations', 'family'=>'Show Families'), $connections->currentUser->getFilterEntryType());
								?>
								
								<?php
									/*
									 * Builds the visibilty select list base on current user capabilities.
									 */
									if (current_user_can('connections_view_public') || $connections->options->getAllowPublic()) $visibilitySelect['public'] = 'Show Public';
									if (current_user_can('connections_view_private'))	$visibilitySelect['private'] = 'Show Private';
									if (current_user_can('connections_view_unlisted'))	$visibilitySelect['unlisted'] = 'Show Unlisted';
									
									if (isset($visibilitySelect))
									{
										/*
										 * Add the 'Show All' option and echo the list.
										 */
										$showAll['all'] = 'Show All';
										$visibilitySelect = $showAll + $visibilitySelect;
										echo $form->buildSelect('visibility_type', $visibilitySelect, $connections->currentUser->getFilterVisibility());
									}
								?>
								<input id="doaction" class="button-secondary action" type="submit" name="filter" value="Filter" />
								<input type="hidden" name="formId" value="do_action" />
								<input type="hidden" name="token" value="<?php echo $form->token("do_action"); ?>" />
							</div>
						</div>
						<div class="clear"></div>
						<div class="tablenav">
							
							<?php
														
							if (current_user_can('connections_edit_entry') || current_user_can('connections_delete_entry'))
							{
								echo '<div class="alignleft actions">';
									echo '<select name="action">';
										echo '<option value="" SELECTED>Bulk Actions</option>';
											
											$bulkActions = array();
											
											if (current_user_can('connections_edit_entry'))
											{
												$bulkActions['public'] = 'Set Public';
												$bulkActions['private'] = 'Set Private';
												$bulkActions['unlisted'] = 'Set Unlisted';
											}
											
											if (current_user_can('connections_delete_entry'))
											{
												$bulkActions['delete'] = 'Delete';
											}
											
											$bulkActions = apply_filters('cn_view_bulk_actions', $bulkActions);	
											
											foreach ( $bulkActions as $action => $string )
											{
												echo '<option value="', $action, '">', $string, '</option>';
											}
																	
									echo '</select>';
									echo '<input id="doaction" class="button-secondary action" type="submit" name="doaction" value="Apply" />';
								echo '</div>';
							}
							?>
							
							<div class="tablenav-pages">
								<?php
									
									echo '<span class="displaying-num">Displaying ' , $connections->resultCount , ' of ' , $connections->recordCount , ' records.</span>';
									
									/*
									 * Dynamically builds the alpha index based on the available entries.
									 */
									$previousLetter = NULL;
									$setAnchor = NULL;
									
									foreach ($results as $row)
									{
										$entry = new cnEntry($row);
										$currentLetter = strtoupper(mb_substr($entry->getSortColumn(), 0, 1));
										if ($currentLetter != $previousLetter)
										{
											$setAnchor .= '<a href="#' . $currentLetter . '">' . $currentLetter . '</a> ';
											$previousLetter = $currentLetter;
										}
									}
									
									echo $setAnchor;
								?>
							</div>
						</div>
						<div class="clear"></div>
						
				       	<table cellspacing="0" class="widefat connections">
							<thead>
					            <tr>
					                <th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"/></th>
									<th class="col" style="width:10%;"></th>
									<th scope="col" colspan="2" style="width:40%;">Name</th>
									<th scope="col" style="width:30%;">Categories</th>
									<th scope="col" style="width:20%;">Last Modified</th>
					            </tr>
							</thead>
							<tfoot>
					            <tr>
					                <th class="manage-column column-cb check-column" scope="col"><input type="checkbox"/></th>
									<th class="col" style="width:10%;"></th>
									<th scope="col" colspan="2" style="width:40%;">Name</th>
									<th scope="col" style="width:30%;">Categories</th>
									<th scope="col" style="width:20%;">Last Modified</th>
					            </tr>
							</tfoot>
							<tbody>
								
								<?php
								
								foreach ($results as $row) {
									/**
									 * @TODO: Use the Output class to show entry details.
									 */								
									$entry = new cnvCard($row);
									$vCard =& $entry;
									
									$currentLetter = strtoupper(mb_substr($entry->getSortColumn(), 0, 1));
									if ($currentLetter != $previousLetter) {
										$setAnchor = "<a name='$currentLetter'></a>";
										$previousLetter = $currentLetter;
									} else {
										$setAnchor = null;
									}
									
									/*
									 * Genreate the edit, copy and delete URLs with nonce tokens.
									 */
									$editTokenURL = $form->tokenURL('admin.php?page=connections&action=edit&id=' . $entry->getId(), 'entry_edit_' . $entry->getId());
									$copyTokenURL = $form->tokenURL('admin.php?page=connections&action=copy&id=' . $entry->getId(), 'entry_copy_' . $entry->getId());
									$deleteTokenURL = $form->tokenURL('admin.php?page=connections&action=delete&id=' . $entry->getId(), 'entry_delete_' . $entry->getId());
									
									
									echo "<tr id='row-" . $entry->getId() . "' class='parent-row'>";
										echo "<th class='check-column' scope='row'><input type='checkbox' value='" . $entry->getId() . "' name='entry[]'/></th> \n";
											echo '<td>';
												echo $entry->getThumbnailImage( array( 'place_holder' => TRUE ) );
											echo '</td>';
											echo '<td  colspan="2">';
												if ($setAnchor) echo $setAnchor;
												echo '<div style="float:right"><a href="#wphead" title="Return to top."><img src="' . WP_PLUGIN_URL . '/connections/images/uparrow.gif" /></a></div>';
												
												if (current_user_can('connections_edit_entry'))
												{
													echo '<a class="row-title" title="Edit ' . $entry->getFullFirstLastName() . '" href="' . $editTokenURL . '"> ' . $entry->getFullLastFirstName() . '</a><br />';
												}
												else
												{
													echo '<strong>' . $entry->getFullLastFirstName() . '</strong>';
												}
												
												echo '<div class="row-actions">';
													echo '<a class="detailsbutton" id="row-' . $entry->getId() . '">Show Details</a> | ';
													echo $vCard->download( array('anchorText' => 'vCard') ) . ' | ';
													if (current_user_can('connections_edit_entry')) echo '<a class="editbutton" href="' . $editTokenURL . '" title="Edit ' . $entry->getFullFirstLastName() . '">Edit</a> | ';
													if (current_user_can('connections_add_entry')) echo '<a class="copybutton" href="' . $copyTokenURL . '" title="Copy ' . $entry->getFullFirstLastName() . '">Copy</a> | ';
													if (current_user_can('connections_delete_entry')) echo '<a class="submitdelete" onclick="return confirm(\'You are about to delete this entry. \\\'Cancel\\\' to stop, \\\'OK\\\' to delete\');" href="' . $deleteTokenURL . '" title="Delete ' . $entry->getFullFirstLastName() . '">Delete</a>';
												echo '</div>';
										echo "</td> \n";
										echo "<td > \n";
											
											$categories = $entry->getCategory();
											
											if ( !empty($categories) )
											{
												$i = 0;
												
												foreach ($categories as $category)
												{
													/*
													 * Genreate the category link token URL.
													 */
													$categoryFilterURL = $form->tokenURL('admin.php?page=connections&action=filter&category_id=' . $category->term_id, 'filter');
													
													echo '<a href="' . $categoryFilterURL . '">' . $category->name . '</a>';
													
													$i++;
													if ( count($categories) > $i ) echo ', ';
												}
												
												unset($i);
											}
											
										echo "</td> \n";											
										echo '<td >';
											echo '<strong>On:</strong> ' . $entry->getFormattedTimeStamp('m/d/Y g:ia') . '<br />';
											echo '<strong>By:</strong> ' . $entry->getEditedBy(). '<br />';
											echo '<strong>Visibility:</strong> ' . $entry->displayVisibiltyType();
										echo "</td> \n";											
									echo "</tr> \n";
									
									echo "<tr class='child-row-" . $entry->getId() . " entrydetails' id='contact-" . $entry->getId() . "-detail' style='display:none;'>";
										echo "<td colspan='2' >&nbsp;</td> \n";
										//echo "<td >&nbsp;</td> \n";
										echo "<td colspan='2'>";
											
											/*
											 * Check if the entry has relations. Count the relations and then cycle thru each relation.
											 * Before the out check that the related entry still exists. If it does and the current user
											 * has edit capabilites the edit link will be displayed. If the user does not have edit capabilities
											 * the only the relation will be shown. After all relations have been output insert a <br>
											 * for spacing [@TODO: NOTE: this should be done with styles].
											 */
											if ($entry->getFamilyMembers())
											{
												$count = count($entry->getFamilyMembers());
												$i = 0;
												
												foreach ($entry->getFamilyMembers() as $key => $value)
												{
													$relation = new cnEntry();
													$relation->set($key);
													$editRelationTokenURL = $form->tokenURL('admin.php?page=connections&action=edit&id=' . $relation->getId(), 'entry_edit_' . $relation->getId());
													
													if ($relation->getId())
													{
														if (current_user_can('connections_edit_entry'))
														{
															echo '<strong>' . $connections->options->getFamilyRelation($value) . ':</strong> ' . '<a href="' . $editRelationTokenURL . '" title="Edit ' . $relation->getFullFirstLastName() . '">' . $relation->getFullFirstLastName() . '</a><br />' . "\n";
														}
														else
														{
															echo '<strong>' . $connections->options->getFamilyRelation($value) . ':</strong> ' . $relation->getFullFirstLastName() . '<br />' . "\n";
														}
													}
													
													if ($count - 1 == $i) echo '<br />'; // Insert a break after all connections are listed.
													$i++;
													unset($relation);
												}
												unset($i);
												unset($count);
											}
											
											if ($entry->getContactFirstName() || $entry->getContactLastName()) echo '<strong>Contact:</strong> ' . $entry->getContactFirstName() . ' ' . $entry->getContactLastName() . '<br />';
											if ($entry->getTitle()) echo '<strong>Title:</strong> ' . $entry->getTitle() . '<br />';
											if ($entry->getOrganization() && $entry->getEntryType() !== 'organization' ) echo '<strong>Organization:</strong> ' . $entry->getOrganization() . '<br />';
											if ($entry->getDepartment()) echo '<strong>Department:</strong> ' . $entry->getDepartment() . '<br />';
											
											if ($entry->getAddresses())
											{
												foreach ($entry->getAddresses() as $address)
												{
													echo "<div style='margin-bottom: 10px;'>";
														if ($address->name != NULL || $address->type) echo "<strong>" . $address->name . "</strong><br />"; //The OR is for compatiblity for 0.2.24 and under
														if ($address->line_one != NULL) echo $address->line_one . "<br />";
														if ($address->line_two != NULL) echo $address->line_two . "<br />";
														if ($address->city != NULL) echo $address->city . "&nbsp;";
														if ($address->state != NULL) echo $address->state . "&nbsp;";
														if ($address->zipcode != NULL) echo $address->zipcode . "<br />";
														if ($address->country != NULL) echo $address->country;
													echo "</div>";														
												}
											}
										echo "</td> \n";
										
										echo "<td>";
											if ($entry->getEmailAddresses())
											{
												foreach ($entry->getEmailAddresses() as $emailRow)
												{
													if ($emailRow->address != null) echo "<strong>" . $emailRow->name . ":</strong><br /><a href='mailto:" . $emailRow->address . "'>" . $emailRow->address . "</a><br /><br />";
												}
											}
											
											if ($entry->getIm())
											{
												foreach ($entry->getIm() as $imRow)
												{
													if ($imRow->id != "") echo "<strong>" . $imRow->name . ":</strong><br />" . $imRow->id . "<br /><br />";
												}
											}
											
											if ($entry->getSocialMedia())
											{
												foreach ($entry->getSocialMedia() as $socialNetwork)
												{
													if ($socialNetwork->id != "") echo "<strong>" . $socialNetwork->name . ":</strong><br /><a target='_blank' href='" . $socialNetwork->url . "'>" . $socialNetwork->url . "</a><br /><br />";
												}
											}
											
											if ($entry->getWebsites())
											{
												foreach ($entry->getWebsites() as $website)
												{
													if ($website->url != "") echo "<strong>Website:</strong><br /><a target='_blank' href='" . $website->url . "'>" . $website->url . "</a><br /><br />";
												}
											}
											
											if ($entry->getPhoneNumbers())
											{
												foreach ($entry->getPhoneNumbers() as $phone) 
												{
													if ($phone->number != "") echo "<strong>" . $phone->name . "</strong>: " .  $phone->number . "<br />";
												}
											}
											
										echo "</td> \n";
																				
										echo "<td>";
											if ($entry->getBirthday()) echo "<strong>Birthday:</strong><br />" . $entry->getBirthday() . "<br /><br />";
											if ($entry->getAnniversary()) echo "<strong>Anniversary:</strong><br />" . $entry->getAnniversary();
										echo "</td> \n";
									echo "</tr> \n";
									
									echo "<tr class='child-row-" . $entry->getId() . " entrynotes' id='contact-" . $entry->getId() . "-detail-notes' style='display:none;'>";
										echo "<td colspan='2'>&nbsp;</td> \n";
										//echo "<td >&nbsp;</td> \n";
										echo "<td colspan='3'>";
											if ($entry->getBio()) echo "<strong>Bio:</strong> " . $entry->getBio() . "<br />"; else echo "&nbsp;";
											if ($entry->getNotes()) echo "<strong>Notes:</strong> " . $entry->getNotes(); else echo "&nbsp;";
										echo "</td> \n";
										echo '<td>
											<strong>Entry ID:</strong> ' . $entry->getId() . '<br />' . '
											<strong>Date Added:</strong> ' . $entry->getDateAdded('m/d/Y g:ia') . '<br />
											<strong>Added By:</strong> ' . $entry->getAddedBy() . '<br />';
											if (!$entry->getImageLinked()) echo "<br /><strong>Image Linked:</strong> No"; else echo "<br /><strong>Image Linked:</strong> Yes";
											if ($entry->getImageLinked() && $entry->getImageDisplay()) echo "<br /><strong>Display:</strong> Yes"; else echo "<br /><strong>Display:</strong> No";
										echo "</td> \n";
									echo "</tr> \n";
																			
								} ?>
							</tbody>
				        </table>
						</form>
						<p style="font-size:smaller; text-align:center">This is version <?php echo $connections->options->getVersion(), '-', $connections->options->getDBVersion(); ?> of Connections.</p>
						
						
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="text-align:center">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="5070255">
							<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					
				
				
				<script type="text/javascript">
					/* <![CDATA[ */
					(function($){
						$(document).ready(function(){
							$('#doaction, #doaction2').click(function(){
								if ( $('select[name^="action"]').val() == 'delete' ) {
									var m = 'You are about to delete the selected entry(ies).\n  \'Cancel\' to stop, \'OK\' to delete.';
									return showNotice.warn(m);
								}
							});
						});
					})(jQuery);
					/* ]]> */
				</script>
			<?php
			}
			else
			{
				$connections->setErrorMessage('capability_view_entry_list');
			}
			
		break;
	}
	?>
	</div>
<?php
}
?>