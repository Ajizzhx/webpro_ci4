<?php 
namespace App\Models; 
  
use CodeIgniter\Model; 
  
class M_Peminjaman extends Model 
{ 
    protected $table = 'tbl_peminjaman'; 
    protected $tableTmp = 'tbl_temp_peminjaman'; 
    // Add allowed fields for the main table if you plan to use $model->save() or $model->update()
    protected $allowedFieldsPeminjaman = ['no_peminjaman', 'id_anggota', 'tgl_pinjam', 'total_pinjam', 'id_admin', 'status_transaksi', 'status_ambil_buku', 'qr_code'];
    // Add allowed fields for the temp table
    protected $allowedFieldsTemp = ['id_anggota', 'id_buku', 'jumlah_temp'];
    protected $tableDetail = 'tbl_detail_peminjaman'; 
  
    public function getDataPeminjaman($where = false) 
    { 
        if ($where === false) { 
            $builder = $this->db->table($this->table); 
            $builder->select('*'); 
            $builder->orderBy('no_peminjaman','DESC'); 
            return $query = $builder->get(); 
        } else { 
            $builder = $this->db->table($this->table); 
            $builder->select('*'); 
            $builder->where($where); 
            $builder->orderBy('no_peminjaman','DESC'); 
            return $query = $builder->get(); 
        } 
    } 
     
    public function getDataPeminjamanJoin($where = false) 
    {  if ($where === false) { 
        $builder = $this->db->table($this->table); 
        $builder->select('*'); 
        $builder->join('tbl_anggota','tbl_anggota.id_anggota = tbl_peminjaman.id_anggota','LEFT'); 
        $builder->join('tbl_admin','tbl_admin.id_admin = tbl_peminjaman.id_admin','LEFT'); 
        $builder->orderBy('tbl_peminjaman.no_peminjaman','DESC'); 
        return $query = $builder->get(); 
    } else { 
        $builder = $this->db->table($this->table); 
        $builder->select('*'); 
        $builder->where($where); 
        $builder->join('tbl_anggota','tbl_anggota.id_anggota = tbl_peminjaman.id_anggota','LEFT'); 
        $builder->join('tbl_admin','tbl_admin.id_admin = tbl_peminjaman.id_admin','LEFT'); 
        $builder->orderBy('tbl_peminjaman.no_peminjaman','DESC'); 
        return $query = $builder->get(); 
    } 
} 

public function getDataTemp($where = false) 
{ 
    if ($where === false) { 
        $builder = $this->db->table($this->tableTmp); 
        $builder->select('*'); 
        return $query = $builder->get(); 
    } else { 
        $builder = $this->db->table($this->tableTmp); 
        $builder->select('*'); 
        $builder->where($where); 
        return $query = $builder->get(); 
    } 
} 

public function getDataTempJoin($where = false) 
{ 
    if ($where === false) { 
        $builder = $this->db->table($this->tableTmp); 
        $builder->select('*'); 
        $builder->join('tbl_buku','tbl_buku.id_buku = tbl_temp_peminjaman.id_buku','LEFT'); 
        return $query = $builder->get(); 
    } else { 
        $builder = $this->db->table($this->tableTmp); 
        $builder->select('*'); 
        $builder->where($where); 
        $builder->join('tbl_buku','tbl_buku.id_buku = tbl_temp_peminjaman.id_buku','LEFT'); 
        return $query = $builder->get(); 
    } 
} 

public function saveDataPeminjaman($data) 
{ 
    $builder = $this->db->table($this->table); 
    return $builder->insert($data); 
}   public function saveDataTemp($data) 
{ 
    $builder = $this->db->table($this->tableTmp); 
    return $builder->insert($data); 
} 

public function saveDataDetail($data) 
{ 
    $builder = $this->db->table($this->tableDetail); 
    return $builder->insert($data); 
} 

public function updateDataPeminjaman($data, $where) 
{ 
    $builder = $this->db->table($this->table); 
    $builder->where($where); 
    return $builder->update($data); 
} 

public function updateDataDetail($data, $where) 
{ 
    $builder = $this->db->table($this->tableDetail); 
    $builder->where($where); 
    return $builder->update($data); 
} 

public function hapusDataTemp($where) 
{ 
    $builder = $this->db->table($this->tableTmp); 
    return $builder->delete($where); 
} 
}
?> 