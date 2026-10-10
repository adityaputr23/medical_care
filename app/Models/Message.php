<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Message extends Model implements ShouldBroadcast
{
    protected $fillable = ['consultation_id', 'sender_id', 'body', 'type', 'file_path', 'read_at'];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('consultation.' . $this->consultation_id)];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'type' => $this->type,
            'sender' => [
                'id' => $this->sender->id,
                'name' => $this->sender->name,
                'avatar' => $this->sender->avatar,
                'role' => $this->sender->role,
            ],
            'created_at' => $this->created_at->format('H:i A'),
        ];
    }
}
