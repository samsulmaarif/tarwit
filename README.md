# tarwit
Stan #BlankOn di #BekrafHabibieFestival


## Kebutuhan
- subdomain
- apache2
- mysql-server
- php php-curl php-xml php-mbstring
- composer
- Twitter apps api

### Database
- buat database
- impor ```visitor.sql```

### Edit ```databaseFiles/insertDetails.php```
```
$consumerkey = "HERE";
$consumersecret = "HERE";
$accesstoken = "HERE";  
$accesstokensecret = "HERE";
$photoAddr =  <-- disesuaikan domainnya saja
```

### Edit ```databaseFiles/database_connections.php```

### Edit ```js/angular-script.js```

### install dependensi
```
$ cd databaseFiles/twitteroauth
$ composer install
```

## Deploy dengan Docker
- Jika hendak melakukan deploy dengan docker, langkah-langkah di atas dapat diabaikan
- Install Docker terlebih dahulu, tambahkan user ke grup docker
```
$ sudo usermod -aG docker namauser
```
- install docker-compose
```
$ sudo curl -L "https://github.com/docker/compose/releases/download/1.22.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
$ sudo chmod +x /usr/local/bin/docker-compose
```
- logout, lalu login lagi untuk menjalankan perintah berikutnya, atau gunakan tab terminal baru
- Sunting berkas *docker-compose.yml*
- pada service **php**, bagian **environment** lengkapi dengan credensial API twitter
```
- TW_CONSUMER_KEY=
- TW_SECRET_KEY=
- TW_ACCESS_TOKEN=
- TW_ACCESS_TOKEN_SECRET=
- DB_HOST=tarwitdb
- DB_USER=root
- DB_NAME=tarwit
- DB_PASSWD=strongpassword
```
- buat beberapa direktori
```
$ mkdir -p tmp/img
$ mkdir logs
$ mkdir dbdata
```
- lakukan proses build dengan perintah:
```
$ docker-compose --verbose build
```
- eksekusi perintah berikut untuk menjalankan tarwit:
```
$ docker-compose --verbose up
```
- install dependency untuk twitteroauth dengan masuk ke container melalui perintah docker-compose
```
$ docker-compose exec php bash
www-data@a41a38a96ac6:~/html$ cd databaseFiles/twitteroauth
www-data@a41a38a96ac6:~/html/databaseFiles/twitteroauth$ composer install
```
- Jika semua berjalan lancar, coba akses melalui peramban URL http://ip-server:8000 atau jika di lokal dapat diakses langsung dengan http://localhost:8000