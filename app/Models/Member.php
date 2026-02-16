<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $fillable = [
        'name',
        'email',
        'nap',
        'phone',
        'birthdate',
        'gender',
        'workplace',
        'diploma_number',
        'str_number',
        'sip_number',
        'status',
        'joined_at',
        'ijazah_file',
        'str_file',
        'foto_file',
    ];

    public function getIsProfileCompleteAttribute(): bool
    {
        return filled($this->nap)
            && filled($this->gender)
            && filled($this->birthdate)
            && filled($this->phone)
            && filled($this->ijazah_file)
            && filled($this->str_file)
            && filled($this->foto_file);
    }

    public function profileCompletion()
    {
        $fields = [
            'nap',
            'gender',
            'birthdate',
            'phone',
            'diploma_number',
            'str_number',
            'ijazah_file',
            'str_file',
            'foto_file',
        ];

        $filled = 0;

        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filled++;
            }
        }

        $total = count($fields);

        return [
            'filled' => $filled,
            'total' => $total,
            'percent' => round(($filled / $total) * 100),
            'complete' => $filled === $total,
        ];
    }



    public function event()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function user()
    {
        return $this->hasOne(User::class,'member_id');
    }

    public function boardMembers()
    {
        return $this->hasMany(BoardMember::class);
    }

    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function sipRecommendations()
    {
        return $this->hasMany(SipRecommendation::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function mutations()
    {
        return $this->hasMany(Mutation::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
