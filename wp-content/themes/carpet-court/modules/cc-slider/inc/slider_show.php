<?php 

/**
 * [html_showsliders function to show the list of slider]
 *  
 */
function html_showsliders( $rows, $pageNav, $sort, $cat_row) {	
	global $wpdb;
	?>
    <script language="javascript">
		function ordering(name,as_or_desc) {
			document.getElementById('asc_or_desc').value=as_or_desc;		
			document.getElementById('order_by').value=name;
			document.getElementById('admin_form').submit();
		}

		function saveorder() {
			document.getElementById('saveorder').value="save";
			document.getElementById('admin_form').submit();
			
		}

		function listItemTask(this_id,replace_id) {
			document.getElementById('oreder_move').value=this_id+","+replace_id;
			document.getElementById('admin_form').submit();
		}

		function doNothing() {  
			var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if( keyCode == 13 ) {
				if(!e) var e = window.event;
				e.cancelBubble = true;
				e.returnValue = false;

				if (e.stopPropagation) {
						e.stopPropagation();
						e.preventDefault();
				}
			}
		}
	</script>

	<div class="wrap">	
	   
		<div style="clear:both;"></div>
		<div id="poststuff">
			<div id="sliders-list-page">
				<form method="post"  onkeypress="doNothing()" action="admin.php?page=cc_sliders" id="admin_form" name="admin_form">
				<h2>CC Sliders
					<a onclick="window.location.href='admin.php?page=cc_sliders&task=add_cat'" class="add-new-h2" >Add New Slider</a>
				</h2>
				<?php
				$serch_value='';
				if ( isset($_POST['serch_or_not'] ) && $_POST['serch_or_not'] == "search" ) {
					$serch_value=esc_html( stripslashes( $_POST['search_events_by_title']));
				} 

				$serch_fields='<div class="alignleft actions"">
					<label for="search_events_by_title" style="font-size:14px">Filter: </label>
						<input type="text" name="search_events_by_title" value="'.$serch_value.'" id="search_events_by_title" onchange="clear_serch_texts()">
				</div>
				<div class="alignleft actions">
					<input type="button" value="Search" onclick="document.getElementById(\'page_number\').value=\'1\'; document.getElementById(\'serch_or_not\').value=\'search\';
					 document.getElementById(\'admin_form\').submit();" class="button-secondary action">
					 <input type="button" value="Reset" onclick="window.location.href=\'admin.php?page=cc_sliders\'" class="button-secondary action">
				</div>';

				 print_html_nav($pageNav['total'],$pageNav['limit'],$serch_fields);
				?>
				<table class="wp-list-table widefat fixed pages" style="width:95%">
					<thead>
					 <tr>
						<th scope="col" id="id" style="width:30px" ><span>ID</span><span class="sorting-indicator"></span></th>
						<th scope="col" id="name" style="width:85px" ><span>Name</span><span class="sorting-indicator"></span></th>
						<th scope="col" id="prod_count"  style="width:75px;" ><span>Images</span><span class="sorting-indicator"></span></th>
						<th style="width:40px">Delete</th>
					 </tr>
					</thead>
					<tbody>
					 <?php 
					 $trcount=1;
					  for( $i=0; $i<count($rows); $i++) {
						$trcount++;
						$ka0=0;
						$ka1=0;
						$move_up="";
						if( isset( $rows[$i-1]->id ) ) {
						  	if ( $rows[$i]->sl_width == $rows[$i-1]->sl_width ) {
								  $x1=$rows[$i]->id;
								  $x2=$rows[$i-1]->id;
								  $ka0=1;
						  	} else {
								  	$jj=2;
								  	while(isset($rows[$i-$jj])) {

									  	if($rows[$i]->sl_width == $rows[$i-$jj]->sl_width) {
										  	$ka0=1;
										  	$x1=$rows[$i]->id;
										  	$x2=$rows[$i-$jj]->id;
										   	break;
									  	}

										$jj++;
								  	}
						  	}
							$move_up="";
							if( $ka0 ) {
								$move_up='<span><a href="#reorder" onclick="return listItemTask(\''.$x1.'\',\''.$x2.'\')" title="Move Up">   <img src="'.get_stylesheet_directory_uri(). '/modules/cc-slider/images/uparrow.png'.'" width="16" height="16" border="0" alt="Move Up"></a></span>';
							} 
						} 
						
						$move_down="";
						if ( isset( $rows[$i+1]->id ) ) {
							
							if( $rows[$i]->sl_width==$rows[$i+1]->sl_width ) {
							  $x1=$rows[$i]->id;
							  $x2=$rows[$i+1]->id;
							  $ka1=1;
							} else {
							  	$jj=2;
							  	while(isset($rows[$i+$jj])) {

								  	if($rows[$i]->sl_width==$rows[$i+$jj]->sl_width) {
									  $ka1=1;
									  $x1=$rows[$i]->id;
									  $x2=$rows[$i+$jj]->id;
									  break;
								  	}
									$jj++;
							  	}
							}
							
							$move_down="";
							if($ka1){
								$move_down='<span><a href="#reorder" onclick="return listItemTask(\''.$x1.'\',\''. $x2.'\')" title="Move Down">  <img src="'.get_stylesheet_directory_uri(). '/modules/cc-slider/images/downarrow.png'.'" width="16" height="16" border="0" alt="Move Down"></a></span>';
							}
						}

						$uncat=$rows[$i]->par_name;
						if(isset($rows[$i]->prod_count))
							$pr_count=$rows[$i]->prod_count;
						else
							$pr_count=0;

						?>
						<tr <?php if($trcount%2==0){ echo 'class="has-background"';}?>>
							<td><?php echo $rows[$i]->id; ?></td>
							<td><a  href="admin.php?page=cc_sliders&task=edit_cat&id=<?php echo esc_html($rows[$i]->id) ?>"><?php echo esc_html(stripslashes($rows[$i]->name)); ?></a></td>
							<td>(<?php if(!($pr_count)){echo '0';} else{ echo $rows[$i]->prod_count;} ?>)</td>
							<td><a  href="admin.php?page=cc_sliders&task=remove_cat&id=<?php echo esc_html($rows[$i]->id) ?>">Delete</a></td>
						</tr> 
					 <?php } ?>
					</tbody>
				</table>
				 <input type="hidden" name="oreder_move" id="oreder_move" value="" />
				 <input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo esc_html($_POST['asc_or_desc']);?>"  />
				 <input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo esc_html($_POST['order_by']);?>"  />
				 <input type="hidden" name="saveorder" id="saveorder" value="" />
				 <input type="hidden" name="csrf_token_cc_1752" value="csrf_token_cc_1752" />

				 <?php $_SESSION['csrf_token_cc_1752'] = 'csrf_token_cc_1752'; ?>
				</form>
			</div>
		</div>
	</div>
    <?php
}