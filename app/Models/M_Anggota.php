<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Anggota extends Model
{
    protected $table = 'tbl_anggota'; // Nama tabel anggota (sesuai database)
    protected $primaryKey = 'id_anggota'; // Primary key tabel
    protected $allowedFields = [ // Kolom yang boleh diisi massal
        'id_anggota',
        'nama_anggota',
        'jenis_kelamin',
        'no_tlp',
        'alamat',
        'email',
        'password_anggota',
        'is_delete_anggota',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = false; // Kita atur manual created_at/updated_at

    // Mengambil data anggota berdasarkan kondisi
    public function getDataAnggota($where)
    {
        // Gunakan Query Builder untuk keamanan dan kemudahan
        return $this->db->table($this->table)->getWhere($where);
    }

    // Menyimpan data anggota baru
    public function saveDataAnggota($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    // Memperbarui data anggota berdasarkan kondisi
    public function updateDataAnggota($data, $where)
    {
        return $this->db->table($this->table)->update($data, $where);
    }

    // Membuat nomor ID anggota otomatis
    public function autoNumber()
    {
        return $this->db->table($this->table)
                        ->select('id_anggota')
                        ->orderBy('id_anggota', 'DESC')
                        ->limit(1)
                        ->get();
    }
}
