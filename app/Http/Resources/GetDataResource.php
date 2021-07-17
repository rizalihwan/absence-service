<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message' => 'Success get data',
            'data' => [
                'id_user' => $this->id,
                'nama_user' => $this->name,
                'tanggal' => $this->epresences->created_at->format('y-m-d'),
                'waktu_absensi' => $this->epresences->created_at,
                'status_masuk' => $this->status_approve()
            ]
        ];
    }

    public function status_approve()
    {
        $is_approved = $this->epresences->is_approve;
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
