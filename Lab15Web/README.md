# Lab15Web
## Ainun Dwi Permana (312310013)

### Tugas mengerjakan latihan pada module dua belas Pemrograman Web

#### Membuat Tabel User
```sh
CREATE TABLE user (
id INT(11) auto_increment,
username VARCHAR(200) NOT NULL,
useremail VARCHAR(200),
userpassword VARCHAR(200),
PRIMARY KEY(id)
);
```

#### Membuat Model User
- Selanjutnya adalah membuat Model untuk memproses data Login. Buat file baru pada direktori app/Models dengan nama UserModel.php
```sh
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'useremail', 'userpassword'];
}

```

#### Membuat Controller User
- Buat Controller baru dengan nama User.php pada direktori app/Controllers. Kemudian tambahkan method index() untuk menampilkan daftar user, dan method login() untuk proses login.
```sh
<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function login()
    {
        helper(['form']);
        $session = session();
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$email) {
            return view('user/login');
        }

        $login = $model->where('useremail', $email)->first();
        if ($login) {
            $pass = $login['userpassword'];

            if (password_verify($password, $pass)) {
                $session->set([
                    'user_id' => $login['id'],
                    'user_name' => $login['username'],
                    'user_email' => $login['useremail'],
                    'logged_in' => true,
                ]);

                return redirect()->to('/admin/artikel');
            } else {
                $session->setFlashdata("flash_msg", "Password salah.");
                return redirect()->to('/user/login');
            }
        } else {
            $session->setFlashdata("flash_msg", "Email tidak terdaftar.");
            return redirect()->to('/user/login');
        }
    }
}
### Membuat View Login
Buat direktori baru dengan nama user pada direktori app/views, kemudian buat file baru dengan nama login.php.
```
```sh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('/login.css'); ?>">
    
</head>
<body>
    <div id="login-wrapper" class="container mt-5">
        <h1 class="text-center">Sign In</h1>

        <?php if (session()->getFlashdata('flash_msg')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('flash_msg') ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="InputForEmail" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="InputForEmail" value="<?= set_value('email') ?>" required>
            </div>

            <div class="mb-3">
                <label for="InputForPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="InputForPassword" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS (Optional, hanya jika butuh interaksi tambahan) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

```

### Membuat css Login
```sh
/* Style untuk center form */
body {
    background-color: #f5f5f5; /* Warna background halaman */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
}

#login-wrapper {
    background-color: white;
    /*Warnakotakcontainer*/padding: 20px;
    border-radius: 8px;
    /*Membuatsudutlebihmembulat*/box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    /*Efekbayangansupayatimbul*/width: 350px;
    /*Aturlebarkotak*/text-align: center;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
}

h1 {
    color: #333;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 10px;
    background: gray;
    border: none;
    border-radius: 5px;
    color: white;
    cursor: pointer;
}

button:hover {
    background: darkgray;
}

.flash-message {
    color: red;
    font-size: 14px;
}

```

#### Membuat Database Seeder
Database seeder digunakan untuk membuat data dummy. Untuk keperluan ujicoba modul login, kita perlu memasukkan data user dan password kedaalam database. Untuk itu buat database seeder untuk tabel user. Buka CLI, kemudian tulis perintah berikut:
```sh
php spark make:seeder UserSeeder
```

- Selanjutnya, buka file UserSeeder.php yang berada di lokasi direktori /app/Database/Seeds/UserSeeder.php kemudian isi dengan kode berikut:
```sh
<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin',
            'useremail' => 'admin@email.com',
            'userpassword' => password_hash('admin123', PASSWORD_DEFAULT),
        ];

        // Insert data ke tabel user
        $this->db->table('user')->insert($data);
    }
}

```

- Selanjutnya buka kembali CLI dan ketik perintah berikut:
```sh
php spark db:seed UserSeeder
```

#### Uji Coba Login
- Selanjutnya buka url http://localhost:8080/user/login seperti berikut:
![alt text](https://github.com/Ainun27/Lab13Web/blob/main/tugas12/1.png?raw=true)

#### Menambahkan Auth Filter
- Selanjutnya membuat filer untuk halaman admin. Buat file baru dengan nama Auth.php pada direktori app/Filters.
```sh
<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diubah jika tidak ada aksi setelah request
    }
}
```
- Selanjutnya buka file app/Config/Filters.php tambahkan kode berikut:
```sh
'auth' => App\Filters\Auth::class
```

- Selanjutnya buka file app/Config/Routes.php dan sesuaikan kodenya.
```sh
$routes->group('admin', ['filter' => 'auth'], function($routes) {
```

#### Percobaan Akses Menu Admin
- Buka url dengan alamat http://localhost:8080/admin/artikel ketika alamat tersebut diaksesmaka, akan dimuculkan halaman login.
![alt text](https://github.com/Ainun27/Lab13Web/blob/main/tugas12/2.png?raw=true)
