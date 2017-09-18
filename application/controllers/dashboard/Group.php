<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        $this->load->model('M_dashboard', 'admin', TRUE);

        $this->load->model('M_identitas', 'identitas', TRUE);
        $this->data['iden_data'] = $this->identitas->get_identitas();
    }

    public function index(){

        if (!$this->ion_auth->logged_in())
        {
            redirect('dashboard/login', 'refresh');
        }
        else {

            $keyword = '';

            $config['base_url'] = base_url() . 'dashboard/group/index/';
            $config['total_rows'] = $this->admin->total_rows_group();
            $config['per_page'] = 10;
            $config['uri_segment'] = 4;
            $config['first_url'] = base_url() . 'dashboard/group';
            $this->pagination->initialize($config);

            $start = $this->uri->segment(4, 0);
            $group = $this->admin->index_limit_group($config['per_page'], $start);


            $this->data['group_data']   = $group;
            $this->data['keyword']      = $keyword;
            $this->data['pagination']   = $this->pagination->create_links();
            $this->data['total_rows']   = $config['total_rows'];
            $this->data['start']        = $start;
            $this->data['judul_pendek'] = 'Master Group User';

            $this->data['main_view']	= "dashboard/group/group_list";
            $this->load->view('dashboard/dashboard', $this->data);
        }

    }
    // create a new group
    public function create()
    {
        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('dashboard/login', 'refresh');
        }

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

        if ($this->form_validation->run() == TRUE)
        {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if($new_group_id)
            {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect(site_url('dashboard/group'));
            }
        }
        else
        {
            // display the create group form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['group_name'] = array(
                'name'  => 'group_name',
                'id'    => 'group_name',
                'type'  => 'text',
                'class'  => 'form-control',
                'value' => $this->form_validation->set_value('group_name'),
            );
            $this->data['description'] = array(
                'name'  => 'description',
                'id'    => 'description',
                'type'  => 'text',
                'class'  => 'form-control',
                'value' => $this->form_validation->set_value('description'),
            );


            $this->data['judul_pendek'] = 'Tambah Group';
            $this->data['action']       = site_url('dashboard/group/create');
            $this->data['main_view']    = 'dashboard/group/group_form';

            $this->load->view('dashboard/dashboard', $this->data);

//            $this->_render_page('dashboard/create_group', $this->data);
        }
    }

    // edit a group
    public function edit($id)
    {

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('dashboard/login', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

        if (isset($_POST) && !empty($_POST))
        {
            if ($this->form_validation->run() === TRUE)
            {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if($group_update)
                {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                }
                else
                {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect(site_url('dashboard/group'));
            }
        }

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['group'] = $group;

        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

        $this->data['group_id'] = array(
            'name'    => 'group_id',
            'id'      => 'group_id',
            'type'    => 'hidden',
            'class'    => 'form-control',
            'value'   => $this->form_validation->set_value('group_id', $group->id),
            $readonly => $readonly,
        );
        $this->data['group_name'] = array(
            'name'    => 'group_name',
            'id'      => 'group_name',
            'type'    => 'text',
            'class'    => 'form-control',
            'value'   => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );
        $this->data['group_description'] = array(
            'name'  => 'group_description',
            'id'    => 'group_description',
            'type'  => 'text',
            'class'    => 'form-control',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );

        $this->data['judul_pendek'] = 'Edit Group';
        $this->data['action']       = site_url('dashboard/group/edit');
        $this->data['main_view']    = 'dashboard/group/group_edit';

        $this->load->view('dashboard/dashboard', $this->data);
    }



    public function search(){
        $keyword = $this->uri->segment(4, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');

        if ($this->uri->segment(3)=='search') {
            $config['base_url'] = base_url() . 'dashboard/group/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'dashboard/group/index/';
        }

        $config['total_rows'] = $this->admin->search_total_rows_group($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 5;
        $config['first_url'] = base_url() . 'dashboard/group/search/'.$keyword;
        $this->pagination->initialize($config);

        $start = $this->uri->segment(5, 0);
        $group = $this->admin->search_index_limit_group($config['per_page'], $start, $keyword);

        $this->data['group_data']   = $group;
        $this->data['keyword']      = $keyword;
        $this->data['pagination']   = $this->pagination->create_links();
        $this->data['total_rows']   = $config['total_rows'];
        $this->data['start']        = $start;

        $this->data['main_view']	= "dashboard/group/group_list";

        $this->load->view('dashboard/dashboard', $this->data);

    }




    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    public function _valid_csrf_nonce()
    {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
    {

        $this->viewdata = (empty($data)) ? $this->data: $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
    }


}