<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Like;

class LikeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function like($image_id){
        //Recoger datos del usuario que esta logueado
        $user = \Auth::user();
        //Condicion para saber si ya existe el like y no duplicarlo
        $isset_like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->count();
        if($isset_like == 0){
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id;
            $like->save();
            
            return response()->json([
                'like' => $like
            ]);
        }else{
            return response()->json([
                'message' => 'El like ya existe'
            ]);
        }
        
        
    }
    public function dislike($image_id){
        //Recoger datos del usuario que esta logueado
        $user = \Auth::user();
        //Condicion para saber si ya existe el like y no duplicarlo
        $like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->first();//metodo que permite sacar un unico objeto
        if($like){ 
            
            $like->delete();
            
            return response()->json([
                'like' => $like,
                'message' => 'Has dado dislike correctamente'
            ]);
        }else{
            return response()->json([
                'message' => 'No se dio dislike correctamente'
            ]);
        }
        
    }
    public function index(){
        $user = \Auth::user();
        $likes = Like::where('user_id', $user->id)->orderBy('id', 'desc')
                                                  ->paginate(5);
        return view('like.index', ([
            'likes' => $likes
        ]));
    }
}
