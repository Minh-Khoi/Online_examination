<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * they can be filled by custom 's values
     * The attributes "visible_password", "occupation", "address", "phone", "is_admin"
     * are custom 's fields, the attributes 'name', 'email', 'password' are built-in
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', "visible_password", "occupation", "address", "phone", "is_admin"
    ];

    /**
     * The attributes that should be hidden for arrays.
     * The "visible_password" field was added by developer,
     * we need it hidden when the User instance is passed to client side
     * @var array
     */
    protected $hidden = [
        "visible_password", 'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * this function set the attributes $visible_password and $password (enscrypted form of $visible_password)
     * concurrently. I DO NOT use Mutator because Mutator can set ONLY ONE attribute
     *  which is called by function name. See link below
     * https://laracasts.com/discuss/channels/general-discussion/setting-another-attribute-from-within-a-mutator?page=2
     * This function might not neccessary to use because the RegisterController save User 's
     * "visible_password" and "password" (had been enscrypted) concurrently
     * @param string $password_which_is_visible is the value passed in Request object
     * (sent from front-end through API)
     */
    public function set_password_and_visible_password(string $password_which_is_visible)
    {
        $this->visible_password = $password_which_is_visible;
        $this->password = Hash::make($password_which_is_visible);
    }
}