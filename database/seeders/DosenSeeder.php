<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataDosen=[
            [13, 'ALDE ALANDA, S.Kom, M.T', '0025088802', '198808252015041002', 'Laki-laki', 'Padang', '1988-08-25', '12345678', 'S2', 7, 26, 2, 'Jl. Jati No. 1', 'alde@pnp.ac.id', '081234567801', 'alde.png', 'Aktif'],
            [14, 'ALDO ERIANDA, M.T, S.ST', '003078904', '198907032019031015', 'Laki-laki', 'Bukittinggi', '1989-07-03', '12345678', 'S2', 7, 25, 1, 'Jl. Merdeka No. 2', 'aldo@pnp.ac.id', '081234567802', 'aldo.png', 'Aktif'],
            [40, 'CIPTO PRABOWO, S.T, M.T', '0002037410', '197403022008121001', 'Laki-laki', 'Medan', '1974-03-02', '12345678', 'S2', 7, 26, 3, 'Jl. Sudirman No. 3', 'cipto@pnp.ac.id', '081234567803', 'cipto.png', 'Aktif'],
            [46, 'DEDDY PRAYAMA, S.Kom, M.ISD', '0015048105', '198104152006041002', 'Laki-laki', 'Palembang', '1981-04-15', '12345678', 'S2', 7, 26, 4, 'Jl. Ahmad Yani No. 4', 'deddy@pnp.ac.id', '081234567804', 'deddy.png', 'Aktif'],
            [50, 'DEFNI, S.Si, M.Kom', '0007128104', '198112072008122001', 'Perempuan', 'Bandung', '1981-12-07', '12345678', 'S2', 7, 25, 1, 'Jl. Melati No. 5', 'defni@pnp.ac.id', '081234567805', 'DEFNI.png', 'Aktif'],
            [52, 'DENI SATRIA, S.Kom, M.Kom', '0028097803', '197809282008121002', 'Laki-laki', 'Solo', '1978-09-28', '12345678', 'S3', 7, 25, 2, 'Jl. Kenanga No. 6', 'dns1st@gmail.com', '081234567806', '', 'Aktif'],
            [66, 'DWINY MEIDELFI, S.Kom, M.Cs', '0009058601', '198605092014042001', 'Perempuan', 'Jakarta', '1986-05-09', '12345678', 'S2', 7, 27, 3, 'Jl. Mawar No. 7', 'dwinymeidelfi@pnp.ac.id', '081234567807', 'Dwiny.png', 'Aktif'],
            [85, 'ERVAN ASRI, S.Kom, M.Kom', '0001097802', '197809012008121001', 'Laki-laki', 'Padang', '1978-09-01', '12345678', 'S2', 7, 25, 4, 'Jl. Dahlia No. 8', 'ervan@pnp.ac.id', '081234567808', 'ervanasri.png', 'Aktif'],
            [91, 'FAZROL ROZI, M.Sc.', '0021078601', '19860721201012006', 'Laki-laki', 'Bali', '1986-07-21', '12345678', 'S3', 7, 26, 1, 'Jl. Anggrek No. 9', 'fazrol@pnp.ac.id', '081234567809', 'OJIX.png', 'Aktif'],
            [103, 'FITRI NOVA, M.T, S.ST', '1029058502', '198505292014042001', 'Perempuan', 'Medan', '1985-05-29', '12345678', 'S2', 7, 26, 2, 'Jl. Cempaka No. 10', 'fitrinova85@gmail.com', '081234567810', 'Fitri.png', 'Aktif'],
            [109, 'Ir. HANRIYAWAN ADNAN MOODUTO, M.Kom.', '0010056606', '196605101994031003', 'Laki-laki', 'Padang', '1966-05-10', '12345678', 'S2', 7, 26, 3, 'Jl. Sakura No. 11', 'mooduto@pnp.ac.id', '081234567811', 'mooduto.png', 'Aktif'],
            [116, 'HENDRICK, S.T, M.T.,Ph.D', '0002127705', '197712022006041000', 'Laki-laki', 'Bogor', '1977-12-02', '12345678', 'S3', 4, 7, 1, 'Jl. Mangga No. 12', 'hendrickpnp77@gmail.com', '081234567812', '', 'Aktif'],
            [121, 'HIDRA AMNUR, S.E., S.Kom, M.Kom', '0015048209', '198204152012121002', 'Laki-laki', 'Padang', '1982-04-15', '12345678', 'S2', 7, 25, 4, 'Jl. Sukun No. 13', 'hidra@pnp.ac.id', '081234567813', 'hidra.png', 'Aktif'],
            [122, 'HUMAIRA, S.T, M.T', '0019038103', '198103192006042002', 'Perempuan', 'Yogyakarta', '1981-03-19', '12345678', 'S2', 7, 27, 2, 'Jl. Melur No. 14', 'humaira@pnp.ac.id', '081234567814', 'humaira.png', 'Aktif'],
            [127, 'IKHSAN YUSDA PRIMA PUTRA, S.H., LL.M', '0001107505', '197510012006041002', 'Laki-laki', 'Malang', '1975-10-01', '12345678', 'S3', 7, 26, 3, 'Jl. Seruni No. 15', 'ikhsanyusda@pnp.ac.id', '081234567815', 'ikhsnyusda.png', 'Aktif'],
            [132, 'INDRI RAHMAYUNI, S.T, M.T', '0025068301', '198306252008012004', 'Perempuan', 'Lampung', '1983-06-25', '12345678', 'S2', 7, 27, 4, 'Jl. Asoka No. 16', 'indri@pnp.ac.id', '081234567816', 'INDRI.png', 'Aktif'],
            [160, 'MERI AZMI, S.T, M.Cs', '0029068102', '198106292006042001', 'Perempuan', 'Padang', '1981-06-29', '12345678', 'S3', 7, 25, 1, 'Jl. Kamboja No. 17', 'meriazmi@gmail.com', '081234567817', 'meriazmi.png', 'Aktif'],
            [198, 'Ir. Rahmat Hidayat, S.T, M.Sc.IT', '1015047801', '197804152000121002', 'Laki-laki', 'Bengkulu', '1978-04-15', '12345678', 'S2', 7, 27, 2, 'Jl. Wijaya Kusuma No. 18', 'rahmat@pnp.ac.id', '081234567818', 'ramathidayat.png', 'Aktif'],
            [206, 'RASYIDAH, S.Si, M.M.', '0001067407', '197406012006042001', 'Perempuan', 'Padang', '1974-06-01', '12345678', 'S2', 7, 25, 3, 'Jl.Kamboja No. 1', 'rasyidah@pnp.ac.id', '081234567890', 'Rasyidah.png', 'Aktif'],
            [212, 'RIKA IDMAYANTI, S.T, M.Kom', '0022017806', '197801222009122002', 'Perempuan', 'Padang', '1978-01-22', '12345678', 'S2', 7, 27, 1, 'Jl. Kusmawa No. 2', 'rikaidmayanti@pnp.ac.id', '081234567891', 'rika-idmayanti.png', 'Aktif'],
            [220, 'RITA AFYENNI, S.Kom, M.Kom', '0018077099', '197007182008012010', 'Perempuan', 'Bukittinggi', '1970-07-18', '12345678', 'S2', 7, 25, 4, 'Jl. Kiri No. 3', 'ritaafyenni@pnp.ac.id', '081234567892', 'rita.png', 'Aktif'],
            [223, 'RONAL HADI, S.T, M.Kom', '0029017603', '197601292002121001', 'Laki-laki', 'Padang', '1976-01-29', '12345678', 'S2', 7, 26, 2, 'Jl. Melati No. 4', 'ronalhadi@pnp.ac.id', '081234567893', 'ronalhadi.png', 'Aktif'],
            [258, 'TAUFIK GUSMAN, S.S.T, M.Ds', '0010088805', '198808102019031012', 'Laki-laki', 'Payakumbuh', '1988-08-10', '12345678', 'S2', 7, 25, 1, 'Jl. Riyah No. 5', 'taufikgusman@gmail.com', '081234567894', 'Taufiq.png', 'Aktif'],
            [277, 'YANCE SONATHA, S.Kom, M.T', '0029128003', '198012292006042001', 'Perempuan', 'Padang', '1980-12-29', '12345678', 'S2', 7, 25, 1, 'Jl. Raya No. 10', 'sonatha.yance@gmail.com', '081234567890', 'yance-sonatha.png', 'Aktif'],
            [289, 'Dr. Ir. YUHEFIZAR, S.Kom., M.Kom', '0013017604', '197601132006041002', 'Laki-laki', 'Padang', '1976-01-13', '12345678', 'S3', 7, 25, 2, 'Jl. Merdeka No. 5', 'yuhefizar@pnp.ac.id', '081234567890', 'yuhefizar.png', 'Aktif'],
            [292, 'YULHERNIWATI, S.Kom, M.T', '0019077609', '197607192008012017', 'Perempuan', 'Padang', '1976-07-19', '12345678', 'S2', 7, 27, 3, 'Jl. Gunung No. 7', 'yulherniwati@pnp.ac.id', '081234567890', 'yulherniwati.png', 'Aktif'],
            [310, 'TRI LESTARI, S.Pd.,M.Eng.', '0005039205', '199203052019032025', 'Perempuan', 'Padang', '1992-03-05', '12345678', 'S2', 7, 25, 4, 'Jl. Raya No. 15', 'trilestari0503@gmail.com', '081234567890', 'Tari.png', 'Aktif'],
            [311, 'Fanni Sukma, S.ST., M.T', '0006069009', '199006062019032026', 'Perempuan', 'Padang', '1990-06-06', '12345678', 'S2', 7, 27, 1, 'Jl. Merpati No. 9', 'fannisukma@pnp.ac.id', '081234567890', 'Fanny.png', 'Aktif'],
            [312, 'Andre Febrian Kasmar, S.T., M.T.', '0020028804', '198802202019031009', 'Laki-laki', 'Padang', '1988-02-20', '12345678', 'S2', 7, 27, 2, 'Jl. Sejahtera No. 3', 'andrefebrian@pnp.ac.id', '081234567890', '', 'Aktif'],
            [351, 'RONI PUTRA, S.Kom, M.T ', '0022078607', '198607222009121004', 'Laki-laki', 'Padang', '1986-07-22', '12345678', 'S2', 7, 25, 3, 'Jl. Karang No. 4', 'rn.putra@gmail.com', '081234567890', 'roni-putra.png', 'Aktif'],
            [352, 'Ardi Syawaldipa, S.Kom.,M.T.', '0029058909', '19890529 202012 1 003', 'Laki-laki', 'Padang', '1989-05-29', '12345678', 'S2', 7, 26, 4, 'Jl. Merdeka No. 10', 'ardi.syawaldipa@gmail.com', '081234567890', 'ardi-syawaldipa.png', 'Aktif'],
            [353, 'Harfebi Fryonanda, S.Kom., M.Kom', '0310119101', '19911110 202203 1 008', 'Laki-laki', 'Padang', '1991-11-10', '12345678', 'S2', 7, 27, 1, 'Jl. Bunga No. 8', 'harfebi@pnp.ac.id', '081234567890', '', 'Aktif'],
            [354, 'Ideva Gaputra, S.Kom., M.Kom', '0012098808', '198809122022031006', 'Laki-laki', 'Padang', '1988-09-12', '12345678', 'S2', 7, 26, 2, 'Jl. Raya No. 2', 'idevagaputra@pnp.ac.id', '081234567890', 'IDEVA.png', 'Aktif'],
            [355, 'Yulia Jihan Sy, S.Kom., M.Kom', '1017078904', '19890717 202203 2 010', 'Perempuan', 'Padang', '1989-07-17', '12345678', 'S2', 7, 26, 3, 'Jl. Merpati No. 12', 'yulia@pnp.ac.id', '081234567890', 'Yulia.png', 'Aktif'],
            [356, 'Andrew Kurniawan Vadreas, S.Kom., M.T ', '1021028702', '19870221 202203 1 001', 'Laki-laki', 'Padang', '1987-02-21', '12345678', 'S2', 7, 25, 4, 'Jl. Sejahtera No. 5', 'andrew@pnp.ac.id', '081234567890', 'Andrew.png', 'Aktif'],
            [357, 'YORI ADI ATMA, S.Pd., M.Kom', '2010059001', '19900510 202203 1 002', 'Laki-laki', 'Padang', '1990-05-10', '12345678', 'S2', 7, 25, 1, 'Jl. Karang No. 6', 'yori@pnp.ac.id', '081234567890', 'Yori-Adi-Atma.png', 'Aktif'],
            [358, 'Dr. Ulya Ilhami Arsyah, S.Kom., M.Kom', '0130039101', '19910330 202203 1 004', 'Laki-laki', 'Padang', '1991-03-30', '12345678', 'S3', 7, 27, 2, 'Jl. Raya No. 8', 'ulya@pnp.ac.id', '081234567890', 'ulya.png', 'Aktif'],
            [359, 'Hendra Rotama, S.Pd., M.Sn', '0218068801', '19880618 202203 1 003', 'Laki-laki', 'Padang', '1988-06-18', '12345678', 'S2', 7, 26, 3, 'Jl. Merdeka No. 9', 'hendrarotama@pnp.ac.id', '081234567890', 'Hendra.png', 'Aktif'],
            [360, 'Sumema, S.Ds., M.Ds', '0008069103', '19910608 202203 2 006', 'Perempuan', 'Padang', '1991-06-08', '12345678', 'S2', 7, 26, 4, 'Jl. Sejahtera No. 10', 'sumema@pnp.ac.id', '081234567890', 'Sumema.png', 'Aktif'],
            [361, 'Raemon Syaljumairi, S.Kom., M.Kom', '0017078407', '19840717 201012 1 002', 'Laki-laki', 'Padang', '1984-07-17', '12345678', 'S2', 7, 26, 1, 'Jl. Bunga No. 6', 'raemon_syaljumairi@pnp.ac.id', '081234567890', 'raemon.png', 'Aktif'],
            [362, 'Mutia Rahmi Dewi, S.Kom., M.Kom', '0004099601', '19960904 202203 2 018', 'Perempuan', 'Padang', '1996-09-04', '12345678', 'S2', 7, 27, 2, 'Jl. Raya No. 4', 'mutiarahmi@pnp.ac.id', '081234567890', 'Mutia-Rahmi-Dewi.png', 'Aktif'],
            [363, 'Novi, S.Kom., M.T', '0001118611', '19861101 202203 2 003', 'Perempuan', 'Padang', '1986-11-01', '12345678', 'S2', 7, 26, 3, 'Jl. Merpati No. 6', 'novi@pnp.ac.id', '081234567890', '', 'Aktif'],
            [364, 'Rahmi Putri Kurnia, S.Kom., M.Kom', '0027089303', '19930827 202203 2 012', 'Perempuan', 'Padang', '1993-08-27', '12345678', 'S2', 7, 26, 4, 'Jl. Sejahtera No. 10', 'rahmiputri@pnp.ac.id', '081234567890', '', 'Aktif']

        ];

            foreach($dataDosen as $data){
                DB::table('dosen')->insert([
                    'id_dosen'=>$data[0],
                    'nidn'=>$data[2],
                    'nama'=>$data[1],
                    'nip'=>$data[3],
                    'gender'=>$data[4],
                    'tempt_lahir'=>$data[5],
                    'tgl_lahir'=>$data[6],
                    'password'=>$data[7],
                    'pendidikan'=>$data[8],
                    'jurusan_id'=>$data[9],
                    'prodi_id'=>$data[10],
                    'golongan_id'=>$data[11],
                    'alamat'=>$data[12],
                    'email'=>$data[13],
                    'no_hp'=>$data[14],
                    'image'=>$data[15],
                    'status'=>$data[15],
                ]);
            }
        }
    }
