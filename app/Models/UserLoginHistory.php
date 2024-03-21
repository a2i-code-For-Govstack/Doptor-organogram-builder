<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginHistory extends Model
{
    protected $table = 'user_login_history';

    public function office()
    {
        return $this->hasOne(Office::class, 'id', 'office_id');
    }

    public static function getLoginHistoryDataOfficeWise($data): array
    {
        try {
            $start_date = $data['start_date'];
            $end_date = $data['end_date'];

            $history = UserLoginHistory::whereBetween('login_time', [$start_date, $end_date])
                ->select('office_id')
                ->where('office_id', '!=', 0)
                ->selectRaw('COUNT(DISTINCT user_id) as total_unique_user_login_count')
                ->groupBy('office_id')
                ->orderByDesc('total_unique_user_login_count')
                ->with('office:id,office_name_bng,office_name_eng')
                ->get();

            $first_login_time = UserLoginHistory::select('login_time')->first()->login_time;

            $total_office_login = $history->count();

            $total_unique_user = $history->sum('total_unique_user_login_count');

            return [
                'login_history' => $history,
                'first_login_time' => $first_login_time,
                'total_office_login' => $total_office_login,
                'total_unique_user_login_count' => $total_unique_user,
            ];

        } catch (\Exception $e) {
            return [
                'login_history' => null,
                'from_login_history' => null,
                'total_office_login' => null,
                'total_unique_user_login_count' => null,
                'error' => $e->getMessage(),
            ];
        }
    }
}
