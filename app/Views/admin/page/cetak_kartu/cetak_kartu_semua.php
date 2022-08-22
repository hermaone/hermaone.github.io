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
            <th style="text-align: left;height: 10px; width: 20%;">No Pendaftaran</th><th style="width: 2%;">:</th><td><?= $row['jalur_penerimaan'];?>073154<?php echo $no?></td>
             <td rowspan="6"><span><img src="<?= $base64;?>" width="160px" height="160px" style="position: relative;bottom: 132px;margin-left: auto;margin-right: auto;display: block;"></span></td>
        </tr>
        

        <tr  height="10px">
            <th style="text-align: left;height: 10px;">Nama Lengkap</th><th>:</td><td><?= $row['fullname'];?></td>
        </tr>

        <tr  height="10px">
            <th style="text-align: left;height: 10px;">Jalur Penerimaan</th><th>:</td><td><?= $row['jalur_penerimaan'];?></td>
        </tr>

        <tr  height="10px">
            <th style="text-align: left;height: 10px;">Program Studi</th><th>:</th><td>1. <?= $row['prodi_satu'];?> </td>
        </tr>
        <tr  height="10px">
            <th style="text-align: left;height: 10px;"></th><th></th><td>2. <?= $row['prodi_dua'];?> </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;"></td>
        </tr>
         <tr>
            <td colspan="3"></td><td style="text-align: left;">Bangkalan, <?php echo date("d-m-Y"); ?></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;">Panitia Sipenmaru,</td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;">(...............................................)</td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        <tr>
            <td colspan="3"></td><td style="text-align: left;"></td>
        </tr>
        
        <tr>
            <td colspan="3" style="font-size: 11px">Dicetak oleh system Sipenmarunhm pada tanggal : <?php echo date('d-m-Y');?></td>
        </tr>      
</table>
 <?php $no++;?>
<?php endforeach;?>
</body></html>

