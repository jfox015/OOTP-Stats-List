<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class statslist extends Front_Controller {

	//--------------------------------------------------------------------

	public function index() 
	{
		$this->lang->load('statslist');
		
		$settings = $this->settings_lib->find_all();
		
		$this->load->model('open_sports_toolkit/leagues_model');
		$this->load->model('open_sports_toolkit/teams_model');
		
		$years = $this->leagues_model->get_all_seasons($settings['osp.league_id']);

		$this->load->helper('open_sports_toolkit/general');
        
		if ($this->input->post('submit')) 
		{
            $this->load->library('open_sports_toolkit/stats');
            
			Stats::init($settings['osp.game_sport'],$settings['osp.game_source']);
			
            $stats_list = Stats::get_stats_list();
				
			$team_id = ($this->input->post('team_id') ? $this->input->post('team_id') : false);
			$year = ($this->input->post('year')? $this->input->post('year') : false);
			
			if ($team_id !== false)
			{
				$league_year = false;
				if ($year !== false) 
				{
					$league_year = $year;
				}
				else 
				{
					$currDate = strtotime($this->leagues_model->get_league_date('current',$settings['osp.league_id']));
					$startDate = strtotime($this->leagues_model->get_league_date('start',$settings['osp.league_id']));
					if ($currDate <= $startDate) 
					{
						$league_year = (intval($years[0]));
					}
					else 
					{
						$league_year = date('Y',$currDate);
					}
				}
				$team_id = (int)$team_id;
				$league_year = (int)$league_year;
				$stat_classes = array (
					'Batting'=>stats_class(TYPE_OFFENSE, CLASS_COMPLETE, array('NAME','GENERAL')),
					'Pitching'=>stats_class(TYPE_SPECIALTY,CLASS_COMPLETE, array('NAME','GENERAL'))
				);
				$records = array (
                    'Batting'=>Stats::get_stats(ID_TEAM,$team_id,TYPE_OFFENSE,$stat_classes['Batting'],STATS_SEASON,RANGE_SEASON,array('year'=>$league_year)),
                    'Pitching'=>Stats::get_stats(ID_TEAM,$team_id,TYPE_SPECIALTY,$stat_classes['Pitching'],STATS_SEASON,RANGE_SEASON,array('year'=>$league_year))
                );
				// RENDER STATS TO VIEW CODE				
				//$batting = $records['Batting'];
				$batting = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>TYPE_OFFENSE,'stats_class'=>$stat_classes['Batting'],'stats_list'=>$stats_list,'records'=>$records['Batting']), true);
				//$pitching = array();
				$pitching = $this->load->view('open_sports_toolkit/stats_table',array('player_type'=>TYPE_SPECIALTY,'stats_class'=>$stat_classes['Pitching'],'stats_list'=>$stats_list,'records'=>$records['Pitching']), true);

				//Template::set('batting_query', $this->teams_model->get_team_stats($team_id,TYPE_OFFENSE,$headers['Batting'],STATS_SEASON,RANGE_SEASON,array('where'=>array('year'=>$league_year)),true));
				//Template::set('pitching_query', $this->teams_model->get_team_stats($team_id,TYPE_SPECIALTY,$headers['Pitching'],STATS_SEASON,RANGE_SEASON,array('where'=>array('year'=>$league_year)),true));
				
				Template::set('batting',$batting);
				Template::set('pitching',$pitching);
				Template::set('stat_classes',$stat_classes);
				Template::set('stats_list',$stats_list);
				Template::set('league_year',$league_year);
				Template::set('team_id',$team_id);
				Template::set('team_details',$this->teams_model->select('team_id, name, nickname, logo_file')->find($team_id));
			}
		}
        // ASSURE PATH COMPLIANCE TO OOPT VERSION
        $settings = get_asset_path($settings);
        $this->load->helper('form');
		$this->load->helper('url');
		Template::set('teams',$this->teams_model->get_teams_array(($settings['statslist.limit_to_primary'] == 1) ? $settings['osp.league_id'] : false));
		Template::set('years',$years);
		Template::set('settings',$settings);
		Template::set_view('statslist/index');
		Template::render();
	}
}