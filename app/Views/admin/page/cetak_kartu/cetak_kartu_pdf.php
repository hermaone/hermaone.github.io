<!DOCTYPE html>
<html>
<head>
    <title><?= $title;?></title>
</head><body>
<table border="0" style="text-align: center;width: 100%;">
    <?php $no=1; foreach($data as $row):
        $path   = realpath(FCPATH.'file_foto_maba/'.$row['foto_maba']);
        $path1  = realpath(FCPATH.'img/logostikes.png');
        $path2  = realpath(FCPATH.'img/kampusmerdeka.png');
        $type   = pathinfo($path,PATHINFO_EXTENSION);
        $data   = file_get_contents($path);
        $data1  = file_get_contents($path1);
        $data2  = file_get_contents($path2);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $logo1  = 'data:image/' . $type . ';base64,' . base64_encode($data1);
        $logo2  = 'data:image/' . $type . ';base64,' . base64_encode($data2);
        
    ?>
    <img src="<?= $logo1;?>" width="100px" height="100px" style="position: absolute;
    left: 80px; top: -5px;">

    <img src="<?= $logo2;?>" width="100px" height="70px" style="position: absolute;
    right: 80px; top: 0px;">
    <tr>
        <td>PANITIA PENERIMAAN MAHASISWA BARU (SIPENMARU)</td>
        
    </tr>
    <tr>
        <td style="font-size: 20px;font-weight: bold;">SEKOLAH TINGGI ILMU KESEHATAN (STIKES)</td>
    </tr>
    <tr>
        <td style="font-size: 36px;font-weight: bold;">NGUDIA HUSADA MADURA</td>
    </tr>
    <tr>
        <td>JL. RE. Martadinata No.45 Mlajah Bangkalan Madura. Tlp. (031) 3061522. Webiste. www.stikesnhm.ac.id</td>
    </tr>
    

</table>
<hr> 
<h4 style="text-align: center;">KARTU UJIAN MAHASISWA BARU</h4>
<table border="0" width="100%">
    
        <tr height="10px">
            <th style="text-align: left;height: 10px; width: 25%;">No Pendaftaran</th><th style="width: 2%;">:</th><td><?= $row['no_pendaftaran'];?></td>
             <td rowspan="6" th style="text-align: left;height: 10px; width: 20%;"><span><img src="<?= $base64;?>" width="160px" height="160px" style="position: relative;bottom: 132px;margin-left: auto;margin-right: auto;display: block;"></span></td>
        </tr>
        

        <tr  height="10px">
            <th style="text-align: left;height: 10px;">Nama Lengkap</th><th>:</td><td><?= $row['fullname'];?></td>
        </tr>

        <tr  height="10px">
            <th style="text-align: left;height: 10px;">Asal Sekolah</th><th>:</td><td><?= $row['asal_sekolah'];?></td>
        </tr>

        <tr  height="10px">
            <th style="text-align: left;height: 10px;">Jurusan Sekolah</th><th>:</td><td><?= $row['jurusan_sekolah'];?></td>
        </tr>

        <tr  height="10px">
            <th style="text-align: left;height: 10px;">Jalur Penerimaan</th><th>:</td><td><?= $row['jalur_penerimaan'];?> <?= $row['gelombang'];?></td>
        </tr>

        <tr  height="10px">
            <th style="text-align: left;height: 10px;">Program Studi</th><th>:</th><td>1. <?= $row['prodi_satu'];?> </td>
        </tr>
        <tr  height="10px">
            <th style="text-align: left;height: 10px;"></th><th></th><td>2. <?= $row['prodi_dua'];?> </td>
        </tr>
        <tr>
            <td colspan="3"><b>IDENTIFIKASI UJIAN : </b>
            </td>
        </tr>
</table>
<table border="1" width="100%" style="border-collapse: collapse;font-family: sans-serif;">
      <tr>
            <td style="text-align: center; width: 5%"><strong>No</strong></td>
            <td style="text-align: center; width: 50%"><strong>Ujian</strong></td>
            <td style="text-align: center; width: 0%;"><strong>Paraf Petugas</strong></td>
            <td style="text-align: center; border-collapse: collapse;border-left: 1px solid #777575;border-top: 1px solid transparent;border-right: 1px solid transparent;border-bottom: 1px solid transparent;">Bangkalan, <?= date('d-M-Y', strtotime($row['tanggal_valid_berkas']));?></td>
      </tr>
      <tr>
            <td style="text-align: center;">1</td>
            <td>TULIS</td>
            <td></td>
            <td style="text-align: center;border-collapse: collapse;border-left: 1px solid #777575;border-top: 1px solid transparent;border-right: 1px solid transparent;border-bottom: 1px solid transparent;">Tim Pendaftaran</td>
      </tr>
      <tr>
            <td style="text-align: center;">2</td>
            <td>WAWANCARA</td>
            <td></td>
            <td style="text-align: center;border-collapse: collapse;border-left: 1px solid #777575;border-top: 1px solid transparent;border-right: 1px solid transparent;border-bottom: 1px solid transparent;"></td>
      </tr>
      <tr>
            <td style="text-align: center;">3</td>
            <td>KESEHATAN</td>
            <td></td>
            <td style="text-align: center;border-collapse: collapse;border-left: 1px solid #777575;border-top: 1px solid transparent;border-right: 1px solid transparent;border-bottom: 1px solid transparent;"></td>
      </tr>
      <tr>
            <td style="text-align: center;">4</td>
            <td>PSIKOTES</td>
            <td></td>
            <td style="text-align: center;border-collapse: collapse;border-left: 1px solid #777575;border-top: 1px solid transparent;border-right: 1px solid transparent;border-bottom: 1px solid transparent;"></td>
      </tr>
      
      <tr>
            <td style="text-align: center;border-collapse: collapse;border-left: 1px solid transparent;border-top: 1px solid transparent;border-right: 1px solid transparent;border-bottom: 1px solid transparent;"></td>
            <td style="text-align: center;border-collapse: collapse;border-left: 1px solid #777575;border-top: 1px solid transparent;border-right: 1px solid transparent;border-bottom: 1px solid transparent;"></td>
           <td style="text-align: center;border-collapse: collapse;border-left: 1px solid #777575;border-top: 1px solid transparent;border-right: 1px solid transparent;border-bottom: 1px solid transparent;"></td>
            <td style="text-align: center;border-collapse: collapse;border-left: 1px solid #777575;border-top: 1px solid transparent;border-right: 1px solid transparent;border-bottom: 1px solid transparent;">(...........................)</td>
      </tr>
      
</table>
<table border="0" width="100%">
    <tr>
        <td style="font-size: 10px">*Peserta diharapkan datang 30 menit sebelum ujian dimulai. Pakaian bebas, rapi, sopan , tidak berbahan jeans dan kaos, wajib bersepatu.</td>
    </tr>
    <tr>
        <td style="font-size: 10px">*Tes KESEHATAN DAN PSIKOTES Tidak berlaku untuk jenjang Profesi, Alih Jenjang dan Tes Tulis tidak berlaku untuk Jalur PMDP.  <i style="float: left; font-size: 10px;"> * Dicetak oleh system Sipenmaru STIKES NHM pada tanggal <?php echo date('d-M-Y. h:i:s');?> WIB</td>
    </tr>
    

</table>
 <?php $no++;?>
<?php endforeach;?>
</body></html>

