<?php

use App\Controllers\AuthController;
use App\Controllers\MahasiswaController;
use App\Controllers\ProdiController;
use App\Controllers\MatakuliahController;

return [
    // Auth
    'GET /'                        => [AuthController::class, 'index'],
    'GET /login'                   => [AuthController::class, 'index'],
    'POST /login'                  => [AuthController::class, 'login'],
    'GET /logout'                  => [AuthController::class, 'logout'],

    // CRUD Mahasiswa
    'GET /mahasiswa'                => [MahasiswaController::class, 'index'],
    'GET /mahasiswa/create'         => [MahasiswaController::class, 'create'],
    'POST /mahasiswa/store'         => [MahasiswaController::class, 'store'],
    'GET /mahasiswa/edit/{nim}'     => [MahasiswaController::class, 'edit'],
    'POST /mahasiswa/update/{nim}'  => [MahasiswaController::class, 'update'],
    'POST /mahasiswa/delete/{nim}'  => [MahasiswaController::class, 'delete'],

    // CRUD Prodi
    'GET /prodi'                    => [ProdiController::class, 'index'],
    'GET /prodi/create'             => [ProdiController::class, 'create'],
    'POST /prodi/store'             => [ProdiController::class, 'store'],
    'GET /prodi/edit/{id}'          => [ProdiController::class, 'edit'],
    'POST /prodi/update/{id}'       => [ProdiController::class, 'update'],
    'POST /prodi/delete/{id}'       => [ProdiController::class, 'delete'],

    // Mata Kuliah
    'GET /matakuliah'                => [MatakuliahController::class, 'index'],
    'GET /matakuliah/create'         => [MatakuliahController::class, 'create'],
    'POST /matakuliah/store'         => [MatakuliahController::class, 'store'],
    'GET /matakuliah/edit/{id}'      => [MatakuliahController::class, 'edit'],
    'POST /matakuliah/update/{id}'   => [MatakuliahController::class, 'update'],
    'POST /matakuliah/delete/{id}'   => [MatakuliahController::class, 'delete'],
];
