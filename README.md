## How To Install this Project

- Persiapan
1. Memiliki CLI/Command Line Interface berupa Command Prompt (CMD) atau Power Shell atau Git Bash (selanjutnya kita sebut terminal).
2. Memiliki Web Server (misal XAMPP) dengan PHP minimal versi 7.3.
3. Composer telah ter-install, cek dengan perintah composer -V melalui terminal.
4. NodeJS sudah ter-install, cek dengan perintah npm -v melalui terminal.
5. Memiliki koneksi internet (untuk proses installasi).

Langkah-Langkah
1. Download Source Code dari repo Github laravel-ecommerce dalam bentuk Zip.
2. Extract file zip (source code) ke dalam direktori htdocs pada XAMPP, misal htdocs/laravel-ecommerce.
3. Melalui terminal, cd ke direktori laravel-ecommerce.
4. (Sesuai petunjuk installasi) Pada terminal, berikan perintah <b>composer install</b>. Ini yang perlu koneksi internet.
5. Composer akan menginstall dependency paket dari source code tersebut hingga selesai.
6. Pada terminal, berikan perintah <b>npm install && npm run dev</b> untuk compile file-file asset / javascript.
7. Jalankan perintah php artisan, untuk menguji apakah perintah artisan Laravel bekerja.
8. Buat database baru (kosong) pada mysql (via phpmyadmin) dengan nama <b>laravel-ecommerce</b>.
9. Duplikat file .env.example, lalu rename menjadi .env.
10. Kembali ke terminal, php artisan key:generate.
11. Setting koneksi database di file .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
    <br>DB_CONNECTION=mysql
    <br>DB_HOST=localhost
    <br>DB_PORT=3306
    <br>DB_DATABASE=laravel-ecommerce
    <br>DB_USERNAME=root
    <br>DB_PASSWORD=
12. Setting QUEUE_CONNECTION agar bisa menjalankan proses queue menjadi QUEUE_CONNECTION=database.
13. Setting smtp email yang digunakan untuk mengirim password registrasi user dan resi order customer. Jangan lupa setting <b>Less secure app access</b> menjadi <b>On</b> agar bisa mengirimkan email. Contohnya smtp gmail seperti berikut:
    <br>MAIL_DRIVER=smtp
    <br>MAIL_HOST=smtp.gmail.com
    <br>MAIL_PORT=587
    <br>MAIL_USERNAME=alamat email kamu
    <br>MAIL_PASSWORD=password email kamu
    <br>MAIL_ENCRYPTION=tls
15. Setting RAJAONGKIRAPI_KEY dedengan mendaftar terlebih dahulu di https://rajaongkirapi.com:
    <br>RAJAONGKIRAPI_KEY=TOKEN_RUANG_API_KAMU
16. Jalankan perintah <b>php artisan migrate</b>. Cek di phpmyadmin, seharusnya tabel sudah muncul.
17. Jalankan perintah <b>php artisan db:seed</b> untuk mengisi tabel users, provinces, cities, districts. Berikut email dan password untuk login admin pada http://localhost:8000/login
    <br>EMAIL = vicktor@admin.com
    <br>PASSWORD = 123456
18. Jalankan perintah <b>php artisan storage:link</b>    
19. Setelah selesai, Jalankan perintah <b>php artisan serve</b> maka dapat diakses dengan http://localhost:8000/
20. Login Customer dapat diakses dengan http://localhost:8000/member/login
21. Register Customer dapat diakses dengan http://localhost:8000/member/register
22. Ketika sudah import excel pada saat hendak mass upload, jalankan perintah <b>php artisan queue:work</b> agar data diimport ke table products.

SEKIAN PENJELASAN DARI SAYA,TERIMAKASIH. Copyright by <a href="https://github.com/vldcreation"> Kel 2 Kepal </a> </b>
