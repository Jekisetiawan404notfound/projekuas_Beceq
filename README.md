## Alur Kerja Git (Git Workflow)
abaikan yang branch karena kita hanya menggunakan 1 branch 

### Aturan Umum

1. Jangan pernah push langsung ke branch `main`/`master`. Selalu kerja di branch masing-masing.
2. Sebelum mulai kerja, selalu `git pull` dulu supaya kode di laptop kamu terbaru.
3. Satu orang sebaiknya fokus di satu fitur/file supaya tidak sering bentrok (conflict).
4. Commit sesering mungkin dengan pesan yang jelas, jangan numpuk banyak perubahan jadi satu commit besar.

### Langkah-Langkah

1. **Sebelum mulai kerja (wajib tiap hari/sesi):**
```bash
   git checkout main
   git pull origin main
```

2. **Buat branch baru untuk fitur yang mau dikerjakan:**
```bash
   git checkout -b nama-branch
```
   Contoh nama branch: `fitur-login`, `fix-navbar`, `nama-fitur-nama-orang`

3. **Setelah selesai edit kode, cek perubahan:**
```bash
   git status
```

4. **Tambahkan file yang diubah:**
```bash
   git add nama-file
```
   atau kalau mau semua file:
```bash
   git add .
```
   Hindari asal `git add .` tanpa cek `git status` dulu, supaya tidak ikut nambah file yang tidak perlu (misal file `.env`, folder `node_modules`, dll).

5. **Commit dengan pesan yang jelas:**
```bash
   git commit -m "Tambah fitur login user"
```
   Format pesan commit yang disarankan:
   - `Tambah: ...` untuk fitur baru
   - `Perbaiki: ...` untuk bug fix
   - `Ubah: ...` untuk perubahan/penyesuaian
   - `Hapus: ...` untuk menghapus sesuatu

6. **Push branch ke GitHub:**
```bash
   git push origin nama-branch
```

7. **Buat Pull Request (PR) di GitHub**, lalu minta anggota lain review sebelum di-merge ke `main`.

8. **Setelah PR di-merge**, anggota lain wajib `pull` ulang biar kode tetap sinkron:
```bash
   git checkout main
   git pull origin main
```

### Kalau Terjadi Conflict

1. Jangan panik, buka file yang bentrok, akan ada tanda seperti ini:
