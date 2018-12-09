<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\VerifiesEmails;

class UserController extends Controller
{
    use VerifiesEmails;

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = new User;
        $s = $request->s ? $request->s : null;
        $of = $request->order_field ? $request->order_field : 'id';
        $od = $request->order_direction ? $request->order_direction : 'desc';
        $users = $user->search($s)
            ->orderBy($of, $od)
            ->get();

        $data = [
            'users' => $users,
            'order_field' => $of,
            'order_direction' => $od,
            's' => $s,
        ];

        return view('users.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|string|max:255|unique:users,email',
            'gender' => 'required|string|in:male,female',
            'description' => 'required|string',
            'photo' => 'image',
            'attachment' => 'mimes:pdf,xls,xlsx,csv',
        ]);

        $user = new User;

        $photo = $user->uploadFileIfExist($request, 'photo');
        $attachment = $user->uploadFileIfExist($request, 'attachment');

        $user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'description' => $request->description,
                'photo' => $photo,
                'attachment' => $attachment
            ]);

        $request->session()->flash('success', __('User #' . $request->id . ' has been successfully added'));

        return redirect()->route('users.index');
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
        $user = User::find($id);

        return view('users.edit')->with('storedUser', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|string|max:255|unique:users,email,'.$id,
            'gender' => 'required|string|in:male,female',
            'description' => 'required|string',
            'photo' => 'image',
            'file' => 'mimes:pdf,xls,xlsx,csv',
        ]);

        $u = new User;
        $user = User::find($id);

        $photo = $u->uploadFileIfExist($request, 'photo', $user->photo);
        $attachment = $u->uploadFileIfExist($request, 'attachment', $user->attachment);

        $user->name = $request->name;
        $user->email = $request->email;
        if ( $request->old_email != $request->email ) {
            $user->email_verified_at = null;
        }
        $user->gender = $request->gender;
        $user->description = $request->description;
        $user->photo = $photo;
        $user->attachment = $attachment;

        $user->save();

        $request->session()->flash('success', __('User #' . $id . ' has been successfully updated'));

        if ($request->old_email != $request->email) {
            $this->resend($request);
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);

        $user->delete();

        $request->session()->flash('success', __('User #' . $id . ' has been successfully deleted'));

        return redirect()->route('users.index');
    }

    public function updateField(Request $request)
    {
        if($request->ajax()){
            switch ( $request->get( 'name' ) ) {
                case "name":
                    $validationRules[ 'value' ] = 'required|string|max:255';
                case "email":
                    $validationRules[ 'value' ] = 'required|string|max:255|unique:users,email,'.$request->get('pk');
                    break;
                case "gender":
                    $validationRules[ 'value' ] = 'required|string|in:male,female';
                    break;
                case "description":
                    $validationRules[ 'value' ] = 'required|string';
                    break;
                default:
                    break;
            }

            $validator = Validator::make($request->all(), $validationRules);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()], 400);
            }

            $user = new User;
            $user->find($request->get('pk'))->update([$request->get('name') => $request->get('value')]);
            return response()->json(['success'=>true]);
        }
    }
}
