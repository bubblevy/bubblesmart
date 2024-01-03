BubbleSmart Application
Version: 1.0
Author: @Bubble (https://github.com/bubblevy)
Last Update: 1 Januari 2024

This Application use:
- Framework Laravel 10
- Bootstrap 5
- Jquery
- other

### Support
https://trakteer.id/bubblenate/tip

### ABOUT APP
BubbleSmart adalah aplikasi belajar online Aksara Jawa dengan mudah dan menyenangkan. Berikut beberapa fitur yang ada di BubbleSmart:

## FITUR BUBBLESMART:

# FITUR ADMIN

- Dashboard
  Di dalam 'Dashboard', admin bisa melihat statistik pengguna yang mengerjakan quiz, total pengguna, total quiz, dan thread forum.

- Data Materi
  Dalam menu 'Data Materi', admin dapat melakukan insert data materi, update data materi, dan juga delete data materi. Selain itu, terdapat juga fitur searching untuk melakukan filer saat mencari data materi. Data materi berisi gambar, judul, kategori, dan juga audio.

- Data Quiz
  Di dalam menu 'Data Quiz', admin dapat melakukan insert data quiz, update data quiz, delete data quiz, lihat pertanyaan, tambah pertannyaan, update pertannyaan, dan juga delete pertanyaan. Terdapat juga fitur pencarian data quiz dan juga data pertannyan.

- Forum
  Dalam menu 'Forum', admin dapat menambahkan thread baru, delete thread, like thread, comment thread dan juga delete comment pada thread. Admin bisa melihat siapa saja yang like thread.

- Laporan
  Dalam menu 'Laporan', admin dapat melihat siapa saja yang sudah mengerjakan quiz, serta dapat melihat jawaban dan juga nilai pengguna aplikasi.

- Text to Aksara
  Dalam menu 'Text to Aksara', admin dapat mengubah text latin menjadi huruf aksara jawa. Terdapat juga menu salin text aksara untuk mempercepat.

- Pengaturan
  Di menu 'Pengaturan', admin dapat melihat dan mengubah informasi identitas pribadi, termasuk perubahan identitas, perubahan kata sandi, dan pengaturan lain yang terkait dengan aplikasi.

# FITUR MEMBER

- Materi
  Di menu 'Materi', Pengguna dapat melihat materi pembelajaran aksara jawa berupa macam-macam huruf aksara jawa, sandhangan, dan juga pasangannya serta pengguna bisa mendengarkan audio pelafalannya.

- Quiz
  Dalam menu 'Quiz', terdapat soal-soal yang bisa dikerjakan untuk melatih pemahaman tentang aksara jawa. Quiz ini bisa dikerjakan secara berulang-ulang.

- Forum
  Forum digunakan untuk berdiskusi jika terdapat masalah mengenai materi yang ada. Setiap pengguna bisa mengajukan pertanyaan dan nantinya pertanyaan tersebut bisa dijawab oleh pengguna lain.
  Dalam menu 'Forum', member dapat menambahkan thread baru, delete thread, like thread, comment thread dan juga delete comment pada thread. member juga bisa melihat siapa saja yang like thread.

- Nilai
  Setiap selesai menjawab quiz, pengguna dapat melihat nilainya langsung di menu 'Nilai'. Pengguna juga dapat melihat pertanyaan mana saja yang jawabannya benar dan juga salah. Selain itu, pengguna juga bisa menghapus histori mengerjakan quiznya.

- Pengaturan
  Dalam menu 'Pengaturan', pengguna dapat melihat dan mengubah identitas diri seperti nama, alamat, foto profil dan lain-lain. Pengguna juga dapat mengubah password.

- Dokumentasi
  Dalam dokumentasi, pengguna dapat melihat tutorial bagaimana cara menggunakan aplikasi. Mulai dari membuat akun, melihat materi, mengerjakan quiz, melihat nilai quiz, mengubah password, dan lain-lain.

### Installation

1. Clone the repository
git clone https://github.com/bubblevy/bubblesmart.git

2. Change Directory
cd bubblesmart

3. Copy .env
cp .env.example .env

4. Configure .env
FAKER_LOCALE=id_ID
FILESYSTEM_DISK=public

5. Install depedencies
composer install

6. Generate Key
php artisan key:generate

7. Run Symlink
php artisan storage:link

8. Migrate database
php artisan migrate

9. Database seeders
php artisan db:seed

10. Run application
php artisan serve

### License
The BubbleSmart is open-sourced licensed under the MIT license (https://github.com/bubblevy/bubblesmart/blob/main/LICENSE).