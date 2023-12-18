<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PermissionFolder\Models\Role;
use App\User;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UpdateUserRequest;
use Hash;
use App\Http\Requests\UpdatePasswordRequest;
use Auth;
use App\Http\Requests\UpdateProfilePictureRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use App\Farm;
use App\Client;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess', 'user.index');

        $users = User::with('roles')->orderBy('id', 'DESC')->paginate(10);
        //return $users;
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->pluck('name', 'id');
        $farmsList = Farm::select('id', 'name', 'tradename')->orderBy('name', 'ASC')->get();
        $clientsList = Client::select('id', 'name')->orderBy('name', 'ASC')->get();

        return view('user.create', compact('roles', 'farmsList', 'clientsList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // Validator::make($request, [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);
        //dd($request);
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'type_user' => $request->type_user,
            'password'  => Hash::make($request->password),
        ]);

        $user->roles()->sync($request->get('roles'));

        return redirect()->route('user.index')
            ->with('status_success', 'User creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', [$user, ['user.show', 'userown.show']]);
        $roles = Role::orderBy('name', 'ASC')->pluck('name', 'id');

        //dd($user->roles[0]->name);
        return view('user.show', compact('user', 'roles'));
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        $this->authorize('update', [$user, ['user.edit', 'userown.edit']]);
        
        $roles = Role::orderBy('name', 'ASC')->pluck('name', 'id');
        $farmsList = Farm::select('id', 'name', 'tradename')->orderBy('name', 'ASC')->get();
        $clientsList = Client::select('id', 'name')->orderBy('name', 'ASC')->get();
        //dd($roles);
        
        return view('user.edit', compact('user', 'roles', 'farmsList', 'clientsList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        $user->update($request->all());

        $user->roles()->sync($request->get('roles'));

        return redirect()->route('user.index')
            ->with('status_success', 'User actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Gate::authorize('haveaccess', 'user.destroy');

        $user->delete();

        return back()->with('status_success', 'Eliminado correctamente');
    }

    public function password()
    {
        return view('user.password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        if(Hash::check($request->mypassword, \Auth::user()->password)){
            $user = new User;
            $user->where('email', '=', \Auth::user()->email)
                ->update(['password' => bcrypt($request->password)]);

            return redirect()->route('user.index')
                ->with('status_success', 'Contraseña actualizada con éxito');
        }else{
            return redirect()->route('user.index')
                ->with('status_success', 'Credenciales Incorrectas');
        }
    }

    public function updateProfilePicture(UpdateProfilePictureRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $file = $request->file('image');
        //$name = Str::random(30) . '-' . $request->file('image')->getClientOriginalName();
        $nameImage = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
        $path = public_path() . '/profiles/';
        if($file->move($path, $nameImage))
        {
            \File::delete(public_path() . '/profiles/' . $user->profile);
        }
        $user->where('email', '=', Auth::user()->email)
            ->update(['profile' => $nameImage]);

        return redirect()->route('user.show', Auth::user()->id)
            ->with('status_success', 'Foto actualizada con éxito');
    }
}
