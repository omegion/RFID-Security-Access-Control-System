<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\User;

//Events
use App\Events\CardIsFound;
use App\Events\CardIsNotFound;

class CardController extends Controller
{
    
    public function read($cardId)
    {
        
        //check card id is exists
        $user = User::where('card_id', $cardId)->first();

        if (is_null($user)) {

            event(new CardIsNotFound($cardId));
            
            return 'not found';

        } else {
            
            event(new CardIsFound($user));

            return 'found';
            
        }

    }
    
    public function store(Request $request, $cardId)
    {
        
        //add user
        $user = new User;
        $user->name = $request->firstname .' '. $request->lastname; 
        $user->title = $request->title; 
        $user->email = $request->email;
        $user->card_id = $request->cardID;
        $user->save();

        

    }

}
