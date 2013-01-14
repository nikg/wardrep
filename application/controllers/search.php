<?php

/**
 * @ignore
 */
defined('BASEPATH') OR exit;

/**
 * Search
 */
class Search extends AppController {
    /* Member variables */
    public $_ogdi = null;
    
    /**
     * __construct
     *
     * @access: public
     * @param: void
     * @return: void
     */
    public function __construct() {
        parent::__construct();
        
        $this->load->library('OGDI', null, '_ogdi');
        
        if( !$this->_session->exists('valid_cities') )
        {
            $this->_load_valid_cities();
        }
    }
    
    /**
     * index
     *
     * @access: public
     * @param: void
     * @return: void
     */
    public function index($type = 'address', $data = null) {
        $data = str_replace(array('_'), array(' '), trim($data));
        
        $this->_view_vars['search_terms'] = '';
        $this->_view_vars['has_ambiguous_terms'] = $has_ambiguous_terms = false;
        $this->_view_vars['has_error'] = $has_error = false;
        $this->_view_vars['has_results'] = $has_results = false;
        
        $invoke_search = false;
        
        if( 'address' == $type && !empty($data) )
        {
            $search_type   = 'address';
            $search_terms  = $data;
            $invoke_search = true;
        }
        else if( $this->input->post('search') )
        {
            $search_type   = 'address';
            $search_terms  = $this->input->post('search_terms');
            
            if( empty($search_terms) )
            {
                $has_error = true;
                $this->_view_vars['error_message'] = 'You must enter search terms before you can continue.';
            }
            else
            {
                redirect('search/' . implode('/', array($search_type, $search_terms)));
                exit;
            }
        }
        
        if( $invoke_search && !$has_error ) {
            $this->_view_vars['search_terms'] = &$search_terms;
            
            $this->load->library('BingMaps', null, '_bing_maps');
            $terms_geocoded = $this->_bing_maps->geocode_lookup_latlng($search_terms);
            
            if( is_array($terms_geocoded) ) {
                $terms_geocoded_size = count($terms_geocoded);
                if( 1 == $terms_geocoded_size ) {
                    $terms_geocoded = $terms_geocoded[0];
                }
                else if( 1 < $terms_geocoded_size ) {
                    $same_coords = false;
                    foreach( $terms_geocoded as $i => &$term )
                    {
                        for( $j = 0; $j != $terms_geocoded_size; ++$j )
                        {
                            if( $j == $i )
                            {
                                continue;
                            }
                            
                            if( round($term->latitude, 2) == round($terms_geocoded[$j]->latitude, 2) && round($term->longitude, 2) == round($terms_geocoded[$j]->longitude, 2) )
                            {
                                $same_coords = true;
                            } else {
								$same_coords = false;
							}
                        }
                    }
                    unset($term);
                    
                    if( !$same_coords )
                    {
                        $this->_view_vars['has_ambiguous_terms'] = $has_ambiguous_terms = true;
                    }
                    
                    $terms_geocoded = $terms_geocoded[0];
                }
                else {
                    $terms_geocoded = null;
                    $has_error      = true;
                    $this->_view_vars['error_message'] = 'An error occurred while attempting to geocode the entered search terms. Please try again.';
                }
                unset($terms_geocoded_size);
            }
            
            $this->_view_vars['geocoded_search_terms'] = $terms_geocoded;
            
            if( !$has_ambiguous_terms ) {
                if( !$has_error )
                {
                    if( !isset($terms_geocoded->country) || isset($terms_geocoded->country) && 'canada' != strtolower($terms_geocoded->country) )
                    {
                        $has_error = true;
                        $this->_view_vars['error_message'] = 'Only Canadian addresses are accepted and valid.';
                    }
                }
                
                if( !$has_error )
                {
                    $valid_cities = $this->_session->get('valid_cities');
                    if( !in_array($terms_geocoded->city, $valid_cities) )
                    {
                        $has_error = true;
                        $this->_view_vars['error_message'] = 'The city and representative information for your address is not available.';
                    }
                }
            }
            
            if( !$has_error && !$has_ambiguous_terms ) {
                $representative_results = $this->_ogdi->query('WardRepRepresentatives', sprintf("city eq '%s'", $terms_geocoded->city));
                $representative_result_count = count($representative_results);
                
                $ward_results = $this->_ogdi->query('CityWards', "city eq '{$terms_geocoded->city}'");
                $ward_result_count = count($ward_results);
                
                if( 0 < $representative_result_count && 0 < $ward_result_count )
                {
                    $result_count = array('councillor' => 0, 'regional councillor' => 0, 'mayor' => 0);
                    $results      = array('councillor' => array(), 'regional councillor' => array(), 'mayor' => array());
            
                    foreach( $representative_results as &$rep )
                    {
                        
						/* START track wardnumber & wardname for each rep */

						foreach( $ward_results as &$xward )
                        {
							 if( isset($rep->wardid ))
							 {
								// print sprintf('<p>%s</p>', $rep->wardid);
								if( $xward->wardid == $rep->wardid  )
								{
									// print sprintf('<p> Ward ID: %s - ', $xward->wardid);
									// print sprintf('Rep: %s - ', $rep->lastname);
									// print sprintf('WardNumber: %s - ', $xward->wardnumber);
									// print sprintf('WardName: %s </p> ', $xward->wardname);
									
									$rep->wardnumber = $xward->wardnumber;
									$rep->wardname = $xward->wardname;
								}
							 }
                        }  
						unset($xward);
						// print_r($rep);
						
						/* END track wardnumber/wardname */
						
						switch( strtolower($rep->representativetype) )
                        {
                            case 'city councillor':
                                $results['councillor'][] = $rep;
                                ++$result_count['councillor'];
                                break;
                            
                            case 'mayor':
                                $results['mayor'][] = $rep;
                                ++$result_count['mayor'];
                                break;
                            
                            case 'local & regional councillor':
                                $results['regional councillor'][] = $rep;
                                ++$result_count['regional councillor'];
                                break;
                        }
						
						// print (print_r($results['regional councillor']) . "<p>");
						// print (print_r($result_count['regional councillor']) . "<HR>");
                    }
                    unset($reps);
                    
                    $representative_results = $results;
                    $representative_result_count = $result_count;
                    
                    unset($result_count, $results);
                    
                    usort($representative_results['councillor'], '_sort_wardreps_by_wardid');
                    usort($representative_results['regional councillor'], '_sort_wardreps_by_wardid');
                    
                    $searched_location = array(
                        'geocode' => $terms_geocoded,
                        'pushpin' => site_url('/assets/images/point.png'),
                        'ward' => null,
                        'representatives' => array(
                            'data' => array(),
                            'count' => 0
                        )
                    );
                    
					/* Lookup Address against Ward Coorindates */
					
                    $sloc_ward_found = false;
                    foreach( $ward_results as &$ward )
                    {
                        $kml_coords = explode('|', $ward->kmlcoords);
                        $bound_coords = array();
                        $bound_coords_size = 0;
                        
                        foreach( $kml_coords as $coords )
                        {
                            $coords = explode(",", $coords);
                            $bound_coords[] = array('lat' => (double) $coords[1], 'lng' => (double) $coords[0]);
                            ++$bound_coords_size;
                        }                        
                        $ward->bound_coords = $bound_coords;
                        
                        if( !$sloc_ward_found )
                        {
                            $is_point_in_poly = false;
                            
                            $lhs = $rhs = null;
                            $rhs = $ward->bound_coords[$bound_coords_size - 1];
                            
                            for( $i = 0; $i < $bound_coords_size; ++$i )
                            {
                                $lhs = $ward->bound_coords[$i];
                                
                                if( $lhs['lng'] < $searched_location['geocode']->longitude && $rhs['lng'] >= $searched_location['geocode']->longitude ||
                                    $rhs['lng'] < $searched_location['geocode']->longitude && $lhs['lng'] >= $searched_location['geocode']->longitude )
                                {   
                                    $val = $lhs['lat'] + ($searched_location['geocode']->longitude - $lhs['lng']) / ($rhs['lng'] - $lhs['lng']) * ($rhs['lat'] - $lhs['lat']);
                                    if( $val < $searched_location['geocode']->latitude )
                                    {
                                        $is_point_in_poly = !$is_point_in_poly;
                                    }
                                }
                                
                                $rhs = $lhs;
                            }
                            
                            if( $is_point_in_poly )
                            {
                                $searched_location['ward'] = &$ward;
                                foreach( $representative_results['councillor'] as &$representative )
                                {
                                    if( $ward->wardid == $representative->wardid )  /* changed to account for WardID update in OGDI */
                                    {
                                        $searched_location['representatives']['data'][] = &$representative;
                                        ++$searched_location['representatives']['count'];
                                    }
                                }
                                unset($representative);
								
								/* Added for Regional Councilor */ 
								foreach( $representative_results['regional councillor'] as &$representative )
                                {
                                    if( $ward->wardid == $representative->wardid )  // changed to account for WardID update in OGDI 
                                    {
                                        $searched_location['representatives']['data'][] = &$representative;
                                        ++$searched_location['representatives']['count'];
                                    }
                                }
                                unset($representative);
                                
                                $sloc_ward_found = true;
                            }
                        }
                    }
                    
                    $colors = $this->config->item('search_poly_colors');
                    shuffle($colors);
                    
                    $this->_view_vars['application_js']['Application']['config']['search'] = array(
                        'representatives' => array(
                            'count' => $representative_result_count,
                            'data'  => $representative_results
                        ),
                        'wards' => array(
                            'count' => $ward_result_count,
                            'data' => $ward_results
                        ),
                        'polygon_bg_colors' => $colors,
                        'searched_location' => $searched_location
                    );
                    
                    $this->_view_vars['representative_results'] = &$representative_results;
                    $this->_view_vars['representative_result_count'] = $representative_result_count;
                    $this->_view_vars['searched_location'] = &$searched_location;
                    $this->_view_vars['has_results'] = $has_results = true;
                }
                else
                {
                    $has_error = true;
                    $this->_view_vars['error_message'] = 'Unable to find city and representative information for your address.';
                }
            }
        }
        
        $this->_view_vars['has_error'] = $has_error;
        
        $this->render(array('header', 'search', 'footer'));
    }
    
    private function _load_valid_cities()
    {
        $valid_cities = array();
        $data = $this->_ogdi->query('WardRepRepresentatives');
        foreach( $data as $key => $entity )
        {
            if( !in_array($entity->city, $valid_cities) )
            {
                $valid_cities[] = $entity->city;
            }
        }
        
        $this->_session->set('valid_cities', $valid_cities);
    }
}

function _sort_wardreps_by_wardid($lhs, $rhs) {
    if( !isset($lhs->wardid) || !isset($rhs->wardid) )
    {
        $lhs->wardid = null;
        $rhs->wardid = null;
        
        throw new Exception('Unable to sort Representative entities on "wardnumber" field.');
    }
    
    if( $lhs->wardid == $rhs->wardid )
        return 0;
    
    return $lhs->wardid < $rhs->wardid ? -1 : 1;
}