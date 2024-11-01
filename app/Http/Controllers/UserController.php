<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\PasswordUpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;


class UserController extends Controller
{
  public function create()
  {
    return view('user.create');
  }

  // public function store(Request $request)
  public function store(StoreUserRequest $request)
  {

    $request->validate([
      'name' => ['required', 'max:255'],
      'email' => ['required', 'email', 'max:255', 'unique:users'],
      'login' => ['required', 'min:3', 'max:255', 'unique:users'],
      'password' => ['required', 'confirmed']
    ]);

    // dd($request->all());
    $user = User::create($request->all());

    event(new Registered($user));
    Auth::login($user);

    // return redirect()->route('login')->with('success', 'Зареєстровано');
    // dd($request->all());

    return redirect()->route('verification.notice');
  }


  public function login()
  {
    return view('user.login');
  }

  public function loginAuth(Request $request): RedirectResponse
  {
    // dump($request->boolean('remember'));
    // dd($request->all());


    $credentials = $request->validate([
      'login' => ['required'],
      'password' => ['required'],
    ]);

    // 'is_active'=>'1'
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
      // перестворення/ утворення нової сесії для користувача
      $request->session()->regenerate();
      return redirect()->intended('dashboard')->with('success', 'Доброго дня, ' . Auth::user()->name . '!');
    }

    //   return back()->withErrors([
    //     'email' => 'The provided credentials do not match our records.',
    // ])->onlyInput('email');

    return back()->withErrors([
      'email' => 'Йой, то шо таке не таке. Невірний логін або пароль.'
    ]);
  }

  public function logout()
  {
    Auth::logout();
    return redirect()->route('login');
  }

  // краще створити окремий контролер під адмінку
  public function dashboard()
  {
    return view('user.dashboard');
  }

// відправка пароля на email
public function forgotPasswordStore(Request $request){
  $request->validate(['email' => 'required|email']);

  $status = Password::sendResetLink(
      $request->only('email')
  );

  return $status === Password::RESET_LINK_SENT
              // ? back()->with(['sent' => __($status)])
              ? back()->with(['success' => __($status)])
              : back()->withErrors(['email' => __($status)]);
}

public function resetPasswordUpdate(PasswordUpdateUserRequest $request){

    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:3|confirmed',
    ]);
    
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => $password
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('success', __($status))
                : back()->withErrors(['email' => [__($status)]]);
}
}

