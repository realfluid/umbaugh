<?php
function connectionsShowRolesPage()
{
	/*
	 * Check whether user can edit roles
	 */
	if (!current_user_can('connections_change_roles'))
	{
		wp_die('<p id="error-page" style="-moz-background-clip:border;
				-moz-border-radius:11px;
				background:#FFFFFF none repeat scroll 0 0;
				border:1px solid #DFDFDF;
				color:#333333;
				display:block;
				font-size:12px;
				line-height:18px;
				margin:25px auto 20px;
				padding:1em 2em;
				text-align:center;
				width:700px">You do not have sufficient permissions to access this page.</p>');
	}
	else
	{
		global $connections, $wp_roles;
		
		$form = new cnFormObjects();
		
		$connections->displayMessages();
							
		/*if (isset($_POST['submit']))
		{
			if (isset($_POST['roles']))
			{
				// Cycle thru each role available because checkboxes do not report a value when not checked.
				foreach ($wp_roles->get_names() as $role => $name)
				{
					if (!isset($_POST['roles'][$role])) continue;
					
					foreach ($_POST['roles'][$role]['capabilities'] as $capability => $grant)
					{
						// the admininistrator should always have all capabilities
						if ($role == 'administrator') continue;
						
						if ($grant == 'true')
						{
							$connections->options->addCapability($role, $capability);
						}
						else
						{
							$connections->options->removeCapability($role, $capability);
						}
					}
				}
			}
			
			if (isset($_POST['reset'])) $connections->options->setDefaultCapabilities($_POST['reset']);
			
			if (isset($_POST['reset_all'])) $connections->options->setDefaultCapabilities();
			
			echo "<div id='message' class='updated fade'>";
				echo "<p><strong>Role capabilities have been updated.</strong></p>";
			echo "</div>";
			
		}*/
	
	?>
		<div class="wrap">
			<div id="icon-connections" class="icon32">
		        <br>
		    </div>
			
			<h2>Connections : Roles &amp; Capabilities</h2>
			
			<?php 
				$attr = array(
							 'action' => 'admin.php?page=connections_roles&action=update_role_settings',
							 'method' => 'post',
							 );
				
				$form->open($attr);
				$form->tokenField('update_role_settings');
			?>
						
				<div class="form-wrap">
					
					<?php
						$editable_roles = get_editable_roles();
						
						foreach( $editable_roles as $role => $details )
						{
							$name = translate_user_role($details['name'] );	
							
							// the admininistrator should always have all capabilities
							if ($role == 'administrator') continue;
							
							echo '<div class="form-field connectionsform">';
								echo '<table class="form-table">';
									echo '<tbody>';
							
										echo '<tr valign="top">';
											echo '<th scope="row">';
												echo $name;
											echo '</th>';
											echo '<td>';
												$capabilies = $connections->options->getDefaultCapabilities();
												
												foreach ($capabilies as $capability => $capabilityName)
												{
													// if unregistered users are permitted to view the entry list there is no need for setting this capability
													if ($capability == 'connections_view_public' && $connections->options->getAllowPublic() == true) continue;
													
													echo '<label for="' . $role . '_' . $capability . '">';
													echo '<input type="hidden" name="roles[' . $role . '][capabilities][' . $capability . ']" value="false" />';
													echo '<input type="checkbox" id="' . $role . '_' . $capability . '" name="roles[' . $role . '][capabilities][' . $capability . ']" value="true" '; 
													
													if ($connections->options->hasCapability($role, $capability)) echo 'CHECKED ';
													// the admininistrator should always have all capabilities
													if ($role == 'administrator') echo 'DISABLED ';
													echo '/> ' . $capabilityName . '</label>' . "\n";
													
												}
												
												echo '<label for="' . $role . '_reset_capabilities">';
												echo '<input type="checkbox" id="' . $role . '_reset_capabilities" name="reset[' . $role . ']" value="' . $name . '" ';
												echo '/> Reset ' . $name . ' Capabilities</label>' . "\n";
													
											echo '</td>';
										echo '</tr>';
									echo '</tbody>';
								echo '</table>';
							echo '</div>';
						}
					?>
								
					<div class="form-field" style="background-color:#FFFBCC; border: 1px solid #E6DB55; -moz-border-radius:3px; border-style:solid; border-width:1px;">
						<table class="form-table">
							<tbody>
								
								<tr valign="top">
									<th scope="row">
										Reset
									</th>
									<td>
										<label for="reset_all_roles">
											<input type="checkbox" id="reset_all_roles" name="reset_all" value="true">
											Reset All Role Capabilities
										</label>
									</td>
								</tr>
								
							</tbody>
						</table>
					</div>
				</div>
				
			<p class="submit"><input class="button-primary" type="submit" value="Save Changes" name="save" /></p>
			
			<?php $form->close(); ?>
		</div>
		<div class="clear"></div>
		
	<?php }
}
?>