<?php

namespace App\Models; // Pastikan namespace benar

use CodeIgniter\Model;

class M_Kategori extends Model // Pastikan nama class benar
{
    protected $table = 'tbl_kategori'; // Ganti dengan nama tabel kategori Anda jika berbeda
    protected $primaryKey = 'id_kategori'; // Ganti jika primary key berbeda

    // Tambahkan kolom yang diizinkan jika menggunakan fitur save/update bawaan model
    // protected $allowedFields = ['id_kategori', 'nama_kategori', 'is_delete_kategori', 'created_at', 'updated_at'];

    protected $useTimestamps = false; // Sesuaikan jika Anda ingin CI mengelola created_at/updated_at

    // Method dasar untuk mengambil data
    public function getDataKategori($where = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        if ($where !== false) {
            $builder->where($where);
        }
        $builder->orderBy('nama_kategori', 'ASC'); // Urutkan berdasarkan nama kategori
        return $query = $builder->get();
    }

    // Method dasar untuk menyimpan data
    public function saveDataKategori($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    // Method dasar untuk update data
    public function updateDataKategori($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }

    // Method dasar untuk auto number (sesuaikan format jika perlu)
    public function autoNumber()
    {
        $builder = $this->db->table($this->table);
        $builder->select("id_kategori"); // Ganti jika nama kolom ID berbeda
        $builder->orderBy("id_kategori", "DESC"); // Ganti jika nama kolom ID berbeda
        $builder->limit(1);
        return $query = $builder->get();
    }

    // Anda bisa menambahkan method lain sesuai kebutuhan
}
