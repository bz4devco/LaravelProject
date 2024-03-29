<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketFile extends Model
{
    use HasFactory;

    protected $table = 'ticket_files';

    protected $fillable = ['file_path', 'file_size', 'file_type', 'ticket_id', 'user_id', 'status'];


    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket\Ticket', 'ticket_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }



    public function userTypeFileUploded()
    {
        return $this->user->user_type == 0 ? 0 : 1;
    }

    public function showFileSize()
    {
        $s = array('B', 'KB', 'MB', 'GB');
        $e = floor(log($this->file_size, 1024));

        return round($this->file_size / pow(1024, $e), 2) . $s[$e];
    }

}
