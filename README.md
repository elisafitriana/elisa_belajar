# Helpdesk

Helpdesk adalah aplikasi yang digunakan untuk menangani dan mengelola tiket dukungan dari pelanggan. Fitur utama dari aplikasi ini meliputi:

## Features

- **Pengajuan tiket**: Pelanggan dapat mengajukan tiket dukungan dengan mengisi form yang disediakan.
- **Kategorisasi tiket**: Tiket dapat dikelompokkan berdasarkan kategori, seperti perangkat keras atau perangkat lunak.
- **Komentar pada tiket**: Pengguna dapat berkomunikasi satu sama lain melalui komentar pada tiket yang diterima.
- **Kirim email jika tiket selesai dikerjakan**: Pengguna dapat informasi lewat email jika tiket sudah di kerjakan.
- **Export Laporan tiket**: Laporan dapat dihasilkan untuk melihat statistik tiket yang diterima, seperti jumlah tiket yang diterima dalam jangka waktu tertentu.

Aplikasi ini ditujukan untuk memudahkan tim dukungan dalam mengelola tiket dukungan dari pelanggan dan membuat proses dukungan lebih efisien.

## Requirements

- PHP 8.0 or higher
- Laravel 9.0 or higher
- MySQL or MariaDB database

## Installation

1. Clone the repository: `git clone https://github.com/your-username/laravel.git`
2. Navigate to the project directory: `cd laravel`
3. Install dependencies: `composer install`
4. Create a copy of the .env.example file and name it .env: `cp .env.example .env`
5. Generate an app key: `php artisan key:generate`
6. Create a database and update the .env file with the database connection details
7. Run the migration and seed scripts to set up the database: `php artisan migrate --seed`
8. Start the development server: `php artisan serve`

