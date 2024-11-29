<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\classes;
use App\Models\members;
use App\Models\payments;
use App\Models\trainers;
use App\Models\memberships;
use Illuminate\Http\Request;
use App\Models\specializations;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $trainersCount = trainers::count();
        $exerciseCount = specializations::count();
        return view('admin.index', compact('trainersCount', 'exerciseCount'));
    }

    public function shipsIndex()
    {
        $memberships = memberships::all();
        return view('admin.memberships.index', compact('memberships'));
    }

    public function shipsActive($id)
    {
        $membership = memberships::find($id);
        $membership->status = 'active';
        $membership->save();

        return redirect()->route('membership-index')->with('active', 'Membership Activated');
    }


    public function shipsInactive($id)
    {
        $membership = memberships::find($id);
        $membership->status = 'inactive';
        $membership->save();

        return redirect()->route('membership-index')->with('inactive', 'Membership Inactivated');
    }


    public function membersIndex()
    {
        $memberships = memberships::where('status', '=', 'active')->get();
        $members = members::join('memberships', 'memberships.id', '=', 'members.membership_id')
            ->select('members.*', 'memberships.type')
            ->get();

        return view('admin.members.index', compact('memberships', 'members'));
    }

    public function membersStore(Request $req)
    {
        $member = new members();
        $member->first_name = $req->first_name;
        $member->last_name = $req->last_name;
        $member->phone = $req->phone;
        $member->email = $req->email;
        $member->address = $req->address;
        $member->membership_id = $req->membership_id;
        $member->joining_date = $req->joining_date;
        $member->save();

        $membership=memberships::find($req->membership_id);

        $payment = new payments();
        $payment->member_id = $member->id;
        $payment->membership_id = $req->membership_id;
        $payment->total_amount = $membership->price;
        $payment->paid_amount = 0;
        $payment->save();

        return redirect()->route('members-index')->with('success', "Member Registered");
    }

    public function trainerIndex()
    {
        $specializations = specializations::all();
        $trainers = trainers::join('specializations', 'specializations.id', '=', 'trainers.specialization_id')
        ->select('trainers.*','trainers.name as trainer_name', 'specializations.*', 'specializations.name as specialization')
        ->get();
        return view('admin.trainer.index', compact('specializations', 'trainers'));
    }

    public function trainerStore(Request $req)
    {
        $trainer = new trainers();
        $trainer->name = $req->name;
        $trainer->specialization_id = $req->specialization;
        $trainer->phone = $req->phone;
        $trainer->email = $req->email;
        $trainer->salary = $req->salary;
        $trainer->save();

        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make(12345678);
        $user->role = 1;
        $user->save();

        //ispe ek dimagh mein code run kiya tha isko baad mein dekhna hai mujhe. importance:high

        return redirect()->route('trainers-index')->with('success', 'Trainer Added');
    }

    public function getTrainer($id)
    {
        $trainers = trainers::where('specialization_id', $id)->get(['id', 'name']);
        return response()->json($trainers);
    }

    public function classesIndex()
    {
        $specializations = specializations::all();
        $trainers = trainers::all();
        return view('admin.classes.index', compact('specializations'));
    }
    public function classesStore(Request $req)
    {
        $class = new classes();
        $class->specialization_id = $req->exercise;
        $class->trainerId = $req->trainer_id;
        $class->start_date = $req->start_date;
        $class->end_date = $req->end_date;
        $class->fees = $req->fees;
        $class->days = $req->days;
        $class->time = $req->time;
        $class->capacity = $req->capacity;

        $class->save();

        return redirect()->route('classes-index')->with('success', 'Class Registered');
    }


    public function paymentIndex()
    {
        $payments = payments::join('members', 'payments.member_id', '=', 'members.id')
            ->select('payments.*', 'members.*')
            ->get();
        return view('admin.payments.index', compact('payments'));
    }


}
