<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Medicine;

class MedicineCatalogSeeder extends Seeder
{
    public function run(): void
    {
        // === DAFTAR PRODUK PER SUBKATEGORI ===
        // Format: [Nama, Resep(bool), Harga, Deskripsi, Image Path]
        // Note: Path di sini masih 'medicines/namafile', nanti akan ditambahkan 'storage/' otomatis di bawah.
        $catalog = [

            // Batuk, Pilek & Flu
            'batuk-flu' => [
                [
                    'Paracetamol 500 mg', 
                    false, 
                    8000, 
                    'Paracetamol 500 mg adalah obat pereda nyeri dan penurun demam yang komposisi utamanya adalah Paracetamol 500 mg. Zat aktif ini bekerja dengan cara menghambat pembentukan prostaglandin di otak, yaitu zat kimia yang berperan dalam memicu rasa sakit dan demam.', 
                    'medicines/3kqkk8ASOEfj4n7pVH6gydSzlxWAGb7Pb0oxy1po.webp'
                ],
                [
                    'Dextromethorphan Sirup 60 ml', 
                    false, 
                    15000, 
                    'DEXTROSIN SIRUP adalah obat yang memiliki kandungan Dextromethorphan HBr, Phenylpropanolamine HCl, Diphenhydramine HCl, Glyceryl guaiacolate. Obat ini digunakan untuk meredakan batuk yang disertai hidung tersumbat, pilek dan gejala alergi lainnya.', 
                    'medicines/Tn9mWFQSxfALnKtukjjgRed8tpSefXHZQMovyYu4.webp'
                ],
                [
                    'Guaifenesin Tablet 200 mg', 
                    false, 
                    12000, 
                    'Guaifenesin adalah obat pengencer dahak golongan ekspektoran. Guaifenesin bermanfaat meredakan batuk berdahak saat flu, batuk pilek, atau alergi. Guaifenesin bekerja dengan cara membasahi saluran pernapasan sehingga dahak kental menjadi lebih encer.', 
                    'medicines/yEI5eId0U3p2GRTFIHzNdsKakWaSOKCmG7fv8wr0.webp'
                ],
                [
                    'Ambroxol 30 mg', 
                    false, 
                    12000, 
                    'Ambroxol adalah obat untuk mengencerkan dahak. Obat ini dapat digunakan pada berbagai kondisi dengan batuk berdahak, termasuk batuk pilek (common cold), bronkitis, emfisema, atau bronkiektasis.', 
                    'medicines/npOboyCP8PUjHxBfmHVwH1TU7HR6t5Vmb1cbqo4b.jpg'
                ],
                [
                    'Pseudoephedrine 60 mg', 
                    true, 
                    18000, 
                    'Indikasi Pseudoephedrine adalah untuk meringankan gejala kongesti sinus dan nasal. Pseudoephedrine sediaan tablet konvensional dapat digunakan dalam dosis 60 mg setiap 4–6 jam, maksimal 240 mg/hari.', 
                    'medicines/YYtQehkt5b9o62SVWjRSEZwKmtVEywebaczKIIac.jpg'
                ],
                [
                    'Oseltamivir 75 mg', 
                    true, 
                    75000, 
                    'Oseltamivir 75 mg 10 Kapsul. OSELTAMIVIR berguna Untuk mengatasi infeksi virus influenza tipe A (misalnya flu burung) atau B. Pembelian obat ini memerlukan edukasi terkait penggunaan.', 
                    'medicines/TAnVQAuzPDRQzBFDsIkOTHJiSu3XinSAKV6mJKXS.jpg'
                ],
                [
                    'Vitamin C 500 mg', 
                    false, 
                    14000, 
                    'VITAMIN C merupakan suplemen dengan kandungan vitamin C. Vitamin ini berpengaruh dalam sintesis lipid dan protein, metabolisme karbohidrat, penyerapan zat besi, dan respirasi sel.', 
                    'medicines/o09Djgki98yrMZZtzzo1cG5Xc47XHvEZ1U8GYjqa.jpg'
                ],
            ],

            'balsem-minyak-esensial' => [
                [
                    'Minyak Kayu Putih 60 ml', 
                    false, 
                    22000, 
                    'Minyak Kayu Putih ukuran 60 ml adalah minyak herbal alami dari ekstrak daun dan ranting tanaman kayu putih, yang digunakan untuk menghangatkan tubuh, meredakan masuk angin, perut kembung, gatal akibat gigitan serangga, serta sebagai aromaterapi.', 
                    'medicines/CYREKgoPmr7QCQByYxyFL0Ls78OcqjDdszoLKnsx.jpg'
                ],
                [
                    'Minyak Telon 60 ml', 
                    false, 
                    26000, 
                    'KONICARE MINYAK TELON merupakan minyak yang mengandung minyak adas, minyak kayu putih, dan minyak kelapa. Minyak telon ini digunakan untuk membantu meredakan perut kembung dan memberikan rasa hangat pada tubuh bayi.', 
                    'medicines/SjKqrbnYJap2Bd2gVXlHsPsP7FJxzaifIMbgv79e.jpg'
                ],
                [
                    'Balsem Hangat 20 g', 
                    false, 
                    18000, 
                    'BALSEM OTOT GELIGA 20 G merupakan obat gosok yang digunakan untuk membantu meredakan nyeri otot dan sendi seperti nyeri akibat pukulan/memar, keseleo dan nyeri otot punggung. Baik juga digunakan sebagai balsam pemanasan bagi olahragawan.', 
                    'medicines/BtvLH0EGEiLD9L3DbUqrKFPPRajUb9mnDugAuK8n.jpg'
                ],
                [
                    'Aromatherapy Roll On', 
                    false, 
                    25000, 
                    'SAFE CARE AROMATHERAPY adalah minyak angin yang digunakan untuk meredakan perut kembung, pusing, masuk angin dan mabuk perjalanan. Produk ini mengandung olive oil sebagai anti iritasi bila dipakai berulang.', 
                    'medicines/nerNqNxCjTnlAnVXvdZDGAc7iXDGkRA0luf6Q2na.webp'
                ],
                [
                    'Minyak Angin Aromatik', 
                    false, 
                    17000, 
                    'Minyak Angin Aromatik adalah minyak gosok modern dalam kemasan roll-on yang memanfaatkan minyak esensial alami untuk memberikan sensasi hangat dan aroma menyegarkan, serta membantu meredakan sakit kepala, masuk angin, mual, pegal, dan gatal.', 
                    'medicines/ZfaH2epZQvBJBYieJQC9DfV4vc4SnlKk9hbQhZYl.webp'
                ],
            ],

            'perawatan-herbal' => [
                [
                    'Echinacea Kapsul 500 mg', 
                    false, 
                    38000, 
                    'ECHINACEA MPL 500 MG adalah sediaan herbal yang diformulasikan secara khusus untuk membantu memelihara daya tahan tubuh. Produk ini mengandung ekstrak tunggal Echinacea Purpurea Herba Ekstrak dalam setiap kapsulnya.', 
                    'medicines/YmolMk7Ayzf0z2zgqIgUDaGeDqC1WkhipIGYROvl.webp'
                ],
                [
                    'Ekstrak Jahe Merah', 
                    false, 
                    32000, 
                    'Ekstrak Jahe Merah (Zingiber officinale var. rubrum) adalah konsentrat dari rimpang jahe merah yang kaya akan senyawa aktif seperti gingerol, shogaol, vitamin C, dan minyak atsiri. Memiliki sifat antiinflamasi dan antioksidan.', 
                    'medicines/DSlPECq3dVjyxpBSZqOSTg7f7mU8PfSrMm6O42vq.jpg'
                ],
                [
                    'Madu Herbal 250 g', 
                    false, 
                    45000, 
                    'Madu-herbal-250-g mengacu pada madu yang dicampur dengan bahan-bahan herbal dalam kemasan 250 gram untuk memberikan manfaat kesehatan tambahan selain manfaat madu murni, seperti meningkatkan daya tahan tubuh.', 
                    'medicines/EYs1jrjt7oMd4jgSrrbLWAYd4z2C6xo6AHdgU4ha.jpg'
                ],
                [
                    'Propolis Tetes', 
                    false, 
                    52000, 
                    'Propolis Diamond Liquid membantu memelihara daya tahan tubuh. Propolis merupakan produk alami yg dihasilkan oleh lebah yang berfungsi sebagai zat kekebalan sarang dan tubuh lebah dari bakteri, virus, dan jamur.', 
                    'medicines/6jgnahRcRCT7FYw57OPWOYUz7qYBrtauigAUi17g.webp'
                ],
                [
                    'Kunyit Asam Sirup', 
                    false, 
                    28000, 
                    'Sirup Kunyit Asam adalah minuman tradisional Indonesia berupa sirup konsentrat dari bahan alami kunyit dan asam jawa, yang memiliki cita rasa manis asam segar. Bermanfaat untuk meredakan nyeri haid dan meningkatkan daya tahan tubuh.', 
                    'medicines/esNxFaOyBNucfgcw3YjPBBa4gVm6brLXFT7lKxgz.webp'
                ],
            ],

            'nasal-spray-dekongestan' => [
                [
                    'Saline Nasal Spray', 
                    false, 
                    30000, 
                    'Saline nasal spray adalah semprotan hidung berisi larutan garam dan air (air garam fisiologis) yang berfungsi untuk melembapkan saluran hidung kering, membantu membersihkan lendir yang kental, dan meredakan iritasi.', 
                    'medicines/s4frQXtcDl8WINr9hkBg3HcQ7HDeiGMlePKmB9o9.png'
                ],
                [
                    'Oxymetazoline 0.05% Spray', 
                    false, 
                    35000, 
                    'Oxymetazoline adalah obat yang termasuk golongan dekongestan hidung. Obat ini bekerja dengan cara menyempitkan pembuluh darah di dalam rongga hidung, sehingga dapat mengurangi pembengkakan dan melegakan hidung tersumbat.', 
                    'medicines/TDh0fyXNcZpJ4IbJvdqC7oquwWgWbRaZfgzFOFgt.png'
                ],
                [
                    'Xylometazoline 0.1% Spray', 
                    false, 
                    35000, 
                    'Xylometazoline adalah obat tetes hidung yang berguna untuk mengatasi hidung tersumbat. Obat ini boleh digunakan oleh orang dewasa dan anak usia 6 tahun atau lebih.', 
                    'medicines/Fs0YGHoAB121Dbk4033jfAMkiL3DbyfHeQd9hXiQ.webp'
                ],
                [
                    'Fluticasone Nasal Spray', 
                    true, 
                    90000, 
                    'Fluticasone merupakan jenis obat antiradang golongan kortikosteroid. Obat ini bekerja dengan meredakan pembengkakan jaringan yang membuat hidung tersumbat dan menghambat pelepasan zat peradangan.', 
                    'medicines/KkhGDKvFVyNIney24VCRApNYO32O8jIaFIRBiYcL.webp'
                ],
            ],

            'untuk-bayi-anak' => [
                [
                    'Paracetamol Drops Anak', 
                    false, 
                    22000, 
                    'PARACETAMOL DROPS adalah obat yang mengandung Paracetamol (Acetaminophen) sebagai zat aktifnya yang digunakan sebagai analgesik (pereda nyeri) dan antipiretik (penurun demam) untuk bayi dan anak.', 
                    'medicines/bSF9LoMyOLMmVxDr9rdJqj0f05fnXddzuSVsLbHi.webp'
                ],
                [
                    'Sirup Batuk Anak 60 ml', 
                    false, 
                    24000, 
                    'FLUTOP C SIRUP 60 ML obat batuk hitam dengan rasa yang enak dan disukai anak. Obat ini mengandung Paracetamol, Guaifenesin, Dextromethorphan HBr, Phenylpropanolamine HCl, dan Chlorpheniramine maleate.', 
                    'medicines/5sbE0y5tZPgApo23e7mkxfw5Klc6WcSqxhsU9H0D.jpg'
                ],
                [
                    'Saline Tetes Hidung Bayi', 
                    false, 
                    20000, 
                    'Larutan saline (air garam steril) aman dan efektif untuk bayi, terutama untuk membersihkan hidung tersumbat dengan mengencerkan lendir sehingga lebih mudah dikeluarkan.', 
                    'medicines/8GbYjDSwTJ278aYmYSVE4irP7X8SxcHQs2Zgrz92.jpg'
                ],
                [
                    'Minyak Telon Plus 60 ml', 
                    false, 
                    27000, 
                    'Minyak telon plus 60 ml adalah minyak perawatan bayi yang berfungsi menghangatkan tubuh, meredakan perut kembung dan masuk angin, serta melindungi bayi dari gigitan nyamuk dan serangga.', 
                    'medicines/DeeWPXtg13vokII7k8uh0LkZ32cAIXCylN0xw8wD.jpg'
                ],
                [
                    'Oral Rehydration Salt (ORS) Anak', 
                    false, 
                    9000, 
                    'Garam rehidrasi oral (ORS) adalah campuran glukosa dan elektrolit, rekomendasi WHO. Larutan ORS digunakan untuk mencegah dan mengobati dehidrasi klinis pada anak-anak akibat diare akut.', 
                    'medicines/r5JL4gRXejeAAMHxxjE9YACk0TiMlFBIiqbsEbdP.jpg'
                ],
            ],

            // Demam & Nyeri
            'pereda-demam-nyeri' => [
                [
                    'Ibuprofen 200 mg', 
                    false, 
                    15000,
                    'IBUPROFEN 200 MG merupakan obat golongan anti inflamasi non steroid yang mempunyai efek anti inflamasi, analgesik dan antipiretik. Obat ini digunakan untuk nyeri ringan sampai sedang seperti sakit gigi, nyeri pasca bedah, dan sakit kepala.',
                    'medicines/5PDJKuli2r6pF0eyzT7eW5sbG5vMnO33Hot27LzV.jpg'
                ],
                [
                    'Asam Mefenamat 500 mg', 
                    true, 
                    20000,
                    'Tablet Asam Mefenamat 500 mg digunakan untuk menangani nyeri ringan sampai sedang, seperti sakit kepala, sakit gigi, nyeri otot tulang, nyeri karena luka, nyeri setelah operasi, dan dismenore.',
                    'medicines/gKrHuMEXUYTYi8WhRZJSU4cnIrXimHCWHhs30nPS.jpg'
                ],
                [
                    'Naproxen 250 mg', 
                    true, 
                    24000,
                    'Naproksen adalah obat antiinflamasi nonsteroid (NSAID) yang digunakan untuk meredakan gejala artritis (misalnya, osteoartritis, artritis reumatoid) seperti peradangan, pembengkakan, kekakuan, dan nyeri sendi.',
                    'medicines/OTSkpR5vHoUPpBAR4bE0hhx74lCxKwUEXmcVUVRi.webp'
                ],
                [
                    'Diclofenac 50 mg', 
                    true, 
                    22000,
                    'NATRIUM DIKLOFENAK 50 MG TABLET adalah obat anti inflamasi non steroid yang memiliki efek analgetik, anti inflamasi, dan antipiretik dengan mekanisme kerja secara reversibel menghambat siklooksigenase-1 dan 2.',
                    'medicines/C2lS8eGtfqo8C1qhJMTJu9EOlAgIdUNcqKH3UOK3.jpg'
                ],
                [
                    'Paracetamol Effervescent 500 mg', 
                    false, 
                    17000,
                    'Paracetamol 500 mg adalah obat pereda nyeri dan penurun demam yang komposisi utamanya adalah Paracetamol 500 mg. Zat aktif ini bekerja dengan cara menghambat pembentukan prostaglandin di otak.',
                    'medicines/D2tCyY1hn7ZlFq2GxGBK6CySFB6WcuCUNCbowPaG.webp'
                ],
                [
                    'Ketoprofen Gel 30 g', 
                    false, 
                    42000,
                    'Kaltrofen Gel 30 g yang mengandung Ketoprofen 2.5% adalah obat antiinflamasi nonsteroid (OAINS) untuk penggunaan luar yang bermanfaat meredakan nyeri, bengkak, dan peradangan pada kondisi seperti nyeri otot, keseleo, dan memar.',
                    'medicines/8UVBKhobXgZr1zbAWW3lXBmXOzJSbvtPrMw0IfLH.webp'
                ],
            ],
            
            'terapi-panas-dingin' => [
                [
                    'Plester Panas', 
                    false, 
                    18000,
                    'Pada umumnya, plester kompres demam bekerja dengan menyerap panas di kulit sehingga suhu pada permukaan kulit menurun. Hal ini dapat membantu meredakan rasa tidak nyaman, sehingga anak bisa beristirahat dengan lebih nyaman.',
                    'medicines/dS6KlVSEeoeyvfhr0Io8y9EGdtfv8rowM1WQiTJT.jpg'
                ],
                [
                    'Bantal Panas Reusable', 
                    false, 
                    60000,
                    'Bantal panas reusable (dapat digunakan kembali) adalah alat terapi yang memberikan kehangatan atau dingin untuk meredakan nyeri, kram, dan kekakuan otot dengan cara yang aman dan bisa digunakan berkali-kali.',
                    'medicines/zvYnlTi1Zre5T1F32JVBfBQEENF2elnFQtv6qYrj.jpg'
                ],
                [
                    'Kompres Dingin Gel Pack', 
                    false, 
                    35000,
                    'Kompres dingin gel pack adalah kantong berisi gel khusus yang dapat didinginkan di dalam freezer untuk digunakan sebagai kompres terapi. Produk ini berfungsi untuk meredakan nyeri, bengkak, memar, dan peradangan.',
                    'medicines/5Zfq3QUHQtuHEr2OxvqxgFyT1Kzw5CDJVSyra6fr.jpg'
                ],
                [
                    'Spray Pendingin Otot', 
                    false, 
                    28000,
                    'Spray pendingin otot adalah semprotan yang memberikan sensasi dingin pada otot untuk meredakan nyeri, peradangan, dan ketegangan akibat cedera olahraga, kram, atau keseleo.',
                    'medicines/UhXUVkAp6QBZcRc5Alth83tdn2ckXdsYnID9xKhe.jpg'
                ],
            ],

            // Masalah Pencernaan
            'asam-lambung-gerd' => [
                [
                    'Antasida Tablet Kunyah', 
                    false, 
                    12000,
                    'ANTASIDA DOEN merupakan obat sakit maag dengan kandungan Alumunium Hydroxide dan Magnesium Hydroxide. Bekerja menetralkan asam lambung dan menginaktifkan pepsin untuk mengurangi nyeri ulu hati dan kembung.',
                    'medicines/Bvt3NEBTukfO1SLrX0zo448g7otFB2JelBscnbtK.jpg'
                ],
                [
                    'Omeprazole 20 mg', 
                    false, 
                    25000,
                    'OMEPRAZOLE adalah obat golongan Proton Pump Inhibitor (PPI) yang berfungsi untuk mengurangi produksi asam lambung. Obat ini bekerja dengan menghambat pompa proton di sel-sel lambung.',
                    'medicines/pf9RqSbUETcY8q6TSGoJj9ymVP6hFeKpOiz10VUV.jpg'
                ],
                [
                    'Esomeprazole 20 mg', 
                    true, 
                    42000,
                    'Esomeprazole 20 mg Tablet bekerja dengan cara menurunkan produksi asam berlebih di dalam lambung. Dengan begitu, keluhan akibat peningkatan asam lambung, seperti nyeri ulu hati, mual, dan kembung, bisa mereda.',
                    'medicines/HPZfxnaCGyaES1XJf8zVQWFlDTuBvZ0vUM43QgUO.webp'
                ],
                [
                    'Sucralfate Sirup 100 ml', 
                    true, 
                    48000,
                    'SUCRALFATE DEXA 500MG/5ML SUSP 100ML merupakan obat yang digunakan untuk mengatasi peradangan pada lambung (gastritis) dan mencegah perdarahan saluran cerna dengan membentuk lapisan pelindung pada tukak.',
                    'medicines/O5GaqKh3ssRWgi4eeBl3uTr9xMrVl0QYkBzbdgxL.jpg'
                ],
                [
                    'Domperidone 10 mg', 
                    true, 
                    22000,
                    'DOMPERIDONE 10 MG 10 TABLET adalah obat antiemetik dan prokinetik. Domperidone bekerja dengan meningkatkan kontraksi otot polos lambung dan usus bagian atas, mempercepat pengosongan lambung, dan meningkatkan tonus sfingter esofagus.',
                    'medicines/KnKuNJbh2iepA7BCKfieoZpgzyHNytPa303BkICa.jpg'
                ],
            ],
            'mual-muntah' => [
                [
                    'Ondansetron 4 mg', 
                    true, 
                    52000,
                    'ONDANSETRON 4 MG TABLET merupakan obat antiemetik yang digunakan untuk meredakan mual dan muntah akibat kemoterapi serta pencegahan mual dan muntah paska operasi. Ondansetron bekerja sebagai antagonis reseptor 5-HT3.',
                    'medicines/CKWtUW4L6r4jYyFu68BovSfBOW4a85tpyKB2ntyO.jpg'
                ],
                [
                    'Metoclopramide 10 mg', 
                    true, 
                    18000,
                    'Metoclopramide 10 mg Tablet bermanfaat untuk meredakan mual dan muntah akibat penyakit asam lambung atau prosedur medis. Bekerja dengan cara meningkatkan gerakan lambung dalam mentransfer makanan ke usus.',
                    'medicines/Ib3OcqgNv0VF5FrGsILat3wT8Dqyq1lERvzsA6hd.png'
                ],
                [
                    'Oralit (ORS) 1 sachet', 
                    false, 
                    7000,
                    'ORALIT adalah larutan rehidrasi oral (LRO) dalam bentuk serbuk. Produk ini merupakan pertolongan pertama untuk mencegah dan mengobati dehidrasi (kekurangan cairan) ringan hingga sedang akibat diare atau muntah.',
                    'medicines/ggtJUDOIuqhxdaryOMP8YDV1AKl7peypuNz4Kai6.jpg'
                ],
                [
                    'Jahe Instan Anti Mual', 
                    false, 
                    15000,
                    'Jahe instan adalah minuman herbal praktis dari bubuk jahe yang dapat membantu meredakan mual dan muntah, karena kandungan zat aktifnya seperti gingerol yang bersifat antiemetik (anti mual).',
                    'medicines/L0WdiYEORmwAVvt8jr6Q6H1m8tAcez74wnuoxh72.jpg'
                ],
            ],
            'diare' => [
                [
                    'Loperamide 2 mg', 
                    false, 
                    15000,
                    'Loperamide adalah obat untuk meredakan diare. Obat ini juga bisa digunakan untuk mengurangi jumlah feses yang keluar pada pasien dengan ileostomi. Loperamide bekerja dengan cara memperlambat gerakan usus.',
                    'medicines/MYGsrvcKEvab0gsg2DRAlZkWkb24BARtpJKNUrha.png'
                ],
                [
                    'Attapulgite 650 mg', 
                    false, 
                    12000,
                    'Attapulgite adalah obat untuk meredakan diare. Attapulgite bekerja dengan cara menyerap bakteri atau racun penyebab diare, lalu membuangnya bersama feses.',
                    'medicines/owTncQajKqM5IMdodS8fL7DllJw28Psl2sMMFjh7.jpg'
                ],
                [
                    'Probiotik Kapsul', 
                    false, 
                    38000,
                    'Probiotik adalah suplemen untuk membantu melindungi dan memelihara kesehatan sistem pencernaan, terutama lambung dan usus. Probiotik sering disebut sebagai bakteri "baik".',
                    'medicines/GJq5wUVNQSmnGTYfALUxgyv0Jn2AWzgqCeq0oJcA.jpg'
                ],
                [
                    'Zinc 20 mg', 
                    false, 
                    18000,
                    'Zinc 20 mg 10 Tablet adalah suplemen mineral dalam bentuk tablet yang digunakan sebagai terapi pelengkap untuk mengatasi diare akut pada anak-anak. Setiap tablet mengandung Zinc sulfate yang setara dengan Zinc elemental 20 mg.',
                    'medicines/MCx28I34qDtyDcCx4gcI9WtsandJ48xI1MNoympW.jpg'
                ],
                [
                    'Larutan Rehidrasi 200 ml', 
                    false, 
                    12000,
                    'RENALYTE adalah minuman isotonik atau larutan elektrolit yang di gunakan untuk menanggulangi dehidrasi ringan sampai sedang pada bayi dan anak-anak akibat diare.',
                    'medicines/VNjP1AQVophn8mT8M1JLbM0GLHcIz4hMZJDWMH1k.webp'
                ],
            ],
            'infeksi-cacing' => [
                [
                    'Albendazole 400 mg', 
                    false, 
                    18000,
                    'ALBENDAZOLE (al BEN da zole) mengobati infeksi yang disebabkan oleh parasit, seperti cacing pita. Ia bekerja dengan membunuh parasit.',
                    'medicines/PlE6jVnubd9pNeFtFgqIrIvh1itJQ0MEMD1tWTLJ.png'
                ],
                [
                    'Mebendazole 500 mg', 
                    false, 
                    17000,
                    'Mebendazole mengandung bahan aktif Mebendazole, yang memiliki sifat anthelmintik, mencegah perkembangan cacing di usus. Obat ini diformulasikan dalam bentuk tablet.',
                    'medicines/HESk8UYCBLOQPh9DpGpUAjB8s1HbvhB6lqM8JiCs.webp'
                ],
                [
                    'Pyrantel Pamoate Sirup 15 ml', 
                    false, 
                    16000,
                    'Pyrantel Pamoate adalah obat yang digunakan untuk mencegah perkembangan cacing di dalam tubuh. Ini merupakan obat bebas yang masuk golongan anthelmintics.',
                    'medicines/Ls5PDbP1CxofTwNajX5JAccWXDSATcSArcdTG0MA.webp'
                ],
            ],
            'sembelit-wasir' => [
                [
                    'Bisacodyl 5 mg', 
                    false, 
                    16000,
                    'Bisacodyl adalah stimulan laksatif yang bekerja dengan cara merangsang saraf pada dinding usus besar. Ini menyebabkan otot-otot usus berkontraksi lebih sering, yang mempercepat pergerakan feses melalui usus.',
                    'medicines/a2iJJmSGHJ1nzQLH9wOkuILW89anAITC03IZgUfL.webp'
                ],
                [
                    'Laktulosa Sirup 100 ml', 
                    false, 
                    42000,
                    'Laktulosa adalah obat untuk mengatasi sembelit atau sulit buang air besar. Obat ini juga dapat digunakan untuk menangani dan mencegah ensefalopati hepatik.',
                    'medicines/slOtTDWNaTW01HttMyDb8R6RwE8Is5IkyiBxQ7hM.webp'
                ],
                [
                    'Psyllium Husk 100 g', 
                    false, 
                    52000,
                    'Psyllium husk 100g adalah serbuk serat alami dari tanaman Plantago ovata yang digunakan untuk kesehatan pencernaan dan manajemen berat badan. Kaya serat larut dan tidak larut, efektif mengatasi sembelit dan diare.',
                    'medicines/KYkMP4DaqCg5kY8NBKU9SrasgUhPnZdIy70zEBSW.jpg'
                ],
                [
                    'Salep Wasir 15 g', 
                    false, 
                    38000,
                    'BORRAGINOL-S SALEP adalah obat topikal dengan formula multi-aksi yang digunakan untuk meredakan gejala wasir (hemoroid) secara komprehensif, mulai dari peradangan, pembengkakan, nyeri, hingga gatal.',
                    'medicines/OzxCnhAyLlgtke004LpdAnc2F2UYmGvoJhgksZ6T.jpg'
                ],
            ],

            // Alergi
            'obat-alergi' => [
                [
                    'Cetirizine 10 mg', 
                    false, 
                    16000,
                    'Cetirizine adalah obat golongan antihistamin yang diindikasikan untuk meredakan berbagai gejala yang timbul akibat reaksi alergi, seperti rinitis alergi musiman dan tahunan, konjungtivitis alergi, serta urtikaria kronis.',
                    'medicines/MPnTl3rQFlKR7yDSjhjmmUNG1bEw1JsIMADIRBpG.jpg'
                ],
                [
                    'Loratadine 10 mg', 
                    false, 
                    16000,
                    'Loratadine 10 mg bermanfaat untuk mengatasi gejala alergi, seperti bersin-bersin, pilek, hidung tersumbat, dan ruam kulit yang terasa gatal. Bekerja dengan menghambat histamin.',
                    'medicines/kxRWfHOpCP6qsm1XJqWqhg2jCD2kD3Hpfhcs3UCR.jpg'
                ],
                [
                    'Fexofenadine 120 mg', 
                    false, 
                    26000,
                    'Fexofenadine HCl yang terkandung dalam Telfast® 120 mg merupakan antihistamin (anti-alergi) generasi ketiga yang bekerja spesifik pada reseptor H1 untuk meredakan gejala rinitis alergi tanpa menyebabkan kantuk.',
                    'medicines/poEyNLLJDiH5MFw6hJ84MKlP9ObnwyYdmQc5j12c.webp'
                ],
                [
                    'Prednisone 5 mg', 
                    true, 
                    14000,
                    'Prednison Tablet bermanfaat membantu meredakan peradangan pada beberapa kondisi, seperti alergi, penyakit autoimun, radang sendi, atau dermatitis kontak. Prednison merupakan obat golongan kortikosteroid.',
                    'medicines/24cx46QOnzZuLKEg6nOpVGv0Cvj8NFTsy0KqXwsN.png'
                ],
                [
                    'Mometasone Nasal Spray', 
                    true, 
                    95000,
                    'Semprotan hidung mometason termasuk dalam golongan obat yang disebut kortikosteroid. Obat ini bekerja dengan menghambat pelepasan zat alami tertentu yang menyebabkan gejala alergi.',
                    'medicines/0VPT4XqkCicXDcsB8uKHoCXKZuNHwivNEBPBPTGH.webp'
                ],
            ],
            'pereda-gatal' => [
                [
                    'Caladine Lotion', 
                    false, 
                    24000,
                    'Caladine Lotion adalah lotion anti gatal yang membantu meredakan rasa gatal akibat biang keringat, udara panas, gigitan serangga, serta alergi. Mengandung calamine, zinc oxide, dan diphenhydramine HCl.',
                    'medicines/AXBv22HfFWWlQxcINSX4oS8HKqVPxO9p4FCI8VKI.jpg'
                ],
                [
                    'Hydrocortisone 1% Krim 10 g', 
                    false, 
                    18000,
                    'Hydrocortisone adalah obat yang digunakan untuk meredakan peradangan, mengurangi reaksi sistem kekebalan tubuh yang berlebihan, dan mengatasi kekurangan hormon kortisol. Termasuk golongan kortikosteroid.',
                    'medicines/eDgjLPj9ETWks16MfCafxiBMFeIfvodhc1OJIiEH.webp'
                ],
                [
                    'Sagalon 5% Krim 10 g', 
                    false, 
                    17000,
                    'Sagalon 5% Krim 10 G merupakan obat yang digunakan secara topikal untuk pengobatan jangka pendek (8 hari) pada pasien yang menderita pruritus sedang sampai berat pada ekzema. Mengandung Doxepin HCl 5% (antihistamin).',
                    'medicines/FtqFrUHMDQ1nNMXCfqWGawZGbLnfMVeACoet1jhJ.png'
                ],
                [
                    'Gel Lidokain 2% 10 g', 
                    false, 
                    23000,
                    'Lidokain 5% Gel mengandung 50 mg Lidocaine HCI per gram dalam pembawa asam ringan. Digunakan untuk anestesi lokal pada kulit.',
                    'medicines/jx8vX961vagO26eY0TsD063Tj3HbbHIWPot7VQgW.jpg'
                ],
            ],

            // Masalah Mata
            'gatal-kering-merah' => [
                [
                    'Tetes Mata Lubrikan (Artificial Tears)', 
                    false, 
                    24000,
                    'Tetes mata lubrikan, atau air mata buatan, adalah larutan tetes mata yang digunakan untuk melumasi, melembapkan, dan meredakan ketidaknyamanan akibat mata kering. Mengandung bahan seperti polietilen glikol.',
                    'medicines/MgpU8LjBXHqLjQ933N4BWNokxrAr9lMpODyLhtbQ.jpg'
                ],
                [
                    'Tetes Mata Dekongestan', 
                    false, 
                    22000,
                    'Dekongestan adalah obat-obatan untuk mengatasi gejala hidung tersumbat, namun golongan obat ini juga dapat digunakan untuk meredakan mata merah akibat iritasi ringan.',
                    'medicines/HcGCTzSngVc4xn7ZBehIL8PcbXlKe6aV0T4IzP7B.webp'
                ],
                [
                    'Olopatadine 0.1% Eye Drops', 
                    true, 
                    72000,
                    'Lergio adalah obat tetes mata berbahan aktif olopatadine. Lergio bermanfaat untuk mengatasi gejala alergi pada mata, seperti mata merah, gatal, panas, dan berair, serta belekan.',
                    'medicines/dTXMQcuxCat4IG3euiePPxrt725k3E79ToEJ3tvx.jpg'
                ],
                [
                    'Chloramphenicol Eye Drops', 
                    true, 
                    28000,
                    'CENDO FENICOL 0.5% EYE DROPS 5 ML adalah sediaan antibiotik topikal dalam bentuk tetes mata, yang digunakan untuk mengobati infeksi bakteri pada permukaan mata.',
                    'medicines/NtRKAnTdJg4p3u9XclH36APAfME7t39XPuIUJnYg.webp'
                ],
            ],
            'lainnya' => [
                [
                    'Salep Mata Vitamin A', 
                    false, 
                    21000,
                    'Obat tetes mata berbentuk gel yang mengandung vitamin A (retinol palmitat), digunakan untuk membantu mengatasi mata kering, iritasi, atau kondisi kekurangan air mata akibat berbagai sebab.',
                    'medicines/psUN0t5Ie5uhWnnEI3QtHwI5uX3C8esbGwWMBRco.jpg'
                ],
                [
                    'Kompres Mata Hangat', 
                    false, 
                    25000,
                    'Kompres mata hangat adalah metode perawatan di rumah dengan menempelkan kain bersih yang dibasahi air hangat ke mata tertutup untuk meredakan berbagai kondisi mata seperti bintitan, mata kering, dan mata merah.',
                    'medicines/YslVRqmsU0srZknR3CzJ4GUMEVKKqwAteptxRLYx.jpg'
                ],
            ],

            // Masalah THT
            'sariawan-herpes' => [
                [
                    'Gel Mulut Benzocaine', 
                    false, 
                    25000,
                    'BENZOCAINE meredakan nyeri ringan dan iritasi di mulut dan tenggorokan. Obat ini bekerja dengan membuat area yang terdampak mati rasa (anestesi lokal).',
                    'medicines/cidWXFa7PP1juH3KIzXwTdzTjaugkqoS1mvQMq3Q.jpg'
                ],
                [
                    'Acyclovir 200 mg', 
                    true, 
                    30000,
                    'Acyclovir merupakan salah satu obat antivirus. Obat ini digunakan terutama untuk pengobatan infeksi virus herpes simpleks, cacar air, dan herpes zoster.',
                    'medicines/LlM5cSeZAaHg52u9FAmmwTd1r2UQlUK6IQsdOg6S.jpg'
                ],
                [
                    'Benzydamine Mouthwash 120 ml', 
                    false, 
                    38000,
                    'TANTUM VERDE ORAL RINSE mengandung Benzydamine HCl dan Alcohol. Obat kumur ini digunakan untuk meringankan rasa sakit pada mulut dan tenggorokan, seperti tonsilitis, sakit tenggorokan, dan sariawan.',
                    'medicines/BXAVFPsFkAaimoRZN5t7bf52DELnm9OwJED3L0s9.webp'
                ],
            ],
            'obat-kumur-antiseptik' => [
                [
                    'Povidone Iodine Kumur 100 ml', 
                    false, 
                    26000,
                    'Povidone Iodine Kumur 100 ml adalah obat kumur antiseptik dengan kandungan Povidone-Iodine 1% yang berfungsi untuk membersihkan dan membunuh bakteri, virus, dan jamur di rongga mulut dan tenggorokan.',
                    'medicines/TGgPd461ztLmHgeCZ3mCVwPi3jIUIQepsS1ixP68.png'
                ],
                [
                    'Chlorhexidine Mouthwash 250 ml', 
                    false, 
                    52000,
                    'Chlorhexidine Mouthwash 250 ml adalah obat kumur antiseptik antibakteri yang digunakan untuk mengobati penyakit gusi (gingivitis), sariawan, dan menjaga kebersihan mulut.',
                    'medicines/Q1sD5I3XHEm2M7WABljKlKOfNe7P3XtIMUNu7Kpt.jpg'
                ],
            ],
            'obat-tetes-telinga' => [
                [
                    'Carbamide Peroxide Ear Drops', 
                    false, 
                    32000,
                    'Carbamide peroxide ear drops adalah obat tetes telinga yang digunakan untuk melunakkan, melonggarkan, dan mengeluarkan penumpukan kotoran telinga yang berlebihan.',
                    'medicines/xBFbyBOU35dWGXFEbuUgB8jecE29joETZDkL8to1.jpg'
                ],
                [
                    'Ciprofloxacin Ear Drops', 
                    true, 
                    54000,
                    'CIPROFLOXACIN mengobati infeksi telinga yang disebabkan oleh bakteri. Obat ini termasuk dalam kelompok antibiotik kuinolon.',
                    'medicines/8jwWdNT4Q1W9mX9DA7gjZKMME3TD60rOVccEMRg1.webp'
                ],
            ],
            'kebersihan-hidung' => [
                [
                    'Neti Pot + Saline', 
                    false, 
                    68000,
                    'Neti pot adalah wadah teko berbentuk khusus yang digunakan untuk membilas rongga hidung dengan larutan garam (saline), membersihkan lendir, alergen, dan kotoran.',
                    'medicines/G0qunzdv8RrPMUTqA3EiXc1ixMBdwrrHgTWhNxQz.webp'
                ],
                [
                    'Saline Rinse Sachet', 
                    false, 
                    22000,
                    'Saline Rinse Sachet adalah kemasan saset berisi campuran garam halus (saline) dan bahan lain seperti natrium bikarbonat yang digunakan untuk membuat larutan pencuci hidung.',
                    'medicines/J3W7KB8XYCQrn4UvwXAhl8K8HHk7l1QUhm3Hhc9F.jpg'
                ],
            ],
            'pelega-tenggorokan' => [
                [
                    'Lozenges Menthol 8 butir', 
                    false, 
                    12000,
                    'Lozenges Menthol 8 butir adalah tablet hisap dengan rasa menthol yang membantu melegakan sakit tenggorokan, iritasi, dan batuk. Bekerja sebagai antiseptik dan memberikan sensasi dingin.',
                    'medicines/89HsoIeI7e9avkHns6U9RkO9Q3tLPnvOXodlWzgi.jpg'
                ],
                [
                    'Spray Tenggorokan Antiseptik', 
                    false, 
                    38000,
                    'Cooling 5 Antiseptic Spray Cool Mint 15 ml bermanfaat untuk meredakan sakit tenggorokan, sariawan, dan mengurangi bau mulut. Mengandung phenol.',
                    'medicines/7XTFYwyoVy74WnliD0rXDH6ZKTjX7qXEN86UyyyY.webp'
                ],
                [
                    'Permen Pelega Mint', 
                    false, 
                    9000,
                    'Permen pelega mint adalah permen hisap yang dirancang untuk menyegarkan napas dan meredakan iritasi serta ketidaknyamanan pada tenggorokan berkat kandungan mint atau mentolnya.',
                    'medicines/BbCf6BcmjSojha2s9xNEn5Z2AnD8KZXWVt1FA4we.jpg'
                ],
            ],
        ];

        // === SEED ===
        foreach ($catalog as $catSlug => $items) {
            $category = Category::where('slug', $catSlug)->first();
            if (!$category) {
                // $this->command?->warn("Kategori tidak ditemukan: {$catSlug} (dilewati)");
                continue;
            }

            foreach ($items as $it) {
                // Bongkar 5 variabel dari array
                [$name, $rx, $price, $desc, $img] = $it; 
                
                // === REVISI: TAMBAHKAN PREFIX 'storage/' JIKA FOLDER ANDA ADA DI PUBLIC/STORAGE ===
                if (!str_starts_with($img, 'medicines/')) {
                    $img = 'medicines' . $img;
                }
                
                $slug = Str::slug($name);

                // Pastikan slug unik lintas kategori
                if (Medicine::where('slug', $slug)->exists()) {
                    $slug .= '-' . $category->id;
                }

                Medicine::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name'                 => $name,
                        'category_id'          => $category->id,
                        'price'                => $price,
                        'is_prescription_only' => (bool) $rx,
                        'description'          => $desc, 
                        'image'                => $img, 
                    ]
                );
            }
        }

        // Tambahkan "pengisi" (Dummy) untuk subkategori lain
        $filled = array_keys($catalog);
        $otherChildren = Category::whereNotNull('parent_id')
            ->whereNotIn('slug', $filled)
            ->get();

        foreach ($otherChildren as $cat) {
            for ($i = 1; $i <= 4; $i++) {
                $name = $cat->name . ' Sample ' . $i;
                $slug = Str::slug($name) . '-' . $cat->id;

                Medicine::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name'                 => $name,
                        'category_id'          => $cat->id,
                        'price'                => rand(9000, 65000),
                        'is_prescription_only' => (bool) random_int(0, 1),
                        'description'          => 'Deskripsi contoh untuk obat ' . $name . '.',
                        'image'                => 'medicines/default.jpg', 
                    ]
                );
            }
        }
    }
}