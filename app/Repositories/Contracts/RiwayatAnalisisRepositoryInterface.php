<?php

namespace App\Repositories\Contracts;

interface RiwayatAnalisisRepositoryInterface
{
    /**
     * Dapatkan data riwayat terpaginasi milik user tertentu dengan pencarian.
     *
     * @param int $userId
     * @param string|null $search
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedForUser(int $userId, ?string $search = null, int $perPage = 10);

    /**
     * Ambil data riwayat berdasarkan ID dan User ID.
     *
     * @param int $id
     * @param int $userId
     * @return \App\Models\RiwayatAnalisis|null
     */
    public function findForUser(int $id, int $userId);

    /**
     * Simpan data riwayat analisis baru.
     *
     * @param array $data
     * @return \App\Models\RiwayatAnalisis
     */
    public function store(array $data);

    /**
     * Hapus riwayat berdasarkan ID dan User ID.
     *
     * @param int $id
     * @param int $userId
     * @return bool
     */
    public function delete(int $id, int $userId): bool;
}
