<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Like;
use App\Comment;

class ImageController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {
        return view('image.create');
    }

    public function save(Request $request) {
        //Validacion
        $validate = $this->validate($request, [
            'image_path' => 'image|required',
            'description' => 'required'
        ]);

        //Recibir los datos 
        $user = \Auth::user();
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;

        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName(); //nombre de la imagen
            Storage::disk('images')->put($image_path_name, File::get($image_path)); //con put inserto la imagen en el disco de storage, y con file::get se encarga de mover el archivo que esta guardado temporalmente a la carpeta de images
            $image->image_path = $image_path_name;
        }

        $image->save();

        return redirect()->route('home')
                        ->with([
                            'message' => 'Imagen subida correctamente'
        ]);
    }

    public function getImage($filename) {
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function imageDetail($id) {
        $image = Image::find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }

    public function delete($id) {
        $user = \Auth::user();
        $image = Image::find($id);
        $likes = Like::where('image_id', $id)->get();
        $comments = Comment::where('image_id', $id)->get();

        if ($user && $image->user->id == $user->id) {
            //Borrar likes
            if (count($likes) >= 1) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }
            //Borrar comentarios
            if (count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }
            //Borrar imagen de el disco de storage y de la base de datos
            Storage::disk('images')->delete($image->image_path);
            $image->delete();

            return redirect()->route('home')->with([
                    'success' => 'La imagen se borro correctamente'
        ]);
        } else {
            return redirect()->route('home')->with([
                    'error' => 'La imagen no se pudo borrar correctamente'
        ]);
        }   
    }

    public function edit($id){
        $user = \Auth::user();
        $image = Image::find($id);
        
        if($user && $image && $image->user->id == $user->id){
            return view('image.edit', ['image' => $image]);
        } else {
            return redirect()->route('home');
        }
    }
    
    public function update(Request $request){
        $validate = $this->validate($request, [
            'image_path' => 'image',
            'description' => 'required'
        ]);
        
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description =  $request->input('description');
        
        $image = Image::find($image_id);
        $image->description = $description;
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }
        $image->update();
        
        return redirect()->route('image.detail', ['id' => $image_id])
                         ->with(['success' => 'La imagen se actualizo correctamente']);
    }
    
}
