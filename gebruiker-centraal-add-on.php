<?php
/*
Plugin Name: Gebruiker Centraal Add-on
Version: 1.2
Description: Correcties op Event Manager's functionaliteit; verwijderen van de BBPress login widget.
Plugin URI: http://wbvb.nl/plugins/gebruiker-centraal-add-on/
Author: Paul van Buuren
Author URI: http://wbvb.nl/
*/



add_action( 'init', 'GC_WBVB_overrule_eventmanager', 10 );

add_action( 'widgets_init', 'GC_WBVB_remove_plugin_widgets', 10 );  


//========================================================================================================

function GC_WBVB_remove_plugin_widgets() {
  
  // bbpres login widget	
  unregister_widget('BBP_Login_Widget');

  unregister_widget('widget_meta');


  
}


//========================================================================================================


function GC_WBVB_overrule_eventmanager() {

	if ( class_exists( 'EM_Event_Post' ) ) {

		class WBVB_extend_eventmanager extends EM_Event_Post {


        	public static function init(){
        		global $wp_query;
        		//Front Side Modifiers

        		if( !is_admin() ){
        		    // replace the old filter with my new filter
        			remove_filter('the_content', array('EM_Event_Post','the_content') );
        			add_filter('the_content', array('WBVB_extend_eventmanager','the_content') );

                }
            }
                
        	public static function the_content( $content ){
    			//override formatting for single page 
        		global $post, $EM_Event, $EM_Location;

        		if( $post->post_type == EM_POST_TYPE_EVENT ){
        			if( is_archive() || is_search() ){
        				if(get_option('dbem_cp_events_archive_formats')){
        					$EM_Event = em_get_event($post);
        					$content = $EM_Event->output(get_option('dbem_event_list_item_format'));
        				}
        			}else{
        				if( get_option('dbem_cp_events_formats') && !post_password_required() ){
        					$EM_Event = em_get_event($post);
        					ob_start();
        					em_locate_template('templates/event-single.php',true);
        					$content = ob_get_clean();
        				}elseif( !post_password_required() ){
        					$EM_Event = em_get_event($post);
        					if( $EM_Event->event_rsvp ){
        					    
        					    //================
        					    // changing this line is what this plugin is all about
        					    // (see <plugins>/events-manager/classes/em-event-post.php, line 135)
        					    $content .= $EM_Event->output('<h2 id="datum">' . __('Datum en plaats','dbem') . '</h2>#_EVENTDATES,  #_EVENTTIMES{has_location}<br />#_LOCATIONNAME<br />#_LOCATIONADDRESS<br />#_LOCATIONPOSTCODE, #_LOCATIONTOWN<br />#_LOCATIONMAP<br />{/has_location} <h2 id="reserveer">' . __('Bookings','dbem') . '</h2>#_BOOKINGFORM');
        					    //================

        					    
        					}
        				}
        			}
        		}
        		return $content;
        	}
		}

        WBVB_extend_eventmanager::init();

	}

}

//========================================================================================================

