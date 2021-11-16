<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Detail Barang</h1>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/img/<?= $barang['gambar']; ?>" class="img-fluid rounded-start">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h2 class="card-title"><?= $barang['nama_barang']; ?></h2>
                            <h5 class="card-title"><?= $barang['lokasi']; ?></h5>
                            <h6 class="card-title"><?= $barang['kondisi']; ?></h6>
                            <p class="card-title"><?= $barang['jumlah_barang']; ?></p>
                            <p class="card-text"><?= $barang['spesifikasi']; ?></p>

                            <a href="/barang/edit/<?= $barang['slug']; ?>" class="btn btn-warning">Edit</a>

                            <form action="/barang/<?= $barang['id']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin ?');">Delete</button>
                            </form>

                            <br><br>
                            <a href="/barang">Kembali ke daftar Barang</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>