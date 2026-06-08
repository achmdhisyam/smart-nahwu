# Rencana Pengembangan Fitur Smart Nahwu

Dokumen ini merangkum gagasan dan rancangan fitur potensial untuk pengembangan aplikasi **Smart Nahwu** ke depan agar menjadi media pembelajaran tata bahasa Arab (*Nahwu*) yang lebih interaktif, menyenangkan, dan komprehensif.

---

## 1. Gamifikasi & Motivasi Belajar

### 🏆 Papan Skor (Leaderboard)
* **Deskripsi**: Sistem pemeringkatan global antar santri/pengguna.
* **Mekanisme**: Poin dihitung berdasarkan skor kuis, kecepatan menjawab, dan penyelesaian bab belajar. 
* **Tujuan**: Mendorong motivasi belajar yang kompetitif secara sehat.

### 🗺️ Mode Petualangan (Peta Belajar RPG)
* **Deskripsi**: Transformasi visual peta belajar menjadi pulau petualangan bertema fantasi islami.
* **Mekanisme**: Setiap bab direpresentasikan sebagai sebuah wilayah atau pos. Menyelesaikan kuis dengan nilai sempurna membuka *item* koleksi (seperti pedang/perisai pusaka) yang dapat dipajang di profil santri.

### 📅 Tantangan Harian (Daily Challenge) & Streak
* **Deskripsi**: Kuis acak berdurasi singkat yang berganti setiap harinya.
* **Mekanisme**: Pengguna ditantang menjawab 3-5 pertanyaan acak per hari untuk mempertahankan *daily streak*. Bonus poin akan diberikan bagi pengguna yang mempertahankan ritme belajar harian.

---

## 2. Fitur Interaktif & Latihan Mandiri

### 🧩 Game Susun I'rab (Drag & Drop Builder)
* **Deskripsi**: Latihan membedah kedudukan kata secara visual.
* **Mekanisme**: Pengguna disajikan satu kalimat arab penuh (misal: `قَامَ زَيْدٌ`). Mereka harus menggeser (*drag*) kartu status i'rab (seperti *Fi'il Madhi*, *Fa'il*, *Mubtada'*, dsb.) ke posisi kata arab yang tepat.

### 🎮 Kuis Duel (1 vs 1 Real-time Battle)
* **Deskripsi**: Kompetisi pengerjaan kuis nahwu secara langsung antar santri.
* **Mekanisme**: Dua pengguna dipertemukan di arena kuis secara acak atau via undangan kode. Keduanya menjawab paket soal yang sama secara bersamaan. Pemenang dinilai dari akurasi jawaban dan waktu respons tercepat.

### 🧪 Kalkulator Amil (Nawasih Simulator)
* **Deskripsi**: Alat peraga visual untuk memahami dampak masuknya Amil Nawasih.
* **Mekanisme**: Pengguna mengetik kalimat dasar (misal: `زَيْدٌ قَائِمٌ`), lalu memilih partikel amil (seperti `كَانَ` atau `إِنَّ`). Simulator akan otomatis mengubah harakat akhir secara dinamis menjadi `كَانَ زَيْدٌ قَائِمًا` atau `إِنَّ زَيْدًا قَائِمٌ` lengkap dengan penjelasannya.

---

## 3. Asisten AI & Pembelajaran Cerdas

### 💬 Tanya AI Ustadz (Nahwu Chatbot)
* **Deskripsi**: Chatbot interaktif berbasis kecerdasan buatan (Gemini AI).
* **Mekanisme**: Santri dapat mengajukan pertanyaan bebas seputar kaidah bahasa Arab, nahu, atau i'rab. AI akan merespons dengan bahasa yang santun khas ustadz serta menyertakan rujukan bab dari Kitab Matan Al-Ajurrumiyyah.

### 🔍 Detektor Salah Harakat (Harakat Error Checker)
* **Deskripsi**: Alat bantu evaluasi penulisan harakat mandiri.
* **Mekanisme**: Pengguna memasukkan kalimat berharakat, dan sistem AI akan memvalidasi apakah harakat tersebut sesuai dengan aturan Nahwu. Jika terdeteksi salah harakat (misal: `جَاءَ زَيْدًا`), sistem akan menandainya dan menjelaskan aturan yang benar (harusnya `زَيْدٌ` karena ia berkedudukan sebagai *Fa'il*).

---

## 4. Evaluasi Tingkat Lanjut & Praktik Kitab

### 📖 Latihan Baca Kitab Gundul (Bare Text Practice)
* **Deskripsi**: Latihan membaca paragraf arab tanpa harakat (*kitab kuning/gundul*).
* **Mekanisme**: Sistem menampilkan teks gundul. Pengguna diminta mengklik kata tertentu dan memilih harakat akhir yang tepat dari pilihan ganda yang disajikan berdasarkan aturan sintaksis kalimat tersebut.

### 🕌 Klinik I'rab Al-Qur'an (Quranic Grammar Explorer)
* **Deskripsi**: Modul khusus membedah i'rab dari ayat-ayat suci Al-Qur'an.
* **Mekanisme**: Menyediakan daftar surat/ayat pilihan (seperti Juz Amma). Pengguna bisa mengklik per kata di dalam ayat tersebut untuk melihat status i'rab, tanda i'rab, dan alasan tata bahasanya secara visual.

### 📜 Ujian Akhir & Syahadah Digital
* **Deskripsi**: Ujian kelulusan akhir untuk mengukur penguasaan total Kitab Al-Ajurrumiyyah.
* **Mekanisme**: Ujian terdiri atas 50 soal acak dari seluruh bab. Jika santri berhasil lulus dengan nilai batas tertentu (misal > 80%), sistem akan men-generate sertifikat kelulusan digital (Syahadah) premium berformat PDF.

---

## 5. Produktivitas & Manajemen Pembelajaran

### 📖 Kamus Istilah Nahwu (Glosarium)
* **Deskripsi**: Modul ensiklopedia mini yang memuat daftar istilah-istilah Nahwu.
* **Mekanisme**: Fitur pencarian kata kunci istilah (seperti *Isim*, *Fi'il*, *Harf*, *Mubtada'*, *Khabar*, dsb.) yang disertai dengan definisi ringkas, contoh, serta rujukan bab terkait.

### 📊 Rapor Santri & Analitik Belajar
* **Deskripsi**: Grafik analisis performa belajar pribadi.
* **Mekanisme**: Menyajikan visualisasi waktu belajar, rata-rata skor kuis, dan data statistik mengenai bab-bab yang sudah dikuasai serta bab-bab yang masih lemah (sering salah menjawab kuis).

### 🔖 Penanda Materi (Bookmark/Favorit)
* **Deskripsi**: Menyimpan bagian materi tertentu untuk dipelajari kembali.
* **Mekanisme**: Tombol bookmark pada setiap definisi, kaidah gramatika, atau contoh kalimat agar santri bisa mengaksesnya secara cepat melalui menu dashboard profil mereka.

### 🏫 Sistem Kelas & Dashboard Ustadz
* **Deskripsi**: Fitur manajemen kelas untuk pengajar di pesantren atau sekolah.
* **Mekanisme**: Ustadz dapat membuat kelas virtual, mengundang santri, memberikan tugas membaca bab tertentu atau mengerjakan kuis tertentu, serta memantau rapor dan nilai rata-rata kelas secara terpusat.

### 🎙️ Perekam Suara & Setoran Hafalan
* **Deskripsi**: Fitur setoran hafalan nadhom/matan secara online.
* **Mekanisme**: Santri merekam hafalan bait matan Al-Ajurrumiyyah mereka langsung di browser. Rekaman suara tersebut dikirimkan ke dashboard Ustadz untuk dikoreksi, diberi umpan balik, dan diberikan penilaian kelancaran.
