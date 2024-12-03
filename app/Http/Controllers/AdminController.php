<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\classes;
use App\Models\members;
use App\Models\payments;
use App\Models\trainers;
use App\Models\enrollments;
use App\Models\memberships;
use App\Models\payment_logs;
use Illuminate\Http\Request;
use App\Models\specializations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $trainersCount = trainers::count();
                $exerciseCount = specializations::count();
                return view('admin.index', compact('trainersCount', 'exerciseCount'));
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function shipsIndex()
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $memberships = memberships::all();
                return view('admin.memberships.index', compact('memberships'));
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function shipsStore(Request $req)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $m = new memberships();
                $m->type = $req->type;
                $m->duration = $req->duration;
                $m->price = $req->price;

                $m->save();
                return redirect()->route('membership-index')->with('success', 'Membership Created');
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function shipsActive($id)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $membership = memberships::find($id);
                $membership->status = 'active';
                $membership->save();

                return redirect()->route('membership-index')->with('active', 'Membership Activated');
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }


    public function shipsInactive($id)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $membership = memberships::find($id);
                $membership->status = 'inactive';
                $membership->save();

                return redirect()->route('membership-index')->with('inactive', 'Membership Inactivated');
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getMembership($id){
        $membership = memberships::select('id', 'type', 'duration', 'price')->find($id);
        return response()->json($membership);

    }

    public function shipsUpdate(Request $req){
        $id = $req->id;
        $membership = memberships::find($id)->first();
        $membership->type = $req->type;
        $membership->duration = $req->duration;
        $membership->price = $req->price;

        $membership->save();

        return redirect()->route('membership-index')->with('update', 'Membership Updated');
    }
    public function shipsDelete(Request $req){
        $id = $req->id_;
        $membership = memberships::find($id);
        $membership->delete();
        return redirect()->route('membership-index')->with('delete', 'Membership Delete');
    }
    public function getSpecialization($id){
        $specialization = specializations::select('id', 'name')->find($id);
        return response()->json($specialization);

    }

    public function specializationUpdate(Request $req){
        $id = $req->id;
        $specialization = specializations::find($id)->first();
        $specialization->name = $req->name_;

        $specialization->save();

        return redirect()->route('specialization-index')->with('update', 'Specialization Updated');
    }
    public function specializationDelete(Request $req){
        $id = $req->id_;
        $specialization = specializations::find($id);
        $specialization->delete();
        return redirect()->route('specialization-index')->with('delete', 'Specialization Delete');
    }

    public function specializationIndex()
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $specializations = specializations::all();
                return view('admin.specializations.index', compact('specializations'));
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function specializationStore(Request $req)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $s = new specializations();
                $s->name = $req->name;

                $s->save();
                return redirect()->route('specialization-index')->with('success', 'Specialization Created');
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function specializationActive($id)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $specialization = specializations::find($id);
                $specialization->status = 'active';
                $specialization->save();

                return redirect()->route('specialization-index')->with('active', 'Specialization Activated');
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }


    public function specializationInactive($id)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $specialization = specializations::find($id);
                $specialization->status = 'inactive';
                $specialization->save();

                return redirect()->route('specialization-index')->with('inactive', 'Specialization Inactivated');
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }


    public function membersIndex()
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $memberships = memberships::where('status', '=', 'active')->get();
                $members = members::join('memberships', 'memberships.id', '=', 'members.membership_id')
                    ->select('members.*', 'memberships.type')
                    ->get();

                return view('admin.members.index', compact('memberships', 'members'));
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function membersStore(Request $req)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $member = new members();
                $member->first_name = $req->first_name;
                $member->last_name = $req->last_name;
                $member->phone = $req->phone;
                $member->email = $req->email;
                $member->address = $req->address;
                $member->membership_id = $req->membership_id;
                $member->joining_date = $req->start_date;
                $member->expiry_date = $req->end_date;
                $member->save();

                $membership = memberships::find($req->membership_id);

                $payment = new payments();
                $payment->member_id = $member->id;
                $payment->membership_id = $req->membership_id;
                $payment->total_amount = $membership->price;
                $payment->paid_amount = 0;
                $payment->save();

                $user = new User();
                $user->email = $req->email;
                $user->name = $req->first_name . " " . $req->last_name;
                $user->password = Hash::make(12345678);
                $user->role = 2;
                $user->save();

                return redirect()->route('members-index')->with('success', "Member Registered");
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }


    public function memberDetails($id)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $details = payments::join('members', 'members.id', '=', 'payments.member_id')
                    ->join('memberships', 'memberships.id', '=', 'payments.membership_id')
                    ->select('payments.*', 'members.*', 'memberships.*', 'members.id as member_id', 'payments.status as payment_status')
                    ->where('members.id', '=', $id)
                    ->first();

                if (!$details) {
                    abort(403, 'Member not found.');
                }

                return view('admin.members.details', compact('details'));
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function memberDelete($id){
        $member = members::find($id);
        $member->delete();

        return redirect()->route('members-index')->with('delete', 'Member Deleted');
    }
    public function memberUpdate(Request $req , $id){
        $member = members::find($id);
        $member->first_name = $req->first_name;
        $member->last_name = $req->last_name;
        $member->email = $req->email;
        $member->address = $req->address;

        $member->save();

        return redirect()->route('members-index')->with('update', 'Member Updated');
    }

    public function membersSearch(Request $req)
    {


        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $memberships = memberships::all();
                $query = $req->input('query');

                // Fetch members and apply filter if query exists
                $members = members::when($query, function ($queryBuilder) use ($query) {
                    return $queryBuilder->where('first_name', 'LIKE', "%{$query}%")
                        ->orWhere('last_name', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%");
                })->get();

                return view('admin.members.index', compact('members', 'memberships'));
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function trainerIndex()
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $specializations = specializations::where('status', 'active')->get();
                $trainers = trainers::join('specializations', 'specializations.id', '=', 'trainers.specialization_id')
                    ->select('trainers.*', 'trainers.id as trainer_id', 'trainers.name as trainer_name', 'specializations.*', 'specializations.name as specialization')
                    ->get();
                return view('admin.trainer.index', compact('specializations', 'trainers'));
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function trainerStore(Request $req)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
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
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getTrainerSpec($id)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $trainers = trainers::where('specialization_id', $id)->get(['id', 'name', 'phone', 'email', 'salary']);
                return response()->json($trainers);
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getTrainer($id)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $trainers = trainers::select('id', 'name', 'salary', 'phone', 'email')->find($id);
                return response()->json($trainers);
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function trainerDelete(Request $req){
        $id = $req->id_;


        $trainer = trainers::find($id);
        $trainer->delete();

        return redirect()->route('trainers-index')->with('delete', 'Trainer Deleted');
    }
    public function trainerUpdate(Request $req){
        $id = $req->id;
        $trainer = trainers::find($id)->first();
        $trainer->name = $req->name_;
        $trainer->email = $req->email_;
        $trainer->phone = $req->phone_;
        $trainer->salary = $req->salary_;

        $trainer->save();

        return redirect()->route('trainers-index')->with('update', 'Trainer Updated');
    }

    public function classesIndex()
    {


        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $specializations = specializations::all();
                $trainers = trainers::all();

                $classes = classes::join('specializations', 'specializations.id', '=', 'classes.specialization_id')
                    ->join('trainers', 'trainers.id', '=', 'classes.trainerId')
                    ->select('trainers.*', 'specializations.*', 'classes.*', 'trainers.name AS trainer_name')
                    ->get();

                return view('admin.classes.index', compact('specializations', 'trainers', 'classes'));
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function getClasses($id)
    {
        // $classes = classes::where('specialization_id', $id)->get();

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $classes = classes::join('specializations', 'specializations.id', '=', 'classes.specialization_id')
                    ->join('trainers', 'trainers.id', '=', 'classes.trainerId')
                    ->select('trainers.name as trainer_name', 'classes.start_date', 'classes.id', 'classes.days', 'classes.time')
                    ->where('classes.specialization_id', $id)
                    ->where('classes.start_date', '>', now())
                    ->where('classes.capacity', '>', 0)
                    ->get();
                // Return as JSON
                return response()->json(['classes' => $classes]);
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function classesStore(Request $req)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
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
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }


    public function paymentIndex()
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $payments = payments::join('members', 'payments.member_id', '=', 'members.id')
                    ->select('payments.*', 'members.*')
                    ->where('payments.total_amount', '>=', 'payments.paid_amount')
                    ->get();
                return view('admin.payments.index', compact('payments'));
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }



    // public function updatePayment(Request $request, $id)
    // {
    //     // Fetch the payment record
    //     $pay = payments::where('member_id', '=', $id)->first();

    //     if (!$pay) {
    //         return redirect()->back()->with('error', 'Payment record not found.');
    //     }

    //     // Update payment details
    //     $pay->paid_amount = $request->amount;
    //     $pay->method = $request->paymentMode;
    //     $pay->payment_date = now();

    //     // Update payment status based on total amount
    //     if ($pay->total_amount == $request->amount) {
    //         $pay->status = 'cleared';

    //         // Update member status in the members table
    //         $member = members::find($id);
    //         if ($member) {
    //             $member->status = 'active';
    //             // $member->activated_on = now();

    //             // Calculate membership expiry based on membership type
    //             // $duration = $member->membership->duration ?? 30; // Default to 30 days if duration not set
    //             // $member->membership_expiry = now()->addDays($duration);

    //             $member->save();
    //         }
    //     }

    //     $pay->save();

    //     return redirect()->route('payment-details', $id)->with('success', 'Payment Received');
    // }

    public function enrollIndex()
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $members = members::where('status', '=', 'active')->get();
                $specializations = specializations::all();

                $classes = classes::join('specializations', 'specializations.id', '=', 'classes.specialization_id')
                    ->join('trainers', 'trainers.id', '=', 'classes.trainerId')
                    ->select('trainers.*', 'specializations.*', 'classes.*', 'trainers.name AS trainer_name')
                    ->get();

                $enrollments = enrollments::join('members', 'members.id', '=', 'enrollments.member_id')
                ->join('classes', 'classes.id', '=', 'enrollments.class_id')
                ->join('trainers', 'trainers.id', '=', 'classes.trainerId')
                ->join('specializations', 'specializations.id', '=', 'classes.specialization_id')
                ->select(
                    'enrollments.id as enrollment_id',
                    'members.first_name',
                    'members.last_name',
                    'classes.days',
                    'classes.time',
                    'trainers.name as trainer_name',
                    'specializations.name as specialization_name',
                    'enrollments.payment_status as enrollstatus'
                )
                ->get();
                return view('admin.enrollments.index', compact('members', 'specializations', 'classes', 'enrollments'));
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function enrollmentStore(Request $req)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $enrollment = new enrollments();
                $enrollment->member_id = $req->member;
                $enrollment->class_id = $req->class;
                $enrollment->enrollment_date = $req->enroll_date;
                $enrollment->save();

                $payment = payments::where('member_id', $req->member)->first(); // Fetch the payment record
                $class = classes::find($req->class);
                $member = members::find($req->member); // Fetch the member directly

                // Update the payment record and class capacity
                if ($payment && $class) { // Ensure both payment and class exist
                    $payment->total_amount += $class->fees; // Add class fees to total
                    $class->capacity -= 1; // Decrease class capacity
                    $class->save();

                    // Update payment status to 'pending'
                    $payment->status = 'pending';
                    $payment->save();
                }

                // Update the member's status to 'pending'
                if ($member) {
                    $member->status = 'pending';
                    $member->save();

                }



                return redirect()->route('enrollment-index')->with('success', 'Member Enrolled');
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }

    }

    public function getEnrollment($id){
        // $id = $req->id_;
        $enrollment = enrollments::select('id')->find($id);

        return response()->json($enrollment);

    }

    public function enrollmentDelete(Request $req){
        $id = $req->id_;
        $enrollment = enrollments::find($id);
        $enrollment->delete();

        return redirect()->route('enrollment-index')->with('delete', 'Enrollment Deleted');
    }

    public function transactionIndex()
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $members = members::join('payments', 'payments.member_id', '=', 'members.id')
                    ->select('members.*', 'payments.*', 'members.id AS member_id')
                    ->whereColumn('payments.total_amount', '>', 'payments.paid_amount')
                    ->get();

                $transactions = payment_logs::join('members', 'members.id', '=', 'payment_logs.member_id')
                    ->select('payment_logs.*', 'members.*')
                    ->get();

                return view('admin.transactions.index', compact('members', 'transactions'));
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function transactionStore(Request $req)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $transaction = new payment_logs();
                $transaction->member_id = $req->member;
                $transaction->description = $req->description;
                $transaction->amount = $req->amount;
                $transaction->payment_mode = $req->method;
                $transaction->referrence_id = $req->referrence_id;
                $transaction->payment_date = $req->payment_date; // Fixed the incorrect property
                $transaction->save();

                $payment = payments::where('member_id', $req->member)->first(); // Use first() to get the first record



                if ($payment) {
                    $payment->paid_amount += $req->amount;

                    if ($payment->total_amount == ($payment->paid_amount)) { // Make sure to compare correctly
                        $member = members::find($req->member);
                        if ($member) {
                            $member->status = 'active';
                            $member->save();
                        }
                        enrollments::where('member_id', $req->member)
                        ->update(['payment_status' => 'cleared']);

                        $payment->status = 'cleared';
                    }

                    $payment->save();
                }


                return redirect()->route('transaction-index')->with('success', 'Transaction Registered');
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }

    }

    public function getMember($id)
    {

        if (Auth::check()) {
            if (Auth::User()->role == 0) {
                $payment = payments::where('member_id', $id)->first();

                return response()->json([
                    'total_amount' => $payment->total_amount,
                    'paid_amount' => $payment->paid_amount
                ]);
            } else {
                abort('403', 'You are not authorized for this page.');
            }
        } else {
            return redirect()->route('login');
        }
    }


}
