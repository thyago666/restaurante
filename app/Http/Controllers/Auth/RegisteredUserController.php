<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    /*   public function create(): View
    {
        return view('auth.register');
    }*/

    public function index()
    {

        if (Gate::allows('viewUser')) {
            $usuario = User::all();
            return view('viewUsuarios', compact('usuario'));
        } else {
            abort(403);
        }
    }

    public function create()
    {
        if (Gate::allows('viewUser')) {
            return view('auth.register');
        } else {
            abort(403);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) //: RedirectResponse
    {
        if (Gate::allows('viewUser')) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'password' => Hash::make($request->password),
                'admin' => $request->admin,
            ]);

            $databaseName = $request->company;

            try {
                DB::statement("CREATE DATABASE `$databaseName`");
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to create database: ' . $e->getMessage()], 500);
            }

            // Atualiza a configuração para usar o novo banco de dados
            Config::set('database.connections.mysql_2.database', $databaseName);
            DB::purge('mysql_2'); // Limpa a conexão para recarregar a configuração

            try {
                Artisan::call('migrate', [
                    '--database' => 'mysql_2',
                    '--path' => 'database/migrations',
                    '--force' => true
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to run migrations: ' . $e->getMessage()], 500);
            }

            // Retorne uma resposta de sucesso ou prossiga com outras operações
            return redirect()->route('indexUser');
            Event(new Registered($user));

            // Auth::login($user);
            return redirect()->route('indexUser');
            //return redirect(route('dashboard', absolute: false));
        } else {
            abort(403);
        }
    }

    public function delete($id)
    {
        if (Gate::allows('viewUser')) {
            $item = User::find($id);
            $item->delete();

            DB::statement("DROP DATABASE `$item->company`");
            return redirect()->route('indexUser');
        } else {
            abort(403);
        }
    }
}
