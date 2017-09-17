<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* ------------------------------- Manajemen Login -------------------------------*/
    public function load_form_rules()
    {
        $form_rules = array(
            array('field' => 'username','label' => 'Username','rules' => 'required'),
            array('field' => 'password','label' => 'Password','rules' => 'required'),
        );
        return $form_rules;
    }
    public function validasi_login()
    {
        $form = $this->load_form_rules();
        $this->form_validation->set_rules($form);

        if ($this->form_validation->run())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    // cek status user, login atau tidak?
    public function cek_user_login()
    {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $query = $this->db->where('username', $username)
            ->where('userpass', $password)
            ->limit(1)
            ->get('users');

        if ($query->num_rows() == 1)
        {
            foreach($query->result() as $sess)
            {
                $sess_data['login']     = TRUE;
                $sess_data['id_user']   = $sess->id_user;
                $sess_data['username']  = $sess->username;
                $sess_data['userpass']  = $sess->userpass;
                $sess_data['nama']      = $sess->nama_lengkap;
                $sess_data['stts']      = $sess->stts;

                $this->session->set_userdata($sess_data);
            }
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    public function logout()
    {
        $this->session->unset_userdata(array('username' => '', 'login' => FALSE));
        $this->session->sess_destroy();
    }

    /* ------------------------------- Identitas -------------------------------*/
    public $table_identitas = 'identitas';
    public $id_identitas = 'id_identitas';
    public $order_identitas = 'ASC';
    // get data by id
    function get_by_id_identitas($id)
    {
        $this->db->where($this->id_identitas, $id);
        return $this->db->get($this->table_identitas)->row();
    }
    // update data
    function update_identitas($id, $data)
    {
        $this->db->where($this->id_identitas, $id);
        $this->db->update($this->table_identitas, $data);
    }


    /* ------------------------------- Manajemen User-------------------------------*/
    public $table_users = 'users';
    public $id_users = 'id_user';
    public $order_users = 'ASC';
    // get all
    function get_all_users()
    {
        $this->db->order_by($this->id_users, $this->order_users);
        return $this->db->get($this->table_users)->result();
    }
    // get data by id
    function get_by_id_users($id)
    {
        $this->db->where($this->id_users, $id);
        return $this->db->get($this->table_users)->row();
    }
    // get total rows
    function total_rows_users() {
        $this->db->from($this->table_users);
        return $this->db->count_all_results();
    }
    // get data with limit
    function index_limit_users($limit, $start = 0) {
        $this->db->order_by($this->id_users, $this->order_users);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_users)->result();
    }
    // get search total rows
    function search_total_rows_users($keyword = NULL) {
        $this->db->like('id_user', $keyword);
        $this->db->or_like('username', $keyword);
        $this->db->or_like('nama_lengkap', $keyword);
        $this->db->or_like('stts', $keyword);
        $this->db->from($this->table_users);
        return $this->db->count_all_results();
    }
    // get search data with limit
    function search_index_limit_users($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id_users, $this->order_users);
        $this->db->like('id_user', $keyword);
        $this->db->or_like('username', $keyword);
        $this->db->or_like('nama_lengkap', $keyword);
        $this->db->or_like('stts', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_users)->result();
    }
    // insert data
    function insert_users($data)
    {
        $this->db->insert($this->table_users, $data);
    }
    // update data
    function update_users($id, $data)
    {
        $this->db->where($this->id_users, $id);
        $this->db->update($this->table_users, $data);
    }
    // delete data
    function delete_users($id)
    {
        $this->db->where($this->id_users, $id);
        $this->db->delete($this->table_users);
    }

    /* ------------------------------- Manajemen Kategori Produk -------------------------------*/
    public $table_kategori = 'kategori';
    public $id_kategori = 'id_kategori';
    public $order_kategori = 'ASC';
    // get all
    function get_all_kategori()
    {
        $this->db->order_by($this->id_kategori, $this->order_kategori);
        return $this->db->get($this->table_kategori)->result();
    }
    // get data by id
    function get_by_id_kategori($id)
    {
        $this->db->where($this->id_kategori, $id);
        return $this->db->get($this->table_kategori)->row();
    }
    // get total rows
    function total_rows_kategori() {
        $this->db->from($this->table_kategori);
        return $this->db->count_all_results();
    }
    // get data with limit
    function index_limit_kategori($limit, $start = 0) {
        $this->db->order_by($this->id_kategori, $this->order_kategori);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_kategori)->result();
    }
    // get search total rows
    function search_total_rows_kategori($keyword = NULL) {
        $this->db->like('id_kategori', $keyword);
        $this->db->or_like('nm_kategori', $keyword);
        $this->db->or_like('gen_kategori', $keyword);
        $this->db->or_like('seo_kategori', $keyword);
        $this->db->from($this->table_kategori);
        return $this->db->count_all_results();
    }
    // get search data with limit
    function search_index_limit_kategori($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id_kategori, $this->order_kategori);
        $this->db->like('id_kategori', $keyword);
        $this->db->or_like('nm_kategori', $keyword);
        $this->db->or_like('gen_kategori', $keyword);
        $this->db->or_like('seo_kategori', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_kategori)->result();
    }
    // insert data
    function insert_kategori($data)
    {
        $this->db->insert($this->table_kategori, $data);
    }
    // update data
    function update_kategori($id, $data)
    {
        $this->db->where($this->id_kategori, $id);
        $this->db->update($this->table_kategori, $data);
    }
    // delete data
    function delete_kategori($id)
    {
        $this->db->where($this->id_kategori, $id);
        $this->db->delete($this->table_kategori);
    }

    /* ------------------------------- Manajemen Slider-------------------------------*/
    public $table_slider = 'slider';
    public $id_slider = 'id_slider';
    public $order_slider = 'DESC';
    // get all
    function get_all_slider()
    {
        $this->db->order_by($this->id_slider, $this->order_slider);
        return $this->db->get($this->table_slider)->result();
    }
    // get data by id
    function get_by_id_slider($id)
    {
        $this->db->where($this->id_slider, $id);
        return $this->db->get($this->table_slider)->row();
    }
    // get total rows
    function total_rows_slider() {
        $this->db->from($this->table_slider);
        return $this->db->count_all_results();
    }
    // get data with limit
    function index_limit_slider($limit, $start = 0) {
        $this->db->order_by($this->id_slider, $this->order_slider);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_slider)->result();
    }
    // get search total rows
    function search_total_rows_slider($keyword = NULL) {
        $this->db->like('id_slider', $keyword);
        $this->db->or_like('nm_slider', $keyword);
        $this->db->or_like('gambar', $keyword);
        $this->db->from($this->table_slider);
        return $this->db->count_all_results();
    }
    // get search data with limit
    function search_index_limit_slider($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id_slider, $this->order_slider);
        $this->db->like('id_slider', $keyword);
        $this->db->or_like('nm_slider', $keyword);
        $this->db->or_like('gambar', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_slider)->result();
    }
    // insert data
    function insert_slider($data)
    {
        $this->db->insert($this->table_slider, $data);
    }
    // update data
    function update_slider($id, $data)
    {
        $this->db->where($this->id_slider, $id);
        $this->db->update($this->table_slider, $data);
    }
    // delete data
    function delete_slider($id)
    {
        $this->db->where($this->id_slider, $id);
        $this->db->delete($this->table_slider);
    }

    /* ------------------------------- Manajemen Slider Intro-------------------------------*/
    public $table_intro = 'intro';
    public $id_intro = 'id_intro';
    public $order_intro = 'DESC';
    // get all
    function get_all_intro()
    {
        $this->db->order_by($this->id_intro, $this->order_intro);
        return $this->db->get($this->table_intro)->result();
    }
    // get data by id
    function get_by_id_intro($id)
    {
        $this->db->where($this->id_intro, $id);
        return $this->db->get($this->table_intro)->row();
    }
    // get total rows
    function total_rows_intro() {
        $this->db->from($this->table_intro);
        return $this->db->count_all_results();
    }
    // get data with limit
    function index_limit_intro($limit, $start = 0) {
        $this->db->order_by($this->id_intro, $this->order_intro);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_intro)->result();
    }
    // get search total rows
    function search_total_rows_intro($keyword = NULL) {
        $this->db->like('id_intro', $keyword);
        $this->db->or_like('nm_intro', $keyword);
        $this->db->or_like('gambar', $keyword);
        $this->db->from($this->table_intro);
        return $this->db->count_all_results();
    }
    // get search data with limit
    function search_index_limit_intro($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id_intro, $this->order_intro);
        $this->db->like('id_intro', $keyword);
        $this->db->or_like('nm_intro', $keyword);
        $this->db->or_like('gambar', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_intro)->result();
    }
    // insert data
    function insert_intro($data)
    {
        $this->db->insert($this->table_intro, $data);
    }
    // update data
    function update_intro($id, $data)
    {
        $this->db->where($this->id_intro, $id);
        $this->db->update($this->table_intro, $data);
    }
    // delete data
    function delete_intro($id)
    {
        $this->db->where($this->id_intro, $id);
        $this->db->delete($this->table_intro);
    }

    /*-----------------------------------GANTI PASSWORD---------------------------*/
    // update data
    function update_password($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update('users', $data);
    }

    /* ------------------------------- Manajemen Halaman Profil -------------------------------*/
    public $table_halaman = 'halaman';
    public $id_halaman = 'id_halaman';
    public $order_halaman = 'DESC';
    // get all
    function get_all_halaman()
    {
        $this->db->order_by($this->id_halaman, $this->order_halaman);
        return $this->db->get($this->table_halaman)->result();
    }
    // get data by id
    function get_by_id_halaman($id)
    {
        $this->db->where($this->id_halaman, $id);
        return $this->db->get($this->table_halaman)->row();
    }
    // get total rows
    function total_rows_halaman() {
        $this->db->from($this->table_halaman);
        return $this->db->count_all_results();
    }
    // get data with limit
    function index_limit_halaman($limit, $start = 0) {
        $this->db->order_by($this->id_halaman, $this->order_halaman);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_halaman)->result();
    }
    // get search total rows
    function search_total_rows_halaman($keyword = NULL) {
        $this->db->like('id_halaman', $keyword);
        $this->db->or_like('judul', $keyword);
        $this->db->or_like('judul_seo', $keyword);
        $this->db->or_like('pic_halaman', $keyword);
        $this->db->or_like('isi_halaman', $keyword);
        $this->db->from($this->table_halaman);
        return $this->db->count_all_results();
    }
    // get search data with limit
    function search_index_limit_halaman($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id_halaman, $this->order_halaman);
        $this->db->like('id_halaman', $keyword);
        $this->db->or_like('judul', $keyword);
        $this->db->or_like('judul_seo', $keyword);
        $this->db->or_like('pic_halaman', $keyword);
        $this->db->or_like('isi_halaman', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_halaman)->result();
    }
    // insert data
    function insert_halaman($data)
    {
        $this->db->insert($this->table_halaman, $data);
    }
    // update data
    function update_halaman($id, $data)
    {
        $this->db->where($this->id_halaman, $id);
        $this->db->update($this->table_halaman, $data);
    }
    // delete data
    function delete_halaman($id)
    {
        $this->db->where($this->id_halaman, $id);
        $this->db->delete($this->table_halaman);
    }


    /* ------------------------------- Manajemen Fasilitas Kamar-------------------------------*/
    public $table_fasilitas = 'fasilitas';
    public $id_fasilitas = 'id_fasilitas';
    public $order_fasilitas = 'ASC';

    function get_all_fasilitas()
    {
        $this->db->order_by($this->id_fasilitas, $this->order_fasilitas);
        return $this->db->get($this->table_fasilitas)->result();
    }
    function get_by_id_fasilitas($id)
    {
        $this->db->where($this->id_fasilitas, $id);
        return $this->db->get($this->table_fasilitas)->row();
    }
    function total_rows_fasilitas() {
        $this->db->from($this->table_fasilitas);
        return $this->db->count_all_results();
    }
    function index_limit_fasilitas($limit, $start = 0) {
        $this->db->order_by($this->id_fasilitas, $this->order_fasilitas);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_fasilitas)->result();
    }
    function search_total_rows_fasilitas($keyword = NULL) {
        $this->db->like('id_fasilitas', $keyword);
        $this->db->or_like('nm_fasilitas', $keyword);
        $this->db->or_like('seo_fasilitas', $keyword);
        $this->db->from($this->table_fasilitas);
        return $this->db->count_all_results();
    }
    function search_index_limit_fasilitas($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id_fasilitas, $this->order_fasilitas);
        $this->db->like('id_fasilitas', $keyword);
        $this->db->or_like('nm_fasilitas', $keyword);
        $this->db->or_like('seo_fasilitas', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_fasilitas)->result();
    }
    function insert_fasilitas($data)
    {
        $this->db->insert($this->table_fasilitas, $data);
    }
    function update_fasilitas($id, $data)
    {
        $this->db->where($this->id_fasilitas, $id);
        $this->db->update($this->table_fasilitas, $data);
    }
    function delete_fasilitas($id)
    {
        $this->db->where($this->id_fasilitas, $id);
        $this->db->delete($this->table_fasilitas);
    }























    /* ------------------------------- Manajemen Album Foto -------------------------------*/
    public $table_album = 'album';
    public $id_album = 'id_album';
    public $order_album = 'DESC';
    // get all
    function get_all_album()
    {
        $this->db->order_by($this->id_album, $this->order_album);
        return $this->db->get($this->table_album)->result();
    }

    // get data by id
    function get_by_id_album($id)
    {
        $this->db->where($this->id_album, $id);
        return $this->db->get($this->table_album)->row();
    }

    // get total rows
    function total_rows_album() {
        $this->db->from($this->table_album);
        return $this->db->count_all_results();
    }

    // get data with limit
    function index_limit_album($limit, $start = 0) {
        $this->db->order_by($this->id_album, $this->order_album);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_album)->result();
    }

    // get search total rows
    function search_total_rows_album($keyword = NULL) {
        $this->db->like('id_album', $keyword);
        $this->db->or_like('nm_album', $keyword);
        $this->db->or_like('pic_album', $keyword);
        $this->db->from($this->table_album);
        return $this->db->count_all_results();
    }

    // get search data with limit
    function search_index_limit_album($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id_album, $this->order_album);
        $this->db->like('id_album', $keyword);
        $this->db->or_like('nm_album', $keyword);
        $this->db->or_like('pic_album', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_album)->result();
    }

    // insert data
    function insert_album($data)
    {
        $this->db->insert($this->table_album, $data);
    }

    // update data
    function update_album($id, $data)
    {
        $this->db->where($this->id_album, $id);
        $this->db->update($this->table_album, $data);
    }

    // delete data
    function delete_album($id)
    {
        $this->db->where($this->id_album, $id);
        $this->db->delete($this->table_album);
    }

    /* ------------------------------- Manajemen Galeri Foto -------------------------------*/
    public $table_galeri = 'galeri';
    public $id_galeri = 'id_galeri';
    public $order_galeri = 'DESC';
    // get all
    function get_all_galeri()
    {
        $this->db->select("galeri.id_galeri, galeri.nm_galeri, album.id_album, album.nm_album, galeri.pic_galeri")
            ->from("galeri")
            ->join('album','galeri.id_album = album.id_album')
            ->order_by('album.id_album', 'DESC');
        return $this->db->get()->result_array();
    }

    // get data by id
    function get_by_id_galeri($id)
    {
        $data = $this->db->select("galeri.id_galeri, galeri.nm_galeri, album.id_album, album.nm_album, galeri.pic_galeri")
            ->from("galeri")
            ->join('album','galeri.id_album = album.id_album')
            ->where($this->id_galeri, $id)
            ->get()
            ->row();
        return $data;
    }

    // get total rows
    function total_rows_galeri() {
        $this->db->from($this->table_galeri);
        return $this->db->count_all_results();
    }

    // get data with limit
    function index_limit_galeri($limit, $start = 0) {
        $data = $this->db->select("galeri.id_galeri, galeri.nm_galeri, album.id_album, album.nm_album, galeri.pic_galeri")
            ->from($this->table_galeri)
            ->join('album','galeri.id_album = album.id_album')
            ->order_by('album.id_album', 'DESC')
            ->limit($limit, $start)
            ->get()
            ->result();
        return $data;
    }

    // get search total rows
    function search_total_rows_galeri($keyword = NULL) {
        $this->db->like('id_galeri', $keyword);
        $this->db->or_like('nm_galeri', $keyword);
        $this->db->or_like('pic_galeri', $keyword);
        $this->db->from($this->table_galeri);
        return $this->db->count_all_results();
    }

    // get search data with limit
    function search_index_limit_galeri($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id_galeri, $this->order_galeri);
        $this->db->like('id_galeri', $keyword);
        $this->db->or_like('nm_galeri', $keyword);
        $this->db->or_like('pic_galeri', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_galeri)->result();
    }

    // insert data
    function insert_galeri($data)
    {
        $this->db->insert($this->table_galeri, $data);
    }

    // update data
    function update_galeri($id, $data)
    {
        $this->db->where($this->id_galeri, $id);
        $this->db->update($this->table_galeri, $data);
    }

    // delete data
    function delete_galeri($id)
    {
        $this->db->where($this->id_galeri, $id);
        $this->db->delete($this->table_galeri);
    }


    /* ------------------------------- Manajemen Album Foto -------------------------------*/
    public $table_kamar = 'kamar';
    public $id_kamar = 'id_kamar';
    public $order_kamar = 'DESC';

    function get_all_kamar()
    {
        $this->db->order_by($this->id_kamar, $this->order_kamar);
        return $this->db->get($this->table_kamar)->result();
    }
    function get_by_id_kamar($id)
    {
        $this->db->where($this->id_kamar, $id);
        return $this->db->get($this->table_kamar)->row();
    }
    function total_rows_kamar() {
        $this->db->from($this->table_kamar);
        return $this->db->count_all_results();
    }
    function index_limit_kamar($limit, $start = 0) {
        $this->db->order_by($this->id_kamar, $this->order_kamar);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_kamar)->result();
    }
    function search_total_rows_kamar($keyword = NULL) {
        $this->db->like('id_kamar', $keyword);
        $this->db->or_like('nm_kamar', $keyword);
        $this->db->or_like('seo_kamar', $keyword);
        $this->db->or_like('harga_kamar', $keyword);
        $this->db->or_like('deskripsi', $keyword);
        $this->db->or_like('fasilitas', $keyword);
        $this->db->or_like('pic_kamar', $keyword);
        $this->db->from($this->table_kamar);
        return $this->db->count_all_results();
    }
    function search_index_limit_kamar($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id_kamar, $this->order_kamar);
        $this->db->like('id_kamar', $keyword);
        $this->db->or_like('nm_kamar', $keyword);
        $this->db->or_like('seo_kamar', $keyword);
        $this->db->or_like('harga_kamar', $keyword);
        $this->db->or_like('deskripsi', $keyword);
        $this->db->or_like('fasilitas', $keyword);
        $this->db->or_like('pic_kamar', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_kamar)->result();
    }
    function insert_kamar($data)
    {
        $this->db->insert($this->table_kamar, $data);
    }
    function update_kamar($id, $data)
    {
        $this->db->where($this->id_kamar, $id);
        $this->db->update($this->table_kamar, $data);
    }
    function delete_kamar($id)
    {
        $this->db->where($this->id_kamar, $id);
        $this->db->delete($this->table_kamar);
    }


    /* ------------------------------- Manajemen Fasilitas Kamar-------------------------------*/
    public $table_reservation = 'reservation';
    public $id_reservation = 'id_reservation';
    public $order_reservation = 'DESC';

    function get_all_reservation()
    {
        $this->db->order_by($this->id_reservation, $this->order_reservation);
        return $this->db->get($this->table_reservation)->result();
    }
    function get_by_id_reservation($id)
    {
        $this->db->where($this->id_reservation, $id);
        return $this->db->get($this->table_reservation)->row();
    }
    function total_rows_reservation() {
        $this->db->from($this->table_reservation);
        return $this->db->count_all_results();
    }
    function index_limit_reservation($limit, $start = 0) {
        $this->db->order_by($this->id_reservation, $this->order_reservation);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_reservation)->result();
    }
    function search_total_rows_reservation($keyword = NULL) {
        $this->db->like('id_reservation', $keyword);
        $this->db->or_like('check_in', $keyword);
        $this->db->or_like('check_out', $keyword);
        $this->db->or_like('first_name', $keyword);
        $this->db->or_like('last_name', $keyword);
        $this->db->or_like('adult_count', $keyword);
        $this->db->or_like('chilt_count', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->or_like('phone', $keyword);
        $this->db->or_like('created_at', $keyword);
        $this->db->or_like('updated_at', $keyword);
        $this->db->or_like('deleted_at', $keyword);
        $this->db->from($this->table_reservation);
        return $this->db->count_all_results();
    }
    function search_index_limit_reservation($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id_reservation, $this->order_reservation);
        $this->db->like('id_reservation', $keyword);
        $this->db->or_like('check_in', $keyword);
        $this->db->or_like('check_out', $keyword);
        $this->db->or_like('first_name', $keyword);
        $this->db->or_like('last_name', $keyword);
        $this->db->or_like('adult_count', $keyword);
        $this->db->or_like('chilt_count', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->or_like('phone', $keyword);
        $this->db->or_like('created_at', $keyword);
        $this->db->or_like('updated_at', $keyword);
        $this->db->or_like('deleted_at', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table_reservation)->result();
    }
    function insert_reservation($data)
    {
        $this->db->insert($this->table_reservation, $data);
    }
    function update_reservation($id, $data)
    {
        $this->db->where($this->id_reservation, $id);
        $this->db->update($this->table_reservation, $data);
    }
    function delete_reservation($id)
    {
        $this->db->where($this->id_reservation, $id);
        $this->db->delete($this->table_reservation);
    }





}