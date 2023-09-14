<?php
$conn = mysqli_connect("localhost", "root", "", "mirorim");

//insert req
if (isset($_POST['tokoinput'])) {
    $jum = $_POST['jum'];
    $sku = $_POST['sku'];
    $inv = $_POST['inv'];
    $status = $_POST['status'];
    $stat = $_POST['stat'];
    $tipe = $_POST['tipe_pesanan'];
    $quantity = $_POST['quantity'];
    $requester = $_POST['requester'];

    for ($i = 0; $i < $jum; $i++) {
        if ($inv[$i] == '0') {

            $select = mysqli_query($conn, "SELECT id_toko FROM toko_id WHERE sku_toko='$sku[$i]'");
            $data = mysqli_fetch_array($select);
            $idt = $data['id_toko'];

            if ($select) {
                $insert = mysqli_query($conn, "INSERT INTO request_id(id_toko, quantity_req, requester, type_req, status_req) VALUES('$idt','$quantity[$i]','$requester','$status','$stat')");
                header('location:?url=product');
            }
        } else {
            $select = mysqli_query($conn, "SELECT id_toko FROM toko_id WHERE sku_toko='$sku[$i]'");
            $data = mysqli_fetch_array($select);
            $idt = $data['id_toko'];

            if ($select) {
                $selectlist = mysqli_query($conn, "SELECT id_komponen FROM list_komponen WHERE id_product_finish='$idt'");
                $list = mysqli_fetch_array($selectlist);

                $id_komp = $list['id_komponen'];
                if ($id_komp > 1999999) {
                    $selectproductgudang = mysqli_query($conn, "SELECT SUM(quantity) AS quantity FROM gudang_id WHERE id_product='$id_komp' GROUP BY id_product");
                    $datagudang = mysqli_fetch_array($selectproductgudang);
                    $quantitytotal = $datagudang['quantity'];

                    if ($quantity[$i] > $quantitytotal) {
                        echo '
                    
                    <script>
                    
                    alert("Quantity yang anda minta melebihi yang ada");
                    
                    window.location.href="?url=product";
                    
                    </script>';
                    } else {
                        $insert = mysqli_query($conn, "INSERT INTO request_id(id_toko, invoice, quantity_req, requester, type_req, status_req, tipe_pesanan) VALUES('$idt','$inv[$i]','$quantity[$i]','$requester','$status','$stat','$tipe[$i]')");
                        header('location:?url=product');
                    }
                } elseif ($id_komp < 1999999) {
                    $selectproductgudang = mysqli_query($conn, "SELECT SUM(quantity) AS quantity FROM mateng_id WHERE id_product='$id_komp' GROUP BY id_product");
                    $datagudang = mysqli_fetch_array($selectproductgudang);
                    $quantitytotal = $datagudang['quantity'];

                    if ($quantity[$i] > $quantitytotal) {
                        echo '
                    
                    <script>
                    
                    alert("Quantity yang anda minta melebihi yang ada");
                    
                    window.location.href="?url=product";
                    
                    </script>';
                    } else {
                        $insert = mysqli_query($conn, "INSERT INTO request_id(id_toko, invoice, quantity_req, requester, type_req, status_req, tipe_pesanan) VALUES('$idt','$inv[$i]','$quantity[$i]','$requester','$status','$stat','$tipe[$i]')");
                        header('location:?url=product');
                    }
                }
            } else {
                echo '
                    
                    <script>
                    
                    alert("Tidak ada Komponen Mentah di Gudang, Harap Lapor Gudang");
                    
                    window.location.href="?url=product";
                    
                    </script>';
            }
        }
    } {
    }
}

if (isset($_POST['request'])) {
    $inv = $_POST['inv'];
    $sku = $_POST['sku'];
    $status = $_POST['status'];
    $stat = $_POST['stat'];
    $tipe = $_POST['tipe_pesanan'];
    $quantity = $_POST['quantity'];
    $requester = $_POST['requester'];
    
    // Menghitung jumlah elemen inv yang dikirimkan
    $jum = count($inv);

    // Array untuk menyimpan data yang akan di-insert ke database
    $dataToInsert = array();

    // Selanjutnya, Anda bisa melakukan pengolahan data sesuai kebutuhan, seperti insert ke database
    foreach ($inv as $key => $invoice) {
        if ($invoice == '0') {
            continue;
        }
        
        $select = mysqli_query($conn, "SELECT id_toko FROM toko_id WHERE sku_toko='{$sku[$key]}'");
        $data = mysqli_fetch_array($select);
        $idt = $data['id_toko'];

        if ($select) {
            $selectlist = mysqli_query($conn, "SELECT id_komponen FROM list_komponen WHERE id_product_finish='$idt'");
            $list = mysqli_fetch_array($selectlist);

            $id_komp = $list['id_komponen'];
            if ($id_komp > 1999999) {
                $selectproductgudang = mysqli_query($conn, "SELECT SUM(quantity) AS quantity FROM gudang_id WHERE id_product='$id_komp' GROUP BY id_product");
                $datagudang = mysqli_fetch_array($selectproductgudang);
                $quantitytotal = $datagudang['quantity'];

                if ($quantity[$key] > $quantitytotal) {
                    echo '
                    <script>
                        alert("Quantity yang anda minta melebihi yang ada untuk invoice ' . $invoice . ' dengan SKU ' . $sku[$key] . '");
                        window.location.href="?url=product";
                    </script>';
                } else {
                    // Menambahkan data ke dalam array untuk di-insert
                    $dataToInsert[] = array(
                        'id_toko' => $idt,
                        'invoice' => $invoice,
                        'quantity_req' => $quantity[$key],
                        'requester' => $requester,
                        'type_req' => $status,
                        'status_req' => $stat,
                        'tipe_pesanan' => $tipe[$key]
                    );
                }
            } elseif ($id_komp < 1999999) {
                $selectproductgudang = mysqli_query($conn, "SELECT SUM(quantity) AS quantity FROM mateng_id WHERE id_product='$id_komp' GROUP BY id_product");
                $datagudang = mysqli_fetch_array($selectproductgudang);
                $quantitytotal = $datagudang['quantity'];

                if ($quantity[$key] > $quantitytotal) {
                    echo '
                    <script>
                        alert("Quantity yang anda minta melebihi yang ada untuk invoice ' . $invoice . ' dengan SKU ' . $sku[$key] . '");
                        window.location.href="?url=approve";
                    </script>';
                } else {
                    // Menambahkan data ke dalam array untuk di-insert
                    $dataToInsert[] = array(
                        'id_toko' => $idt,
                        'invoice' => $invoice,
                        'quantity_req' => $quantity[$key],
                        'requester' => $requester,
                        'type_req' => $status,
                        'status_req' => $stat,
                        'tipe_pesanan' => $tipe[$key]
                    );
                }
            }
        } else {
            echo '
            <script>
                alert("Tidak ada Komponen Mentah di Gudang, Harap Lapor Gudang untuk SKU ' . $sku[$key] . '");
                window.location.href="?url=product";
            </script>';
        }
    }

    // Sekarang, Anda dapat meng-insert data ke dalam database di sini
    foreach ($dataToInsert as $data) {
        $idt = $data['id_toko'];
        $invoice = $data['invoice'];
        $quantity_req = $data['quantity_req'];
        $requester = $data['requester'];
        $status = $data['type_req'];
        $stat = $data['status_req'];
        $tipe_pesanan = $data['tipe_pesanan'];

        $insert = mysqli_query($conn, "INSERT INTO request_id(id_toko, invoice, quantity_req, requester, type_req, status_req, tipe_pesanan) VALUES('$idt','$invoice','$quantity_req','$requester','$status','$stat','$tipe_pesanan')");

        if (!$insert) {
            echo '
            <script>
                alert("Gagal menyimpan data untuk invoice ' . $invoice . '.");
                window.location.href="?url=product";
            </script>';
        }
    }

    // Setelah semua data berhasil di-insert, redirect ke halaman approve
    echo '
    <script>
        window.location.href="?url=approve";
    </script>';
}
//Approve Refill
if (isset($_POST['approverefill'])) {
    $quantity = $_POST['quantity'];
    $stat = $_POST['stat'];
    $idr = $_POST['idr'];
    $displayQuantity = $_POST['displayQuantity'];
    $jum = count($idr);

    for ($i = 0; $i < $jum; $i++) {
        $currQuantity = (int)$displayQuantity[$i];

        //gambar
        $allowed_extension = array('png', 'jpg', 'jpeg', 'svg', 'webp');

        $namaimage = $_FILES['file']['name']; //ambil gambar

        if (!empty($namaimage[$i])) {
            $dot = explode('.', $namaimage[$i]);
            $ekstensi = strtolower(end($dot)); //ambil ekstensi
            $ukuran = $_FILES['file']['size']; //ambil size
            $file_tmp = $_FILES['file']['tmp_name']; //lokasi

            //nama acak
            $image = md5(uniqid($namaimage[$i], true) . time()) . '.' . $ekstensi; //compile

            // Proses upload
            if (in_array($ekstensi, $allowed_extension) && $ukuran[$i] < 5000000) {
                move_uploaded_file($file_tmp[$i], '../assets/tokoimg/' . $image);
            } else {
                // File upload error, handle it as needed
                echo "File upload error for image " . ($i + 1);
                continue; // Skip the current iteration and proceed to the next one
            }
        } else {
            $image = ''; // No file chosen, set an empty image
        }

        if ($currQuantity !== 0) {
            $selectlist = mysqli_query($conn, "SELECT quantity_req FROM request_id WHERE id_request='" . $idr[$i] . "'");
            $datalist = mysqli_fetch_array($selectlist);
            $qtyreq = $datalist['quantity_req'];

            if ($qtyreq == $currQuantity) {
                $select = mysqli_query($conn, "SELECT id_gudang AS idg, jenis_item, quantity_tambah FROM request_total WHERE id_request='" . $idr[$i] . "'");
                while ($data = mysqli_fetch_array($select)) {
                    $jenis = $data['jenis_item'];
                    $idg = $data['idg'];
                    $quantitytotal = $data['quantity_tambah'];

                    if ($jenis == 'mentah') {
                        $selectgudang = mysqli_query($conn, "SELECT id_gudang, quantity FROM gudang_id WHERE id_gudang='$idg'");
                        $datagudang = mysqli_fetch_array($selectgudang);
                        $quantitygudang = $datagudang['quantity'];

                        $kurang = $quantitygudang - $quantitytotal;
                        if ($selectgudang) {
                            $update = mysqli_query($conn, "UPDATE gudang_id SET quantity='$kurang' WHERE id_gudang='$idg'");
                            if ($update) {
                                $updatetotal = mysqli_query($conn, "UPDATE request_total SET status_total='Approved' WHERE id_request='$idr[$i]'");
                                if ($updatetotal) {
                                    $updatereq = mysqli_query($conn, "UPDATE request_id SET image_toko='$image', quantity_count='$currQuantity', status_req='Approved' WHERE id_request='$idr[$i]'");
                                    if (!$updatereq) {
                                        echo "Gagal mengupdate status request";
                                    }
                                } else {
                                    echo "Gagal mengupdate status total";
                                }
                            } else {
                                echo "Gagal mengupdate quantity gudang";
                            }
                        } else {
                            echo "Gagal mendapatkan data gudang";
                        }
                    } elseif ($jenis == 'mateng') {
                        $selectgudang = mysqli_query($conn, "SELECT id_gudang, quantity FROM mateng_id WHERE id_gudang='$idg'");
                        $datagudang = mysqli_fetch_array($selectgudang);
                        $quantitygudang = $datagudang['quantity'];

                        $kurang = $quantitygudang - $quantitytotal;
                        if ($selectgudang) {
                            $update = mysqli_query($conn, "UPDATE mateng_id SET quantity='$kurang' WHERE id_gudang='$idg'");
                            if ($update) {
                                $updatetotal = mysqli_query($conn, "UPDATE request_total SET status_total='Approved' WHERE id_request='$idr[$i]'");
                                if ($updatetotal) {
                                    $updatereq = mysqli_query($conn, "UPDATE request_id SET image_toko='$image', quantity_count='$currQuantity', status_req='Approved' WHERE id_request='$idr[$i]'");
                                    if (!$updatereq) {
                                        echo "Gagal mengupdate status request";
                                    }
                                } else {
                                    echo "Gagal mengupdate status total";
                                }
                            } else {
                                echo "Gagal mengupdate quantity gudang";
                            }
                        } else {
                            echo "Gagal mendapatkan data gudang";
                        }
                    }
                }
            } else {
                $update = mysqli_query($conn, "UPDATE request_id SET image_toko='$image', quantity_count='$currQuantity' WHERE id_request='$idr[$i]'");
                if (!$update) {
                    echo "Gagal mengupdate status request";
                }
            }
        }
    }
    header('location:?url=approve');
    exit;
}


if (isset($_POST['approvereadmin'])) {

    $quantityr = $_POST['quantityr'];

    $quantityc = $_POST['quantityc'];

    $stat = $_POST['stat'];

    $idt = $_POST['idt'];

    $idk = $_POST['idk'];

    $idg = $_POST['idg'];



    $jum = count($idt);

    for ($i = 0; $i < $jum; $i++) {

        $update = mysqli_query($conn, "UPDATE request_id SET quantity_req='$quantityr[$i]', quantity_count='$quantityc[$i]' WHERE id_request='$idt[$i]'");

        if ($quantityc[$i] == $quantityr[$i]) {

            $update = mysqli_query($conn, "UPDATE request_id SET quantity_count='$quantity[$i]', status_req='$stat[$i]' WHERE id_request='$idt[$i]'");

            if ($update) {

                $selecttotal = mysqli_query($conn, "SELECT id_total, id_gudang, quantity_tambah FROM request_total WHERE id_request='$idt[$i]'");

                while ($opsi = mysqli_fetch_array($selecttotal)) {

                    $id = $opsi['id_gudang'];

                    $qty = $opsi['quantity_tambah'];

                    $idtol = $opsi['id_total'];



                    if ($selecttotal) {

                        $selectgudang = mysqli_query($conn, "SELECT quantity FROM gudang_id WHERE id_gudang='$id'");

                        $opsi2 = mysqli_fetch_array($selectgudang);

                        $qtyg = $opsi2['quantity'];



                        $kurang = $qtyg - $qty;

                        if ($selectgudang) {

                            $updateg = mysqli_query($conn, "UPDATE gudang_id SET quantity='$kurang' WHERE id_gudang='$id'");

                            if ($updateg) {

                                $updatetol = mysqli_query($conn, "UPDATE request_total SET status_total='$stat[$i]' WHERE id_total='$idtol'");

                                header('location:?url=approve');
                            }
                        } else {
                        }
                    } else {
                    }
                }
            } else {
            }
        } else {
        }

        header('location:?url=approveadmin');
    } {
    }
}



//Edit SKU

if (isset($_POST['addsku'])) {

    $idp = $_POST['idp'];

    $sku = $_POST['sku'];



    $jum = count($idp);

    for ($i = 0; $i < $jum; $i++) {
        $select = mysqli_query($conn, "SELECT sku_toko FROM toko_id WHERE sku_toko='$sku[$i]'");
        $data = mysqli_fetch_array($select);
        $skutoko = $data['sku_toko'];

        $hitung = mysqli_num_rows($select);
        if ($skutoko == "-") {
            $edit = mysqli_query($conn, "UPDATE toko_id SET sku_toko='$sku[$i]' WHERE id_product='$idp[$i]'");
            header('location?url=product');
        } else {
            if ($hitung > 0) {
                echo '
                    
                    <script>
                    
                    alert("Data SKU sudah ada");
                    
                    window.location.href="?url=product";
                    
                    </script>';
            } else {
                $edit = mysqli_query($conn, "UPDATE toko_id SET sku_toko='$sku[$i]' WHERE id_product='$idp[$i]'");
                header('location?url=product');
            }
        }
    } {
    }
}

if (isset($_POST['edititemsuper'])) {
    $skug = $_POST['skut'];
    $nama = $_POST['nama'];
    $idp = $_POST['idp'];
    $idt = $_POST['idt'];

    //gambar

    $allowed_extensions = array('png', 'jpg', 'jpeg', 'svg', 'webp');

    $namaimage = $_FILES['file']['name']; //ambil gambar

    $dot = explode('.', $namaimage);

    $ekstensi = strtolower(end($dot)); //ambil ekstensi

    $ukuran = $_FILES['file']['size']; //ambil size

    $file_tmp = $_FILES['file']['tmp_name']; //lokasi

    //nama acak

    $image = md5(uniqid($namaimage, true) . time()) . '.' . $ekstensi; //compile

    if ($ukuran == 0) {
        $update = mysqli_query($conn, "UPDATE product_toko_id SET nama='$nama' WHERE id_product='$idp'");

        if ($update) {

            $select = mysqli_query($conn, "SELECT sku_toko FROM toko_id WHERE sku_toko='$skug'");

            $hitung = mysqli_num_rows($select);
            if ($hitung > 1 && $skug !== '-') {
                echo '

            <script>

                alert("SKU Toko Telah ada");

                window.location.href="?url=product";

            </script>';
            } else {
                $update2 = mysqli_query($conn, "UPDATE toko_id SET sku_toko='$skug' WHERE id_toko='$idt'");
                header('location:?url=product');
            }
        } else {

            echo '

            <script>

                alert("Barang Tidak bisa di update");

                window.location.href="?url=product";

            </script>';
        }
    } else {

        move_uploaded_file($file_tmp, '../assets/img/' . $image);

        $update = mysqli_query($conn, "UPDATE product_toko_id SET nama='$nama', image='$image' WHERE id_product='$idp'");

        if ($update) {
            $select = mysqli_query($conn, "SELECT sku_toko FROM toko_id WHERE sku_toko='$skug'");
            $hitung = mysqli_num_rows($select);
            if ($hitung > 1 && $skug !== '-') {
                echo '

            <script>

                alert("SKU Toko Telah ada");

                window.location.href="?url=product";

            </script>';
            } else {
                $update2 = mysqli_query($conn, "UPDATE toko_id SET sku_toko='$skug' WHERE id_toko='$idt'");
                header('location:?url=product');
            }
        } else {

            echo '

            <script>

                alert("Barang dan Gambar Tidak bisa di update");

                window.location.href="?url=product";

            </script>';
        }
    }
}
//mutasi



if (isset($_POST['mutasi'])) {
    $sku = $_POST['sku'];
    $idt = $_POST['idt'];
    $sku1 = $_POST['sku1'];

    $jum = count($sku);

    for ($i = 0; $i < $jum; $i++) {
        $select = mysqli_query($conn, "SELECT sku_toko FROM toko_id WHERE sku_toko='$sku[$i]'");
        $hitung = mysqli_num_rows($select);
        if ($hitung > 0) {
            echo '
                  <script>    
                    alert("Data SKU yang dimasukan telah ada");
                    window.location.href="?url=product";
                    </script>';
        } else {
            if ($sku == $sku1) {
                echo '
                  <script>    
                    alert("Data SKU yang dimasukan sama");
                    window.location.href="?url=product";
                    </script>';
            } else {
                $insert = mysqli_query($conn, "INSERT INTO mutasitoko_id(id_toko, sku_lama, sku_baru) VALUES('$idt[$i]','$sku1[$i]','$sku[$i]')");
                if ($insert) {
                    $insert = mysqli_query($conn, "UPDATE toko_id SET sku_toko='$sku[$i]' WHERE id_toko='$idt[$i]'");
                    header('location:?url=product');
                } else {
                }
            }
        }
    } {
    }
}
//MUTASI ACC



if (isset($_POST['mutasiacc'])) {
    $cek = $_POST['cek'];
    $idt = $_POST['idt'];
    $idm = $_POST['idm'];
    $stat = $_POST['stat'];

    $jum = count($cek);

    for ($i = 0; $i < $jum; $i++) {
        $select = mysqli_query($conn, "SELECT sku_lama, sku_baru, id_toko AS idt FROM mutasitoko_id WHERE id_mutasi='$cek[$i]'");
        $data = mysqli_fetch_array($select);
        $skubaru = $data['sku_baru'];
        $skulama = $data['sku_lama'];
        $idtoko = $data['idt'];

        if ($select) {
            $update = mysqli_query($conn, "UPDATE toko_id SET sku_toko='$skubaru' WHERE id_toko='$idtoko'");
            if ($update) {
                $update1 = mysqli_query($conn, "UPDATE mutasitoko_id SET status_mutasi='$stat' WHERE id_mutasi='$cek[$i]'");
            }
        } else {
        }
    } {
    }
}

if (isset($_POST['newtoko'])) {
    $nama = $_POST['nama'];
    $jenis =  $_POST['jenis'];
    $skug = $_POST['skug'];
    $jum = $_POST['jum'];

    for ($i = 0; $i < $jum; $i++) {

        //gambar

        $allowed_extension = array('png', 'jpg', 'jpeg', 'svg', 'webp');

        $namaimage = $_FILES['file']['name']; //ambil gambar

        $dot = explode('.', $namaimage[$i]);

        $ekstensi = strtolower(end($dot)); //ambil ekstensi

        $ukuran = $_FILES['file']['size']; //ambil size

        $file_tmp = $_FILES['file']['tmp_name']; //lokasi



        //nama acak

        $image = md5(uniqid($namaimage[$i], true) . time()) . '.' . $ekstensi; //compil

        //proses upload

        if (in_array($ekstensi, $allowed_extension) === true) {

            //validasi ukuran

            if ($ukuran[$i] > 0) {

                move_uploaded_file($file_tmp[$i], '../assets/img/' . $image);

                $insert = mysqli_query($conn, "INSERT INTO product_toko_id(image, nama, jenis) VALUES('$image','$nama[$i]','$jenis')");
                if ($insert) {
                    $select = mysqli_query($conn, "SELECT id_product FROM product_toko_id WHERE nama='$nama[$i]' LIMIT 1");
                    $data = mysqli_fetch_array($select);
                    $idp = $data['id_product'];
                    if ($select) {
                        $insertgudang = mysqli_query($conn, "INSERT INTO toko_id(id_product, sku_toko) VALUES('$idp','$skug[$i]')");
                        header('location:?url=product');
                    }
                } else {
                }
            } else {
                $insert = mysqli_query($conn, "INSERT INTO product_toko_id(image, nama, jenis) VALUES('$image','$nama[$i]','$jenis')");
                if ($insert) {
                    $select = mysqli_query($conn, "SELECT id_product FROM product_toko_id WHERE nama='$nama[$i]' LIMIT 1");
                    $data = mysqli_fetch_array($select);
                    $idp = $data['id_product'];
                    if ($select) {
                        $insertgudang = mysqli_query($conn, "INSERT INTO toko_id(id_product, sku_toko) VALUES('$idp','$skug[$i]')");
                        header('location:?url=product');
                    }
                } else {
                }
            }
        }
    } {
    }
}

if (isset($_POST['hapusitemsuper'])) {

    $skug = $_POST['skut'];
    $nama = $_POST['nama'];
    $idp = $_POST['idp'];
    $idt = $_POST['idt'];



    //gambar

    $allowed_extension = array('png', 'jpg', 'jpeg', 'svg', 'webp');

    $namaimage = $_FILES['file']['name']; //ambil gambar

    $dot = explode('.', $namaimage);

    $ekstensi = strtolower(end($dot)); //ambil ekstensi

    $ukuran = $_FILES['file']['size']; //ambil size

    $file_tmp = $_FILES['file']['tmp_name']; //lokasi



    //nama acak

    $image = md5(uniqid($namaimage, true) . time()) . '.' . $ekstensi; //compile

    if ($ukuran == 0) {

        $update = mysqli_query($conn, "DELETE FROM product_toko_id  WHERE id_product='$idp'");

        if ($update) {

            $select = mysqli_query($conn, "SELECT sku_toko FROM toko_id WHERE sku_toko='$skug'");

            $hitung = mysqli_num_rows($select);
            if ($hitung > 1 && $skug !== '-') {
                echo '

            <script>

                alert("SKU Toko Telah ada");

                window.location.href="?url=product";

            </script>';
            } else {
                $update2 = mysqli_query($conn, "DELETE FROM toko_id WHERE id_toko='$idt'");

                header('location:?url=product');
            }
        } else {

            echo '

            <script>

                alert("Barang Tidak bisa di update");

                window.location.href="?url=product";

            </script>';
        }
    } else {

        move_uploaded_file($file_tmp, '../assets/img/' . $image);

        $update = mysqli_query($conn, "DELETE FROM product_toko_id  WHERE id_product='$idp'");

        if ($update) {


            $select = mysqli_query($conn, "SELECT sku_toko FROM toko_id WHERE sku_toko='$skug'");
            $hitung = mysqli_num_rows($select);
            if ($hitung > 1 && $skug !== '-') {
                header('location:?url=product');
            } else {
                $update2 = mysqli_query($conn, "DELETE FROM toko_id WHERE id_toko='$idt'");

                header('location:?url=product');
            }
        } else {

            echo '

            <script>

                alert("Barang dan Gambar Tidak bisa di Hapus");

                window.location.href="?url=product";

            </script>';
        }
    }
}
