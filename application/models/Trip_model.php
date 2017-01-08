<?php 
	class Trip_model extends CI_Model{
		public function __construct(){}

		public function register($data){
			$this->db->insert('fixed_trips',$data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}

		public function check_start_time($data){
			$start_range = new DateTime($data->start_time);
			$start_range->sub(new DateInterval('PT2H'));
			$end_range = new DateTime($data->start_time);
			$end_range->add(new DateInterval('PT2H'));
			$query = $this->db->get_where('fixed_trips',array('start_time >=' => $start_range->format('Y-m-d H:i:s'), 
															'start_time<=' => $end_range->format('Y-m-d H:i:s'),
															'driver_id' => $data->driver_id));
			if($query->num_rows()>=1)
				return $query->result();
			else
				return null;
		}

		public function get_user_trips($data){
			$query = $this->db->get_where('fixed_trips',array('driver_id' => $data->driver_id));
			if($query->num_rows()>=1)
				return $query->result();
			else
				return null;
		}

		public function get_areas(){
			$query = $this->db->get('fixed_trip_areas');
			return $query->result_array();
		}

		public function get_points_of_area($data){
			$query = $this->db->get_where('fixed_trip_points',array('area_id' => $data->area_id));
			if($query->num_rows()>=1)
				return $query->result();
			else
				return null;
		}

		public function get_roads(){
			$query = $this->db->get('fixed_trip_roads');
			return $query->result_array();
		}

		public function get_all_active_trips(){
			$query = $this->db->get_where('fixed_trips',array('status_id' => 1));
			if($query->num_rows()>=1)
				return $query->result();
			else
				return null;
		}

		public function get_point($data){
			$query = $this->db->get_where('fixed_trip_points',array('id' => $data->id));
			if($query->num_rows()===1)
				return $query->result();
			else
				return null;
		}

		public function get_area($data){
			$query = $this->db->get_where('fixed_trip_areas',array('id' => $data->id));
			if($query->num_rows()===1)
				return $query->result();
			else
				return null;
		}

		public function get_road($data){
			$query = $this->db->get_where('fixed_trip_roads',array('id' => $data->id));
			if($query->num_rows()===1)
				return $query->result();
			else
				return null;
		}

		public function get_active_start_end_areas(){
			$this->db->select('fixed_trips.id as trip_id,
				sa.id as start_area_id, sa.name as start_area_name, 
				fixed_trip_roads.id as road_id, fixed_trip_roads.name as road_name,
				ea.id as end_area_id, ea.name as end_area_name' );
			$this->db->from('fixed_trips');
			$this->db->join('fixed_trip_points sp', 'fixed_trips.start_point_id = sp.id');
			$this->db->join('fixed_trip_areas sa', 'sp.area_id = sa.id');
			$this->db->join('fixed_trip_points ep', 'fixed_trips.end_point_id = ep.id');
			$this->db->join('fixed_trip_areas ea', 'ep.area_id = ea.id');
			$this->db->join('fixed_trip_roads', 'fixed_trips.road_id = fixed_trip_roads.id');
			$this->db->where('fixed_trips.status_id=1');
			$query = $this->db->get();
			return $query->result();
		}

		public function search_active_trip_by_points($data){
			$query = $this->db->get_where('fixed_trips',array('start_point_id'=>$data->start_point_id,
															 'end_point_id'=>$data->end_point_id,
															 'status'=>1));
			if($query->num_rows()>=1)
				return $query->result();
			else
				return null;
		}

		public function search_active_trip_by_areas($data){
			$this->db->from('fixed_trips');
			$this->db->join('fixed_trip_points sp', 'fixed_trips.start_point_id = sp.id');
			$this->db->join('fixed_trip_areas sa', 'sp.area_id = sa.id');
			$this->db->join('fixed_trip_points ep', 'fixed_trips.end_point_id = ep.id');
			$this->db->join('fixed_trip_areas ea', 'ep.area_id = ea.id');
			$this->db->join('fixed_trip_roads', 'fixed_trips.road_id = fixed_trip_roads.id');
			$this->db->where('fixed_trips.status_id=1');
			$this->db->where('sa.id='.intval($data->start_area_id));
			$this->db->where('ea.id='.intval($data->end_area_id));
			$query = $this->db->get();
			if($query->num_rows()>=1)
				return $query->result();
			else
				return null;
		}

		public function get_trip($data){
			$query = $this->db->get_where('fixed_trips',array('id' => $data->trip_id));
			if($query->num_rows()===1)
				return $query->result()[0];
			else
				return null;
		}

		public function add_user_to_trip($data){
			$this->db->insert('fixed_trip_riders',$data);
		}

		public function start_trip($data){
		    $this->db->where('id', $data->trip_id);
			$this->db->update('fixed_trips', array('actual_start_time' => $data->actual_start_time));
		}

		public function end_driver_trip($data){
			$this->db->where('trip_id', $data->trip_id);
			$this->db->where('cost',null);
			$this->db->update('fixed_trip_riders', array('end_time' => $data->end_time,
														'end_point_id' => $data->end_point_id,
														'distance' => $data->distance,
														'cost' => $data->cost));	
		}

		public function end_user_trip($data){
			$this->db->where('trip_id', $data->trip_id);
			$this->db->where('user_id', $data->user_id);
			$this->db->update('fixed_trip_riders', array('end_time' => $data->end_time,
														'end_point_id' => $data->end_point_id,
														'distance' => $data->distance,
														'cost' => $data->cost));	
		}

		public function get_trip_rider($data){
			$query = $this->db->get_where('fixed_trip_riders',array('trip_id' => $data->trip_id,
																'user_id' => $data->user_id));
			if($query->num_rows()===1)
				return $query->result()[0];
			else
				return null;
		}

		public function finish_trip($data){
			$this->db->where('id', $data->trip_id);
			$this->db->update('fixed_trips', array('status_id' => 2));
		}
	}
?>