<?php
/*
 * form_kursus.php - form yang sama dipakai halaman tambah & edit kursus.
 * Variabel dari halaman pemanggil: $mode ('tambah'/'edit'), $nilai (isi form), $errors, $id
 */
$opsiKategori = ['matematika' => 'Matematika', 'sains' => 'Sains', 'bahasa' => 'Bahasa', 'sosial' => 'Sosial'];
$opsiTingkat = ['4-6' => 'Kelas 4–6', '7-8' => 'Kelas 7–8', '9' => 'Kelas 9'];
?>
<?php if (!empty($errors)): ?>
<div class="alert-form"><b>Periksa lagi:</b><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>
        <form action="<?= $mode === 'edit' ? 'admin-edit-kursus.php?id=' . urlencode($id) : 'admin-tambah-kursus.php' ?>" method="POST" enctype="multipart/form-data">
          <?php if ($mode === 'edit'): ?><input type="hidden" name="id" value="<?= e($id) ?>"><?php endif; ?>
          <div class="form-group">
            <label for="nama-kursus">Nama Kursus</label>
            <input type="text" id="nama-kursus" name="nama_kursus" class="form-control" placeholder="Contoh: Aljabar Linear Dasar" value="<?= e($nilai['nama']) ?>" required>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="kategori">Kategori</label>
              <select id="kategori" name="kategori" class="form-control" required>
                <option value="">Pilih kategori</option>
                <?php foreach ($opsiKategori as $v => $l): ?>
                <option value="<?= $v ?>" <?= $nilai['kategori'] === $v ? 'selected' : '' ?>><?= $l ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="tingkat">Tingkat Kelas</label>
              <select id="tingkat" name="tingkat" class="form-control" required>
                <option value="">Pilih tingkat</option>
                <?php foreach ($opsiTingkat as $v => $l): ?>
                <option value="<?= $v ?>" <?= $nilai['tingkat'] === $v ? 'selected' : '' ?>><?= $l ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="deskripsi">Deskripsi Kursus</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" maxlength="500" placeholder="Tulis deskripsi singkat kursus..."><?= e($nilai['deskripsi']) ?></textarea>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="status">Status Kursus</label>
              <select id="status" name="status" class="form-control">
                <option value="draft" <?= $nilai['status'] === 'draft' ? 'selected' : '' ?>>Draft (Simpan sebagai konsep)</option>
                <option value="aktif" <?= $nilai['status'] === 'aktif' ? 'selected' : '' ?>>Aktif (Langsung terbitkan)</option>
              </select>
            </div>
            <div class="form-group">
              <label for="thumbnail">Thumbnail Kursus</label>
              <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*" style="padding: 9px 16px;">
            </div>
          </div>

          <div class="form-actions">
            <a href="admin-kursus.php" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> <?= $mode === 'edit' ? 'Simpan Perubahan' : 'Simpan Kursus' ?></button>
          </div>
        </form>
