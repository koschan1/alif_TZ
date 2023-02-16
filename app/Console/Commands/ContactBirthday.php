<?php


namespace App\Console\Commands;


use App\Mail\Birthday\happyMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactBirthday extends Command
{
    protected $signature = "ContactBirthday:api";

    protected $description = "Отправка сообщений о дне рождении";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(){

        $today = date("Y-m-d");

        $contacts = DB::select("SELECT name,user_id FROM user_contacts WHERE date_of_birth='$today'");

        if(isset($contacts[0])){
            $user_id = $contacts[0]->user_id;
            $userEmail = DB::select("SELECT email FROM users WHERE id='$user_id'");
            Mail::to($userEmail[0]->email)->send(new happyMail($contacts));
            $this->info("Дни рождения есть, письма разосланы!");
        }else{
            $this->info("Нет день рождений сегодня!");
        }

    }
}
