<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\HistoryModel;
use App\User;

class HistoryController extends Controller
{
    public function show($userID)
    {
        
        $user = User::with('history')->find($userID);

        $history = $user->history->sortByDesc('created_at');

        $last_access = $history->first();

        $history = $history->groupBy(function($history) {

            return $history->created_at->format('Y-m-d');

        });

        return view('history-show')
            ->with('user', $user)
            ->with('history', $history)
            ->with('last_access', $last_access);

    }
}
