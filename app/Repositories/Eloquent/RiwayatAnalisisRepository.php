<?php

namespace App\Repositories\Eloquent;

use App\Models\RiwayatAnalisis;
use App\Repositories\Contracts\RiwayatAnalisisRepositoryInterface;

class RiwayatAnalisisRepository implements RiwayatAnalisisRepositoryInterface
{
    public function getPaginatedForUser(int $userId, ?string $search = null, int $perPage = 10)
    {
        $query = RiwayatAnalisis::where('user_id', $userId);

        if (!empty($search)) {
            $query->where('input_text', 'like', '%' . $search . '%');
        }

        return $query->latest()->paginate($perPage);
    }

    public function findForUser(int $id, int $userId)
    {
        return RiwayatAnalisis::where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function store(array $data)
    {
        return RiwayatAnalisis::create($data);
    }

    public function delete(int $id, int $userId): bool
    {
        $history = $this->findForUser($id, $userId);
        
        if ($history) {
            return $history->delete();
        }

        return false;
    }
}
