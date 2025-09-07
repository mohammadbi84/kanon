<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, $advertisement_id)
    {
        $ip = $request->ip();
            $ad = Advertisement::find(id: $advertisement_id);

        $like = Like::where('advertisement_id', $advertisement_id)
            ->where('ip_address', $ip)
            ->first();

        if ($like) {
            $like->delete();
            $ad->like_number -= 1;
            $ad->save();
            return response()->json(['liked' => false]);
        } else {
            Like::create([
                'advertisement_id' => $advertisement_id,
                'ip_address' => $ip,
            ]);
            $ad->like_number += 1;
            $ad->save();
            return response()->json(['liked' => true]);
        }
    }
    public function count($advertisement_id)
    {
        $count = Like::where('advertisement_id', $advertisement_id)->count();
        return response()->json(['count' => $count]);
    }
}
