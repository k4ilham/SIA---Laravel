## Pertemuan 1

1. Buat proyek Laravel menggunakan perintah berikut:
    ```
    composer create-project --prefer-dist laravel/laravel ProjectSIA2
    ```

2. Tambahkan paket dompdf untuk Laravel dengan perintah:
    ```
    composer require barryvdh/laravel-dompdf
    ```

3. Pasang paket Sweet Alert menggunakan Composer:
    ```
    composer require realrashid/sweet-alert
    ```

## Pertemuan 2

### Konfigurasi Database

Nama Database: `db_sia2`

Ubah file `.env` dengan konfigurasi berikut:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_sia2
    DB_USERNAME=root
    DB_PASSWORD=

### Pembuatan Model dan Migrasi

1. Gunakan perintah berikut untuk membuat model dan migrasi untuk setiap entitas:

        php artisan make:model Barang -m

        php artisan make:model Supplier -m

        php artisan make:model Akun -m
        php artisan make:model Setting -m
        php artisan make:model Pemesanan -m
        php artisan make:model DetailPesan -m
        php artisan make:model Pembelian -m
        php artisan make:model DetailPembelian -m
        php artisan make:model Retur -m
        php artisan make:model DetailRetur -m
        php artisan make:model Jurnal -m
        php artisan make:model Pemesanan_tem 
        php artisan make:model Temp_pesan 
        php artisan make:model Beli
        php artisan make:model Laporan

2. Membuat trigger

        php artisan make:migration trigger_bersih_tempesan
        
        php artisan make:migration trigger_tambah


### Membuat Migration

1. barang

        Schema::create('barang', function (Blueprint $table){
            $table->string('kd_brg',5)->primary();
            $table->string('nm_brg',5);
            $table->integer('harga');
            $table->integer('stok');
        }); 

2. akun

        Schema::create('akun', function (Blueprint $table) {
            $table->string('no_akun',5)->primary();
            $table->string('nm_akun',25);
        });

3. supplier

        Schema::create('supplier', function (Blueprint $table){
            $table->string('kd_supp',5)->primary();
            $table->string('nm_supp',25);
            $table->string('alamat',50);
            $table->string('telepon',13);
        });  

4. pemesanan

        Schema::create('pemesanan', function (Blueprint $table) {
            $table->string('no_pesan', 14)->primary();
            $table->date('tgl_pesan');
            $table->integer('total');
            $table->string('kd_supp', 5);
        });    

5. setting

        Schema::create('setting', function (Blueprint $table) {
            $table->string('id_setting',5)->primary();
            $table->string('no_akun',5);
            $table->string('nama_transaksi',20);
        });    

6. detail_pesan

        Schema::create('detail_pesan', function (Blueprint $table) {
            $table->string('no_pesan', 14);
            $table->string('kd_brg', 5);
            $table->integer('qty_pesan');
            $table->integer('subtotal');
        });    

7. temp_pemesanan

         Schema::create('temp_pemesanan', function (Blueprint $table) {
            $table->string('kd_brg', 5);
            $table->integer('qty_pesan');
        });   

8. pembelian

        Schema::create('pembelian', function (Blueprint $table) {
            $table->string('no_beli',14)->primary();
            $table->date('tgl_beli');
            $table->string('no_faktur',14);
            $table->integer('total_beli');
            $table->string('no_pesan',14);
        });    

9. detail_pembelian


        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->string('no_beli',14);
            $table->string('kd_brg',5);
            $table->integer('qty_beli');
            $table->integer('sub_beli');
        });   


10. detail_retur

         Schema::create('detail_retur', function (Blueprint $table) {
            $table->string('no_retur',14);
            $table->string('kd_brg',5);
            $table->integer('qty_retur');
            $table->integer('sub_retur');
        });   

11. retur

         Schema::create('retur', function (Blueprint $table) {
            $table->string('no_retur',14)->primary();
            $table->date('tgl_retur');
            $table->integer('total_retur');
        });   

12. jurnal

         Schema::create('jurnal', function (Blueprint $table) {
            $table->string('no_jurnal', 14)->primary();
            $table->date('tgl_jurnal');
            $table->text('keterangan');
            $table->string('no_akun', 5);
            $table->integer('debet');
            $table->integer('kredit');
        });   

### membuat trigger

1. clear_tem_pesan

         DB::unprepared('
        CREATE TRIGGER clear_tem_pesan AFTER INSERT ON detail_pesan
        FOR EACH ROW 
        BEGIN
            DELETE FROM temp_pemesanan;
        END
        ');   

2. detail_pembelian

        DB::unprepared('
            CREATE TRIGGER after  INSERT ON detail_pembelian
            FOR EACH ROW BEGIN
                UPDATE barang
                    SET stok = stok + NEW.qty_beli
                WHERE
                    kd_brg = NEW.kd_brg;
            END
        ');    

Setelah menjalankan perintah di atas, Anda dapat melakukan migrasi dengan perintah:


    php artisan migrate:refresh --seed

### Membuat view, jalankan query SQL berikut pada database Anda:

1. temp_pemesanan

    CREATE VIEW `after` AS SELECT `temp_pemesanan`.`kd_brg` AS 
    `kd_brg`, concat(`barang`.`nm_brg`,`barang`.`harga`) 
    AS `nm_brg`,`temp_pemesanan`.`qty_pesan` AS `qty_pesan`, `barang`.`harga`* 
    `temp_pemesanan`.`qty_pesan` AS `sub_total` FROM (`temp_pemesanan` join 
    `barang`) WHERE `temp_pemesanan`.`kd_brg` = `barang`.`kd_brg` ;

2. tampil_pemesanan

    CREATE VIEW `tampil_pemesanan` AS SELECT `detail_pesan`.`kd_brg` AS `kd_brg`, 
    `detail_pesan`.`no_pesan` AS `no_pesan`, `barang`.`nm_brg` AS `nm_brg`, 
    `detail_pesan`.`qty_pesan` AS `qty_pesan`, `detail_pesan`.`subtotal` AS `sub_total` 
    FROM (`barang` join `detail_pesan`) WHERE `detail_pesan`.`kd_brg` = 
    `barang`.`kd_brg` ;

3. tampil_pembelian

    CREATE VIEW `tampil_pembelian` AS (select `barang`.`kd_brg` AS 
    `kd_brg`,`detail_pembelian`.`no_beli` AS `no_beli`,`barang`.`nm_brg` AS 
    `nm_brg`,`barang`.`harga` AS `harga`,`detail_pembelian`.`qty_beli` AS `qty_beli` from 
    (`barang` join `detail_pembelian`) where `barang`.`kd_brg` = 
    `detail_pembelian`.`kd_brg`) ;

4. lap_jurnal

    CREATE VIEW `lap_jurnal` AS SELECT `akun`.`nm_akun` AS `nm_akun`, 
    `jurnal`.`tgl_jurnal` AS `tgl`, sum(`jurnal`.`debet`) AS `debet`, sum(`jurnal`.`kredit`) AS 
    `kredit` FROM (`akun` join `jurnal`) WHERE `akun`.`no_akun` = `jurnal`.`no_akun` 
    GROUP BY `jurnal`.`no_jurnal` ;

5. lap_stok

    CREATE VIEW `lap_stok` AS (select `barang`.`kd_brg` AS `kd_brg`,`barang`.`nm_brg` 
    AS `nm_brg`,`barang`.`harga` AS `harga`,`barang`.`stok` AS 
    `stok`,sum(`detail_pembelian`.`qty_beli`) AS `beli`,sum(`detail_retur`.`qty_retur`) AS 
    `retur` from ((`barang` join `detail_retur`) join `detail_pembelian`) where 
    `barang`.`kd_brg` = `detail_retur`.`kd_brg` and `barang`.`kd_brg` = 
    `detail_pembelian`.`kd_brg` group by `barang`.`kd_brg`) ;

## Pertemuan 3

### Install Laravel UI

    composer require laravel/ui

    php artisan ui vue --auth
    npm install
    npm run dev
    npm run build

    php artisan serve

    php artisan ui vue
    npm install
    npm run dev
    npm run build
    php artisan migrate

    https://github.com/aleckrh/laravel-sb-admin-2

## Pertemuan 4

### Menambahkan role permission

    composer require spatie/laravel-permission
    php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

### Menambahkan spatie ke model User

    use Spatie\Permission\Traits\HasRoles;
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

### Membuat Role Seeder

    php artisan make:seeder RoleSeeder

    // Update File database/seeder/RoleSeeder.php

    use Spatie\Permission\Models\Role;

    Role::create([
        'name' => 'admin',
        'guard_name' => 'web'
    ]);

    Role::create([
        'name' => 'user',
        'guard_name' => 'web'
    ]);

### Membuat User Seeder

    php artisan make:seeder UserSeeder

    // Update File database/seeder/UserSeeder.php

    use App\Models\User;

    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole('admin');

    $user = User::create([
        'name' => 'user',
        'email' => 'user@test.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('user');

### Membuat Database Seeder

    // Update File database/seeder/databaseSeeder.php

    use Database\Seeders\RoleSeeder;
    use Database\Seeders\UserSeeder;

    $this->call(RoleSeeder::class);
    $this->call(UserSeeder::class);

### jalankan perintah migration dan seeder

    php artisan migrate:fresh --seed

### Membuat Middleware

    update file  app/Http/Kernel.php

    protected $middlewareAliases = [
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ];

    @role('admin')
        //isi menu
    @endrole

### Menambahkan role ke register

    $user->assignRole('user');

## Pertemuan 5

### Memecah Layout

    // tambahkan view di
    resources/views/layouts/partials/footer.blade.php
    resources/views/layouts/partials/navbar.blade.php
    resources/views/layouts/partials/sidebar.blade.php

### Form Master User 

    //controller
    php artisan make:controller UserController --resource

    //routes
    use App\Http\Controllers\UserController;
    Route::get('/user/hapus/{id}', [UserController::class, 'destroy']);
    Route::resource('/user', UserController::class);

    //view
    resources/views/admin/user/index.blade.php
    resources/views/admin/user/edit.blade.php

### Menambahkan DataTable

    <script src="{{ asset('asset/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('asset/js/datatables/modules-datatables.js') }}"></script>
    <script src="{{ asset('asset/js/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('asset/js/datatables/dataTables.select.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/datatables/select.bootstrap4.min.css') }}">

## Pertemuan 6

### Form Master Barang 

    //model Barang

    class Barang extends Model
    {
        use HasFactory;

        protected $primaryKey = 'kd_brg';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "barang";
        protected $fillable=['kd_brg','nm_brg','harga','stok'];
    }

    //controller
    php artisan make:controller BarangController --resource

    //routes
    use App\Http\Controllers\BarangController;
    Route::get('/user/hapus/{id}', [BarangController::class, 'destroy']);
    Route::resource('/user', BarangController::class);

    //view
    resources/views/admin/barang/index.blade.php
    resources/views/admin/barang/edit.blade.php

### Form Master Supplier

    //model Supplier

    class Supplier extends Model
    {
        use HasFactory;

        protected $primaryKey = 'kd_supp';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "supplier";
        protected $fillable=['kd_supp','nm_supp','alamat','telepon'];
    }

    //controller
    php artisan make:controller SupplierController --resource

    //routes
    use App\Http\Controllers\SupplierController;
    Route::get('/user/hapus/{id}', [SupplierController::class, 'destroy']);
    Route::resource('/user', SupplierController::class);

    //view
    resources/views/admin/supplier/index.blade.php
    resources/views/admin/supplier/edit.blade.php

## Pertemuan 7


### Form Master Akun

    //model Akun

    class Akun extends Model
    {
        use HasFactory;

        protected $primaryKey = 'no_akun';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "akun";
        protected $fillable=['no_akun','nama_akun'];
    }

    //controller
    php artisan make:controller AkunController --resource

    //routes
    use App\Http\Controllers\AkunController;
    Route::get('/akun/hapus/{id}', [AkunController::class, 'destroy']);
    Route::resource('/akun', AkunController::class);

    //view
    resources/views/admin/akun/index.blade.php
    resources/views/admin/akun/edit.blade.php


### Form Master Setting Akun

    //model Setting

    class Setting extends Model
    {
        use HasFactory;

        protected $primaryKey = 'id_setting';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "setting";
        protected $fillable=['id_setting','no_akun','nama_transaksi'];
    }

    //controller
    php artisan make:controller SettingController --resource

    //routes
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.transaksi');
    Route::post('/setting/simpan','SettingController@simpan');

    //view
    resources/views/admin/setting/index.blade.php

### Seed Setting Akun

    php artisan make:seeder SettingSeeder
    php artisan db:seed

## Pertemuan 8

    Libur UTS

## Pertemuan 9

### Form Transaksi Pemesanan

    //Model Pemesanan
        protected $primaryKey = 'no_pesan';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "pemesanan";
        protected $fillable=['no_pesan','tgl_pesan','total','kd_supp'];


    //Model Pemesanan_tem 
        protected $primaryKey = 'kd_brg';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "temp_pemesanan";
        protected $fillable=['kd_brg','qty_pesan'];

    //Model Temp_pesan
        protected $primaryKey = 'kd_brg';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "view_temp_pesan";
        protected $fillable=['kd_brg','nm_brg','harga','stok'];
    
    //Model Detail_pesan
        protected $primaryKey = 'no_pesan';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "detail_pesan";
        protected $fillable=['no_pesan','kd_brg','qty_pesan','subtotal'];

    //controller
        php artisan make:controller PemesananController 
        php artisan make:controller DetailPesanController 

    //view
        resources/views/pemesanan/index.blade.php

    //Route Pemesanan
        Route::get('/transaksi', [PemesananController::class, 'index'])->name('pemesanan.index');
        Route::post('/sem/store', [PemesananController::class, 'store']);
        Route::get('/transaksi/hapus/{kd_brg}',[PemesananController::class, 'destroy']); 

    //Route Detail Pesan
        Route::post('/detail/store', [DetailPesanController::class, 'store']);
        Route::post('/detail/simpan', [DetailPesanController::class, 'simpan']);

## Pertemuan 10 & 11

### Form Transaksi Pembelian

    //Model Pembelian
        protected $primaryKey = 'no_beli';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "pembelian";
        protected $fillable=['no_beli','tgl_beli','no_faktur','total_beli','no_pesan'];

    //Model DetailPembelian
        protected $primaryKey = 'no_beli';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "detail_pembelian";
        protected $fillable=['no_beli','kd_brg','qty_beli','sub_beli'];

    //Model Beli
        protected $primaryKey = 'no_pesan';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "tampil_pemesanan";
        protected $fillable=['kd_brg','no_pesan','nm_brg','qty_pesan','sub_total'];

    //Model Jurnal
        protected $primaryKey = 'no_jurnal';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "jurnal";
        protected $fillable=['no_jurnal','tgl_jurnal','keterangan','no_akun','debet','kredit'];

    //controller
        php artisan make:controller PembelianController --resource

    //view
        resources/views/pembelian/index.blade.php
        resources/views/pembelian/beli.blade.php

    //Route Pembelian
        Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
        Route::get('/pembelian-beli/{id}', [PembelianController::class, 'edit']);
        Route::post('/pembelian/simpan', [PembelianController::class, 'simpan']);

### Faktur Invoice

    //Route Cetak Invoice
        Route::get('/laporan/faktur/{invoice}', [PembelianController::class, 'pdf'])->name('cetak.order_pdf');

    //view
        resources/views/laporan/faktur.blade.php

## Pertemuan 12

### Trigger Pengurang Stok

    php artisan make:migration trigger_kurang

    DB::unprepared('
        CREATE TRIGGER update_stok_retur after INSERT ON detail_retur
        FOR EACH ROW BEGIN
        UPDATE barang
        SET stok = stok - NEW.qty_retur
        WHERE
        kd_brg = NEW.kd_brg;
        END 
    ');

    DB::unprepared('DROP TRIGGER update_stok_retur');

    php artisan migrate.

### Form Retur

    //Model Retur
        protected $primaryKey = 'no_retur';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "retur_beli";
        protected $fillable=['no_retur','tgl_retur','total_retur'];

    //Model DetailRetur
        protected $primaryKey = 'no_retur';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;
        protected $table = "detail_retur";
        protected $fillable=['no_retur','kd_brg','qty_retur','sub_retur'];

    //controller
        php artisan make:controller ReturController --resource

    //view
        resources/views/retur/index.blade.php
        resources/views/retur/beli.blade.php

    //Route Retur 
        Route::get('/retur',[ReturController::class, 'index'])->name('retur.index');
        Route::get('/retur-beli/{id}', [ReturController::class, 'edit']);
        Route::post('/retur/simpan', [ReturController::class, 'simpan']);

### Laporan Jurnal Umum

    //Model Laporan
        protected $table = "jurnal";
        protected $fillable=['no_jurnal','tgl_jurnal','keterangan','no_akun','debet','kredit'];

    //controller
        php artisan make:controller LaporanController --resource

    //view
        resources/views/laporan/index.blade.php
        resources/views/laporan/cetak.blade.php

    //Route Laporan
        Route::resource( '/laporan' , LaporanController::class);
        Route::get('/laporancetak/cetak_pdf', [LaporanController::class, 'cetak_pdf']);

### Laporan Stok Barang

    //Model Laporan Stok
        php artisan make:model Laporanstok

        protected $table = "lap_stok";
        protected $fillable = ['kd_brg','nm_brg','harga','stok','beli','retur'];

    //controller
        php artisan make:controller LapstokController --resource

    //view
        resources/views/laporan/stok.blade.php

    //Route Laporan
        Route::resource( '/stok' , LapStokController::class);


## Pertemuan 13

    Review

## Pertemuan 14 & 15

    Presentasi Project

## Pertemuan 16

    Libur UAS



























