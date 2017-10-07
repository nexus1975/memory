<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use Auth;
use Mail;
use App\User;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

        public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required'
		]);

		$credentials = $request->only('email', 'password');
                $credentials = array_add($credentials, 'status', 1);
                
		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
                    //Auth hashtag http://stackoverflow.com/questions/40654710/laravel-login-redirect-loses-the-url-hash
                    $newRequest = redirect()->intended($this->redirectPath());
                    $newRequest->setTargetUrl($newRequest->getTargetUrl().$request->urlHash);
                    return $newRequest;
                    //return redirect()->intended($this->redirectPath());
		}
         
		return redirect($this->loginPath())
					->withInput($request->only('email', 'remember'))
					->withErrors([
						'email' => $this->getFailedLoginMessage(),
					]);
	}        
	public function postRegister(Request $request)
	{
                $rqs = $request->all();
		$validator = $this->registrar->validator($rqs);

		if ($validator->fails()) {
			$this->throwValidationException($request, $validator);
		}

		$user = $this->registrar->create($rqs);
                
                $data = $rqs;
                $data['activation_token'] = $user->activation_token;
                Mail::send(['html'=>'emails.confirm'], $data, function($message) use ($data) {
                    $date = date("F j, Y, g:i:s a");
                    $message->to($data['email'], $data['name'])->subject('Welcome to Memory Game'); //.$date.$data['activation_token']
                });
                
                return view('auth.confirm', [ 'email' => $rqs['email'],
                                               'name' => $rqs['name'] ]);
	}   
        /**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function getConfirm(Request $request, $token)
	{
		/*$validator = $this->registrar->validator($request->all());
		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}
		$this->auth->login($this->registrar->create($request->all()));
		return redirect($this->redirectPath());*/
            
            try {
                $user = User::where('activation_token', '=', $token)
                            ->where('status', '=', 0)
                            ->whereDate('activation_token_expire', '>', new \DateTime())
                            ->get()->first();              
                if ($user /*instanceof App\User*/) {
                    $user->status = 1;
                    $user->activation_token = 'EXP#'.$user->activation_token;
                    $user->activation_token_expire = null;
                    $user->save();  
                    $this->auth->login($user);
                    return redirect('home');                    
                } else {
                    return view('auth.confirm-error', ['token'=>$token]);
                }
            } catch (Exception $e) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
                /*
                         * if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
        return response()->json([
            'data' => [
                'message' => 'Resource not found',
                'status_code' => Response::HTTP_NOT_FOUND
            ]
        ], Response::HTTP_NOT_FOUND);
    } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
        return response()->json([
            'data' => [
                'message' => 'Endpoint not found',
                'status_code' => Response::HTTP_NOT_FOUND
            ]
        ], Response::HTTP_NOT_FOUND);
    }

    return response()->json([
            'data' => [
                'message' => $e->getMessage(),
                'status_code' => Response::HTTP_BAD_REQUEST
            ]
        ], Response::HTTP_BAD_REQUEST);
                         */
            }
	}
        
}
