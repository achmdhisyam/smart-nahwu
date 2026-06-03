<?php

namespace App\Services\Riwayat;

use App\Repositories\Contracts\RiwayatAnalisisRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

class RiwayatService
{
    protected $analysisRepo;

    public function __construct(RiwayatAnalisisRepositoryInterface $analysisRepo)
    {
        $this->analysisRepo = $analysisRepo;
    }

    /**
     * Mendapatkan daftar riwayat berpaginasi untuk pengguna aktif.
     */
    public function getUserHistory(int $userId, ?string $search = null): LengthAwarePaginator
    {
        return $this->analysisRepo->getPaginatedForUser($userId, $search, 8);
    }

    /**
     * Mendapatkan detail satu riwayat analisis spesifik milik pengguna.
     */
    public function getHistoryDetail(int $id, int $userId)
    {
        $history = $this->analysisRepo->findForUser($id, $userId);

        if (!$history) {
            throw new InvalidArgumentException("Data riwayat tidak ditemukan atau Anda tidak memiliki akses ke data tersebut.");
        }

        return $history;
    }

    /**
     * Menghapus salah satu item riwayat.
     */
    public function deleteHistory(int $id, int $userId): bool
    {
        return $this->analysisRepo->delete($id, $userId);
    }
}
