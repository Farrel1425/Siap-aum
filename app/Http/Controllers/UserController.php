<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getListVerifikator(Request $request)
    {
        $request->validate([
            'except' => 'array',
        ]);
        try {
            $query = User::where('role_id', RoleEnum::VERIFIKATOR->value)->where(function ($query) {
                    $query->where('name', 'like', '%' . request()->search . '%');
                });

            if (request()->except) {
                $query->whereNotIn('id', request()->except);
            }

            $verifikator = $query->paginate(10);
            $results = $verifikator->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->name,
                ];
            });

            return response()->json([
                'results' => $results,
                'pagination' => [
                    'more' => $verifikator->hasMorePages()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data verifikator',
            ]);
        }
    }
}
