<?php

// Version 0.1.0

class CWP_Forms {
	
	protected $months = array(
		'','January','February','March','April','May','June','July','August','September','October','November','December'
		);
		
	protected $full_colors  = array(
		'','#fff','#eff0f1','#d7dadb','#b5babe','#8d959a','#5e6a71','#464e54','#2a3033',
		'#000','#981e32','#c60c30','#f4f2eb','#e3dfcd','#cbc4a2','#afa370','#8f7e35',
		'#72652a','#564c20','#393215','#ada400','#f8f1eb','#eddccc','#ddbea1','#cb9b6e','#b67233',
		'#925b29','#6d441f','#492e14','#f6861f','#edf3f4','#d3e1e3','#aec7cb','#82a9af','#4f868e','#3f6b72',
		'#2f5055','#203639','#00a5bd','#f9f4e7','#f1e4c4','#e5cd93','#d7b258','#c69214','#9e7510','#77580c',
		'#4f3a08','#ffb81c',
	);
	
	//Gets
	public function get_full_colors(){ return $this->full_colors; }
		
	//Gets
	public function get_months(){ return $this->months; }
	
	
	// Basic text field
	public function text_field( $name, $value, $label = false, $args = array() ){
		
		$ipt = '';
		
		if ( $label ){
			
			$ipt .= $this->label( $label , 'text' , $args );
			
		} // end if
		
		$ipt .= '<input type="text" ';
		
		$ipt .= 'name="' . $name . '" ';
		
		$ipt .= 'value="' . $value . '" '; 
		
		if ( ! empty( $args['class'] ) ){
			
			$ipt .= 'class="' . $args['class'] . '"';
			
		} // end if 
		
		$ipt .= ' />';
		
		return $this->wrap_input( $ipt );
		
	}
	
	// Month year picker
	public function month_year_select( $name, $month_value, $year_value, $label = false, $args = array() ){
		
		if ( ! empty( $args['is_array'] ) ){
			
			$name_month = $name . '[month]';
			
			$name_year = $name . '[year]';
			
		} else {
			
			$name_month = $name . '_month';
			
			$name_year = $name . '_year';
			
		} // end if
		
		$ipt = '';
		
		if ( $label ){
			
			$ipt .= $this->label( $label , 'select' , $args );
			
		} // end if
		
		$ipt .= $this->select( $name_month , $this->get_months() , $month_value , false , array('no_wrap' => true ) );
		
		$ipt .= $this->select( $name_year , $this->utility_get_year_array() , $year_value , false , array('no_wrap' => true ) , false );
		
		return $this->wrap_input( $ipt );	
		
	}
	
	// Basic Select
	public function select( $name, $values, $c_value, $label = false , $args = array(), $use_key = true ){
		
		$ipt = '';
		
		if ( $label ){
			
			$ipt .= $this->label( $label , $args , 'select' , $args );
			
		} // end if
		
		$ipt .= '<select name="' . $name . '">';
		
		foreach( $values as $key => $value ){
			
			$opt_value = ( $use_key ) ? $key : $value ;
			
			$ipt .= '<option value="' . $opt_value . '" ' . selected( $opt_value , $c_value , false ) . '>' . $value . '</option>';
			
		} // end foreach
		
		$ipt .= '</select>';
		
		return $this->wrap_input( $ipt , $args );
		
	}
	
	// Basic Checkbox 
	public function checkbox( $name , $value , $current_value = '' , $label = false , $args = array() ){
		
		$id = $name . '_' . rand( 0 , 1000000000 );
		
		$ipt = '';
		
		$ipt .= '<input type="checkbox" ';
		
		$ipt .= 'name="' . $name . '" ';
		
		$ipt .= 'value="' . $value . '" '; 
		
		$ipt .= 'id="' . $id . '" ';
		
		if ( ! empty( $args['class'] ) ){
			
			$ipt .= 'class="' . $args['class'] . '"';
			
		} // end if 
		
		
		
		$ipt .= checked( $value , $current_value, false ) . ' />';
		
		if ( $label ){
			
			$ipt .= $this->label( $label , 'checkbox' ,$args , $id );
			
		} // end if
		
		return $this->wrap_input( $ipt );
		
	}
	// Media Select
	protected function insert_media( $name , $img_id = '', $img_src = '', $class = ''){

		$input = '<span class="cwpb-add-media-wrap">';
		
		$input .= '<span class="cwpb-add-media-img">';
		
		if ( $img_src ){
			
			$input .= '<img src="' . $img_src . '" />';
			
		} // end if
		
		$input .= '</span><span  class="cwpb-add-media-img-data">';
		
		$input .= '<label>ID: </label><input type="text" value="' . $img_id . '" class="cwpb-add-media-id cwpb-input-short" name="_cwpb[' . $this->get_id() . '][settings][img_id]" max="" min="1" step="1">';
		
		$input .= '<label>SRC: </label><input type="text" class="cwpb-add-media-src" name="_cwpb[' . $this->get_id() . '][settings][img_src]" value="' . $img_src . '" /><br/>';
		
		$input .= '<a href="#" class="add-media-action cwpb-standard-button" style="margin-top: 0.5rem;">Insert Media</a>';
		
		$input .= '</span></span>';
		
		return $input;
		
	}
	
	
	// Basic label
	public function label ( $title , $type , $args = array() , $input_id = false ){
		
		$id = ( $input_id ) ? ' for="' . $input_id . '"' : '';
		
		$cls = 'cwp-input-' . $type;
		
		if ( ! empty( $args['label_class'] ) ) $cls .= ' ' . $args['label_class'];
		
		$l = '<label' . $id . ' class="' . $cls . '" >' . $title . '</label>'; 
		
		return $l;
		
	}
	
	
	// Wrap the input
	public  function wrap_input( $input , $args = array() ){
		
		if ( empty( $args['no_wrap'] ) ){
		
			$cls = ( ! empty( $args['wrap_class'] ) ) ? $args['wrap_class'] : 'inline-input ';
			
			$input = '<span class="cwp-input-wrapper ' . $cls . '">' . $input . '</span>';
		
		} // end if
		
		return $input;
		
	}
	
	// Services
	public function utility_get_year_array(){
		
		$year = date("Y");
		
		$year_array = array( '' );
		
		for ( $i = 0; $i < 150 ; $i++ ){
			
			$year_array[] = ( $year - $i );
			
		} // end for
		
		return $year_array;
		
	}
	
}