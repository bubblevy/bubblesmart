<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Materi;
use App\Models\Application;
use App\Models\Thread;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(5)->create();
        Application::create([
            'name_app' => 'BubbleSmart',
            'description_app' => 'BubbleSmart adalah platform edukasi terpercaya nomor satu di Dunia.'
        ]);

        User::create([
            'name' => 'Bubble Smith',
            'email' => 'bubble@gmail.com',
            'username' => 'admin',
            'image' => 'profil-images/5.jpeg',
            'is_admin' => 1,
            'gender' => 'Laki-Laki',
            'password' => bcrypt('@Admin123')
        ]);

        User::create([
            'name' => 'Daniella Francesca',
            'email' => 'daniellafrancescag@gmail.com',
            'username' => 'member',
            'image' => 'profil-images/1.jpeg',
            'gender' => 'Perempuan',
            'password' => bcrypt('@Member123')
        ]);

        User::create([
            'name' => 'Angie Anatasya',
            'email' => 'angieanatasya@gmail.com',
            'username' => 'angieanatasya',
            'image' => 'profil-images/3.jpeg',
            'gender' => 'Perempuan',
            'password' => bcrypt('@Angieanatasya123')
        ]);

        User::create([
            'name' => 'Luca Francesco',
            'email' => 'lucafrancesco@gmail.com',
            'username' => 'lucafrancesco',
            'image' => 'profil-images/6.jpg',
            'gender' => 'Laki-Laki',
            'password' => bcrypt('@Lucafrancesco123')
        ]);

        User::create([
            'name' => 'Laurent Gabriella',
            'email' => 'laurentgabriella@gmail.com',
            'username' => 'laurentgabriella',
            'image' => 'profil-images/4.jpeg',
            'gender' => 'Perempuan',
            'password' => bcrypt('@Laurentgabriella123')
        ]);

        User::create([
            'name' => 'Annabella Angelina',
            'email' => 'anabellaangelina@gmail.com',
            'username' => 'anabellaangelina',
            'gender' => 'Perempuan',
            'image' => 'profil-images/2.jpeg',
            'password' => bcrypt('@Anabellaangelina123')
        ]);

        User::create([
            'name' => 'Leonardo Vittorio',
            'email' => 'leonardovittorio@gmail.com',
            'username' => 'leonardovittorio',
            'image' => 'profil-images/5.png',
            'gender' => 'Laki-Laki',
            'password' => bcrypt('@Leonardovittorio123')
        ]);

        Materi::create([
            'image' => 'aksara/aksara_ha.png',
            'title' => 'ha',
            'category' => 'huruf',
            'audio' => 'audio/bubblesmart.mp3'
        ]);

        // materi
        $hurufAksara = ['na', 'ca', 'ra', 'ka', 'da', 'ta', 'sa', 'wa', 'la', 'pa', 'dha', 'ja', 'ya', 'nya', 'ma', 'ga', 'ba', 'tha', 'nga'];
        foreach ($hurufAksara as $huruf) {
            Materi::create([
                'image' => 'aksara/aksara_' . $huruf . '.png',
                'title' => $huruf,
                'category' => 'huruf'
            ]);
        }

        $pasanganAksara = ['Ha', 'Na', 'Ca', 'Ra', 'Ka', 'Da', 'Ta', 'Sa', 'Wa', 'La', 'Pa', 'Dha', 'Ja', 'Ya', 'Nya', 'Ma', 'Ga', 'Ba', 'Tha', 'Nga'];
        foreach ($pasanganAksara as $pasangan) {
            Materi::create([
                'image' => 'aksara/pasangan_' . $pasangan . '.png',
                'title' => $pasangan,
                'category' => 'pasangan'
            ]);
        }

        $sandhanganAksara = ['cecak', 'layar', 'pangkon', 'pepet', 'suku', 'taling_tarung', 'taling', 'tarung', 'wignyan', 'wulu'];
        foreach ($sandhanganAksara as $sandhangan) {
            Materi::create([
                'image' => 'aksara/sandhangan_' . $sandhangan . '.png',
                'title' => $sandhangan,
                'category' => 'sandhangan'
            ]);
        }

        // forum
        Thread::create([
            'user_id' =>  1,
            'title' =>  'Efisiensi dalam Proses Pengembangan',
            'content' => 'Bagaimana perbedaan metodologi pengembangan tradisional (Waterfall) dengan pendekatan modern (Agile, DevOps) dapat memengaruhi efisiensi pengembangan?'
        ]);
        Thread::create([
            'user_id' =>  2,
            'title' =>  'Evolusi Teknologi dalam Pengembangan Perangkat Lunak',
            'content' => 'Bagaimana evolusi bahasa pemrograman telah membantu dalam meningkatkan efisiensi dan kemampuan pengembangan perangkat lunak?'
        ]);
        Thread::create([
            'user_id' =>  3,
            'title' =>  'Masa Depan Pengembangan Perangkat Lunak',
            'content' => 'Bagaimana integrasi teknologi baru akan mempengaruhi cara kita mengembangkan perangkat lunak di masa depan?'
        ]);
        Thread::create([
            'user_id' =>  4,
            'title' =>  'Strategi Digitalisasi Bisnis',
            'content' => 'Bagaimana penggunaan teknologi dalam digitalisasi dapat mengubah cara perusahaan melakukan operasi sehari-hari, mengoptimalkan proses, dan mengurangi biaya serta waktu yang dibutuhkan?'
        ]);
        Thread::create([
            'user_id' =>  5,
            'title' =>  'Perbandingan Metodologi Tradisional dan Pendekatan Modern',
            'content' => 'Bagaimana kelebihan dan kekurangan masing-masing metodologi pengembangan ini dalam konteks efisiensi waktu, sumber daya, dan kualitas produk yang dihasilkan?'
        ]);
        Thread::create([
            'user_id' =>  6,
            'title' =>  'Optimalisasi Produktivitas Melalui Kultur Kerja Kolaboratif',
            'content' => 'Bagaimana perbedaan antara kultur kerja yang mendorong kolaborasi dan kultur yang menekankan kerja secara individual dapat memengaruhi produktivitas serta kreativitas di lingkungan kerja?'
        ]);
        Thread::create([
            'user_id' =>  7,
            'title' =>  'Tantangan dalam Membangun Kultur Kerja Kolaboratif',
            'content' => 'Apa saja hambatan utama yang dihadapi dalam menciptakan kultur kerja yang mendukung kolaborasi, dan bagaimana mengatasi hambatan tersebut untuk mencapai produktivitas yang optimal?'
        ]);

        // Comment
        Comment::create([
            'user_id' => 2,
            'thread_id' => 1,
            'comment' => 'Waterfall: Metode Waterfall mengadopsi pendekatan linear yang terstruktur. Setiap fase pengembangan (analisis, desain, pengembangan, pengujian, implementasi) dilakukan secara berurutan, dan fase selanjutnya dimulai setelah selesai dari fase sebelumnya. Agile & DevOps: Pendekatan Agile dan DevOps berfokus pada siklus pengembangan iteratif dan inkremental. Proyek dikerjakan dalam iterasi pendek yang disebut "sprint" (Agile) atau dengan pendekatan kontinu (DevOps), yang memungkinkan perubahan yang lebih cepat dan tanggap terhadap kebutuhan perubahan.'
        ]);

        Comment::create([
            'user_id' => 1,
            'thread_id' => 1,
            'comment' => 'Thank You',
            'parent_id' => 1
        ]);

        Comment::create([
            'user_id' => 3,
            'thread_id' => 1,
            'comment' => 'Waterfall: Interaksi dengan pengguna seringkali terjadi di awal dan akhir siklus pengembangan. Perubahan setelah fase awal seringkali sulit dan mahal. Agile & DevOps: Melalui pendekatan iteratif, pengguna terlibat secara terus-menerus selama proses pengembangan. Ini memungkinkan perubahan yang lebih fleksibel dan responsif terhadap umpan balik pengguna.'
        ]);

        Comment::create([
            'user_id' => 1,
            'thread_id' => 1,
            'comment' => 'Thank You',
            'parent_id' => 3
        ]);

        Comment::create([
            'user_id' => 5,
            'thread_id' => 1,
            'comment' => 'Waterfall: Tidak fleksibel terhadap perubahan. Perubahan yang dibutuhkan setelah fase awal seringkali sulit dan memakan waktu, dapat mengganggu jadwal dan anggaran. Agile & DevOps: Lebih responsif terhadap perubahan. Kemampuan untuk menyesuaikan diri dengan perubahan kebutuhan bisnis atau keinginan pengguna pada setiap iterasi memungkinkan fleksibilitas yang lebih besar.'
        ]);

        Comment::create([
            'user_id' => 1,
            'thread_id' => 1,
            'comment' => 'Thank You',
            'parent_id' => 5
        ]);

        Comment::create([
            'user_id' => 4,
            'thread_id' => 1,
            'comment' => 'Waterfall: Pengujian biasanya dilakukan pada akhir siklus pengembangan, dan perbaikan kesalahan atau bug seringkali kompleks dan mahal. Agile & DevOps: Pengujian terintegrasi ke dalam siklus pengembangan secara kontinyu. Hal ini memungkinkan identifikasi dini terhadap kesalahan atau bug dan perbaikan yang lebih cepat.'
        ]);

        Comment::create([
            'user_id' => 6,
            'thread_id' => 1,
            'comment' => 'Waterfall: Pendekatan Waterfall memiliki batasan terhadap kolaborasi tim karena tugas dan tanggung jawab seringkali terbagi secara linear. Agile & DevOps: Kolaborasi tim lebih kuat dalam pendekatan Agile dan DevOps. Tim bekerja bersama secara terus-menerus, berbagi tanggung jawab, dan berfokus pada tujuan bersama.'
        ]);

        Comment::create([
            'user_id' => 3,
            'thread_id' => 2,
            'comment' => 'Kesederhanaan dan Produktivitas: Bahasa pemrograman modern cenderung lebih mudah dipahami dan lebih ekspresif. Peningkatan ini telah memungkinkan pengembang untuk menulis kode yang lebih singkat, lebih jelas, dan lebih mudah di-maintain, yang pada gilirannya meningkatkan produktivitas.'
        ]);

        Comment::create([
            'user_id' => 2,
            'thread_id' => 2,
            'comment' => 'Makasih Angie',
            'parent_id' => 9
        ]);

        Comment::create([
            'user_id' => 7,
            'thread_id' => 2,
            'comment' => 'Bahasa pemrograman modern menawarkan tingkat abstraksi yang lebih tinggi, memungkinkan pengembang untuk fokus pada konsep dan solusi daripada implementasi teknis yang rumit. Ini membantu dalam menciptakan kode yang lebih fleksibel, mudah diubah, dan mudah,'
        ]);

        Comment::create([
            'user_id' => 4,
            'thread_id' => 2,
            'comment' => 'Bahasa pemrograman modern sering kali dirancang untuk meningkatkan kinerja aplikasi. Dengan teknik kompilasi yang lebih canggih, pengoptimalan kode, dan penggunaan memori yang lebih efisien, bahasa pemrograman baru dapat memberikan eksekusi yang lebih cepat.'
        ]);

        Comment::create([
            'user_id' => 6,
            'thread_id' => 2,
            'comment' => 'Bahasa pemrograman modern seperti Go, Rust, atau Python dengan modul tertentu telah mendukung pemrograman paralel dan konkurensi secara lebih efektif. Ini penting dalam dunia perangkat lunak yang semakin bergeser ke arah komputasi yang terdistribusi dan scalable.'
        ]);

        Comment::create([
            'user_id' => 5,
            'thread_id' => 2,
            'comment' => 'Bahasa pemrograman modern umumnya mendukung paradigma pemrograman yang berbeda seperti pemrograman fungsional, pemrograman berorientasi objek, dan pemrograman berbasis kejadian. Hal ini memberikan fleksibilitas yang lebih besar bagi pengembang dalam menyelesaikan masalah dengan pendekatan yang paling cocok.'
        ]);

        Comment::create([
            'user_id' => 1,
            'thread_id' => 2,
            'comment' => 'Bahasa-bahasa modern sering memiliki ekosistem yang kuat dengan berbagai pustaka dan framework yang mendukung pengembangan aplikasi. Ini memungkinkan pengembang untuk mengakses alat-alat yang telah diuji dan terbukti, mempercepat proses pengembangan.'
        ]);

        Comment::create([
            'user_id' => 6,
            'thread_id' => 3,
            'comment' => 'Teknologi baru seperti alat pengembangan yang lebih canggih, platform cloud, dan penggunaan otomatisasi akan mempercepat siklus pengembangan perangkat lunak. Hal ini akan memungkinkan pengembang untuk membuat, menguji, dan merilis perangkat lunak dengan lebih cepat.'
        ]);

        Comment::create([
            'user_id' => 2,
            'thread_id' => 3,
            'comment' => 'Integrasi teknologi kolaboratif, seperti platform kerja tim yang lebih baik, akan memungkinkan pengembang dari berbagai lokasi untuk bekerja bersama secara efisien. Hal ini akan meningkatkan komunikasi, koordinasi, dan produktivitas tim pengembangan.'
        ]);


        Comment::create([
            'user_id' => 5,
            'thread_id' => 4,
            'comment' => 'Penggunaan teknologi memungkinkan otomatisasi proses yang sebelumnya dilakukan secara manual. Hal ini dapat mencakup otomatisasi tugas administratif, proses produksi, manajemen rantai pasokan, dan lainnya. Dengan mengotomatiskan proses-proses ini, perusahaan dapat meningkatkan efisiensi, mengurangi kesalahan manusia, dan menghemat waktu serta biaya.'
        ]);

        Comment::create([
            'user_id' => 4,
            'thread_id' => 5,
            'comment' => 'Metodologi Tradisional (Waterfall): Kelebihan: Keterstrukturan yang Jelas: Tahapan pengembangan yang terurut dengan baik, dimulai dari analisis hingga pemeliharaan, membuat proyek terlihat terorganisir. Dokumentasi yang Lengkap: Setiap tahap memiliki dokumen yang terinci, memudahkan dalam pelacakan kemajuan dan pemahaman yang jelas tentang proyek. Cocok untuk Proyek dengan Persyaratan Stabil: Cocok untuk proyek dengan persyaratan yang sudah ditetapkan dengan jelas dari awal. Kekurangan: Kurang Fleksibel: Kurangnya kemampuan untuk menanggapi perubahan persyaratan atau perubahan yang dibutuhkan di tengah jalannya proyek. Kesulitan dalam Beradaptasi: Kesulitan untuk mengubah jalur proyek setelah melewati tahapan tertentu, yang dapat memperburuk biaya jika perubahan dibutuhkan. Tidak Mendukung Iterasi atau Umpan Balik Pengguna: Kurangnya fleksibilitas dalam mengakomodasi umpan balik pengguna selama proses pengembangan.'
        ]);

        Comment::create([
            'user_id' => 3,
            'thread_id' => 6,
            'comment' => 'Kultur yang mendorong kolaborasi cenderung meningkatkan produktivitas. Kolaborasi memungkinkan pertukaran ide, penyelesaian masalah bersama, dan pemecahan tantangan yang kompleks dengan pendekatan tim.'
        ]);

        Comment::create([
            'user_id' => 7,
            'thread_id' => 6,
            'comment' => 'Kolaborasi dapat merangsang kreativitas. Ketika orang-orang dari berbagai latar belakang bekerja bersama, munculnya beragam ide dan perspektif yang dapat menghasilkan solusi yang lebih inovatif.'
        ]);

        Comment::create([
            'user_id' => 1,
            'thread_id' => 6,
            'comment' => 'Kolaborasi membangun hubungan kerja yang kuat dan mendalam antar anggota tim. Ini bisa meningkatkan motivasi, rasa memiliki, dan komitmen terhadap tujuan bersama.'
        ]);

        Comment::create([
            'user_id' => 4,
            'thread_id' => 6,
            'comment' => 'Kurangnya kolaborasi bisa menyebabkan kesulitan dalam koordinasi dan komunikasi antar tim. Hal ini dapat menghambat proyek yang memerlukan ketergantungan dari berbagai departemen atau individu.'
        ]);

        Comment::create([
            'user_id' => 5,
            'thread_id' => 6,
            'comment' => 'Kreativitas dalam kerja individu dapat terjadi, tetapi terbatas pada sudut pandang dan pengalaman individu, yang mungkin kurang beragam dibandingkan dengan kolaborasi tim.'
        ]);

        // like
        $idUser = [1, 2, 3, 4, 5, 6, 7];
        foreach ($idUser as $id) {
            like::create([
                'thread_id' => 1,
                'user_id' => $id
            ]);
        }

        $idUser = [1, 2, 3, 5, 6, 7];
        foreach ($idUser as $id) {
            like::create([
                'thread_id' => 2,
                'user_id' => $id
            ]);
        }

        $idUser = [4, 3, 5, 6];
        foreach ($idUser as $id) {
            like::create([
                'thread_id' => 3,
                'user_id' => $id
            ]);
        }

        $idUser = [3, 5, 6, 4, 7];
        foreach ($idUser as $id) {
            like::create([
                'thread_id' => 4,
                'user_id' => $id
            ]);
        }

        $idUser = [2, 5, 4];
        foreach ($idUser as $id) {
            like::create([
                'thread_id' => 5,
                'user_id' => $id
            ]);
        }
        $idUser = [1, 6, 5, 4, 3, 2];
        foreach ($idUser as $id) {
            like::create([
                'thread_id' => 6,
                'user_id' => $id
            ]);
        }
        $idUser = [4, 7];
        foreach ($idUser as $id) {
            like::create([
                'thread_id' => 7,
                'user_id' => $id
            ]);
        }

        Quiz::create([
            'title' => 'Getting to Know Animals',
            'description' => 'This quiz aims to understand and recognize various aspects of animals, including physical characteristics, behavior, habitat, and their role in the environment and ecosystem.',
            'slug' => encrypt('Getting to Know Animals')
        ]);

        Question::create([
            'question' => 'What is the largest species of shark in the world?',
            'score' => 10,
            'quiz_id' => 1
        ]);

        Answer::create([
            'question_id' => 1,
            'answer' => 'Hammerhead shark'
        ]);
        Answer::create([
            'question_id' => 1,
            'answer' => 'Great white shark'
        ]);
        Answer::create([
            'question_id' => 1,
            'answer' => 'Whale shark',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 1,
            'answer' => 'Tiger shark'
        ]);

        Question::create([
            'question' => 'What is the national bird of the United States?',
            'score' => 10,
            'quiz_id' => 1
        ]);

        Answer::create([
            'question_id' => 2,
            'answer' => 'Bald eagle',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 2,
            'answer' => 'Sparrow'
        ]);
        Answer::create([
            'question_id' => 2,
            'answer' => 'Falcon'
        ]);
        Answer::create([
            'question_id' => 2,
            'answer' => 'Owl'
        ]);

        Question::create([
            'question' => 'Which animal is known for its black and white stripes and is native to Africa?',
            'score' => 10,
            'quiz_id' => 1
        ]);

        Answer::create([
            'question_id' => 3,
            'answer' => 'Zebra',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 3,
            'answer' => 'Cheetah'
        ]);
        Answer::create([
            'question_id' => 3,
            'answer' => 'Giraffe'
        ]);
        Answer::create([
            'question_id' => 3,
            'answer' => 'Kangaroo'
        ]);

        Question::create([
            'question' => 'Which of these animals is a marsupial?',
            'score' => 10,
            'quiz_id' => 1
        ]);

        Answer::create([
            'question_id' => 4,
            'answer' => 'Platypus'
        ]);
        Answer::create([
            'question_id' => 4,
            'answer' => 'Koala',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 4,
            'answer' => 'Hedgehog'
        ]);
        Answer::create([
            'question_id' => 4,
            'answer' => 'Beaver'
        ]);

        Question::create([
            'question' => 'What is the largest land animal on Earth?',
            'score' => 10,
            'quiz_id' => 1
        ]);

        Answer::create([
            'question_id' => 5,
            'answer' => 'Hippopotamus'
        ]);
        Answer::create([
            'question_id' => 5,
            'answer' => 'Giraffe'
        ]);
        Answer::create([
            'question_id' => 5,
            'answer' => 'Elephant',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 5,
            'answer' => 'Rhinoceros'
        ]);

        Question::create([
            'question' => 'What is the smallest breed of dog?',
            'score' => 10,
            'quiz_id' => 1
        ]);

        Answer::create([
            'question_id' => 6,
            'answer' => 'Labrador Retriever'
        ]);
        Answer::create([
            'question_id' => 6,
            'answer' => 'Chihuahua',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 6,
            'answer' => 'Golden Retriever'
        ]);
        Answer::create([
            'question_id' => 6,
            'answer' => 'Dalmatian'
        ]);

        Question::create([
            'question' => 'Which of the following animals is known for its ability to change color to match its surroundings?',
            'score' => 10,
            'quiz_id' => 1
        ]);

        Answer::create([
            'question_id' => 7,
            'answer' => 'Chameleon',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 7,
            'answer' => 'Peacock'
        ]);
        Answer::create([
            'question_id' => 7,
            'answer' => 'Flamingo'
        ]);
        Answer::create([
            'question_id' => 7,
            'answer' => 'Parrot'
        ]);

        Question::create([
            'question' => 'What is the largest species of penguin?',
            'score' => 10,
            'quiz_id' => 1
        ]);

        Answer::create([
            'question_id' => 8,
            'answer' => 'Emperor penguin',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 8,
            'answer' => 'King penguin'
        ]);
        Answer::create([
            'question_id' => 8,
            'answer' => 'Adélie penguin'
        ]);
        Answer::create([
            'question_id' => 8,
            'answer' => 'Little blue penguin'
        ]);

        Question::create([
            'question' => 'Which bird is known for its distinctive hooting sound at night?',
            'score' => 10,
            'quiz_id' => 1
        ]);

        Answer::create([
            'question_id' => 9,
            'answer' => 'Robin'
        ]);
        Answer::create([
            'question_id' => 9,
            'answer' => 'Sparrow'
        ]);
        Answer::create([
            'question_id' => 9,
            'answer' => 'Owl',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 9,
            'answer' => 'Pigeon'
        ]);

        Question::create([
            'question' => "What is the world's fastest land animal?",
            'score' => 10,
            'quiz_id' => 1
        ]);

        Answer::create([
            'question_id' => 10,
            'answer' => 'Cheetah',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 10,
            'answer' => 'Lion'
        ]);
        Answer::create([
            'question_id' => 10,
            'answer' => 'Tiger'
        ]);
        Answer::create([
            'question_id' => 10,
            'answer' => 'Jaguar'
        ]);

        Quiz::create([
            'title' => 'Ekosistem dan Hubungan Antar Organisme',
            'description' => 'Quiz ini dirancang untuk menguji pemahaman Anda tentang konsep ekosistem, rantai makanan, hubungan antar organisme, dan peran ekosistem dalam menjaga keseimbangan lingkungan.',
            'slug' => encrypt('ekosistem-dan-hubungan')
        ]);

        Question::create([
            'question' => "Apa yang disebut dengan tingkat tropisasi dalam sebuah rantai makanan?",
            'score' => 20,
            'quiz_id' => 2
        ]);

        Answer::create([
            'question_id' => 11,
            'answer' => 'Posisi suatu organisme dalam rantai makanan',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 11,
            'answer' => 'Jumlah organisme dalam rantai makanan'
        ]);
        Answer::create([
            'question_id' => 11,
            'answer' => 'Cara organisme mengambil makanan'
        ]);
        Answer::create([
            'question_id' => 11,
            'answer' => 'Tingkat kelimpahan organisme dalam ekosistem'
        ]);

        Question::create([
            'question' => "Organisme apa yang berperan sebagai produsen dalam rantai makanan?",
            'score' => 20,
            'quiz_id' => 2
        ]);

        Answer::create([
            'question_id' => 12,
            'answer' => 'Predator'
        ]);
        Answer::create([
            'question_id' => 12,
            'answer' => 'Konsumen'
        ]);
        Answer::create([
            'question_id' => 12,
            'answer' => 'Heterotrof'
        ]);
        Answer::create([
            'question_id' => 12,
            'answer' => 'Autotrof',
            'correct' => 1
        ]);

        Question::create([
            'question' => "Bagaimana akibatnya jika spesies predator dalam ekosistem mengalami penurunan jumlahnya secara signifikan?",
            'score' => 20,
            'quiz_id' => 2
        ]);

        Answer::create([
            'question_id' => 13,
            'answer' => 'Jumlah spesies mangsa meningkat'
        ]);
        Answer::create([
            'question_id' => 13,
            'answer' => 'Keseimbangan ekosistem terganggu',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 13,
            'answer' => 'Penurunan jumlah spesies mangsa'
        ]);
        Answer::create([
            'question_id' => 13,
            'answer' => 'Kualitas air dan udara membaik'
        ]);

        Question::create([
            'question' => "Apa yang disebut dengan hubungan simbiosis antara dua spesies di mana salah satu spesies diuntungkan dan yang lainnya tidak terpengaruh?",
            'score' => 20,
            'quiz_id' => 2
        ]);

        Answer::create([
            'question_id' => 14,
            'answer' => 'Mutualisme'
        ]);
        Answer::create([
            'question_id' => 14,
            'answer' => 'Parasitisme'
        ]);
        Answer::create([
            'question_id' => 14,
            'answer' => 'Komensalisme',
            'correct' => 1
        ]);
        Answer::create([
            'question_id' => 14,
            'answer' => 'Predasi'
        ]);

        Question::create([
            'question' => "Apa yang disebut dengan tingkat trofik tertinggi dalam rantai makanan?",
            'score' => 20,
            'quiz_id' => 2
        ]);

        Answer::create([
            'question_id' => 15,
            'answer' => 'Produsen'
        ]);
        Answer::create([
            'question_id' => 15,
            'answer' => 'Konsumen tingkat pertama'
        ]);
        Answer::create([
            'question_id' => 15,
            'answer' => 'Konsumen tingkat kedua'
        ]);
        Answer::create([
            'question_id' => 15,
            'answer' => 'Konsumen tingkat ketiga',
            'correct' => 1
        ]);
    }
}
