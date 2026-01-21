<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helper.php';

requireLogin(); // staff & admin allowed

$sql = "
SELECT 
    p.id_peminjaman,
    b.judul,
    a.nama_lengkap,
    p.tanggal_pinjam,
    p.tanggal_tenggat,
    p.tanggal_kembali,
    p.status_kembali
FROM peminjaman p
JOIN buku b ON p.id_buku = b.id_buku
JOIN anggota a ON p.id_anggota = a.id_anggota
ORDER BY 
    p.status_kembali ASC,
    p.tanggal_tenggat ASC
";

$data = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>

<div class="dashboard-wrapper">
    <?php require_once __DIR__ . '/../layout/sidebar.php'; ?>

    <div class="main">
        <?php require_once __DIR__ . '/../layout/header.php'; ?>

        <section class="table-section">
            <h3>Daftar Peminjaman</h3>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Nama Anggota</th>
                        <th>Tanggal Peminnjaman</th>
                        <th>Tenggat</th>
                        <th>Tanggal Kembali</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($data as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['judul']) ?></td>
                            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                            <td><?= $row['tanggal_pinjam'] ?></td>
                            <td><?= $row['tanggal_tenggat'] ?></td>

                            <!-- STATUS -->
                            <td>
                                <?php if ($row['status_kembali'] === 'dipinjam'): ?>
                                    <span class="badge bg-warning">Belum Dikembalikan</span>
                                <?php else: ?>
                                    <span class="badge bg-success">
                                        <?= $row['tanggal_kembali'] ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- ACTION -->
                            <td>
                                <?php if ($row['status_kembali'] === 'dipinjam'): ?>
                                    <a href="kembalikan.php?id=<?= $row['id_peminjaman'] ?>"
                                        class="btn btn-primary btn-sm"
                                        onclick="return confirm('Proses pengembalian buku ini?')">
                                        Pengembalian
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-success">Sudah Dikembalikan</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <?php require_once __DIR__ . '/../layout/footer.php'; ?>
    </div>
</div>