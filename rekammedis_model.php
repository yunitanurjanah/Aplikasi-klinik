<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rekammedis_model extends CI_Model {

    public $db_tabel    = 'rekam_medis';
    public $per_halaman = 10;
    public $offset      = 0;

    // rules form validasi, proses TAMBAH
    private function load_form_rules_tambah()
    {
        $form = array(
                        /*array(
                            'field' => 'kode_rekam',
                            'label' => 'Kode Rekam',
                            'rules' => "required|exact_length[6]|numeric|is_unique[$this->db_tabel.kode_rekam]"
                        ),*/
                        array(
                            'field' => 'anamnesa',
                            'label' => 'Anamnesa',
                            'rules' => 'required|max_length[50]'
                        ),
						  array(
                            'field' => 'alergi',
                            'label' => 'Alergi',
                            //'rules' => 'required|max_length[50]'
                        ),
						  array(
                            'field' => 'terapi',
                            'label' => 'Terapi',
                            //'rules' => 'required|max_length[50]'
                        ),
						  array(
                            'field' => 'pasien',
                            'label' => 'Jenis Pasien',
                            'rules' => "required"
                        ),
						array(
                            'field' => 'injeksi',
                            //'label' => 'Jenis Pasien',
                            //'rules' => 'required'
                        ),
						array(
                            'field' => 'nebu',
                            //'label' => 'Jenis Pasien',
                            //'rules' => 'required'
                        ),
						array(
                            'field' => 'guladarah',
                            //'label' => 'Jenis Pasien',
                            //'rules' => 'required'
                        ),
						array(
                            'field' => 'asamurat',
                            //'label' => 'Jenis Pasien',
                            //'rules' => 'required'
                        ),
						array(
                            'field' => 'kolesterol',
                           // 'label' => 'Jenis Pasien',
                            //'rules' => 'required'
                        ),
						array(
                            'field' => 'kode_pasien',
                            'label' => 'Kode Pasien',
                            //'rules' => 'required'
                        ),
						array(
                		'field' => 'tanggal',
                		'label' => 'Tanggal',
               			'rules' => 'required|callback_is_format_tanggal|callback_is_double_entry_tambah'
           				),
                        array(
                            'field' => 'kode_dokter',
                            'label' => 'Nama Dokter',
                            'rules' => 'required'
                        ),
        );
        return $form;
    }

    // rules form validasi, proses EDIT
    private function load_form_rules_edit()
    {
        $form = array(
           /*array(
                            'field' => 'kode_rekam',
                            'label' => 'Kode Rekam',
                            'rules' => "required|exact_length[6]|numeric|callback_is_rekam_medis_exist"
                        ),*/
                        array(
                            'field' => 'anamnesa',
                            'label' => 'Anamnesa',
                            'rules' => "required|max_length[50]"
                        ),
						  array(
                            'field' => 'alergi',
                            'label' => 'Alergi',
                            'rules' => "required|max_length[40]|callback_is_alergi_exist"
                        ),
						  array(
                            'field' => 'terapi',
                            'label' => 'Terapi',
                            'rules' => "required|max_length[40]|callback_is_terapi_exist"
                        ),
						  array(
                            'field' => 'pasien',
                            'label' => 'Jenis Pasien',
                            'rules' => "required|max_length[1]"
                        ),
						array(
                            'field' => 'injeksi',
                            //'label' => 'Jenis Pasien',
                            //'rules' => 'required'
                        ),
						array(
                            'field' => 'nebu',
                            //'label' => 'Jenis Pasien',
                            //'rules' => 'required'
                        ),
						array(
                            'field' => 'guladarah',
                            //'label' => 'Jenis Pasien',
                            //'rules' => 'required'
                        ),
						array(
                            'field' => 'asamurat',
                            //'label' => 'Jenis Pasien',
                            //'rules' => 'required'
                        ),
						array(
                            'field' => 'kolesterol',
                           // 'label' => 'Jenis Pasien',
                            //'rules' => 'required'
                        ),
						array(
                		'field' => 'tanggal',
                		'label' => 'Tanggal',
                		'rules' => 'required|callback_is_format_tanggal|callback_is_double_entry_tambah'
            			),
						array(
                            'field' => 'kode_pasien',
                            'label' => 'Kode Pasien',
                            'rules' => "required|max_length[40]|callback_is_kode_pasien_exist"
                        ),
                        array(
                            'field' => 'kode_dokter',
                            'label' => 'Nama Dokter',
                            'rules' => "required|max_length[40]|callback_is_kode_dokter_exist"
                        ),
        );
        return $form;
    }

    // jalankan proses validasi, untuk operasi TAMBAH
    public function validasi_tambah()
    {
        $form = $this->load_form_rules_tambah();
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

    // jalankan proses validasi, untuk operasi EDIT
    public function validasi_edit()
    {
        $form = $this->load_form_rules_edit();
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

    public function cari_semua($offset)
	{
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */        
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }		
        // $offset end

        return $this->db->select('rekam_medis.kode_rekam,rekam_medis.anamnesa, rekam_medis.alergi, rekam_medis.pasien, rekam_medis.terapi,rekam_medis.injeksi,rekam_medis.nebu,rekam_medis.guladarah,rekam_medis.asamurat,rekam_medis.kolesterol,rekam_medis.tanggal,data_pasien.kode_pasien,data_dokter.nama_dokter')
                        ->from($this->db_tabel)
                        ->join('data_pasien', 'data_pasien.kode_pasien = rekam_medis.kode_pasien')
						->join('data_dokter', 'data_dokter.kode_dokter = rekam_medis.kode_dokter')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('kode_rekam', 'ASC')
                        ->get()
                        ->result();
	}
 
  public function cari_tommy($offset)
	{
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */        
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }		
        // $offset end

        return $this->db->select('rekam_medis.kode_rekam,rekam_medis.anamnesa, rekam_medis.alergi, rekam_medis.pasien, rekam_medis.terapi,rekam_medis.injeksi,rekam_medis.nebu,rekam_medis.guladarah,rekam_medis.asamurat,rekam_medis.kolesterol,rekam_medis.tanggal,data_pasien.kode_pasien,data_pasien.nama,data_dokter.nama_dokter')
                        ->from($this->db_tabel)
                        ->join('data_pasien', 'data_pasien.kode_pasien = rekam_medis.kode_pasien')
						->join('data_dokter', 'data_dokter.kode_dokter = rekam_medis.kode_dokter')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('nama_dokter')
						->having('nama_dokter','dr.Tommy R')
                        ->get()
                        ->result();
	}

 public function cari_chandra($offset)
	{
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */        
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }		
        // $offset end

        return $this->db->select('rekam_medis.kode_rekam,rekam_medis.anamnesa, rekam_medis.alergi, rekam_medis.pasien, rekam_medis.terapi,rekam_medis.injeksi,rekam_medis.nebu,rekam_medis.guladarah,rekam_medis.asamurat,rekam_medis.kolesterol,rekam_medis.tanggal,data_pasien.kode_pasien,data_pasien.nama,data_dokter.nama_dokter')
                        ->from($this->db_tabel)
                        ->join('data_pasien', 'data_pasien.kode_pasien = rekam_medis.kode_pasien')
						->join('data_dokter', 'data_dokter.kode_dokter = rekam_medis.kode_dokter')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('nama_dokter')
						->having('nama_dokter','dr.Chandra')
                        ->get()
                        ->result();
	}
	
	 public function cari_andrian($offset)
	{
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */        
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }		
        // $offset end

        return $this->db->select('rekam_medis.kode_rekam,rekam_medis.anamnesa, rekam_medis.alergi, rekam_medis.pasien, rekam_medis.terapi,rekam_medis.injeksi,rekam_medis.nebu,rekam_medis.guladarah,rekam_medis.asamurat,rekam_medis.kolesterol,rekam_medis.tanggal,data_pasien.kode_pasien,data_pasien.nama,data_dokter.nama_dokter')
                        ->from($this->db_tabel)
                        ->join('data_pasien', 'data_pasien.kode_pasien = rekam_medis.kode_pasien')
						->join('data_dokter', 'data_dokter.kode_dokter = rekam_medis.kode_dokter')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('nama_dokter')
						->having('nama_dokter','dr.Andrian')
                        ->get()
                        ->result();
	}
 public function cari_susi($offset)
	{
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */        
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }		
        // $offset end

        return $this->db->select('rekam_medis.kode_rekam,rekam_medis.anamnesa, rekam_medis.alergi, rekam_medis.pasien, rekam_medis.terapi,rekam_medis.injeksi,rekam_medis.nebu,rekam_medis.guladarah,rekam_medis.asamurat,rekam_medis.kolesterol,rekam_medis.tanggal,data_pasien.kode_pasien,data_pasien.nama,data_dokter.nama_dokter')
                        ->from($this->db_tabel)
                        ->join('data_pasien', 'data_pasien.kode_pasien = rekam_medis.kode_pasien')
						->join('data_dokter', 'data_dokter.kode_dokter = rekam_medis.kode_dokter')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('nama_dokter')
						->having('nama_dokter','dr.Susi')
                        ->get()
                        ->result();
	}
public function cari_ruli($offset)
	{
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */        
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }		
        // $offset end

        return $this->db->select('rekam_medis.kode_rekam,rekam_medis.anamnesa, rekam_medis.alergi, rekam_medis.pasien, rekam_medis.terapi,rekam_medis.injeksi,rekam_medis.nebu,rekam_medis.guladarah,rekam_medis.asamurat,rekam_medis.kolesterol,rekam_medis.tanggal,data_pasien.kode_pasien,data_pasien.nama,data_dokter.nama_dokter')
                        ->from($this->db_tabel)
                        ->join('data_pasien', 'data_pasien.kode_pasien = rekam_medis.kode_pasien')
						->join('data_dokter', 'data_dokter.kode_dokter = rekam_medis.kode_dokter')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('nama_dokter')
						->having('nama_dokter','dr.Ruli')
                        ->get()
                        ->result();
	}

public function cari_agustine($offset)
	{
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */        
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }		
        // $offset end

        return $this->db->select('rekam_medis.kode_rekam,rekam_medis.anamnesa, rekam_medis.alergi, rekam_medis.pasien, rekam_medis.terapi,rekam_medis.injeksi,rekam_medis.nebu,rekam_medis.guladarah,rekam_medis.asamurat,rekam_medis.kolesterol,rekam_medis.tanggal,data_pasien.kode_pasien,data_pasien.nama,data_dokter.nama_dokter')
                        ->from($this->db_tabel)
                        ->join('data_pasien', 'data_pasien.kode_pasien = rekam_medis.kode_pasien')
						->join('data_dokter', 'data_dokter.kode_dokter = rekam_medis.kode_dokter')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('nama_dokter')
						->having('nama_dokter','dr.Agustine Rosa')
                        ->get()
                        ->result();
	}
	
	public function cari_sutisna($offset)
	{
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */        
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }		
        // $offset end

        return $this->db->select('rekam_medis.kode_rekam,rekam_medis.anamnesa, rekam_medis.alergi, rekam_medis.pasien, rekam_medis.terapi,rekam_medis.injeksi,rekam_medis.nebu,rekam_medis.guladarah,rekam_medis.asamurat,rekam_medis.kolesterol,rekam_medis.tanggal,data_pasien.kode_pasien,data_pasien.nama,data_dokter.nama_dokter')
                        ->from($this->db_tabel)
                        ->join('data_pasien', 'data_pasien.kode_pasien = rekam_medis.kode_pasien')
						->join('data_dokter', 'data_dokter.kode_dokter = rekam_medis.kode_dokter')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('nama_dokter')
						->having('nama_dokter','dr.H.Sutisna')
                        ->get()
                        ->result();
	}
	
		public function cari_mariana($offset)
	{
        /**
         * $offset start
         * Gunakan hanya jika class 'PAGINATION' menggunakan option
         * 'use_page_numbers' => TRUE
         * Jika tidak, beri comment
         */        
		if (is_null($offset) || empty($offset))
        {
            $this->offset = 0;
        }
        else
        {
            $this->offset = ($offset * $this->per_halaman) - $this->per_halaman;
        }		
        // $offset end

        return $this->db->select('rekam_medis.kode_rekam,rekam_medis.anamnesa, rekam_medis.alergi, rekam_medis.pasien, rekam_medis.terapi,rekam_medis.injeksi,rekam_medis.nebu,rekam_medis.guladarah,rekam_medis.asamurat,rekam_medis.kolesterol,rekam_medis.tanggal,data_pasien.kode_pasien,data_pasien.nama,data_dokter.nama_dokter')
                        ->from($this->db_tabel)
                        ->join('data_pasien', 'data_pasien.kode_pasien = rekam_medis.kode_pasien')
						->join('data_dokter', 'data_dokter.kode_dokter = rekam_medis.kode_dokter')
                        ->limit($this->per_halaman, $this->offset)
                        ->order_by('nama_dokter')
						->having('nama_dokter','dr. Mariana S')
                        ->get()
                        ->result();
	}
 
 
    public function cari($kode_rekam)
    {
        return $this->db->where('kode_rekam', $kode_rekam)
            ->limit(1)
            ->get($this->db_tabel)
            ->row();
    }

    public function buat_tabel1($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No','Tanggal', 'Kode Rekam Medis', 'Kode Pasien', 'Anamnesa', 'Alergi','Pasien','Terapi','Nama Dokter','Aksi');

        // no urut data
        $no = 0 + $this->offset;

        foreach ($data as $row)
        {
			// Konversi hari dan tanggal ke dalam format Indonesia (dd-mm-yyyy)
            $hari_array = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $hr = date('w', strtotime($row->tanggal));
            $hari = $hari_array[$hr];
            $tgl = date('d-m-Y', strtotime($row->tanggal));
            $hr_tgl = "$hari, $tgl";
			
            $this->table->add_row(
                ++$no,
				$hr_tgl,
				//$row->tanggal,
                $row->kode_rekam,
                $row->kode_pasien,
                $row->anamnesa,
				$row->alergi,
				$row->pasien,
				$row->terapi,
				$row->nama_dokter,
                anchor('rekammedistommy/edit/'.$row->kode_rekam,'Edit',array('class' => 'edit'))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
	
	public function buat_tabel2($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No','Tanggal', 'Kode Rekam Medis', 'Kode Pasien', 'Anamnesa', 'Alergi','Pasien','Terapi','Nama Dokter','Aksi');

        // no urut data
        $no = 0 + $this->offset;

        foreach ($data as $row)
        {
			// Konversi hari dan tanggal ke dalam format Indonesia (dd-mm-yyyy)
            $hari_array = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $hr = date('w', strtotime($row->tanggal));
            $hari = $hari_array[$hr];
            $tgl = date('d-m-Y', strtotime($row->tanggal));
            $hr_tgl = "$hari, $tgl";
			
            $this->table->add_row(
                ++$no,
				$hr_tgl,
				//$row->tanggal,
                $row->kode_rekam,
                $row->kode_pasien,
                $row->anamnesa,
				$row->alergi,
				$row->pasien,
				$row->terapi,
				$row->nama_dokter,
                anchor('rekammedischandra/edit/'.$row->kode_rekam,'Edit',array('class' => 'edit'))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
	
	public function buat_tabel3($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No','Tanggal', 'Kode Rekam Medis', 'Kode Pasien', 'Anamnesa', 'Alergi','Pasien','Terapi','Nama Dokter','Aksi');

        // no urut data
        $no = 0 + $this->offset;

        foreach ($data as $row)
        {
			// Konversi hari dan tanggal ke dalam format Indonesia (dd-mm-yyyy)
            $hari_array = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $hr = date('w', strtotime($row->tanggal));
            $hari = $hari_array[$hr];
            $tgl = date('d-m-Y', strtotime($row->tanggal));
            $hr_tgl = "$hari, $tgl";
			
            $this->table->add_row(
                ++$no,
				$hr_tgl,
				//$row->tanggal,
                $row->kode_rekam,
                $row->kode_pasien,
                $row->anamnesa,
				$row->alergi,
				$row->pasien,
				$row->terapi,
				$row->nama_dokter,
                anchor('rekammedisandrian/edit/'.$row->kode_rekam,'Edit',array('class' => 'edit'))
                );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
	
	public function buat_tabel4($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No','Tanggal', 'Kode Rekam Medis', 'Kode Pasien', 'Anamnesa', 'Alergi','Pasien','Terapi','Nama Dokter','Aksi');

        // no urut data
        $no = 0 + $this->offset;

        foreach ($data as $row)
        {
			// Konversi hari dan tanggal ke dalam format Indonesia (dd-mm-yyyy)
            $hari_array = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $hr = date('w', strtotime($row->tanggal));
            $hari = $hari_array[$hr];
            $tgl = date('d-m-Y', strtotime($row->tanggal));
            $hr_tgl = "$hari, $tgl";
			
            $this->table->add_row(
                ++$no,
				$hr_tgl,
				//$row->tanggal,
                $row->kode_rekam,
                $row->kode_pasien,
                $row->anamnesa,
				$row->alergi,
				$row->pasien,
				$row->terapi,
				$row->nama_dokter,
                anchor('rekammedissusi/edit/'.$row->kode_rekam,'Edit',array('class' => 'edit'))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
	
	public function buat_tabel5($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No','Tanggal', 'Kode Rekam Medis', 'Kode Pasien', 'Anamnesa', 'Alergi','Pasien','Terapi','Nama Dokter','Aksi');

        // no urut data
        $no = 0 + $this->offset;

        foreach ($data as $row)
        {
			// Konversi hari dan tanggal ke dalam format Indonesia (dd-mm-yyyy)
            $hari_array = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $hr = date('w', strtotime($row->tanggal));
            $hari = $hari_array[$hr];
            $tgl = date('d-m-Y', strtotime($row->tanggal));
            $hr_tgl = "$hari, $tgl";
			
            $this->table->add_row(
                ++$no,
				$hr_tgl,
				//$row->tanggal,
                $row->kode_rekam,
                $row->kode_pasien,
                $row->anamnesa,
				$row->alergi,
				$row->pasien,
				$row->terapi,
				$row->nama_dokter,
                anchor('rekammedisruli/edit/'.$row->kode_rekam,'Edit',array('class' => 'edit'))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
	
	public function buat_tabel6($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No','Tanggal', 'Kode Rekam Medis', 'Kode Pasien', 'Anamnesa', 'Alergi','Pasien','Terapi','Nama Dokter','Aksi');

        // no urut data
        $no = 0 + $this->offset;

        foreach ($data as $row)
        {
			// Konversi hari dan tanggal ke dalam format Indonesia (dd-mm-yyyy)
            $hari_array = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $hr = date('w', strtotime($row->tanggal));
            $hari = $hari_array[$hr];
            $tgl = date('d-m-Y', strtotime($row->tanggal));
            $hr_tgl = "$hari, $tgl";
			
            $this->table->add_row(
                ++$no,
				$hr_tgl,
				//$row->tanggal,
                $row->kode_rekam,
                $row->kode_pasien,
                $row->anamnesa,
				$row->alergi,
				$row->pasien,
				$row->terapi,
				$row->nama_dokter,
                anchor('rekammedisagustine/edit/'.$row->kode_rekam,'Edit',array('class' => 'edit'))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
	
	public function buat_tabel7($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No','Tanggal', 'Kode Rekam Medis', 'Kode Pasien', 'Anamnesa', 'Alergi','Pasien','Terapi','Nama Dokter','Aksi');

        // no urut data
        $no = 0 + $this->offset;

        foreach ($data as $row)
        {
			// Konversi hari dan tanggal ke dalam format Indonesia (dd-mm-yyyy)
            $hari_array = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $hr = date('w', strtotime($row->tanggal));
            $hari = $hari_array[$hr];
            $tgl = date('d-m-Y', strtotime($row->tanggal));
            $hr_tgl = "$hari, $tgl";
			
            $this->table->add_row(
                ++$no,
				$hr_tgl,
				//$row->tanggal,
                $row->kode_rekam,
                $row->kode_pasien,
                $row->anamnesa,
				$row->alergi,
				$row->pasien,
				$row->terapi,
				$row->nama_dokter,
                anchor('rekammedissutisna/edit/'.$row->kode_rekam,'Edit',array('class' => 'edit'))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
	
	public function buat_tabel8($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No','Tanggal', 'Kode Rekam Medis', 'Kode Pasien', 'Anamnesa', 'Alergi','Pasien','Terapi','Nama Dokter','Aksi');

        // no urut data
        $no = 0 + $this->offset;

        foreach ($data as $row)
        {
			// Konversi hari dan tanggal ke dalam format Indonesia (dd-mm-yyyy)
            $hari_array = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $hr = date('w', strtotime($row->tanggal));
            $hari = $hari_array[$hr];
            $tgl = date('d-m-Y', strtotime($row->tanggal));
            $hr_tgl = "$hari, $tgl";
			
            $this->table->add_row(
                ++$no,
				$hr_tgl,
				//$row->tanggal,
                $row->kode_rekam,
                $row->kode_pasien,
                $row->anamnesa,
				$row->alergi,
				$row->pasien,
				$row->terapi,
				$row->nama_dokter,
                anchor('rekammedismariana/edit/'.$row->kode_rekam,'Edit',array('class' => 'edit'))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
	
	public function buat_tabel9($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No','Tanggal', 'Kode Rekam Medis', 'Kode Pasien', 'Anamnesa', 'Alergi','Pasien','Terapi','Nama Dokter','Aksi');

        // no urut data
        $no = 0 + $this->offset;

        foreach ($data as $row)
        {
			// Konversi hari dan tanggal ke dalam format Indonesia (dd-mm-yyyy)
            $hari_array = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $hr = date('w', strtotime($row->tanggal));
            $hari = $hari_array[$hr];
            $tgl = date('d-m-Y', strtotime($row->tanggal));
            $hr_tgl = "$hari, $tgl";
			
            $this->table->add_row(
                ++$no,
				$hr_tgl,
				//$row->tanggal,
                $row->kode_rekam,
                $row->kode_pasien,
                $row->anamnesa,
				$row->alergi,
				$row->pasien,
				$row->terapi,
				$row->nama_dokter,
                anchor('rekammedis/edit/'.$row->kode_rekam,'Edit',array('class' => 'edit')).' '.
                anchor('rekammedis/hapus/'.$row->kode_rekam,'Hapus',array('class'=> 'delete','onclick'=>"return confirm('Anda yakin akan menghapus data ini?')"))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }
	
	public function buat_tabel($data)
    {
        $this->load->library('table');

        // buat class zebra di <tr>,untuk warna selang-seling
        $tmpl = array('row_alt_start'  => '<tr class="zebra">');
        $this->table->set_template($tmpl);

        // heading tabel
        $this->table->set_heading('No','Tanggal', 'Kode Rekam Medis', 'Kode Pasien', 'Anamnesa', 'Alergi','Pasien','Terapi','Nama Dokter','Aksi');

        // no urut data
        $no = 0 + $this->offset;

        foreach ($data as $row)
        {
			// Konversi hari dan tanggal ke dalam format Indonesia (dd-mm-yyyy)
            $hari_array = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $hr = date('w', strtotime($row->tanggal));
            $hari = $hari_array[$hr];
            $tgl = date('d-m-Y', strtotime($row->tanggal));
            $hr_tgl = "$hari, $tgl";
			
            $this->table->add_row(
                ++$no,
				$hr_tgl,
				//$row->tanggal,
                $row->kode_rekam,
                $row->kode_pasien,
                $row->anamnesa,
				$row->alergi,
				$row->pasien,
				$row->terapi,
				$row->nama_dokter,
                anchor('rekammedis/edit/'.$row->kode_rekam,'Edit',array('class' => 'edit')).' '.
                anchor('rekammedis/hapus/'.$row->kode_rekam,'Hapus',array('class'=> 'delete','onclick'=>"return confirm('Anda yakin akan menghapus data ini?')"))
            );
        }
        $tabel = $this->table->generate();

        return $tabel;
    }

    public function paging($base_url)
    {
        $this->load->library('pagination');
        $config = array(
            'base_url'         => $base_url,
            'total_rows'       => $this->hitung_semua(),
            'per_page'         => $this->per_halaman,
            'num_links'        => 4,			
			'use_page_numbers' => TRUE,
            'first_link'       => '&#124;&lt; First',
            'last_link'        => 'Last &gt;&#124;',
            'next_link'        => 'Next &gt;',
            'prev_link'        => '&lt; Prev',
        );
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    public function hitung_semua()
    {
        return $this->db->count_all($this->db_tabel);
    }

    public function tambah()
    {
        $rekammedis = array(
			'tanggal'=>date('Y-m-d', strtotime($this->input->post('tanggal'))),
            'kode_rekam' => $this->input->post('kode_rekam'),
            'kode_pasien' => $this->input->post('kode_pasien'),
			'anamnesa' => $this->input->post('anamnesa'),
			'alergi' => $this->input->post('alergi'),
			'pasien' => $this->input->post('pasien'),
			'terapi' => $this->input->post('terapi'),
			'injeksi' => $this->input->post('injeksi'),
			'nebu' => $this->input->post('nebu'),
			'guladarah' => $this->input->post('guladarah'),
			'asamurat' => $this->input->post('asamurat'),
			'kolesterol' => $this->input->post('kolesterol'),
			'kode_dokter' => $this->input->post('kode_dokter')
        );
        $this->db->insert($this->db_tabel, $rekammedis);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	
	  public function tambahtommy()
    {
        $rekammedis = array(
			'tanggal'=>date('Y-m-d'), //strtotime($this->input->post('tanggal'))),
            'kode_rekam' => $this->input->post('kode_rekam'),
            'kode_pasien' => $this->input->post('kode_pasien'),
			'anamnesa' => $this->input->post('anamnesa'),
			'alergi' => $this->input->post('alergi'),
			'pasien' => $this->input->post('pasien'),
			'terapi' => $this->input->post('terapi'),
			'injeksi' => $this->input->post('injeksi'),
			'nebu' => $this->input->post('nebu'),
			'guladarah' => $this->input->post('guladarah'),
			'asamurat' => $this->input->post('asamurat'),
			'kolesterol' => $this->input->post('kolesterol'),
			'kode_dokter' => $this->input->post('kode_dokter')
        );
        $this->db->insert($this->db_tabel, $rekammedis);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function edit($kode_rekam)
    {
        $rekammedis = array(
			'tanggal'=>date('Y-m-d', strtotime($this->input->post('tanggal'))),
            //'kode_rekam' => $this->input->post('kode_rekam'),
            'kode_pasien' => $this->input->post('kode_pasien'),
			'anamnesa' => $this->input->post('anamnesa'),
			'alergi' => $this->input->post('alergi'),
			'pasien' => $this->input->post('pasien'),
			'terapi' => $this->input->post('terapi'),
			'injeksi' => $this->input->post('injeksi'),
			'nebu' => $this->input->post('nebu'),
			'guladarah' => $this->input->post('guladarah'),
			'asamurat' => $this->input->post('asamurat'),
			'kolesterol' => $this->input->post('kolesterol'),
			'kode_dokter' => $this->input->post('kode_dokter')
        );

        // update db
        $this->db->where('kode_rekam', $kode_rekam);
        $this->db->update($this->db_tabel, $rekammedis);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function hapus($kode_rekam)
    {
        $this->db->where('kode_rekam', $kode_rekam)->delete($this->db_tabel);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
/* End of file siswa_model.php */
/* Location: ./application/models/siswa_model.php */