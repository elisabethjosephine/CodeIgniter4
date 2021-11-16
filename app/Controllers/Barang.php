<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Barang extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        // $barang = $this->barangModel->findAll()
        $data = [
            'title' => 'Daftar Barang',
            'barang' => $this->barangModel->getBarang()
        ];

        return view('Barang/index', $data);
    }

    public function detail($slug)
    {

        $data = [
            'title' => 'Detail Barang',
            'barang' => $this->barangModel->getBarang($slug)
        ];

        //jika barang tidak ada di tabel
        if (empty($data['barang'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Nama barang' . $slug . 'tidak
            ditemukan');
        }


        return view('barang/detail', $data);
    }

    public function create()
    {

        $data = [
            'title' => 'Form Tambah Data Barang',
            'validation' => \Config\Services::validation()
        ];
        return view('barang/create', $data);
    }

    public function save()
    {
        //validasi input
        if (!$this->validate([
            'nama_barang' => [
                'rules' => 'required|is_unique[barang.nama_barang]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'is_unique' => '{field} sudah ada.'
                ],
                [
                    'gambar' => [
                        'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png ]',
                        'errors' => [
                            'max_size' => 'Ukuran Gambar terlalu besar',
                            'is_image' => 'yang Anda Pilih bukan Gambar',
                            'mime_in' => 'yang Anda Pilih bukan Gambar',


                        ]

                    ]

                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/barang/create')->withInput()->with('validation', $validation);
        }

        //ambil gambar
        $fileGambar = $this->request->getFile('gambar');
        //apakah tidak ada gambar yang diupload
        if ($fileGambar->getError() == 4) {
            $namaGambar = 'photo.png';
        } else {
            //generate nama gambara random
            $namaGambar = $fileGambar->getRandomName();
            //pindahkan file ke folder img
            $fileGambar->move('img', $namaGambar);
        }
        //ambil nama file gambar
        // $namaGambar = $fileGambar->getName();

        // dd($namaGambar);
        $slug = url_title($this->request->getVar('nama_barang'), '-', true);
        // dd($this->request->getVar());
        $this->barangModel->save([
            'nama_barang' => $this->request->getVar('nama_barang'),
            'slug' => $slug,
            'lokasi' => $this->request->getVar('lokasi'),
            'kondisi' => $this->request->getVar('kondisi'),
            'gambar' => $namaGambar,
            'jumlah_barang' => $this->request->getVar('jumlah_barang'),
            'spesifikasi' => $this->request->getVar('spesifikasi')


        ]);


        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan.');

        return redirect()->to('/barang');
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $barang = $this->barangModel->find($id);

        //cek jika file gambarnya default
        if ($barang['gambar'] != 'photo.png') {
            //hapus gambar
            unlink('img/' . $barang['gambar']);
        }

        $this->barangModel->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
        return redirect()->to('/barang');
    }

    public function edit($slug)
    {

        $data = [
            'title' => 'Form Ubah Data Barang',
            'validation' => \Config\Services::validation(),
            'barang' => $this->barangModel->getBarang($slug)
        ];

        return view('barang/edit', $data);
    }

    public function update($id)
    {
        //cek nama barang
        $barangLama = $this->barangModel->getBarang($this->request->getVar('slug'));
        if ($barangLama['nama_barang'] == $this->request->getVar('nama_barang')) {
            $rule_nama_barang = 'required';
        } else {
            $rule_nama_barang = 'required|is_unique[barang.nama_barang]';
        }

        if (!$this->validate([
            'nama_barang' => [
                'rules' => $rule_nama_barang,
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'is_unique' => '{field} sudah ada.'
                ]
            ],
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png ]',
                'errors' => [
                    'max_size' => 'Ukuran Gambar terlalu besar',
                    'is_image' => 'yang Anda Pilih bukan Gambar',
                    'mime_in' => 'yang Anda Pilih bukan Gambar',


                ]

            ]

        ])) {
            // $validation = \Config\Services::validation();
            return redirect()->to('/barang/edit' . $this->request->getVar('slug'))->withInput();
        }

        $fileGambar = $this->request->getFile('gambar');

        //cek gambar, apakah etap gambar lama
        if ($fileGambar->getError() == 4) {
            $namaGambar = $this->request->getVar('gambarLama');
        } else {
            //genrate nama file random
            $namaGambar = $fileGambar->getRandomName();
            //pindahkan gambar
            $fileGambar->move('img', $namaGambar);
            //hapus file yang lama
            unlink('img/' . $this->request->getVar('gambarLama'));
        }

        $slug = url_title($this->request->getVar('nama_barang'), '-', true);
        $this->barangModel->save([
            'id' => $id,
            'nama_barang' => $this->request->getVar('nama_barang'),
            'slug' => $slug,
            'lokasi' => $this->request->getVar('lokasi'),
            'kondisi' => $this->request->getVar('kondisi'),
            'gambar' => $namaGambar,
            'jumlah_barang' => $this->request->getVar('jumlah_barang'),
            'spesifikasi' => $this->request->getVar('spesifikasi')

        ]);

        session()->setFlashdata('pesan', 'Data Berhasil Diubah.');

        return redirect()->to('/barang');
    }
}
