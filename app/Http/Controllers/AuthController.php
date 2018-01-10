<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\SocialProvider;
use App\User;
class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        //dd($provider);
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try{

            $socialUser = Socialite::driver($provider)->user();
        }catch(Exception $e){
            return redirect('/');
        }
        //checks if we have logged provider
        $socialProvider=SocialProvider::where('provider_id',$socialUser->getId())->first();
        if(!$socialProvider){
            $user=User::where('email',$socialUser->getEmail())->first();
            if(!$user){
                //create a new user and provider
                $user=new User();
                $user->email=$socialUser->getEmail();
                $user->name=$socialUser->getName();
                $user->image=$socialUser->getAvatar();
                $user->role_id='1';
                $user->save();
            }else{
                //create a new social provider 
                $socialProvider=new SocialProvider();
                $socialProvider->user_id=$user->id;
                $socialProvider->provider_id=$socialUser->getId();
                $socialProvider->provider=$provider;
                $socialProvider->save(); 
            }
        }else{
            $user=$socialProvider->user;
        }
        auth()->login($user);
        return redirect()->route('/');
    }
}
