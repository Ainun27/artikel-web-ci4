# Lab14Web/4
## Ainun Dwi Permana (312310013)

Tugas mengerjakan latihan pada module dua Pemrograman Web
       

#### Persiapan membuat dokumen HTML dengan nama file lab4_box.html seperti berikut.
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Box Element</title>
</head>
<body>
    <header>
    <h1>Box Element</h1>
    </header>
</body>
</html>

```

#### Membuat Box Element
- Kemudian tambahkan kode untuk membuat box element dengan tag div seperti berikut
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Box Element</title>
</head>
<body>
    <header>
    <h1>Box Element</h1>
    </header>

    <section>
        <div class="div1">Div 1</div>
        <div class="div2">Div 2</div>
        <div class="div3">Div 3</div> 
    </section>
</body>
</html>

```

#### CSS Float Property
- Selanjutnya tambahkan deklarasi CSS pada head untuk membuat float element, seperti berikut
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Box Element</title>
    <style>
        div {
        float:left;
        padding: 10px; 
        }
        .div1 {
        background: red;
        }
        .div2 {
        background: yellow;
        }
        .div3 {
        background: green;
        }
    </style>
</head>
<body>
    <header>
    <h1>Box Element</h1>
    </header>

    <section>
        <div class="div1">Div 1</div>
        <div class="div2">Div 2</div>
        <div class="div3">Div 3</div> 
    </section>
</body>
</html>

```
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/1.png?raw=true)

#### Mengatur Clearfix Element
- Clearfix digunakan untuk mengatur element setelah float element. Property clear digunakan untuk mengaturnya.
- Tambahkan element div lainnya seteleah div3 seperti berikut
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Box Element</title>
    <style>
        div {
        float:left;
        padding: 10px; 
        }
        .div1 {
        background: red;
        }
        .div2 {
        background: yellow;
        }
        .div3 {
        background: green;
        }
    </style>
</head>
<body>
    <header>
    <h1>Box Element</h1>
    </header>

    <section>
        <div class="div1">Div 1</div>
        <div class="div2">Div 2</div>
        <div class="div3">Div 3</div> 
        <div class="div4">Div 4</div> 
    </section>
</body>
</html>

```

- Kemudian atur property clear pada CSS, seperti berikut.
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Box Element</title>
    <style>
        div {
        float:left;
        padding: 10px; 
        }
        .div1 {
        background: red;
        }
        .div2 {
        background: yellow;
        }
        .div3 {
        background: green;
        }
        .div4 {
        background-color: blue;
        clear: left;
        float: none;
        }
    </style>
</head>
<body>
    <header>
    <h1>Box Element</h1>
    </header>

    <section>
        <div class="div1">Div 1</div>
        <div class="div2">Div 2</div>
        <div class="div3">Div 3</div> 
        <div class="div4">Div 4</div> 
    </section>
</body>
</html>
```
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/2.png?raw=true)

- Lakukan eksperimen terhadap penggunaan property clear dengan nilai lainnya (left, both, right),  dan amati perubahannya.

```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Box Element</title>
    <style>
        div {
        float:left;
        padding: 10px; 
        }
        .div1 {
        background: red;
        }
        .div2 {
        background: yellow;
        }
        .div3 {
        background: green;
        }
        .div4 {
        background-color: blue;
        clear: left;
        float: none;
        }
        .div5 {
        background-color: blue;
        clear: both;
        float: none;
        }
        .div6 {
        background-color: blue;
        clear: right;
        float: none;
        }
    </style>
</head>
<body>
    <header>
    <h1>Box Element</h1>
    </header>

    <section>
        <div class="div1">Div 1</div>
        <div class="div2">Div 2</div>
        <div class="div3">Div 3</div> 
        <div class="div4">Div 4</div> 
        <div class="div5">Div 5</div> 
        <div class="div6">Div 6</div> 
    </section>
</body>
</html>
```
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/k.png?raw=true)

#### Membuat Layout Sederhana
- Kita akan membuat layout web sederhana seperti gambar berikut.
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/i.png?raw=true)

- Buat folder baru dengan nama lab4_layout, kemudian buatlah file baru didalamnya dengan nama home.html, dan file css dengan nama style.css.

```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Sederhana</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="container">
    
    </div>
</body>
</html>
```
- Kemudian buat kerangka layout dengan semantics element seperti berikut
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/j.png?raw=true)

- Kemudian tulis kode berikut
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Sederhana</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="container"></div>
    <header>
        <h1>Layout Sederhana</h1>
    </header>
    <nav>
        <a href="home.html" class="active">Home</a>
        <a href="artikel.html">Artikel</a>
        <a href="about.html">About</a>
        <a href="kontak.html">Kontak</a>
    </nav>
    <section id="hero"></section>
    <section id="wrapper">
        <section id="main"></section>
        <aside id="sidebar"></aside>
    </section>
    <footer>
        <p>&copy; 2021 - Universitas Pelita Bangsa</p>
    </footer>
</body>
</html>
```

- Kemudian buka browser dan lihat hasilnya.
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/3.png?raw=true)

- Kemudian tambahkan kode CSS untuk membuat layoutnya
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Sederhana</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&display=swap" rel="stylesheet">
</head>
<body>
    <div id="container"></div>
    <header>
        <h1>Layout Sederhana</h1>
    </header>
    <nav>
        <a href="home.html" class="active">Home</a>
        <a href="artikel.html">Artikel</a>
        <a href="about.html">About</a>
        <a href="kontak.html">Kontak</a>
    </nav>
    <section id="hero"></section>
    <section id="wrapper">
        <section id="main"></section>
        <aside id="sidebar"></aside>
    </section>
    <footer>
        <p>&copy; 2021 - Universitas Pelita Bangsa</p>
    </footer>
</body>
</html>
```

- Kemudian lihat hasilnya pada browser.
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/4.png?raw=true)


#### Membuat Navigasi
- Kemudian selanjutnya mengatur navigasi.
```ssh
* {
    margin: 0;
    padding: 0;
}
body {
    line-height:1;
    font-size:100%;
    font-family:'Open Sans', sans-serif;
    color:#5a5a5a;
}
#container {
    width: 980px;
    margin: 0 auto;
    box-shadow: 0 0 1em #cccccc;
}
/* header */
header {
    padding: 20px;
}
header h1 {
    margin: 20px 10px;
    color: #b5b5b5;
}
```

```ssh
* {
    margin: 0;
    padding: 0;
}
body {
    line-height:1;
    font-size:100%;
    font-family:'Open Sans', sans-serif;
    color:#5a5a5a;
}
#container {
    width: 980px;
    margin: 0 auto;
    box-shadow: 0 0 1em #cccccc;
}
/* header */
header {
    padding: 20px;
}
header h1 {
    margin: 20px 10px;
    color: #b5b5b5;
}
/* navigasi */
nav {
    display: block;
    background-color: #1f5faa;
}
nav a {
    padding: 15px 30px;
    display: inline-block;
    color: #ffffff;
    font-size: 14px;
    text-decoration: none;
    font-weight: bold;
}
nav a.active,
nav a:hover {
    background-color: #2b83ea;
}
```
- Kemudian lihat hasilnya.
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/5.png?raw=true)

#### Membuat Hero Panel.
- Selanjutnya membuat hero panel. Tambahkan kode HTML dan CSS seperti berikut
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Sederhana</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&display=swap" rel="stylesheet">
</head>
<body>
    <div id="container"></div>
    <header>
        <h1>Layout Sederhana</h1>
    </header>
    <nav>
        <a href="home.html" class="active">Home</a>
        <a href="artikel.html">Artikel</a>
        <a href="about.html">About</a>
        <a href="kontak.html">Kontak</a>
    </nav>
    <section id="hero"></section>
    <section id="wrapper">
        <section id="main"></section>
        <aside id="sidebar"></aside>
    </section>
    <section id="hero">
        <h1>Hello World!</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum lorem 
        elit, iaculis innisl volutpat, malesuada tincidunt arcu. Proin in leo fringilla, 
        vestibulum mi porta, faucibus felis. Integer pharetra est nunc, nec pretium nunc 
        pretium ac.</p>
        <a href="home.html" class="btn btn-large">Learn more &raquo;</a>
    </section>
    <footer>
        <p>&copy; 2021 - Universitas Pelita Bangsa</p>
    </footer>
</body>
</html>
```

```ssh
* {
    margin: 0;
    padding: 0;
}
body {
    line-height:1;
    font-size:100%;
    font-family:'Open Sans', sans-serif;
    color:#5a5a5a;
}
#container {
    width: 980px;
    margin: 0 auto;
    box-shadow: 0 0 1em #cccccc;
}
/* header */
header {
    padding: 20px;
}
header h1 {
    margin: 20px 10px;
    color: #b5b5b5;
}
/* navigasi */
nav {
    display: block;
    background-color: #1f5faa;
}
nav a {
    padding: 15px 30px;
    display: inline-block;
    color: #ffffff;
    font-size: 14px;
    text-decoration: none;
    font-weight: bold;
}
nav a.active,
nav a:hover {
    background-color: #2b83ea;
}

/* Hero Panel */
#hero {
    background-color: #e4e4e5;
    padding:20px;
}
#hero h1 {
    margin-bottom: 20px;
    font-size: 35px;
}
#hero p {
    margin-bottom: 20px;
    font-size: 18px;
    line-height: 25px;
}
```
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/6.png?raw=true)

#### Mengatur Layout Main dan Sidebar
- Selanjutnya mengatur main content dan sidebar, tambahkan CSS floa
```ssh
* {
    margin: 0;
    padding: 0;
}
body {
    line-height:1;
    font-size:100%;
    font-family:'Open Sans', sans-serif;
    color:#5a5a5a;
}
#container {
    width: 980px;
    margin: 0 auto;
    box-shadow: 0 0 1em #cccccc;
}
/* header */
header {
    padding: 20px;
}
header h1 {
    margin: 20px 10px;
    color: #b5b5b5;
}
/* navigasi */
nav {
    display: block;
    background-color: #1f5faa;
}
nav a {
    padding: 15px 30px;
    display: inline-block;
    color: #ffffff;
    font-size: 14px;
    text-decoration: none;
    font-weight: bold;
}
nav a.active,
nav a:hover {
    background-color: #2b83ea;
}

/* Hero Panel */
#hero {
    background-color: #e4e4e5;
    padding:20px;
}
#hero h1 {
    margin-bottom: 20px;
    font-size: 35px;
}
#hero p {
    margin-bottom: 20px;
    font-size: 18px;
    line-height: 25px;
}

/* main content */
#wrapper {
    margin: 0;
}
#main {
    float: left;
    width: 640px;
    padding: 20px;
}
   /* sidebar area */
#sidebar {
    float: left;
    width: 260px;
    padding: 20px;
}
```

#### Membuat Sidebar Widget
- Kemudian selanjutnya menambahkan element lain dalam sidebar.
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Sederhana</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&display=swap" rel="stylesheet">
</head>
<body>
    <div id="container"></div>
    <header>
        <h1>Layout Sederhana</h1>
    </header>
    <nav>
        <a href="home.html" class="active">Home</a>
        <a href="artikel.html">Artikel</a>
        <a href="about.html">About</a>
        <a href="kontak.html">Kontak</a>
    </nav>
    <section id="hero"></section>
    <section id="wrapper">
        <section id="main"></section>
        <aside id="sidebar"></aside>
    </section>
    <section id="hero">
        <h1>Hello World!</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum lorem 
        elit, iaculis innisl volutpat, malesuada tincidunt arcu. Proin in leo fringilla, 
        vestibulum mi porta, faucibus felis. Integer pharetra est nunc, nec pretium nunc 
        pretium ac.</p>
        <a href="home.html" class="btn btn-large">Learn more &raquo;</a>
    </section>

    <aside id="sidebar">
        <div class="widget-box">
        <h3 class="title">Widget Header</h3>
        <ul>
        <li><a href="#">Widget Link</a></li>
        <li><a href="#">Widget Link</a></li>
        <li><a href="#">Widget Link</a></li>
        <li><a href="#">Widget Link</a></li>
        <li><a href="#">Widget Link</a></li>
        </ul>
        </div>
        <div class="widget-box">
        <h3 class="title">Widget Text</h3>
        <p>Vestibulum lorem elit, iaculis in nisl volutpat, malesuada tincidunt 
        arcu. Proin in leo fringilla, vestibulum mi porta, faucibus felis. Integer 
        pharetra est nunc, nec pretium nunc pretium ac.</p>
        </div>
    </aside>

    <footer>
        <p>&copy; 2021 - Universitas Pelita Bangsa</p>
    </footer>
</body>
</html>
```

- Kemudian tambahkan CSS
```ssh
* {
    margin: 0;
    padding: 0;
}
body {
    line-height:1;
    font-size:100%;
    font-family:'Open Sans', sans-serif;
    color:#5a5a5a;
}
#container {
    width: 980px;
    margin: 0 auto;
    box-shadow: 0 0 1em #cccccc;
}
/* header */
header {
    padding: 20px;
}
header h1 {
    margin: 20px 10px;
    color: #b5b5b5;
}
/* navigasi */
nav {
    display: block;
    background-color: #1f5faa;
}
nav a {
    padding: 15px 30px;
    display: inline-block;
    color: #ffffff;
    font-size: 14px;
    text-decoration: none;
    font-weight: bold;
}
nav a.active,
nav a:hover {
    background-color: #2b83ea;
}

/* Hero Panel */
#hero {
    background-color: #e4e4e5;
    padding:20px;
}
#hero h1 {
    margin-bottom: 20px;
    font-size: 35px;
}
#hero p {
    margin-bottom: 20px;
    font-size: 18px;
    line-height: 25px;
}

/* main content */
#wrapper {
    margin: 0;
}
#main {
    width: 640px;
}
   /* sidebar area */
#sidebar {
    width: 260px;
    float: right;
}

/* widget */
.widget-box {
    border:1px solid #eee;
    margin-bottom:20px;
}
.widget-box .title {
    padding:10px 16px;
    background-color:#428bca;
    color:#fff;
}
.widget-box ul {
    list-style-type:none;
}
.widget-box li {
    border-bottom:1px solid #eee;
}
.widget-box li a {
    padding:10px 16px;
    color:#333;
    display:block;
    text-decoration:none;
}
.widget-box li:hover a {
    background-color:#eee;
}
.widget-box p {
    padding:15px;
    line-height:25px;
}
```
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/7.png?raw=true)

#### Mengatur Footer
- Selanjutnya mengatur tampilan footer. Tambahkan CSS untuk footer.
```ssh
* {
    margin: 0;
    padding: 0;
}
body {
    line-height:1;
    font-size:100%;
    font-family:'Open Sans', sans-serif;
    color:#5a5a5a;
}
#container {
    width: 980px;
    margin: 0 auto;
    box-shadow: 0 0 1em #cccccc;
}
/* header */
header {
    padding: 20px;
}
header h1 {
    margin: 20px 10px;
    color: #b5b5b5;
}
/* navigasi */
nav {
    display: block;
    background-color: #1f5faa;
}
nav a {
    padding: 15px 30px;
    display: inline-block;
    color: #ffffff;
    font-size: 14px;
    text-decoration: none;
    font-weight: bold;
}
nav a.active,
nav a:hover {
    background-color: #2b83ea;
}

/* Hero Panel */
#hero {
    background-color: #e4e4e5;
    padding:20px;
}
#hero h1 {
    margin-bottom: 20px;
    font-size: 35px;
}
#hero p {
    margin-bottom: 20px;
    font-size: 18px;
    line-height: 25px;
}

/* main content */
#wrapper {
    margin: 0;
}
#main {
    width: 640px;
}
   /* sidebar area */
#sidebar {
    width: 260px;
    float: right;
}

/* widget */
.widget-box {
    border:1px solid #eee;
    margin-bottom:20px;
}
.widget-box .title {
    padding:10px 16px;
    background-color:#428bca;
    color:#fff;
}
.widget-box ul {
    list-style-type:none;
}
.widget-box li {
    border-bottom:1px solid #eee;
}
.widget-box li a {
    padding:10px 16px;
    color:#333;
    display:block;
    text-decoration:none;
}
.widget-box li:hover a {
    background-color:#eee;
}
.widget-box p {
    padding:15px;
    line-height:25px;
}
footer {
    clear:both;
    background-color:#1d1d1d;
    padding:20px;
    color:#eee;
}
```
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/8.png?raw=true)

#### Menambahkan Elemen lainnya pada Main Content
```ssh
<section id="main">
        <div class="row">
        <div class="box">
        <img src="https://dummyimage.com/120/db7d25/fff.png" alt=""
        class="image-circle">
        <h3>Heading</h3>
        <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis 
        euismod.</p>
        <a href="#" class="btn btn-default">View detail</a>
        </div>
        <div class="box">
        <img src="https://dummyimage.com/120/3e73e6/fff.png" alt=""
        class="image-circle">
        <h3>Heading</h3>
        <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis 
        euismod.</p>
        <a href="#" class="btn btn-default">View detail</a>
        </div>
        <div class="box">
        <img src="https://dummyimage.com/120/71e6d4/fff.png" alt=""
        class="image-circle">
        <h3>Heading</h3>
        <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis 
        euismod.</p>
        <a href="#" class="btn btn-default">View detail</a>
        </div>
        </div>
    </section>
```

- Kemudian tambahkan CSS
```ssh
.box {
    display:block;
    float:left;
    width:33.333333%;
    box-sizing:border-box;
    -moz-box-sizing:border-box;
    -webkit-box-sizing:border-box;
    padding:0 10px;
    text-align:center;
}
.box h3 {
    margin: 15px 0;
}
.box p {
    line-height: 20px;
    font-size: 14px;
    margin-bottom: 15px;
}
box img {
    border: 0;
    vertical-align: middle;
}
.image-circle {
    border-radius: 50%;
    }
.row {
    margin: 0 -10px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
}
.row:after, .row:before,
.entry:after, .entry:before {
    content:'';
    display:table;
}
.row:after,
.entry:after {
    clear:both;
}
```
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/9.png?raw=true)

#### Menambahkan Content Artikel
- Selanjutnya membuat content artikel. Tambahkan HTML berikut pada main conten
```ssh
<hr class="divider" />
        <article class="entry">
            <h2>First featurette heading.</h2>
            <img src="https://dummyimage.com/150/7b8a70/fff.png" alt="">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum lorem 
            elit, iaculis in nisl volutpat, malesuada tincidunt arcu. Proin in leo fringilla, 
            vestibulum mi porta, faucibus felis. Integer pharetra est nunc, nec pretium nunc 
            pretium ac.</p>
        </article>
    <hr class="divider" />
    <article class="entry">
        <h2>First featurette heading.</h2>
        <img src="https://dummyimage.com/150/7b8a70/fff.png" alt=""
    class="right-img">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum lorem 
        elit, iaculis in nisl volutpat, malesuada tincidunt arcu. Proin in leo fringilla, 
        vestibulum mi porta, faucibus felis. Integer pharetra est nunc, nec pretium nunc 
        pretium ac.</p>
    </article>
```
- Kemudian tambahkan CSS
```ssh
.divider {
    display: flex;
    border:0;
    border-top:1px solid #eeeeee;
    margin:40px 0;
}
   /* entry */
.entry {
    flex: 1;
    margin: 15px 0;
}
.entry h2 {
    margin-bottom: 20px;
}
.entry p {
line-height: 25px;
}
.entry img {
float: left;
border-radius: 5px;
margin-right: 15px;
}
.entry .right-img {
    float: right;
}   
```
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/10.png?raw=true)

#### Pertanyaan dan Tugas
1. Tambahkan Layout untuk menu About
- buat single layout yang berisi deskripsi, portfolio, dll
2. Tambahkan layout untuk menu Contact
- yang berisi form isian: nama, email, message, dll

- Code html about
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="about-container">
        <h1>About Me</h1>
        <p>Hello! I am ainun dwi permana. I am a graduate of Madrasah Aliyah Nur El-Ghozy in 2023 and currently pursuing a Bachelor of informatics
            engineering at Universitas Pelita Bangsa. I have completed semester one with a GPA of 3.81. I am currently in
            my second semester.</p>
        
        <h2>Portfolio</h2>
        <div class="portfolio-section">
            <div class="portfolio-item">
                <h3>Project 1</h3>
                <p>I am a dedicated, creative individual with strong problem solving skills. I also have excellent 
                    communication skills, both verbally and in writing. I am able to work independently and as 
                    part of a team. I am confident that I have the skills that match the qualifications required for 
                    the Backend Developer.</p>
        </div>
    </div>
</body>
</html>
```
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/l.png?raw=true)

- code html contect
```ssh
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="contact-container">
        <h1>Contact Me</h1>
        <form action="#" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea><br>

            <input type="submit" value="Send">
        </form>
    </div>
</body>
</html>
```
![alt text](https://github.com/Ainun27/Lab4Web/blob/main/tugas4/m.png?raw=true)

- code css about dan contect
```ssh
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.about-container, .contact-container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

h1 {
    text-align: center;
    color: #333;
}

h2 {
    margin-top: 30px;
    color: #555;
}

.portfolio-section {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.portfolio-item {
    flex-basis: 48%;
    margin-bottom: 20px;
    background-color: #eaeaea;
    padding: 15px;
    border-radius: 5px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin: 10px 0 5px;
    font-weight: bold;
}

input, textarea {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #5cb85c;
    color: white;
    border: none;
    cursor: pointer;
    padding: 10px;
    border-radius: 5px;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #4cae4c;
}
```

