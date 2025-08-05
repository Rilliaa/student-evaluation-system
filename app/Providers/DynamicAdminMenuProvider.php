<?php
namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
//reminder , untuk ngatur nama pada header di vendor/jeroenoten/laravel-adminlte/views/partials/navbar/menu-item-dropdown-user-menu.blade.php.
class DynamicAdminMenuProvider extends ServiceProvider
{
    public function boot()
    {
        // Bagikan menu dinamis ke semua view
        view()->composer('*', function ($view) {

            $user = Auth::user();
            $view->with('user', $user);

            $menu = [];

            // Cek peran pengguna dan atur menu sesuai perannya
            if ($user && $user->roles->nama_roles === 'Admin') {
                // Menu untuk Admin
                $menu = [
                    ['header' => 'PENGGUNA'],
                    [
                        'text' => 'Data Admin',
                        'url'  => '/users',
                        'icon'  => 'fa fa-user',
                    ],
                    [
                        'text' => 'Data Guru',
                        'url'  => '/gurus',
                        'icon'  => 'fa fa-users',
                    ],
                    [
                        'text' => 'Data Murid',
                        'url'  => '/murids',
                        'icon'  => 'fas fa-user-graduate',
                    ],
                    [
                        'text' => 'Data Wali Murid',
                        'url'  => '/ortus',
                        'icon'  => 'fas fa-home',
                    ],
                    [
                        'text' => 'Daftar Roles',
                        'url'  => '/roles',
                        'icon'  => ' fa fa-crown',
                    ],
                    ['header' => 'AKADEMIK'],
                    [
                        'text' => 'Kelola Tahun Ajaran',
                       'icon' => 'fas fa-calendar-alt', 
                        'submenu' => [
                            [
                                'text' => 'Tahun Ajaran Baru',
                                'url'  => '/tahun-ajaran',
                                'icon'  => 'fas fa-book-open',
                            ],
                            [
                                'text' => 'Transisi Tahun Ajaran',
                                'url' => '/transisi-tahun-ajaran',
                                'icon' => 'fas fa-exchange-alt',
                            ],
                        ],
                    ],

                    [
                        'text' => 'Data Kelas',
                        'url'  => '/kelas',
                        'icon'  => 'fa fa-school',
                    ],
                    [
                        'text' => 'Kelola Mata Pelajaran',
                        'url'  => '/mapels',
                        'icon'  => ' fa fa-book',
                    ],
                    [
                        'text' => 'Kelola Jadwal',
                        'icon' => 'fas fa-calendar-check',
                        'submenu' => [
                            [
                                'text' => 'Jam Pelajaran',
                                'url' => '/jam-pelajarans',
                                'icon' => 'fa fa-clock',
                            ],
                            [
                                'text' => 'Jadwal Pelajaran',
                                'url' => '/jadwalPelajarans',
                                'icon' => 'fa fa-calendar-alt',
                            ],
                        ],
                    ],
                    [
                        'text' => 'Kelola Data Nilai',
                        'icon'  => 'fas fa-chart-bar',
                        'submenu' => [
                            // [
                            //     'text' => 'Nilai Semua Murid',
                            //     'url'  => '/nilais',
                            //     'icon' => 'fa fa-user-graduate',
                            // ],
                            [
                                'text' => 'Rincian Nilai',
                                'url'  => '/rincians/nilai',
                                'icon' => 'fa fa-list',
                            ],
                        ],
                    ],
                    [
                        'text' => 'Kelola Data Kehadiran',
                        'icon'  => 'fas fa-user-check',
                        'submenu' => [
                            [
                                'text' => 'Rincian Sesi',
                                'url'  => '/sesi',
                                'icon' => 'fas fa-user-check',
                            ],
                            [
                                'text' => 'Rincian Kehadiran',
                                'url'  => '/rincian-kehadiran',
                                'icon' => 'far fa-calendar-alt',
                            ],

                        ],
                    ],
                    [
                        'text' => 'Pelanggaran dan Prestasi',
                        'icon'  => 'fas fa-exclamation-circle',
                        'submenu' => [
                            [
                                'text' => 'Daftar Pelanggaran',
                                'url'  => '/daftar-pelanggaran',
                                'icon' => 'far fa-list-alt',
                            ],
                            [
                                'text' => 'Daftar Siswa Melanggar',
                                'url'  => '/pelanggaransiswa',
                                'icon' => 'fas fa-exclamation-triangle',
                            ],
                            [
                                'text' => 'Daftar Prestasi',
                                'url'  => '/daftar-prestasi',
                                'icon' => 'fas fa-trophy',
                            ],
                            [
                                'text' => 'Daftar Siswa Berprestasi',
                                'url'  => '/prestasi-siswa',
                                'icon' => 'fas fa-award',
                            ],
                        ],
                    ],
                    [
                        'type'         => 'fullscreen-widget',
                        'topnav_right' => true,
                    ],
                    [
                        'text' => 'blog',
                        'url'  => 'admin/blog',
                        'can'  => 'manage-blog',
                    ],
                    ['header' => 'PENGATURAN AKUN'],
                    [
                        'text' => 'profile',
                        'icon' => 'fas fa-regular fa-address-book',
                        'submenu' => [
                            [
                                'text' => 'Pengaturan Akun',
                                'url'  => '/pengaturan-akun',
                                'icon' => 'fas fa-user-cog',
                            ],
                        ],
                    ],
                    // ['header' => 'Log'],

                    [
                        'text' => 'Log Aktivitas',
                        'url'  => '/cek-log-aktivitas',
                        'icon' => 'fas fa-user-cog',
                    ],

                ];
            } elseif ($user && $user->roles->nama_roles === 'Guru') {
                $menu = [
                    ['header' => 'DASHBOARD Guru'],
                    [
                        'text' => 'Dashboard',
                        'url'  => '/modul/guru/dashboard' ,
                        'icon'  => 'fas fa-home',
                    ],
                    // [
                    //     'text' => 'Kelola Nilai Murid',
                    //     'url'  => '/modul/guru/kelas-saya/' . $user->id_guru,
                    //     'icon' => 'fas fa-school',
                    // ],
                    [
                        'text' => 'Kelola Nilai Murid',
                        'url'  => '/modul/guru/nilai/versi-2/' . $user->id_guru,
                        'icon' => 'fas fa-school',
                    ],
                    [
                        'text' => 'Lihat Jadwal',
                        'url'  => '/modul/guru/jadwal-guru/' . $user->id_guru,
                        'icon' => 'far fa-calendar-alt',
                    ],
                    [
                        'text' => 'Lihat Detail Murid',
                        'url'  => '/modul/guru/detail-murid/' . $user->id_guru,
                        'icon' => 'fas fa-user-graduate',
                    ],
                    ['header' => 'PENGATURAN AKUN'],
                    [
                        'text' => 'profile',
                        'icon' => 'fas fa-regular fa-address-book',
                        'submenu' => [
                            [
                                'text' => 'Pengaturan Akun',
                                'url'  => '/modul/guru/pengaturan-akun/' . $user->id_guru,
                                'icon' => 'fas fa-user-cog',
                            ],
                        ],
                    ],
                    
                ];
            } elseif($user && $user->roles->nama_roles === 'Murid'){
                $menu = [
                    ['header' => 'Dashboard Murid'],
                    [
                        'text' => 'Dashboard',
                        'url'  => '/modul/murid/dashboard',
                        'icon'  => 'fas fa-home',
                    ],
                    [
                        'text' => 'Pelanggaran dan Prestasi',
                        'icon'  => 'fas fa-exclamation-circle',
                        'submenu' => [
                            [
                                'text' => 'Prestasi Murid',
                                'url'  => '/modul/murid/daftar-prestasi/' . $user->id_murid,
                                'icon' => 'fas fa-trophy',
                            ],
                            [
                                'text' => 'Pelanggaran Murid',
                                'url'  => '/modul/murid/daftar-pelanggaran/' . $user->id_murid,
                                'icon' => 'far fa-list-alt',
                            ],
                           
                        ],
                    ],
                    [
                        'text' => 'Rincian Kehadiran',
                        'url'  => '/modul/murid/kehadiran/' . $user->id_murid,
                        'icon' => 'far fa-calendar-alt',
                    ],
                    [
                        'text' => 'Rincian Nilai',
                        'url'  => '/modul/murid/nilai/' . $user->id_murid,
                        'icon' => 'fas fa-chart-bar',
                    ],
                    // [
                    //     'text' => 'Jadwal Pelajaran',
                    //     'url' => '/modul/murid/jadwal/' . $user->id_murid,
                    //     'icon' => 'fa fa-calendar-alt',
                    // ],
                    ['header' => 'PENGATURAN AKUN'],
                    [
                        'text' => 'profile',
                        'icon' => 'fas fa-regular fa-address-book',
                        'submenu' => [
                            [
                                'text' => 'Pengaturan Akun',
                                'url'  => '/modul/murid/pengaturan-akun/' . $user->id_murid,
                                'icon' => 'fas fa-user-cog',
                            ],
                        ],
                    ],
                  
    
                ];
            } elseif ($user && $user->roles->nama_roles === 'Wali Murid') {
                $menu = [
                    ['header' => 'DASHBOARD Wali Murid'],
                    [
                        'text' => 'Dashboard',
                        'url'  => '/modul/dashboard/ortu',
                        'icon'  => 'fas fa-home',
                    ],
                    [
                        'text' => 'Pelanggaran dan Prestasi',
                        'icon'  => 'fas fa-exclamation-circle',
                        'submenu' => [
                            [
                                'text' => 'Prestasi Murid',
                                'url'  => '/modul/wali-murid/daftar-prestasi/' . $user->id_murid,
                                'icon' => 'fas fa-trophy',
                            ],
                            [
                                'text' => 'Pelanggaran Murid',
                                'url'  => '/modul/wali-murid/daftar-pelanggaran/' . $user->id_murid,
                                'icon' => 'far fa-list-alt',
                            ],
                           
                        ],
                    ],
                    [
                        'text' => 'Rincian Kehadiran',
                        'url'  => '/modul/wali-murid/kehadiran/' . $user->id_murid,
                        'icon' => 'far fa-calendar-alt',
                    ],
                    [
                        'text' => 'Rincian Nilai',
                        'url'  => '/modul/wali-murid/nilai/' . $user->id_murid,
                        'icon' => 'fas fa-chart-bar',
                    ],
                    ['header' => 'PENGATURAN AKUN'],
                    [
                        'text' => 'profile',
                        'icon' => 'fas fa-regular fa-address-book',
                        'submenu' => [
                            [
                                'text' => 'Pengaturan Akun',
                                'url'  => '/modul/wali-murid/pengaturan-akun/' . $user->id_ortu,
                                'icon' => 'fas fa-user-cog',
                            ],
                        ],
                    ],
                    
                ];
            }

            // untuk nimpa menu dari config/adminlte.php dengan var menu di method
            config(['adminlte.menu' => $menu]);
        });
    }
}
