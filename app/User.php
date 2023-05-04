<?php
namespace App;


use App\Models\ArtistProfile;
use App\Models\City;
use App\Models\UserReview;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
*/
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;


    protected $fillable = ['uuid','full_name','email','language','phone', 'password', 'remember_token','gender','otp','profile_image'];
    protected $hidden = ['password']; 
   
  
 
    
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

  

    
    public function artist(){
        return $this->hasOne(ArtistProfile::class,'user_id');
    }

    

    public function avergaeRating(){
        $instance= $this->hasMany(UserReview::class,'reviewee_id')->orderBy('rating','DESC');
      
        return $instance;
    }

    public function getAverageRatingAttribute(){
        return $this->avergaeRating()->average('rating');
    }
    
     
}
