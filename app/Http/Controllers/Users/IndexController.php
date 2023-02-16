<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(){

        $user_id = auth()->user()->id;

        $contacts = DB::select("SELECT a.*, b.email, c.phone FROM user_contacts a
                                JOIN (SELECT contact_id, GROUP_CONCAT(email SEPARATOR '<br>') email FROM contact_emails GROUP BY contact_id) b ON b.contact_id=a.id
                                JOIN (SELECT contact_id, GROUP_CONCAT(phone SEPARATOR '<br>') phone FROM contact_phones GROUP BY contact_id) c ON c.contact_id=a.id
                                WHERE a.user_id='$user_id'");

        return view('phonebook.main', compact('contacts'));
    }
}
