<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class settings extends Admin_Controller {

	//--------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('OOLM.StatsList.Manage');
		 if (!class_exists('Activity_model'))
        {
            $this->load->model('activities/Activity_model', 'activity_model', true);
        }
		$this->lang->load('statslist');
	}

	//--------------------------------------------------------------------
	
	public function index()
	{
		if ($this->input->post('submit'))
        {
            if ($this->save_settings())
            {
                Template::set_message(lang('sl_settings_saved'), 'success');
				redirect(SITE_AREA.'/content/');
            } 
			else
            {
                Template::set_message('There was an error saving your settings.', 'error');
            }
        }
		Template::set('settings', $this->settings_lib->find_all_by('module','statslist'));
		Template::set('toolbar_title', lang('statslist_manage'));
        Template::set_view('statslist/settings/index');
        Template::render();
	}

    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------

    private function save_settings()
    {
		$this->load->library('form_validation');

        $this->form_validation->set_rules('limit_to_primary', lang('sl_limit_to_primary'), 'numeric|trim|strip_tags|maxlength[1]|xss_clean');
        if ($this->form_validation->run() === false)
        {
            return false;
        }
		$data = array(
            array('name' => 'statslist.limit_to_primary', 'value' => ($this->input->post('limit_to_primary') ? $this->input->post('limit_to_primary') : 0)),
        );
        //destroy the saved update message in case they changed update preferences.
        if ($this->cache->get('update_message'))
        {
            if (!is_writeable(FCPATH.APPPATH.'cache/'))
            {
                $this->cache->delete('update_message');
            }
        }
        // Log the activity
        $this->activity_model->log_activity($this->auth->user_id(), lang('sl_settings_saved').': ' . $this->input->ip_address(), 'StatsList');

        // save the settings to the DB
        $updated = $this->settings_model->update_batch($data, 'name');

        return $updated;
	}
}