# CI-HMVC-Base
CI-HMVC-Base merupakan base codeigniter yang di integrasikan dengan modular extension dari [WireDesignz Modular Extension](https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc) agar file lebih terogranisir dan maintable. Base ini juga sudah terintegrasi dengan ion_auth dan beberapa library lainnya.

# Persiapan Base

Untuk menggunakan base ini dapat dimulai dengan menyesuaikan konfigurasi di file **configuration.php**. Untuk lebih lengkapnya contact **muh.dickyhidayat@gmail.com**.
1. Pertama - tama Buka file **configuration.php** lalu lakukan beberapa pengaturan seperti ini:
    * Masukkan base url ```var $_site_url = 'http://contoh-url/'```
	* Jika aplikasi dalam sub folder seperti **localhost/ci-hmvc/** maka property ini diisi sesuai dengan nama sub folder, jika tidak dalam sub folder makan kosong kan saja ```var $_sub_path = 'ci-hmvc'```
    * Masukkan host database ```var $_hostname = ''```
    * Masukkan username database ```var $_database_user = ''```
	* Masukkan password database ```var $_database_password = ''```
	* Masukkan nama database ```var $_database_name = ''```
3. Install semua package require yang sudah ada dalam file **composer.json**. Ini memerlukan composer untuk melakukan penginstalan.
4. Setelah package yang dibutuhkan sudah terinstall maka base sudah siap digunakan.

Jika menemukan kendala dalam mempersiapkan base silahkan kontak email **muh.dickyhidayat@gmail.com** untuk lebih detailnya.