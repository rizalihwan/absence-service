<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EpresenceResource;
use App\Http\Resources\GetDataResource;
use App\Models\Epresence;
use App\Models\User;

class EpresenceController extends Controller
{
    // lakukan presensi
    public function attendance()
    {
        $attr = $this->validate(request(), [
            'type' => 'required'
        ]);
        try {
            $attendance = auth()->user()->epresences()->create($attr);
            return new EpresenceResource($attendance);
        } catch (\Exception $e) {
            return response()->json('Epresence failed ' . $e->getMessage(), 400);
        }
    }

    // get data berdasarkan siswa
    public function show($id)
    {
        $data = Epresence::where('user_id', $id)->get();
        foreach ($data as $key) {
            $response = response()->json([
                'message' => 'Success get data',
                'data' => [
                    'id_user' => $key->user_id,
                    'nama_user' => $key->user->name,
                    'tanggal' => $key->created_at->format('y-m-d'),
                    'waktu_absensi' => $key->created_at,
                    'status_masuk' => $this->status_approve()
                ]
            ], 201);
        }
        return $response;
        // return GetDataResource::collection($user);
    }

    public function status_approve()
    {
        $is_approved = Epresence::pluck('is_approve');
        if($is_approved == TRUE)
        {
            $result = 'APPROVE';
        } else if($is_approved == FALSE)
        {
            $result = 'REJECT';
        } else {
            $result = null;
        }
        return $result;
    }
}
