<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\sellerProducks;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'userType',
        'address',
        'phone',
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function products()
    {
        return $this->hasMany(sellerProduck::class, 'seller_id');
    }
    public function buyerOrders()
    {
        return $this->hasMany(BuyOrder::class, 'buyer_id');
    }

    public function sellerOrders()
    {
        return $this->hasMany(BuyOrder::class, 'seller_id');
    }

    public function userLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = $this->where('email', $email)->first();
    
        if ($user) {
            if (Hash::check($password, $user->password)) {
                return (object) ['success' => true, 'user' => $user];
            } else {
                return (object) ['success' => false, 'error' => 'Invalid password'];
            }
        } else {
            return (object) ['success' => false, 'error' => 'User not found'];
        }
    }
    

    public function addUser(Request $request)
    {
        try{
        $name = $request->input('name');
        $email = $request->input('email');
        $userType = $request->input('userType');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $balance = $request->input('balance');
        $password = $request->input('password');
    
        if ($userType == "buyer") {
            $addUser = new User();
            $addUser->name = $name;
            $addUser->email = $email;
            $addUser->userType = $userType;
            $addUser->address = $address;
            $addUser->phone = $phone;
            $addUser->balance = $balance;
            $addUser->password = Hash::make($password);
            $addUser->save();
        } else {
            $addUser = new User();
            $addUser->name = $name;
            $addUser->email = $email;
            $addUser->userType = $userType;
            $addUser->password = Hash::make($password);
            $addUser->save();
        }
    
        if ($addUser) {
            return (object) ['success' => true];
            
        } else {
            return (object) ['success' => false , 'message' => 'User Not Added'  , 'error' => "Error adding user"];
        }
    }catch(\Exception $e){
        return (object) ['success' => false , 'message' => 'Error adding user'  , 'error' => $e->getMessage()];
        }
    }

    public function updateUser(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $userType = $request->input('userType');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $balance = $request->input('balance');
        $password = $request->input('password');

        $data=[];

        if(!empty($name)){
            $data['name'] = $name;
        }
        if(!empty($userType)){
            $data['userType'] = $userType;
        }
        if(!empty($address)){
            $data['address'] = $address;
        }
        if(!empty($phone)){
            $data['phone'] = $phone;
        }
        if(!empty($balance)){
            $data['balance'] = $balance;
        }
        if(!empty($password)){
            $data['password'] = Hash::make($password);
        }

        $updateUser = $this->where('id', $id)->update($data);
    
        if ($updateUser) {
            return (object) ['success' => true , 'message' => 'User Updated' ];
        } else {
            return (object) ['success' => false , 'message' => 'User Not Updated'  , 'error' => "Error updating user"];
        }
    }

    public function changePassword(Request $request)
    {
        $id = $request->input('id');
        $password = $request->input('password');
        $newPassword = $request->input('newPassword');
        $user = $this->where('id', $id)->first();
    
        if ($user) {
            if (Hash::check($password, $user->password)) {
                $user->password = Hash::make($newPassword);
                $user->save();
                return (object) ['success' => true, 'message' => 'Password Changed'];
            } else {
                return (object) ['success' => false, 'error' => 'Invalid password'];
            }
        } else {
            return (object) ['success' => false, 'error' => 'User not found'];
        }
    }
    
}
