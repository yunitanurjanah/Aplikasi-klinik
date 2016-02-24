<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rekammedis extends CI_Controller
{
    public $data = array(
                        'modul'         => 'rekammedis',
                        'breadcrumb'    => 'Rekam Medis',
                        'pesan'         => '',
                        'pagination'    => '',
                        'tabel_data'    => '',
                        'main_view'     => 'rekammedis/rekammedis',
                        'form_action'   => '',
                        'form_value'    => '',
                        'option_datapasien'  => '',
						'option_datadokter'  => '',
						'option_nama'	=>'',
                         );

    public function __construct()
	{
		parent::__construct();		
		$this->load->model('Rekammedis_model', 'rekammedis', TRUE);
		$this->load->model('Datapasien_model', 'datapasien', TRUE);
		$this->load->model('Datadokter_model', 'datadokter', TRUE);
	}

    public function index($offset = 0)
	{
        // hapus data temporary proses update
        $this->session->unset_userdata('kode_rekam_sekarang', '');

        // cari data siswa
        $rekammedis = $this->rekammedis->cari_semua($offset);

        // ada data siswa, tampilkan
        if ($rekammedis)
        {
            $tabel = $this->rekammedis->buat_tabel($rekammedis);
            $this->data['tabel_data'] = $tabel;

            // Paging
            // http://localhost/absensi2014/siswa/halaman/2
            $this->data['pagination'] = $this->rekammedis->paging(site_url('rekammedis/halaman'));
        }
        // tidak ada data siswa
        else
        {
            $this->data['pesan'] = 'Tidak ada data rekammedis.';
        }
        $this->load->view('templated', $this->data);
	}

    public function tambah()
    {
        $this->data['breadcrumb']  = 'Rekam Medis > Tambah';
        $this->data['main_view']   = 'rekammedis/rekammedis_form';
        $this->data['form_action'] = 'rekammedis/tambah';

        // option kelas, untuk menu dropdown
        $kode_pasien = $this->datapasien->cari_semua();

        // data kelas ada
	//if('option_datapasien' = 'kode_dokter'){
        if($kode_pasien)
        {
            foreach($kode_pasien as $row)
            {
                $this->data['option_datapasien'][$row->kode_pasien] = $row->kode_pasien;
            }
        }
        // data kelas tidak ada
        else
        {
            $this->data['option_datapasien']['00'] = '-';
            $this->data['pesan'] = 'Data kelas tidak tersedia. Silahkan isi dahulu data kelas.';
            //$this->load->view('template', $this->data);
        }
		
		if($kode_pasien)
        {
            foreach($kode_pasien as $row)
            {
                $this->data['option_nama'][$row->kode_pasien] = $row->nama;
            }
        }
        // data kelas tidak ada
        else
        {
            $this->data['option_nama']['00'] = '-';
            $this->data['pesan'] = 'Data kelas tidak tersedia. Silahkan isi dahulu data kelas.';
            //$this->load->view('template', $this->data);
        }
		
		 $kode_dokter = $this->datadokter->cari_semua();

        // data kelas ada
        if($kode_dokter)
        {
            foreach($kode_dokter as $row)
            {
                $this->data['option_datadokter'][$row->kode_dokter] = $row->nama_dokter;
            }
        }
        // data kelas tidak ada
        else
        {
            $this->data['option_datapasien']['00'] = '-';
            $this->data['pesan'] = 'Data kelas tidak tersedia. Silahkan isi dahulu data kelas.';
            //$this->load->view('template', $this->data);
        }


        // if submit
        if($this->input->post('submit'))
        {
            // validasi sukses
            if($this->rekammedis->validasi_tambah())
            {
                if($this->rekammedis->tambah())
                {
                    $this->session->set_flashdata('pesan', 'Proses tambah data berhasil.');
                    redirect('rekammedis');
                }
                else
                {
                    $this->data['pesan'] = 'Proses tambah data gagal.';
                    $this->load->view('templated', $this->data);
                }
            }
            // validasi gagal
            else
            {
                $this->load->view('templated', $this->data);
            }
        }
        // if no submit
        else
        {
            $this->load->view('templated', $this->data);
        }
    }

    public function edit($kode_rekam = NULL)
    {
        $this->data['breadcrumb']  = 'Rekam Medis > Edit';
        $this->data['main_view']   = 'rekammedis/rekammedis_form';
        $this->data['form_action'] = 'rekammedis/edit/' . $kode_rekam;

        // option kelas
        $kode_pasien = $this->datapasien->cari_semua();
        foreach($kode_pasien as $row)
        {
            $this->data['option_datapasien'][$row->kode_pasien] = $row->kode_pasien;
        }
		$kode_dokter = $this->datadokter->cari_semua();
        foreach($kode_dokter as $row)
        {
            $this->data['option_datadokter'][$row->kode_dokter] = $row->nama_dokter;
        }


        // Mencegah error http://localhost/absensi2014/siswa/edit/$nis (edit tanpa ada parameter)
        // Ada parameter
        if( ! empty($kode_rekam))
        {
            // submit
            if($this->input->post('submit'))
            {
                // validasi berhasil
                if($this->rekammedis->validasi_edit() === TRUE)
                {
                    //update db
                    $this->rekammedis->edit($this->session->userdata('kode_rekam_sekarang'));
					$this->rekammedis->edit($this->session->userdata('pasien_sekarang'));
					$this->rekammedis->edit($this->session->userdata('alergi_sekarang'));
					$this->rekammedis->edit($this->session->userdata('terapi_sekarang'));
                    $this->session->set_flashdata('pesan', 'Proses update data berhasil.');

                    redirect('rekammedis');
                }
                // validasi gagal
                else
                {
                    $this->load->view('templated', $this->data);
                }

            }
            // tidak disubmit, form pertama kali dimuat
            else
            {
                // ambil data dari database, $form_value sebagai nilai default form
                $rekammedis = $this->rekammedis->cari($kode_rekam);
                foreach($rekammedis as $key => $value)
                {
                    $this->data['form_value'][$key] = $value;
                }

                // set temporary data untuk edit
                $this->session->set_userdata('kode_rekam_sekarang', $rekammedis->kode_rekam);
				$this->session->set_userdata('anamnesa_sekarang', $rekammedis->anamnesa);
				$this->session->set_userdata('alergi_sekarang', $rekammedis->alergi);
				$this->session->set_userdata('terapi_sekarang', $rekammedis->terapi);
				$this->session->set_userdata('pasien_sekarang', $rekammedis->pasien);
				$this->session->set_userdata('kode_pasien_sekarang', $rekammedis->kode_pasien);
				$this->session->set_userdata('kode_dokter_sekarang', $rekammedis->kode_dokter);
                $this->load->view('templated', $this->data);
            }
        }
        // tidak ada parameter $nis di URL, kembalikan ke halaman siswa
        else
        {
            redirect('rekammedis');
        }
    }

    public function hapus($kode_rekam = NULL)
    {
        if( ! empty($kode_rekam))
        {
            if($this->rekammedis->hapus($kode_rekam))
            {
                $this->session->set_flashdata('pesan', 'Proses hapus data berhasil.');
                redirect('rekammedis');
            }
            else
            {
                $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
                redirect('rekammedis');
            }
        }
        else
        {
            $this->session->set_flashdata('pesan', 'Proses hapus data gagal.');
            redirect('rekammedis');
        }
    }

    public function is_kode_rekam_exist()
    {
        $kode_rekam_sekarang  = $this->session->userdata('kode_rekam_sekarang');
        $kode_rekam_baru      = $this->input->post('kode_rekam');

        if ($kode_rekam_baru === $kode_rekam_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek database untuk nis yang sama
            $query = $this->db->get_where('rekam_medis', array('kode_rekam' => $kode_rekam_baru));
            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_kode_rekam_exist',
                                                    "Rekammedis dengan kode_rekam $kode_rekam_baru sudah terdaftar");
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }
	function is_anamnesa_exist()
    {
		$anamnesa_sekarang 	= $this->session->userdata('anamnesa_sekarang');
        $anamnesa_baru		= $this->input->post('anamnesa');
		
		if ($anamnesa_baru === $anamnesa_sekarang)
        {
            return TRUE;
        }
        
	}
	function is_terapi_exist()
    {
		$terapi_sekarang 	= $this->session->userdata('terapi_sekarang');
        $terapi_baru		= $this->input->post('terapi');
		
		if ($terapi_baru === $terapi_sekarang)
        {
            return TRUE;
        }
       
	}
	function is_pasien_exist()
    {
		$pasien_sekarang 	= $this->session->userdata('pasien_sekarang');
        $pasien_baru		= $this->input->post('pasien');
		
		if ($pasien_baru === $pasien_sekarang)
        {
            return TRUE;
        }
       
	}
	function is_kode_pasien_exist()
    {
		$kode_pasien_sekarang 	= $this->session->userdata('kode_pasien_sekarang');
        $kode_pasien_baru		= $this->input->post('kode_pasien');
		
		if ($kode_pasien_baru === $kode_pasien_sekarang)
        {
            return TRUE;
        }
       
	}
	function is_kode_dokter_exist()
    {
		$kode_dokter_sekarang 	= $this->session->userdata('kode_dokter_sekarang');
        $kode_dokter_baru		= $this->input->post('kode_dokter');
		
		if ($kode_dokter_baru === $kode_dokter_sekarang)
        {
            return TRUE;
        }
        
	}
	function is_alergi_exist()
    {
		$alergi_sekarang 	= $this->session->userdata('alergi_sekarang');
        $alergi_baru		= $this->input->post('alergi');
		
		if ($alergi_baru === $alergi_sekarang)
        {
            return TRUE;
        }
       
	}
	public function is_format_tanggal($str)
    {
        if( ! preg_match('/(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-([0-9]{4})/', $str))
        {
            $this->form_validation->set_message('is_format_tanggal', 'Format tanggal tidak valid. (dd-mm-yyyy)');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
	
	public function is_tanggal_exist()
    {
		$tanggal_sekarang 	= $this->session->userdata('tanggal_sekarang');
        $tanggal_baru		= $this->input->post('tanggal');
		
		if ($tanggal_baru === $tanggal_sekarang)
        {
            return TRUE;
        }
	}
          

    // cek agar tidak terjadi siswa dengan NIS yang sama diabsen 2 kali di tanggal yang sama
    public function is_double_entry_tambah()
    {
        $kode_rekam 		= $this->input->post('kode_rekam');
        $tanggal	= date('Y-m-d', strtotime($this->input->post('tanggal')));

        // cek di database
        $this->db->where('kode_rekam', $kode_rekam)
                 ->where('tanggal', $tanggal);
        $query = $this->db->get('rekam_medis')->num_rows();

        if($query > 0)
        {
            $this->form_validation->set_message('is_double_entry_tambah', 'Siswa ini sudah tercatat absen pada tanggal ' . $this->input->post('tanggal'));
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
 public function is_double_entry_edit()
    {
        $tanggal_sekarang 	= $this->session->userdata('tanggal_sekarang');
        $tanggal_baru		= date('Y-m-d', strtotime($this->input->post('tanggal')));
        $nis 			    = $this->input->post('nis');

        if ($tanggal_baru === $tanggal_sekarang)
        {
            return TRUE;
        }
        else
        {
            // cek di database
            $query = $this->db->where('nis', $nis)->where('tanggal', $tanggal_baru)->get('absen');

            if($query->num_rows() > 0)
            {
                $this->form_validation->set_message('is_double_entry_edit', 'Siswa ini sudah tercatat absen pada tanggal ' . $this->input->post('tanggal'));
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
    }

}
