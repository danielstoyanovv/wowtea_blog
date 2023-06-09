<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index', ['users' => User::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.users.edit', ['user' => User::find($id)]);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        if ($request->getMethod() == "PATCH") {
            $validated = $request->validated();
            if (!empty($this->handleUserExistsData($request, $user)['exists'])) {
                session()->flash('message', sprintf("%s already exists", $request->get('email')));
                return redirect()->action([self::class, 'edit'], ['user' => $user->id]);
            }
            try {
                if ($request->has('image')) {
                    $validated['image'] = \App\Helpers\ImageUploader::handleImageRequestData($request);
                }
                $user->update($validated);
                session()->flash('message', __('User was updated'));
                return redirect()->action([self::class, 'edit'], ['user' => $user->id]);

            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }
        }

        throw new NotFoundHttpException();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param User $user
     * @return array|int[]
     */
    private function handleUserExistsData(Request $request, User $user): array
    {
        return ($request->get('email') !==  $user->email && $this->checkIfEmailExists($request->get('email')) ? [
            'exists' => 1
        ] :  []);
    }

    /**
     * @param string $email
     * @return bool
     */
    private function checkIfEmailExists(string $email): bool
    {
        return (bool)((User::where('email', $email)->first()));
    }
}

