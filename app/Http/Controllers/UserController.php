<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index($search = null) {
        if ($search) {
            $users = User::where('nick', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('surname', 'LIKE', '%' . $search . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(5);
            return view('user.index', [
                'users' => $users
            ]);
        } else {
            $users = User::orderBy('id', 'desc')->paginate(5);
            return view('user.index', [
                'users' => $users
            ]);
        }
    }

    public function config() {
        return view('user.config');
    }

    public function update(Request $request) {
        //Recibir datos del formulario
        $user = \Auth::user();
        $id = $user->id;

        $validate = $this->validate($request, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id
        ]);

        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        //Asignar valores al objeto
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //Subir la imagen

        $image_path = $request->file('image_path');
        if ($image_path) {
            //Asigno el nombre a la imagen
            $image_path_name = time() . $image_path->getClientOriginalName(); //time() para que el nombre sea unico y el getclient para que sea el nombre del fichero original cuando lo suba el usuario
            //Guardo la imagen en users con el metodo put
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            //Setear la imagen en el objeto
            $user->image = $image_path_name;
        }


        //Actualizar objeto
        $user->update();
        return redirect()->route('config')
                        ->with(['message' => 'Usuario actualizado correctamente']);
    }

    public function getImage($filename) {
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }

    public function profile($id) {
        $user = User::find($id);
        return view('user.profile', [
            'user' => $user
        ]);
    }

}
