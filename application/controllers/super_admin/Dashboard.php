<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'super_admin/dashboard/index',
            'index_js' => 'super_admin/dashboard/index_js',
            'title' => 'Dashboard',
            'no_sidebar' => true,
        ];

        $this->templates->load($data);
    }

    public function show_data()
    {
        $otoritas = decode_id($this->input->post('otoritas'));
        $data['data'] = $this->db->query("SELECT 
            a.*, c.nama as kecamatan, d.nama as kelurahan
            from data_user a
            left join ref_kecamatan c on c.kode_wilayah=a.kode_kec
            left join ref_kelurahan d on d.kode_wilayah=a.kode_kel
            where a.id_otoritas=$otoritas and a.deleted is null 
        ")->result();
        $data['otoritas'] = $otoritas;
        $html = $this->load->view('super_admin/dashboard/modal_show_data', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function do_pilih_role($id)
    {
        $id = decode_id($id);

        $this->db->select('a.*, b.otoritas');
        $this->db->where('a.id', $id);
        $this->db->where('a.deleted', null);
        $this->db->join('dev_otoritas b', 'b.id = a.id_otoritas', 'left');
        $run = $this->db->get('data_user a')->row();

        if ($run) {

            $this->session->set_userdata([
                'is_login' => true,
                'is_super' => true,
                'id_akun' => $run->id,
                'id_otoritas' => $run->id_otoritas,
                'nama' => $run->nama,
                'foto' => $run->foto,
                'kecamatan' => $run->kode_kec,
                'kelurahan' => $run->kode_kel,
                'username' => $run->username,
                'type' => $run->otoritas,
            ]);

            if ($run->id_otoritas == 1) $link = base_url('super_admin/dashboard');
            elseif ($run->id_otoritas == 2) $link = base_url('admin/dashboard');
            elseif ($run->id_otoritas == 3) $link = base_url('user/dashboard');

            redirect($link);
        }
    }

    public function session()
    {
        session();
    }
}

/* End of file Dashboard.php */
