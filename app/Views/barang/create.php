<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Form Tambah Data Barang</h2>
            <form action="/barang/save" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control <?= ($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>" id="nama_barang" name="nama_barang" autofocus value="<?= old('nama_barang'); ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_barang'); ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?= old('lokasi'); ?>">
                </div>
                <div class="mb-3">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <input type="text" class="form-control" id="kondisi" name="kondisi" value="<?= old('kondisi'); ?>">
                </div>
                <div class="mb-3 ">
                    <label for="gambar" class="form-label">Gambar</label>
                    <div class="col-sm-2 mb-3">
                        <img src="/img/photo.png" class="img-thumbnail img-preview">
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="gambar">Upload</label>
                        <input type="file" class="form-control <?= ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>" id="gambar" name="gambar" onchange="previewImg()">
                        <div class="invalid-feedback">
                            <?= $validation->getError('gambar'); ?>
                        </div>
                    </div>

                </div>
                <div class="mb-3">
                    <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                    <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" value="<?= old('jumlah_barang'); ?>">
                </div>
                <div class="mb-3">
                    <label for="spesifikasi" class="form-label">Spesifikasi</label>
                    <input type="textarea" class="form-control" id="spesifikasi" name="spesifikasi" value="<?= old('spesifikasi'); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Tambah Data</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>