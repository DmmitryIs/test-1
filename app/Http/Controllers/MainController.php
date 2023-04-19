<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ClickService;
use App\Services\LinkService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    public function registration(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'phone' => 'required|numeric|min:10|max:15|unique:users,phone',
                'name' => 'required|min:2|max:120',
            ]);

            $service = new UserService();

            try {
                $data = $request->all();

                $user = $service->createUser([
                    'phone' => trim($data['phone']),
                    'name' => trim($data['name']),
                ]);

                return redirect()->route('main', $user->link);
            } catch (\Exception $exception) {
                $service->deleteCurrent();

                Log::error($exception->getMessage());

                return back()->with('error', 'Unexpected error')->withInput();
            }
        }

        return view('signup');
    }

    public function main($hash, $show = null)
    {
        $hash = trim(strip_tags($hash));
        $service = new LinkService();
        if (!$link = $service->get($hash)) {
            return redirect()->route('registration');
        }

        Auth::login($link->user);

        $data = [
            'url' => route('main', $link->value),
            'hash' => $link->value,
        ];

        try {
            if ($show === 'win') {
                $data['click'] = (new ClickService())->create($link);
            } else if ($show === 'history') {
                $data['history'] = $service->history();
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return back()->with('error', 'Unexpected error');
        }

        return view('main', $data);
    }

    public function generate()
    {
        /**
         * @var $user User
         */
        $user = Auth::user();

        try {
            (new LinkService())->generate($user);

            return redirect()->route('main', $user->link);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return back()->with('error', 'Unexpected error');
        }
    }

    /**
     * @throws \Exception
     */
    public function deactivate(Request $request)
    {
        $request->validate([
            'hash' => 'required|string',
        ]);

        /**
         * @var $user User
         */
        $user = Auth::user();
        $service = new LinkService();
        $hash = trim(strip_tags($request->input('hash')));

        try {
            if (!$link = $service->get($hash)) {
                abort(404);
            }

            if ($user->id !== $link->user->id) {
                throw new \Exception('Auth error');
            }

            $service->deactivate();

            if ($user->link) {
                return redirect()->route('main', $user->link)
                    ->with('message', 'Success! You are redirected to your another link.');
            }

            return redirect()->route('registration');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return back()->with('error', 'Unexpected error');
        }
    }
}
