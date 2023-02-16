<?php


namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Http\Requests\AddContact;
use App\Http\Requests\UpdateContact;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Http\Resources\UserResourse;
use App\Http\Services\UserServices;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetUserController extends Controller
{
    /**
     * Метод возвращает данные авторизованного пользователя
     *
     * @return UserResourse|\Illuminate\Http\JsonResponse
     */
    public function getUser(){

        $user = User::where('id', Auth::id())->get();

        if (count($user) < 1) return response()->json(["status" => "false", "message" => "Контактов нет"]);

        return new UserResourse($user[0]);

    }

    /**
     * Метод возвращает Контакты авторизованного пользователя
     *
     * @return ContactCollection|\Illuminate\Http\JsonResponse
     */
    public function getContacts(){

        $user = Contact::where('user_id', Auth::id())
            ->with('phoneUser')
            ->with('emailUser')
            ->get();

        if(!$user) return response()->json(["status" => "false", "message" => "Контакт не существует"]);
        return new ContactCollection($user);

    }

    /**
     * Метод принимает id контакта и возвращает его данные
     *
     * @param $id
     * @return UserResourse|\Illuminate\Http\JsonResponse
     */
    public function getContact($id){


        $user = Contact::where(['id' => $id, 'user_id' => Auth::id()])
            ->with('phoneUser')
            ->with('emailUser')
            ->first();

        if(!$user) return response()->json(["status" => "false", "message" => "Контакта ".$id." у вас нет"]);

        return new ContactResource($user);

    }

    /**
     * Метод позволяет добавить контакт
     *
     * @param AddContact $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createContact(AddContact $request){

        $data = $request->validated();

        $newContact = DB::table('user_contacts')->insertGetId([
            "name" => $data['name'],
            "date_of_birth" => $data['date_of_birth'],
            "user_id" => $request->user()->id
        ]);

        if($request["phone_contact"] != '') {
            UserServices::addPhoneContact($newContact, $request["phone_contact"]);
        }

        if($request["email_contact"] != '') {
            UserServices::addEmailContact($newContact, $request["email_contact"]);
        }

        if(!$newContact) return response()->json(["status" => "false", "message" => "Ошибка"]);

            $responce = [
                "status" => true,
                "message" => "Контакт успешно добавлен"
            ];
        return response()->json($responce);

    }

    /**
     * Метод обновляет контакт только авторизованного пользователя
     *
     * @param UpdateContact $request
     * @param $id int
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateContact(UpdateContact $request, int $id){

        $current_contact = Contact::where('id', $id)->get();

        if($current_contact[0]->user_id != Auth::user()->id) {

            $responce = [
                "status" => false,
                "message" => "Контакта ".$id." у вас нет!"
            ];
            return response()->json($responce);

        }

        $data = $request->validated();

        Contact::find($id)->update($data);

        if($request["phone_contact"] != '') {
            UserServices::addPhoneContact($id, $request["phone_contact"]);
        }

        if($request["email_contact"] != '') {
            UserServices::addEmailContact($id, $request["email_contact"]);
        }

        $responce = [
            "status" => true,
            "message" => "Контакт успешно Изменен"
        ];
        return response()->json($responce);
    }

    /**
     * Метод осуществляет поиск контакта по имени, телефону или почте
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function search(Request $request){

        $search = trim(strip_tags($request['search']));

        $result = UserServices::search(Auth::id(), $search);

        if(!$result) {
            $responce = [
                "status" => false,
                "message" => "Контакт c такими данными не найден!"
            ];
            return response()->json($responce);
        }

        return $this->getContact($result->id);

    }

}
