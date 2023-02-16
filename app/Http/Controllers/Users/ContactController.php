<?php


namespace App\Http\Controllers\Users;


use App\Http\Controllers\Controller;
use App\Http\Requests\AddContact;
use App\Http\Requests\UpdateContact;
use App\Http\Services\UserServices;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{

    public function index(){

        return view('phonebook.create');

    }

    /**
     * Метод добавляет контакт
     *
     * @param AddContact $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddContact $request)
    {

        $data = $request->validated();

        $newId = Contact::create($data);

        if($request["phone_contact"] != '') {
            UserServices::addPhoneContact($newId->id, $request["phone_contact"]);
        }

        if($request["email_contact"] != '') {
            UserServices::addEmailContact($newId->id, $request["email_contact"]);
        }


        return redirect()->route('user.index');
    }


    /**
     * Метод возвращает данные контакта
     *
     * @param $id int
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $id){

        $contact = UserServices::getContact($id, ',');

        $contact = $contact[0];
        return view('phonebook.show', compact('contact'));
    }


    /**
     * Метод принимает id контакта и позволяет редактировать его
     *
     * @param $id int
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id){


        $contact = UserServices::getContact($id, ',');

        $contact = $contact[0];

        return view('phonebook.edit', compact('contact'));
    }


    /**
     * Метод принимает новые значения и id контакта и обновляет его
     *
     * @param UpdateContact $request
     * @param $id int
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateContact $request, int $id)
    {

        $data = $request->validated();
        Contact::find($id)->update($data);

        if($request["phone_contact"] != '') {
            UserServices::addPhoneContact($id, $request["phone_contact"]);
        }

        if($request["email_contact"] != '') {
            UserServices::addEmailContact($id, $request["email_contact"]);
        }

        return redirect()->route('contact.show', $id);
    }


    /**
     * Метод принимает id контакта и удаляет его
     *
     * @param $id int
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {

        Contact::find($id)->delete();

        DB::delete("DELETE FROM contact_phones WHERE contact_id='$id'");

        DB::delete("DELETE FROM contact_emails WHERE contact_id='$id'");

        return redirect()->route('user.index');
    }
}
