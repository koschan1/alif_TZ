<?php


namespace App\Http\Services;

use Illuminate\Support\Facades\DB;

class UserServices
{

    /**
     * Метод возвращает даные контакта
     * @param $id int
     * @param $separator String
     */
    public static function getContact(int $id, string $separator=''){
        $contact = DB::select("SELECT a.*, b.email, c.phone FROM user_contacts a
                                JOIN (SELECT contact_id, GROUP_CONCAT(email SEPARATOR '$separator') email FROM contact_emails GROUP BY contact_id) b ON b.contact_id=a.id
                                JOIN (SELECT contact_id, GROUP_CONCAT(phone SEPARATOR '$separator') phone FROM contact_phones GROUP BY contact_id) c ON c.contact_id=a.id
                                WHERE a.id='$id'");

        return $contact;
    }

    /**
     * Метод добавляет новые телефоны у контакта
     * @param $id int
     * @param $data array
     */
    public static function addPhoneContact(int $id, string $data){
        $phones = trim(strip_tags($data));
        $arr_phones = explode(',', $phones);

        DB::delete("DELETE FROM contact_phones WHERE contact_id='$id'");
        foreach ($arr_phones as $val) {
            DB::insert("INSERT INTO contact_phones (contact_id, phone) VALUES ('$id', '$val')");
        }
    }

    /**
     * Метод добавляет новые email у контакта
     * @param $id int
     * @param $data array
     */
    public static function addEmailContact(int $id, string $data){
        $phones = trim(strip_tags($data));
        $arr_phones = explode(',', $phones);

        DB::delete("DELETE FROM contact_emails WHERE contact_id='$id'");
        foreach ($arr_phones as $val) {
            DB::insert("INSERT INTO contact_emails (contact_id, email) VALUES ('$id', '$val')");
        }
    }

    /**
     * Метод ищет введенные данные по 3 таблицам
     *
     * @param $id
     * @param $data string
     */
    public static function search($id, string $data){

        $result = DB::select("SELECT a.id FROM user_contacts a
                              JOIN contact_emails b ON b.contact_id=a.id
                              JOIN contact_phones c ON c.contact_id=a.id
                              WHERE a.user_id='$id' AND a.name LIKE '$data%' OR b.email LIKE '$data%' OR c.phone LIKE '$data%' GROUP BY a.id");

        if($result == null){
            return $result;
        }
        return $result[0];
    }
}
