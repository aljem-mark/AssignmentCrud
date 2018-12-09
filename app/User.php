<?php

namespace App;

use Storage;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'description', 'photo', 'attachment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeSearch($query, $q) {
        return $query->where('name', 'like', '%' . $q . '%')
            ->orWhere('email', 'like', '%' . $q . '%')
            ->orWhere('description', 'like', '%' . $q . '%');
    }

    public function uploadFileIfExist(Request $request, $f, $oldFilename = null) {
        if ($request->hasFile($f)) {
            $filename = uniqid() . "_" . $request->file($f)->getClientOriginalName();
            $file = $request->file($f);
            $file->storePubliclyAs('upload', $filename, 'public');
            Storage::disk('public')->delete('upload/' . $oldFilename);
        } else {
            return $oldFilename;
        }

        return $filename;
    }

    /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }
}
