<?php

namespace App\Repositories\Eloquent;

use App\Models\AnalysisHistory;
use App\Repositories\Contracts\AnalysisRepositoryInterface;

class AnalysisRepository implements AnalysisRepositoryInterface
{
    public function getPaginatedForUser(int $userId, ?string $search = null, int $perPage = 10)
    {
        $query = AnalysisHistory::where('user_id', $userId);

        if (!empty($search)) {
            $query->where('input_text', 'like', '%' . $search . '%');
        }

        return $query->latest()->paginate($perPage);
    }

    public function findForUser(int $id, int $userId)
    {
        return AnalysisHistory::where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function store(array $data)
    {
        return AnalysisHistory::create($data);
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
