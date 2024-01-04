<p align="center"><img src="https://i.ibb.co/4VQfqsF/Cuplikan-layar-2024-01-02-205804.png" width="100%" alt="BubbleSmart Demo"></p>

## About BubbleSmart

<b>BubbleSmart</b> adalah aplikasi belajar online Aksara Jawa dengan mudah dan menyenangkan. Berikut beberapa fitur yang ada di BubbleSmart:

### Fitur BubbleSmart:

#### Admin

-   <b>Dashboard</b><br>
    Di dalam 'Dashboard', admin bisa melihat statistik pengguna yang mengerjakan quiz, total pengguna, total quiz, dan thread forum.

-   <b>Data Materi</b><br>
    Dalam menu 'Data Materi', admin dapat melakukan insert data materi, update data materi, dan juga delete data materi. Selain itu, terdapat juga fitur searching untuk melakukan filter saat mencari data materi. Data materi berisi gambar, judul, kategori, dan juga audio.

-   <b>Data Quiz</b><br>
    Di dalam menu 'Data Quiz', admin dapat melakukan insert data quiz, update data quiz, delete data quiz, lihat pertanyaan, tambah pertanyaan, update pertanyaan, dan juga delete pertanyaan. Terdapat juga fitur pencarian data quiz dan juga data pertanyaan.

-   <b>Forum</b><br>
    Dalam menu 'Forum', admin dapat menambahkan thread baru, delete thread, like thread, comment thread dan juga delete comment pada thread. Admin bisa melihat siapa saja yang like thread.

-   <b>Laporan</b><br>
    Dalam menu 'Laporan', admin dapat melihat siapa saja yang sudah mengerjakan quiz, serta dapat melihat jawaban dan juga nilai pengguna aplikasi.

-   <b>Text to Aksara</b><br>
    Dalam menu 'Text to Aksara', admin dapat mengubah text latin biasa menjadi huruf aksara jawa. Terdapat juga menu salin text aksara untuk mempercepat.

-   <b>Pengaturan</b><br>
    Di menu 'Pengaturan', admin dapat melihat dan mengubah informasi identitas pribadi, termasuk perubahan identitas, perubahan password, dan pengaturan lain yang terkait dengan aplikasi.

#### Member

-   <b>Materi</b><br>
    Di menu 'Materi', Pengguna dapat melihat materi pembelajaran aksara jawa berupa macam-macam huruf aksara jawa, sandhangan, dan juga pasangannya serta pengguna bisa mendengarkan audio pelafalannya.

-   <b>Quiz</b><br>
    Dalam menu 'Quiz', terdapat soal-soal yang bisa dikerjakan untuk melatih pemahaman tentang aksara jawa. Quiz ini bisa dikerjakan secara berulang-ulang.

-   <b>Forum</b><br>
    Forum digunakan untuk berdiskusi jika terdapat masalah mengenai materi yang ada. Setiap pengguna bisa mengajukan pertanyaan dan nantinya pertanyaan tersebut bisa dijawab oleh pengguna lain.

    Dalam menu 'Forum', pengguna dapat menambahkan thread baru, delete thread, like thread, comment thread dan juga delete comment pada thread. Pengguna juga bisa melihat siapa saja yang like thread.

-   <b>Nilai</b><br>
    Setiap selesai menjawab quiz, pengguna dapat melihat nilainya langsung di menu 'Nilai'. Pengguna juga dapat melihat pertanyaan mana saja yang jawabannya benar dan juga salah. Selain itu, pengguna juga bisa menghapus histori mengerjakan quiznya.

-   <b>Pengaturan</b><br>
    Dalam menu 'Pengaturan', pengguna dapat melihat dan mengubah identitas diri seperti nama, alamat, foto profil dan lain-lain. Pengguna juga dapat mengubah password.

-   <b>Dokumentasi</b><br>
    Dalam dokumentasi, pengguna dapat melihat tutorial bagaimana cara menggunakan aplikasi. Mulai dari membuat akun, melihat materi, mengerjakan quiz, melihat nilai quiz, mengubah password, dan lain-lain.

## Installation

#### 1. Clone the repository

```sh
git clone https://github.com/bubblevy/bubblesmart.git
```

#### 2. Change Directory

```sh
cd bubblesmart
```

#### 3. Copy .env

```sh
cp .env.example .env
```

#### 4. Configure .env

```sh
FAKER_LOCALE=id_ID
FILESYSTEM_DISK=public
```

#### 5. Install depedencies

```sh
composer install
```

#### 6. Generate Key

```sh
php artisan key:generate
```

#### 7. Run Symlink

```sh
php artisan storage:link
```

#### 8. Migrate database

```sh
php artisan migrate
```

#### 9. Database seeders

```sh
php artisan db:seed
```

#### 10. Run application

```sh
php artisan serve
```

##### <i><b>Note:<br>username: admin & password: @Admin123 <br> username: member & password: @Member123</b></i>

## License

The BubbleSmart is open-sourced licensed under the [MIT license](https://github.com/bubblevy/bubblesmart/blob/main/LICENSE).
