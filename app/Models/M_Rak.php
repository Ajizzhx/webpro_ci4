<?php

namespace App\Models; // Pastikan namespace benar

use CodeIgniter\Model;

class M_Rak extends Model // Pastikan nama class benar
{
    protected $table = 'tbl_rak'; // Ganti dengan nama tabel rak Anda jika berbeda
    protected $primaryKey = 'id_rak'; // Ganti jika primary key berbeda

    // Tambahkan kolom yang diizinkan jika menggunakan fitur save/update bawaan model
    // protected $allowedFields = ['id_rak', 'nama_rak', 'is_delete_rak', 'created_at', 'updated_at'];

    protected $useTimestamps = false; // Sesuaikan jika Anda ingin CI mengelola created_at/updated_at

    // Method dasar untuk mengambil data rak
    public function getDataRak($where = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        if ($where !== false) {
            $builder->where($where);
        }
        $builder->orderBy('nama_rak', 'ASC'); // Urutkan berdasarkan nama rak (atau field lain yang relevan)
        return $query = $builder->get();
    }

    // Method dasar untuk menyimpan data rak
    public function saveDataRak($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    // Method dasar untuk update data rak
    public function updateDataRak($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }

    // Method dasar untuk auto number (sesuaikan format jika perlu)
    public function autoNumber()
    {
        $builder = $this->db->table($this->table);
        $builder->select("id_rak"); // Ganti jika nama kolom ID berbeda
        $builder->orderBy("id_rak", "DESC"); // Ganti jika nama kolom ID berbeda
        $builder->limit(1);
        return $query = $builder->get();
    }

    // Anda bisa menambahkan method lain sesuai kebutuhan
}
