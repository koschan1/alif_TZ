@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Изменить контакт</h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('contact.update', $contact->id) }}">
                        <div class="modal-body">
                            @csrf
                            @method('patch')
                            <label>ФИО</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $contact->name }}">
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <label>День рождение</label>
                            <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $contact->date_of_birth }}">
                            @error('date_of_birth')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <label>телефоны (Введите разделяя запятой)</label>
                            <textarea type="text" name="phone_contact" id="phone_contact" rows="5" class="form-control">{{ $contact->phone }}</textarea>
                            <label>почта (Введите разделяя запятой)</label>
                            <textarea type="text" name="email_contact" id="email_contact" rows="5" class="form-control">{{ $contact->email }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                            <a href="{{ route('user.index') }}" class="btn btn-primary">Все контакты</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
