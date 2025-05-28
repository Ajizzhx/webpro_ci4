<?php

namespace App\Models;

use CodeIgniter\Model;

class M_TempPeminjaman extends Model
{
    protected $table            = 'tbl_temp_peminjaman';
    protected $primaryKey       = 'id_temp'; // Tambahkan primary key auto increment jika belum ada
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_anggota', 'id_buku', 'jumlah_temp']; // Asumsi jumlah_temp selalu 1

    // Dates
    protected $useTimestamps = false;

    public function getTempWithBuku($id_anggota)
    {
        return $this->select('tbl_temp_peminjaman.*, tbl_buku.judul_buku, tbl_buku.pengarang')
                    ->join('tbl_buku', 'tbl_buku.id_buku = tbl_temp_peminjaman.id_buku')
                    ->where('tbl_temp_peminjaman.id_anggota', $id_anggota)
                    ->findAll();
    }

    public function countTempItems($id_anggota)
    {
        return $this->where('id_anggota', $id_anggota)->countAllResults();
    }
}