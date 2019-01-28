<?php

namespace Corals\User\Http\Controllers;

use Carbon\Carbon;
use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Foundation\Http\Requests\BulkRequest;
use Corals\User\DataTables\UsersDataTable;
use Corals\User\Facades\TwoFactorAuth;
use Corals\User\Http\Requests\UserRequest;
use Corals\User\Models\User;
use Illuminate\Http\Request;

class UsersController extends BaseController
{
    protected $excludedRequestParams = [
        'picture', 'channel', 'two_factor_auth_enabled',
        'password_confirmation', 'roles', 'clear', 'confirmed',
    ];

    public function __construct()
    {
        $this->resource_url = config('user.models.user.resource_url');

        $this->title = 'User::module.user.title';
        $this->title_singular = 'User::module.user.title_singular';

        parent::__construct();
    }

    /**
     * @param UserRequest $request
     * @param UsersDataTable $dataTable
     * @return mixed
     */
    public function index(UserRequest $request, UsersDataTable $dataTable)
    {
        return $dataTable->render('User::users.index');
    }

    /**
     * @param UserRequest $request
     * @return $this
     */
    public function create(UserRequest $request)
    {
        $user = new User();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('User::users.create_edit')->with(compact('user'));
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            if ($request->has('confirmed')) {
                $data['confirmed_at'] = Carbon::now();
            }

            $user = User::create($data);

            if (TwoFactorAuth::isActive() && $request->get('two_factor_auth_enabled')) {

                TwoFactorAuth::register($user);

                $twoFactorOptions = $user->getTwoFactorAuthProviderOptions();

                $twoFactorOptions['channel'] = $request->get('channel');

                $twoFactorOptions['enabled'] = $request->get('two_factor_auth_enabled') ? true : false;

                $user->two_factor_options = json_encode($twoFactorOptions);

                $user->save();
            }

            if ($request->hasFile('picture')) {
                $this->addMedia($request, $user);
            }

            $user->roles()->sync($request->roles);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, User::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param Request $request
     * @param User $user
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    protected function addMedia(Request $request, User $user)
    {
        $user->addMedia($request->file('picture'))
            ->withCustomProperties(['root' => 'user_' . $user->hashed_id])
            ->toMediaCollection('user-picture');
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return $this
     */
    public function show(UserRequest $request, User $user)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $user->full_name])]);

        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $user->hashed_id . '/edit']);

        return view('User::users.show')->with(compact('user'));
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return $this
     */
    public function edit(UserRequest $request, User $user)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $user->full_name])]);

        return view('User::users.create_edit')->with(compact('user'));
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            if (!$request->has('confirmed')) {
                $data['confirmed_at'] = null;
            } else {
                $data['confirmed_at'] = Carbon::now();
            }

            if (is_null($data['password'])) {
                unset($data['password']);
            }

            if (TwoFactorAuth::isActive()) {

                if (!TwoFactorAuth::isRegistered($user)) {
                    $user->setAuthPhoneInformation($data['phone_country_code'], $data['phone_number']);
                    $twoFactorOptions = TwoFactorAuth::register($user);
                } else {
                    $twoFactorOptions = $user->getTwoFactorAuthProviderOptions();
                }

                $twoFactorOptions['channel'] = $request->get('channel');
                $twoFactorOptions['enabled'] = $request->get('two_factor_auth_enabled') ? true : false;
                $data['two_factor_options'] = json_encode($twoFactorOptions);
            }

            $user->update($data);

            if ($request->has('clear') || $request->hasFile('picture')) {
                $user->clearMediaCollection('user-picture');
            }

            if ($request->hasFile('picture') && !$request->has('clear')) {
                $this->addMedia($request, $user);
            }

            $user->roles()->sync($request->roles);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, User::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(UserRequest $request, User $user)
    {
        try {
            if (user()->id == $user->id) {
                throw new \Exception(trans('User::exception.invalid_destroy_user'));
            }
            $user->syncRoles([]);
            $user->clearMediaCollection('user-picture');
            $user->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, User::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkAction(BulkRequest $request)
    {
        try {

            $action = $request->input('action');
            $selection = json_decode($request->input('selection'), true);


            switch ($action) {
                case 'delete':
                    foreach ($selection as $selection_id) {
                        $user = User::findByHash($selection_id);
                        $user_request = new UserRequest;
                        $user_request->setMethod('DELETE');
                        $this->destroy($user_request, $user);
                    }
                    $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
                    break;
            }


        } catch (\Exception $exception) {
            log_exception($exception, User::class, 'bulkAction');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }


    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function storeAddress(Request $request, User $user)
    {
        $this->validate($request, [
            'address.address_1' => 'required',
            'address.type' => 'required',
            'address.city' => 'required',
            'address.state' => 'required',
            'address.zip' => 'required',
            'address.country' => 'required',
        ], [], [
            'address.address_1' => 'address 1',
            'address.type' => 'type',
            'address.city' => 'city',
            'address.state' => 'state',
            'address.zip' => 'zip',
            'address.country' => 'country',
        ]);

        try {
            $address = $request->get('address');

            $userAddress = $user->address;

            if (!is_array($userAddress)) {
                $userAddress = [];
            }

            $addressType = array_pull($address, 'type');

            $userAddress[$addressType] = $address;

            $user->address = $userAddress;

            $user->save();

            $addressListForm = view('Settings::addresses.address_list_form', [
                'url' => url('users/' . $user->hashed_id . '/address'), 'method' => 'POST',
                'model' => $user,
                'addressDiv' => '#profile_addresses'
            ])->render();

            $message = [
                'level' => 'success', 'message' => trans('Corals::messages.success.saved', ['item' => trans('User::module.address.title')]),
                'action' => 'refresh_address',
                'address_list' => $addressListForm
            ];
        } catch (\Exception $exception) {
            log_exception($exception, User::class, 'storeAddress');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param $type
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Throwable
     */
    public function editAddress(Request $request, User $user, $type)
    {
        try {
            $userAddress = $user->address ?? [];

            $address = $userAddress[$type];
            $address['type'] = $type;

            $addressListForm = view('Settings::addresses.address_list_form', [
                'url' => url('users/' . $user->hashed_id . '/address'), 'method' => 'POST',
                'model' => $user,
                'object' => $address,
                'addressDiv' => '#profile_addresses'
            ])->render();

            return $addressListForm;

        } catch (\Exception $exception) {
            log_exception($exception, User::class, 'storeAddress');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
            return response()->json($message);
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroyAddress(Request $request, User $user, $type)
    {
        try {
            $userAddress = $user->address ?? [];

            unset($userAddress[$type]);

            $user->address = $userAddress;

            $user->save();

            $addressListForm = view('Settings::addresses.address_list_form', [
                'url' => url('users/' . $user->hashed_id . '/address'), 'method' => 'POST',
                'model' => $user,
                'addressDiv' => '#profile_addresses'
            ])->render();

            $message = [
                'level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => trans('User::module.address.title')]),
                'action' => 'refresh_address',
                'address_list' => $addressListForm
            ];
        } catch (\Exception $exception) {
            log_exception($exception, User::class, 'storeAddress');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}