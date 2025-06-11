<?php

/**
 * GMW FL search form function - Display xprofile fields
 * @version 1.0
 * @author Eyal Fitoussi
 */
function gmw_fl_xprofile_fields( $gmw, $class ) {

    if ( ( !isset( $gmw['search_form']['profile_fields'] ) && !isset( $gmw['search_form']['profile_fields_date'] ) ) )
        return;

    $total_fields = ( isset( $gmw['search_form']['profile_fields'] ) ) ? $gmw['search_form']['profile_fields'] : array();
    
    if ( isset( $gmw['search_form']['profile_fields_date'] ) ) {
        array_unshift( $total_fields, $gmw['search_form']['profile_fields_date'] );
    }
   
    echo '<div class="gmw-fl-form-xprofile-fields gmw-fl-form-xprofile-fields-'.$gmw['ID'].' ' . $class . '">';

    foreach ( $total_fields as $field_id ) {

        $fdata  	= new BP_XProfile_Field( $field_id );
        $fname  	= 'field_'.$field_id;
        $label		= $fdata->name;
        $fclass		= 'field-'.$field_id;
        $fid		= 'gmw-'.$gmw['ID'].'-field-'.$field_id; 
        $children 	= $fdata->get_children();
      
        echo '<div class="editfield '.$fdata->type.' gmw-'.$gmw['ID'].'-field-'.$field_id.'-wrapper">';
       
        switch ( $fdata->type ) {

            case 'datebox':	
            	$value = ( isset( $_REQUEST[$fname] ) ) ? esc_attr (stripslashes ( $_REQUEST[$fname] ) ) : '';
            	$max   = ( isset( $_REQUEST[$fname . '_max'] ) ) ? esc_attr (stripslashes ( $_REQUEST[$fname.'_max'] ) ) : '';
            	 
                echo 	'<label for="'.$fid.'">' . __('Age Range (min - max)', 'GMW') . '</label>';
                echo 	'<input size="3" type="text" name="'.$fname.'" id="'.$fid.'" class="'.$fclass.'" value="'.$value.'" placeholder="'.__( 'Min', 'GMW' ).'" />';
                echo 	'&nbsp;-&nbsp;';
                echo 	'<input size="3" type="text" name="'.$fname.'-max" id="'.$fid.'_max" class="'.$fclass.'-max" value="'.$max.'" placeholder="'.__( 'Max', 'GMW' ).'" />';
            break;
           
            case 'textbox':	
            	$value = ( isset( $_REQUEST[$fname] ) ) ? esc_attr (stripslashes ( $_REQUEST[$fname] ) ) : '';
            	
            	echo '<label for="'.$fid.'">'.$label.'</label>';
            	echo '<input type="text" name="'.$fname.'" id="'.$fid.'" class="'.$fclass.'" value="'.$value.'" />';
            break;

            case 'number':
            	$value = ( isset( $_REQUEST[$fname] ) ) ? esc_attr (stripslashes ( $_REQUEST[$fname] ) ) : '';
            	
            	echo '<label for="'.$fid.'">'.$label.'</label>';
            	echo '<input type="number" name="'.$fname.'" id="'.$fid.'" value="'.$value.'" />';
            break;
            			
            case 'textarea':    	
            	$value = ( isset( $_REQUEST[$fname] ) ) ? esc_attr (stripslashes ( $_REQUEST[$fname] ) ) : '';
            	
            	echo '<label for="'.$fid.'">'.$label.'</label>';
            	echo '<textarea rows="5" cols="40" name="'.$fname.'" id="'.$fid.'" class="'.$fclass.'">'.$value.'</textarea>';
            break;
            			             	
            case 'selectbox':
            	$value = ( isset( $_REQUEST[$fname] ) ) ? esc_attr (stripslashes ( $_REQUEST[$fname] ) ) : '';
            	 
            	echo '<label for="'.$fid.'">'.$label.'</label>';
            	echo '<select name="'.$fname.'" id="'.$fid.'" class="'.$fclass.'">';
            	echo 	'<option value="">'.__( ' -- All -- ', 'GMW' ).'</option>';         	
            	
            	foreach ( $children as $child ) {
            		$option   = trim( $child->name );
            		$selected = ( $option == $value ) ? "selected='selected'" : "";
            		echo '<option '.$selected.' value="'.$option.'" />'.$option.'</label>';
            	}
            	
            	echo '</select>';
            break;
            
            case 'multiselectbox':         	
            	$value = ( isset( $_REQUEST[$fname] ) ) ? $_REQUEST[$fname] : array();
            	 
            	echo '<label for="'.$fid.'">'.$label.'</label>';
            	echo '<select name="'.$fname.'[]" id="'.$fid.'" class="'.$fclass.'" multiple="multiple">';
            	
            	foreach ( $children as $child ) {
            		$option   = trim( $child->name );
            		$selected = ( in_array( $option, $value ) ) ? "selected='selected'" : "";
            		echo '<option '.$selected.' value="'.$option.'" />'.$option.'</label>';
            	}
            	
            	echo "</select>";
            break;
            	
            case 'radio':
            	$value = ( isset( $_REQUEST[$fname] ) ) ? esc_attr (stripslashes ( $_REQUEST[$fname] ) ) : '';
            	
            	echo '<div class="radio">';
                echo '<span class="label">'.$label.'</span>';

                foreach ( $children as $child ) {
                    $option  = trim( $child->name );
                    $checked = ( $child->name == $value ) ? "checked='checked'" : "";
                    echo '<label><input '.$checked.' type="radio" name="'.$fname.'" value="'.$option.'" />'.$option.'</label>';
                }
                
				echo '<a href="#" onclick="event.preventDefault();jQuery(this).closest(\'div\').find(\'input\').prop(\'checked\', false);">'. __('Clear', 'buddypress'). '</a><br/>';
        		echo '</div>';
        		
			break;
            case 'checkbox':
            	$value = ( isset( $_REQUEST[$fname] ) ) ? $_REQUEST[$fname] : array();
            	 
            	echo '<div class="checkbox">';
                echo '<span class="label">'.$label.'</span>';

                foreach ( $children as $child ) {	
                    $option	 = trim( $child->name );
                    $checked = ( in_array( $option, $value ) ) ? "checked='checked'" : "";
                    echo '<label><input '.$checked.' type="checkbox" name="'.$fname.'[]" value="'.$option.'" />'.$option.'</label>';        
                }
                echo '</div>';

        	break;
        } // switch
        
        echo '</div>';      
    }
    echo '</div>';
}

/**
 * GMW FL Search results function - Display user's full address
 * @version 1.0
 * @author Eyal Fitoussi
 */
function gmw_fl_member_address( $gmw ) {

    global $members_template;
    echo apply_filters( 'gmw_fl_members_loop_address', $members_template->member->formatted_address, $gmw, $members_template );

}

/**
 * GMW FL Search results function - Display Radius distance
 * @version 1.0
 * @author Eyal Fitoussi
 */
function gmw_fl_get_by_radius($gmw) {
    global $members_template;

    if ( isset( $members_template->member->distance ) ) {
        return apply_filters('gmw_fl_by_radius', '<div class="gmw-fl-radius-wrapper">' . $members_template->member->distance . ' ' . $gmw['units_array']['name'] . '</div>', $gmw, $members_template);
    }
}

function gmw_fl_by_radius($gmw) {
    echo gmw_fl_get_by_radius($gmw);
}

/**
 * GMW FL search results function - "Get directions" link
 * @version 1.0
 * @author Eyal Fitoussi
 */
function gmw_fl_get_directions_link($gmw, $title) {
    global $members_template;
	  
    if ( !isset( $gmw['search_results']['get_directions'] ) )
        return;
    
    return apply_filters('gmw_fl_get_directions_link', '<a class="gmw-get-directions get-directions" href="http://maps.google.com/maps?f=d'.$gmw['language'].$gmw['region'].'&doflg=' . $gmw['units_array']['map_units'] . '&geocode=&saddr=' . $gmw['org_address'] . '&daddr=' . str_replace(" ", "+", $members_template->member->formatted_address) . '&ie=UTF8&z=12" target="_blank">' . $title . '</a>', $gmw, $members_template, $title);

}

function gmw_fl_directions_link($gmw, $title) {
    echo gmw_fl_get_directions_link($gmw, $title);

}

/**
 * GMW FL search results function - display within distance message
 * @version 1.0
 * @author Eyal Fitoussi
 */
function gmw_fl_wihtin_message($gmw) {

    if (!isset($gmw['org_address']) || empty($gmw['org_address']))
        return;
    echo ' <span>within ' . $gmw['radius'] . ' ' . $gmw['units_array']['name'] . ' from ' . $gmw['org_address'] . '</span>';

}

/**
 * GMW FL search results function - calculate driving distance
 * @version 1.0
 * @author Eyal Fitoussi
 */
function gmw_fl_driving_distance($gmw, $class) {
    global $members_template;

    if (!isset($gmw['search_results']['by_driving']) || $gmw['units_array']['name'] == false)
        return;

    echo '<div id="gmw-fl-driving-distance-' . $members_template->member->ID . '" class="' . $class . '"></div>';
    ?>
    <script>
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();

        var start = new google.maps.LatLng('<?php echo $gmw['your_lat']; ?>', '<?php echo $gmw['your_lng']; ?>');
        var end = new google.maps.LatLng('<?php echo $members_template->member->lat; ?>', '<?php echo $members_template->member->long; ?>');
        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING
        };

        directionsService.route(request, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);
                if ('<?php echo $gmw['units_array']['name']; ?>' == 'Mi') {
                    totalDistance = (Math.round(result.routes[0].legs[0].distance.value * 0.000621371192 * 10) / 10) + ' Mi';
                } else {
                    totalDistance = (Math.round(result.routes[0].legs[0].distance.value * 0.01) / 10) + ' Km';
                }

                jQuery('#<?php echo 'gmw-fl-driving-distance-' . $members_template->member->ID; ?>').text('Driving: ' + totalDistance)
            }
        });
    </script>
    <?php

}

/**
 * GMW FL Search results function - Per page dropdown
 * @version 1.0
 * @author Eyal Fitoussi
 */
function gmw_fl_per_page_dropdown($gmw, $class) {
    global $members_template;

    $perPage  = explode(",", $gmw['search_results']['per_page']);
    $lastpage = ceil($members_template->total_member_count / $gmw['get_per_page']);

    if (count($perPage) > 1) :

        echo '<select name="gmw_per_page" class="gmw-fl-per-page-dropdown ' . $class . '">';

        foreach ($perPage as $pp) :

            if (isset($_GET['gmw_per_page']) && $_GET['gmw_per_page'] == $pp)
                $pp_s = 'selected="selected"';
            else
                $pp_s = "";
            echo '<option value="' . $pp . '" ' . $pp_s . '>' . $pp . ' per page</option>';

        endforeach;

        echo '</select>';

    endif;
    ?>
    <script>
	
        jQuery(document).ready(function($) {

            $(".gmw-fl-per-page-dropdown").change(function() {

                var totalResults = <?php echo $members_template->total_member_count; ?>;
                var lastPage = Math.ceil(totalResults / $(this).val());
                var newPaged = (<?php echo $members_template->pag_num; ?> > lastPage) ? lastPage : <?php echo $members_template->pag_num; ?>;

                if ( window.location.search.length ) {
			   		window.location.href = window.location.href.replace(/(gmw_per_page=).*?(&)/,'$1' + $(this).val() + '$2').replace(/(upage=).*?(&)/,'$1' + newPaged + '$2');
			   	} else {
			   		window.location.href = window.location.href + '?gmw=auto&gmw_per_page='+$(this).val() + '&gmw_form=<?php echo $gmw['ID']; ?>&upage='+newPaged;
			   	}

            });
        });
    </script>
    <?php

}

/**
 * GMW FL results function - no members found
 */
function gmw_fl_no_members( $gmw ) {
	
	do_action( 'gmw_'.$gmw['form_type'].'_before_no_results', $gmw  );
	
	echo apply_filters( 'gmw_'.$gmw['form_type'].'_no_results_message', __( 'Sorry, No members found', 'GMW' ), $gmw );
	
	do_action( 'gmw_'.$gmw['form_type'].'_after_no_results', $gmw );
	
}

/**
 * GMW FL function - display members count
 * @para  $gmw
 * @param $gmw_options
 */
function gmw_fl_member_count($gmw) {
    global $members_template;

    echo $members_template->member->member_count;

}

/**
 * GMW_FL_Search_Query class
 *
 */
class GMW_FL_Search_Query extends GMW {

    /**
     * __construct function.
     */
    function __construct( $form ) {

        do_action( 'gmw_fl_search_query_start', $form );

        add_filter( 'gmw_fl_after_query_clauses',    array( $this, 'query_xprofile_fields' ), 5, 2 );
        add_action( 'gmw_fl_directory_member_start', array( $this, 'modify_member' 			 ), 10 );
        add_filter( 'member_loop_start', 			 array( $this, 'loop_start' 		  ), 10, 2 );

        parent::__construct( $form );
    }

    /**
     * Include search form
     * 
     */
    public function search_form() {
    	
        $gmw 	= $this->form;
        $sForm  = $this->form['search_form']['form_template'];
        
        //Load custom search form and css from child/theme folder
        if ( strpos( $sForm, 'custom_' ) !== false ) {
        
        	$sForm = str_replace( 'custom_', '', $this->form['search_form']['form_template'] );
        	
        	if ( !wp_style_is( 'gmw-custom-' . $sForm . '-form-style' ) )
        		wp_enqueue_style( 'gmw-custom-' . $sForm . '-form-style', get_stylesheet_directory_uri() . '/geo-my-wp/friends/search-forms/' . $sForm . '/css/style.css' );
        
        	include( STYLESHEETPATH . '/geo-my-wp/friends/search-forms/' . $sForm . '/search-form.php' );
        
        } else {
        
        	if ( !wp_style_is( 'gmw-'. $sForm .'-form-style', 'enquequed' ) )
        		wp_enqueue_style( 'gmw-'. $sForm .'-form-style', GMW_FL_URL. '/search-forms/'.$sForm.'/css/style.css' );
        	include GMW_FL_PATH .'/search-forms/'. $sForm.'/search-form.php';       
        }
    }

    /**
     * Query xprofile fields
     * @version 1.0
     * @author Eyal Fitoussi
     * @author Some of the code in this function was inspired by the code written by Andrea Taranti the creator of BP Profile Search - Thank you
     */
    public function query_xprofile_fields( $clauses ) {

        global $bp, $wpdb;

        $total_fields = false;
        $total_fields = ( isset( $this->form['search_form']['profile_fields'] ) ) ? $this->form['search_form']['profile_fields'] : array();
        
        if ( isset( $this->form['search_form']['profile_fields_date'] ) && !empty( $this->form['search_form']['profile_fields_date']) ) {
            array_unshift( $total_fields, $this->form['search_form']['profile_fields_date'] );
        }
        
        if ( !isset( $total_fields ) || empty( $total_fields ) )
            return $clauses;

        $empty_fields = array();
        $userids      = false;
         
        foreach ( $total_fields as $field_id ) {

        	$fdata  = new BP_XProfile_Field( $field_id );
        	$fname  = 'field_'.$field_id;        	
            $value  = ( isset( $_REQUEST[$fname] ) ) ? $_REQUEST[$fname] : '';
            $max   	= ( isset( $_REQUEST[$fname.'_max'] ) ) ? $_REQUEST[$fname.'_max'] : '';
            $sql 	= $wpdb->prepare ( "SELECT `user_id` FROM {$bp->profile->table_name_data} WHERE `field_id` = %d ", $field_id );
             
            if ( $value ) {
                array_push( $empty_fields, $value );
            }
            
            if ( $value || $max ) {
	
                switch ( $fdata->type ) {
					
                	case 'textbox':
                	case 'textarea':	
                		$value 	 = str_replace ( '&', '&amp;', $value );
                		$escaped = '%'. esc_sql ( like_escape ( $value ) ). '%';
                		$sql 	.= $wpdb->prepare ( "AND value LIKE %s", $escaped );
                	break;
                	
                	case 'number':
                		$sql .= $wpdb->prepare ( "AND value = %d", $value );
                	break;
                		
                    case 'selectbox':
					case 'radio':
						$value = str_replace ( '&', '&amp;', $value );
						$sql  .= $wpdb->prepare ( "AND value = %s", $value );
					break;
					
                    case 'multiselectbox':
                    case 'checkbox':
						
                    	$values = $value;
                    	$like   = array ();
                    	
                    	foreach ($values as $value) {
                    		$value   = str_replace ( '&', '&amp;', $value );
                    		$escaped = '%"'. esc_sql ( like_escape ( $value ) ). '"%';
                    		$like[]  = $wpdb->prepare ( "value = %s OR value LIKE %s", $value, $escaped );
                    	}
                    	
                    	$sql .= 'AND ('. implode (' OR ', $like). ')';
                    	
                    	/*
                        $like = array();

                        foreach ( $value as $curvalue ) {
                            $like[] = "value = '$curvalue' OR value LIKE '%\"$curvalue\"%' ";
                        }
                        
                        $sql .= ' AND (' . implode(' OR ', $like) . ')';
						*/
                    	
                    break;
                    case 'datebox':

                        $value = ( !$value ) ? '1' : $value;
                        $max    = ( !$max ) ? '200' : $max;
                        
                        if ( $max < $value ) {
                            $max = $value;
                        }
                        
                        $time  = time();
                        $day   = date("j", $time);
                        $month = date("n", $time);
                        $year  = date("Y", $time);
                        $ymin  = $year - $max - 1;
                        $ymax  = $year - $value;
 
                        if ($max !== '')   $sql .= $wpdb->prepare ("AND DATE(value) > %s", "$ymin-$month-$day");
                        if ($value !== '') $sql .= $wpdb->prepare ("AND DATE(value) <= %s", "$ymax-$month-$day");
                       // $sql = "SELECT user_id from {$bp->profile->table_name_data}";
                        //$sql .= " WHERE field_id = $field_id AND value > '$ymin-$month-$day' AND value <= '$ymax-$month-$day'";

                	break;
                	
                }
                
                $results = $wpdb->get_col( $sql, 0 );
                                  
                if ( !is_array( $userids ) ) {
                	$userids = $results;
                } else {
                	$userids = array_intersect( $userids, $results );
                }
                     
            } // if value //
        } // for eaech //
                  
        /* build SQL filter from profile fields results - member ids array */
        if ( isset( $userids ) && !empty( $userids ) ) {

            $clauses['bp_user_query']['where'] .= $wpdb->prepare(" AND gmwlocations.member_id IN (" . str_repeat( "%d,", count( $userids ) - 1 ) . "%d )", $userids );
            return $clauses;
        
        /* if no results and profile fields are not empty - buba is going to stop the function */ 
        } elseif ( !empty( $empty_fields ) ) {

            $clauses['bp_user_query']['where'] .= " AND 1 = 0 ";
            return $clauses;
        } else {
            return $clauses;
        }
    }

    /**
     * members query clauses
     * @version 1.0
     * @author Eyal Fitoussi
     */
    public function query_clauses() {

        global $wpdb;

        $clauses['bp_user_query'] = false;
        $clauses['wp_user_query'] = false;
		$this->advanced_query = apply_filters( 'gmw_fl_advanced_query', false, $this->form );
		
        /*
         * prepare the filter of bp_query_user. the filter will modify the SQL function and will check the distance
         * of each user from the address entered and will results in user ID's of the users that within
         * the radius entered. The user IDs will then pass to the next wp_query_user below.
         */
        if ( !empty($this->form['org_address'] ) ) {
            /*
             * if address entered:
             * prepare the filter of the select clause of the SQL function. the function join Buddypress's members table with
             * wppl_friends_locator table, will calculate the distance and will get only the members that
             * within the radius was chosen
             */
        	
        	if ( $this->advanced_query ) {      		
        		$clauses['bp_user_query']['select']   = $wpdb->prepare("SELECT u.ID as id, ROUND( %d * acos( cos( radians( %s ) ) * cos( radians( gmwlocations.lat ) ) * cos( radians( gmwlocations.long ) - radians( %s ) ) + sin( radians( %s ) ) * sin( radians( gmwlocations.lat) ) ),1 ) AS distance ", array( $this->form['units_array']['radius'], 
        				$this->form['your_lat'], $this->form['your_lng'], $this->form['your_lat'] ) );    
        		   		
        		$clauses['bp_user_query']['from']     = " FROM {$wpdb->users} u INNER JOIN wppl_friends_locator gmwlocations ON u.id = gmwlocations.member_id";      	
        		$clauses['bp_user_query']['where']    = " AND ( gmwlocations.lat != '0.000000' AND gmwlocations.long != '0.000000' ) ";
        	} else {
	            $clauses['bp_user_query']['select']   = $wpdb->prepare(" SELECT gmwlocations.member_id as id, 			
					ROUND( %d * acos( cos( radians( %s ) ) * cos( radians( gmwlocations.lat ) ) * cos( radians( gmwlocations.long ) - radians( %s ) ) + sin( radians( %s ) ) * sin( radians( gmwlocations.lat) ) ),1 ) AS distance ", $this->form['units_array']['radius'], $this->form['your_lat'], $this->form['your_lng'], $this->form['your_lat']);	
	            $clauses['bp_user_query']['from']     = " FROM wppl_friends_locator gmwlocations";	      
	            $clauses['bp_user_query']['where']    = " WHERE ( gmwlocations.lat != '0.000000' AND gmwlocations.long != '0.000000' ) ";
        	}
        		
        	$clauses['bp_user_query']['having']   = $wpdb->prepare('HAVING distance <= %d OR distance IS NULL ', $this->form['radius']);
        	$clauses['bp_user_query']['order_by'] = 'ORDER BY distance';
        
        } else {
            /*
             * if no address entered choose all members that in members table and wppl_friends_locator table
             * check agains the useids (returned from xprofile fields query) if exist and results in ids
             */
        	if ( $this->advanced_query ) {       		
        		$clauses['bp_user_query']['select']   = " SELECT u.ID as id";      		
        		$clauses['bp_user_query']['from']     = " FROM {$wpdb->users} u INNER JOIN wppl_friends_locator gmwlocations ON u.id = gmwlocations.member_id";      
        		$clauses['bp_user_query']['where']    = " AND ( gmwlocations.lat != '0.000000' AND gmwlocations.long != '0.000000' ) ";
        	} else {
	            $clauses['bp_user_query']['select']   = " SELECT gmwlocations.member_id as id ";	            
	            $clauses['bp_user_query']['from']     = " FROM wppl_friends_locator gmwlocations";
	            $clauses['bp_user_query']['where']    = " WHERE ( gmwlocations.lat != '0.000000' AND gmwlocations.long != '0.000000' ) ";
        	}
        	$clauses['bp_user_query']['having']   = "";
        	$clauses['bp_user_query']['order_by'] = "";
        	
        }
       
        /*
         * prepare the filter of the wp_query_user which is within bp_query_user.
         * the filter will modify the SQL function and will calculate the distance of each user
         * in the array of user IDs that was returned from the function above.
         * the filter will also add the members information from wppl_friends_locator table into the results
         * as well as the distance.
         */
        if ( !empty( $this->form['org_address'] ) ) {
            $clauses['wp_user_query']['query_fields'] = $wpdb->prepare(" , gmwlocations.* , 
					ROUND( %d * acos( cos( radians( %s ) ) * cos( radians( gmwlocations.lat ) ) * cos( radians( gmwlocations.long ) - radians( %s ) ) + sin( radians( %s ) ) * sin( radians( gmwlocations.lat) ) ),1 ) AS distance", $this->form['units_array']['radius'], $this->form['your_lat'], $this->form['your_lng'], $this->form['your_lat']);
        } else {
            $clauses['wp_user_query']['query_fields'] = " , gmwlocations.* ";
        }
        $clauses['wp_user_query']['query_from']    = " INNER JOIN wppl_friends_locator gmwlocations ON ID = gmwlocations.member_id ";
        $clauses['wp_user_query']['query_where']   = " AND ( gmwlocations.lat != '0.000000' AND gmwlocations.long != '0.000000' ) ";
		$clauses['wp_user_query']['query_orderby'] = " ORDER BY user_login ASC ";
		$clauses['wp_user_query']['query_limit']   = "";
       	
        return apply_filters( 'gmw_fl_after_query_clauses', $clauses, $this->form );
    }

    /**
     * Add filter to BP_user_query
     * @version 1.0
     * @author Eyal Fitoussi
     */
    public function gmwBpQuery($gmwBpQuery) {
    	
    	
    	if ( $this->advanced_query ) {
	    	
	    	if ( empty( $gmwBpQuery->uid_clauses['where'] ) ) {
	    		$gmwBpQuery->uid_clauses['where'] = " WHERE 1 = 1 ";
	    	}
	    	$gmwBpQuery->uid_clauses['where']  .= $this->clauses['bp_user_query']['where'];
    	
    	} else {	
	        $gmwBpQuery->uid_clauses['where']      = $this->clauses['bp_user_query']['where'];	        
    	}
    	    	
    	// modify the function to to calculate the total rows(members).
    	$gmwBpQuery->query_vars['count_total'] = 'sql_calc_found_rows';
    	$gmwBpQuery->uid_clauses['select']     = $this->clauses['bp_user_query']['select'];
    	$gmwBpQuery->uid_clauses['select'] 	  .= $this->clauses['bp_user_query']['from'];
    	$gmwBpQuery->uid_clauses['where'] 	  .= $this->clauses['bp_user_query']['having'];
    	
        if ( isset( $this->clauses['bp_user_query']['order_by'] ) ) {
            $gmwBpQuery->uid_clauses['orderby']    = $this->clauses['bp_user_query']['order_by'];
        }
        if ( isset( $this->clauses['bp_user_query']['order'] ) ) {
            $gmwBpQuery->uid_clauses['order']      = $this->clauses['bp_user_query']['order'];
        }

        return $gmwBpQuery;
    }

    /**
     * Add filter to WP_user_query
     * @version 1.0
     * @author Eyal Fitoussi
     */
    public function gmwWpQuery( $gmwWpQuery ) {

        $gmwWpQuery->query_fields  .= $this->clauses['wp_user_query']['query_fields'];
        $gmwWpQuery->query_from    .= $this->clauses['wp_user_query']['query_from'];
        $gmwWpQuery->query_where   .= $this->clauses['wp_user_query']['query_where'];
        $gmwWpQuery->query_orderby  = $this->clauses['wp_user_query']['query_orderby'];
        $gmwWpQuery->query_limit    = $this->clauses['wp_user_query']['query_limit'];

        return $gmwWpQuery;
    }

    public function loop_start() {
        global $members_template;

        //setup member count
        $this->form['paged']        = (!isset($_GET['upage']) || $_GET['upage'] == 1 ) ? 1 : $_GET['upage'];
        $this->form['member_count'] = ( $this->form['paged'] == 1 ) ? 1 : ( $this->form['get_per_page'] * ( $this->form['paged'] - 1 ) ) + 1;
        $this->form['results']      = $members_template->members;
    }

    /**
     * modify members_template in the loop
     * @version 1.0
     * @author Eyal Fitoussi
     */
    public function modify_member() {
        global $members_template;

        $members_template->member->member_count 		= $this->form['member_count'];
        $members_template->member->mapIcon      		= apply_filters( 'gmw_fl_map_icon', 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=' . $members_template->member->member_count . '|FF776B|000000', $members_template->member, $this->form );
		$members_template->member->info_window_content 	= self::info_window_content( $members_template->member );
        
		$this->form['member_count'] ++;

        $members_template = apply_filters( 'gmw_fl_modify_member', $members_template, $this->form );
    }
	
    /**
     * create the content of the info window
     * @since 2.5
     * @param unknown_type $member
     * @return string
     */
    public function info_window_content( $member ) {
    
    	$address = ( !empty( $member->formatted_address ) ) ? $member->formatted_address : $member->address;
    	 
    	$output  = '';
    	$output .= '<div class="wppl-fl-info-window">';
    	$output .= '<div class="wppl-info-window-thumb">'.bp_get_member_avatar($args= 'type=full').'</div>';
    	$output .= '<div class="wppl-info-window-info">';
    	$output .= '<table>';
    	$output .= '<tr><td><div class="wppl-info-window-permalink"><a href="'.bp_get_member_permalink().'">'.$member->display_name.'</a> test</div></td></tr>';
    	$output .= '<tr><td><span>'.$this->form['labels']['info_window']['address'].'</span>'.$address.'</td></tr>';
    	if ( isset( $member->distance ) ) {
    		$output .= '<tr><td><span>'.$this->form['labels']['info_window']['distance'].'</span>'.$member->distance.' '.$this->form['units_array']['name'].'</td></tr>';
    	}
    	 
    	$output .= '</table>';
    	$output .= '</div>';
    	$output .= '</div>';
    	 
    	return apply_filters( 'gmw_fl_inco_window_content', $output, $member, $this->form );
    }
    
    public function results() {

        echo '<div id="buddypress">';

     
        $this->form['query_args'] = array(
        		'type'     => 'distance',
        		'per_page' => $this->form['get_per_page'],
        );

        // Hooks
        $this->form = apply_filters( 'gmw_fl_form_before_members_query', $this->form, $this->settings );
        do_action( 'gmw_fl_before_memebrs_query', $this->form, $this->settings );

        // query clauses
        $this->clauses = $this->query_clauses();
        
        add_action('bp_pre_user_query', array($this, 'gmwBpQuery'));
        add_action('pre_user_query', 	array($this, 'gmwWpQuery'));
        
        //load results template file to display list of members
        if ( isset( $this->form['search_results']['display_members'] ) ) {

            $gmw = $this->form;
		
            // include custom results and stylesheet pages from child/theme 
            if ( strpos( $this->form['search_results']['results_template'], 'custom_') !== false ) {

                $sResults = str_replace( 'custom_', '', $this->form['search_results']['results_template'] );
                wp_register_style( 'gmw-current-style', get_stylesheet_directory_uri() . '/geo-my-wp/friends/search-results/' . $sResults . '/css/style.css' );
                wp_enqueue_style( 'gmw-current-style');

                include(STYLESHEETPATH . '/geo-my-wp/friends/search-results/' . $sResults . '/results.php');
            //include results and stylesheet pages from plugin's folder
            } else {

                wp_register_style( 'gmw-current-style', GMW_FL_URL . 'search-results/' . $this->form['search_results']['results_template'] . '/css/style.css' );
                wp_enqueue_style( 'gmw-current-style' );
                include GMW_FL_PATH . 'search-results/' . $this->form['search_results']['results_template'] . '/results.php';
            }

        /*
         * if we do not display list of members we still need to have a loop
         * and add some information to each members in order to be able to 
         * display it on the map
         */
        } else {
            if ( bp_has_members( $this->form['query_args'] ) ) {
                while ( bp_members()) : bp_the_member();
                    self::modify_member();
                endwhile;
            } 
        }

        global $members_template;

        // if we need to display map
        if ($this->form['search_results']['display_map'] != 'na') {

        	$this->form       = apply_filters( 'gmw_fl_form_before_map',    $this->form, $members_template, $this->settings );
        	$members_template = apply_filters( 'gmw_fl_members_before_map', $members_template, $this->form, $this->settings );

        	do_action( 'gmw_fl_has_memebrs_before_map', $this->form, $this->settings, $members_template );

        	$form            = $this->form;
        	$form['results'] = $members_template->members;

        	wp_enqueue_script( 'gmw-map', true );
        	wp_localize_script( 'gmw-map', 'gmwForm', $form );
        }
        echo '</div>';
    }
}