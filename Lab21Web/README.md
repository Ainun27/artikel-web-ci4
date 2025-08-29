# Lab21Web

## Ainun Dwi Permana (312310013)

### Tugas mengerjakan latihan pada module dua belas Pemrograman Web
### Persiapan
- Untuk memulai penggunaan framework Vuejs, dapat dialkukan dengan menggunakan npm, atau bisa juga dengan cara manual. Untuk praktikum kali ini kita akan gunakan cara manual. Yang diperlukan adalah library Vuejs, Axios untuk melakukan call API REST. Menggunakan CDN.

### Menampilkan data
- File index.html
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Frontend Vuejs</title>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div id="app">
<h1>Daftar Artikel</h1>
<table>
<thead>
<tr>
<th>ID</th>
<th>Judul</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
<tr v-for="(row, index) in artikel">
<td class="center-text">{{ row.id }}</td>
<td>{{ row.judul }}</td>
<td>{{ statusText(row.status) }}</td>
<td class="center-text">
<a href="#" @click="edit(row)">Edit</a>
<a href="#" @click="hapus(index, row.id)">Hapus</a>
</td>
</tr>
</tbody>
</table>
</div>
<script src="assets/js/app.js"></script>
</body>
</html>
```

### File apps.js
```ssh
const { createApp } = Vue
// tentukan lokasi API REST End Point
const apiUrl = 'http://localhost:8080'
createApp({
data() {
return {
artikel: ''
}
},
mounted() {
this.loadData()
},
methods: {
loadData() {
axios.get(apiUrl + '/post')
.then(response => {
this.artikel = response.data.artikel
})
.catch(error => console.log(error))
},
statusText(status) {
if (!status) return ''
return status == 1 ? 'Publish' : 'Draft'
}
},
}).mount('#app')
```

### Hasil outpunya.
![Screenshot 2025-06-04 112508](https://github.com/user-attachments/assets/fc21bf09-7ddb-4610-af6c-9f40444bf916)

### Form Tambah dan Ubah Data
- Pada file index,html sispkan kode berikut sebelum table data.
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Frontend Vuejs</title>
  <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
  <div id="app">
    <h1>Daftar Artikel</h1>
    <button id="btn-tambah" @click="tambah">Tambah Data</button>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Judul</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in artikel" :key="row.id">
          <td class="center-text">{{ row.id }}</td>
          <td>{{ row.judul }}</td>
          <td>{{ statusText(row.status) }}</td>
          <td class="center-text">
            <a href="#" @click.prevent="edit(row)">Edit</a> |
            <a href="#" @click.prevent="hapus(index, row.id)">Hapus</a>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="modal" v-if="showForm">
      <div class="modal-content">
        <span class="close" @click="showForm = false">&times;</span>
        <form id="form-data" @submit.prevent="saveData">
          <h3 id="form-title">{{ formTitle }}</h3>

          <input type="text" name="judul" id="judul" v-model="formData.judul" placeholder="Judul" required />
          <textarea name="isi" id="isi" rows="10" v-model="formData.isi" placeholder="Isi artikel..."></textarea>
          <select name="status" id="status" v-model="formData.status">
            <option v-for="option in statusOptions" :value="option.value">
              {{ option.text }}
            </option>
          </select>

          <input type="hidden" id="id" v-model="formData.id" />

          <button type="submit" id="btnSimpan">Simpan</button>
          <button type="button" @click="showForm = false">Batal</button>
        </form>
      </div>
    </div>
  </div>

  <script src="assets/js/app.js"></script>
</body>
</html>
```

### File app.js lengkapi kodenya.
```ssh
const { createApp } = Vue;
// Tentukan lokasi API REST End Point
const apiUrl = 'http://localhost:8080';

createApp({
  data() {
    return {
      artikel: [],
      formData: {
        id: null,
        judul: '',
        isi: '',
        status: 0,
      },
      showForm: false,
      formTitle: 'Tambah Data',
      statusOptions: [
        { text: 'Draft', value: 0 },
        { text: 'Publish', value: 1 },
      ],
    };
  },
  mounted() {
    this.loadData();
  },
  methods: {
    loadData() {
      axios.get(apiUrl + '/post')
        .then(response => {
          this.artikel = response.data.artikel;
        })
        .catch(error => console.log(error));
    },
    tambah() {
      this.showForm = true;
      this.formTitle = 'Tambah Data';
      this.formData = {
        id: null,
        judul: '',
        isi: '',
        status: 0,
      };
    },
    edit(data) {
      this.showForm = true;
      this.formTitle = 'Ubah Data';
      this.formData = {
        id: data.id,
        judul: data.judul,
        isi: data.isi,
        status: data.status,
      };
    },
    hapus(index, id) {
      if (confirm('Yakin menghapus data?')) {
        axios.delete(apiUrl + '/post/' + id)
          .then(() => {
            this.artikel.splice(index, 1);
          })
          .catch(error => console.log(error));
      }
    },
    saveData() {
      if (this.formData.id) {
        // Update existing data
        axios.put(apiUrl + '/post/' + this.formData.id, this.formData)
          .then(() => {
            this.loadData();
            this.showForm = false;
          })
          .catch(error => console.log(error));
      } else {
        // Add new data
        axios.post(apiUrl + '/post', this.formData)
          .then(() => {
            this.loadData();
            this.showForm = false;
          })
          .catch(error => console.log(error));
      }
      // Reset form data setelah submit
      this.formData = {
        id: null,
        judul: '',
        isi: '',
        status: 0,
      };
    },
    statusText(status) {
      if (status === 1) return 'Publish';
      return 'Draft';
    },
  },
}).mount('#app');
```

### File style.css
```ssh
#app {
  margin: 20px auto;
  width: 900px;
  font-family: Arial, sans-serif;
  color: #333;
}

button {
  cursor: pointer;
  border: none;
  border-radius: 4px;
  padding: 10px 20px;
  background-color: #3152d6;
  color: white;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #243a99;
}

#btn-tambah {
  margin: 15px 0;
}

table {
  width: 100%;
  min-width: 700px;
  border-collapse: collapse;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

th {
  padding: 12px;
  background-color: #5778ff;
  color: #ffffff;
  text-align: left;
}

td {
  padding: 10px;
  border-bottom: 1px solid #eff1ff;
}

tr:nth-child(odd) {
  background-color: #f7f9ff;
}

.center-text {
  text-align: center;
}

td a {
  margin: 0 5px;
  color: #3152d6;
  text-decoration: none;
  font-weight: 600;
}

td a:hover {
  text-decoration: underline;
}

/* Form & Modal */

#form-data {
  width: 100%;
  max-width: 600px;
  box-sizing: border-box;
}

form input,
form textarea,
form select {
  width: 100%;
  padding: 10px 12px;
  margin-bottom: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  box-sizing: border-box;
  transition: border-color 0.3s ease;
}

form select {
  height: 40px;
  background-color: #fff;
  appearance: none;
  background-image: url("data:image/svg+xml;utf8,<svg fill='black' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 16px 16px;
}

form input:focus,
form select:focus,
form textarea:focus {
  border-color: #3152d6;
  outline: none;
}

form button {
  padding: 10px 20px;
  margin-right: 10px;
  background-color: #3152d6;
  color: white;
  border-radius: 4px;
  border: none;
  font-size: 15px;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

form button:hover {
  background-color: #243a99;
}

.modal {
  display: block;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fff;
  margin: 8% auto;
  padding: 20px 30px;
  border-radius: 8px;
  width: 90%;
  max-width: 600px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
  position: relative;
}

.close {
  color: #aaa;
  position: absolute;
  top: 15px;
  right: 20px;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
  transition: color 0.3s ease;
}

.close:hover {
  color: #000;
}

h3#form-title {
  margin-top: 0;
  margin-bottom: 15px;
  font-weight: 700;
  color: #3152d6;
}
```

### Hasil outpunya.
![Screenshot 2025-06-04 113106](https://github.com/user-attachments/assets/63f76aaf-ff05-4b58-92a0-99751e5ebeb3)
![Screenshot 2025-06-04 113122](https://github.com/user-attachments/assets/56852afe-0f84-4aec-8629-a5b2747f33a2)

