@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 style="float: left">Контакт</h3>
                    <form method="POST" action="{{ route('contact.destroy', $contact->id) }}">
                        @csrf @method('delete')
                        <button type="submit" class="btn btn-danger" style="float: right">Удалить</button>
                    </form>
                </div>

                <div class="card-body">
                    <form method="POST" action="">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <label>ФИО</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $contact->name }}">

                            <label>День рождение</label>
                            <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $contact->date_of_birth }}">

                            <label>телефоны</label>
                            <textarea type="text" name="phone_contact" id="phone_contact" rows="5" class="form-control" readonly>{{ $contact->phone }}</textarea>
                            <label>почта</label>
                            <textarea type="text" name="email_contact" id="email_contact" rows="5" class="form-control" readonly>{{ $contact->email }}</textarea>

                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('contact.edit', $contact->id) }}" class="btn btn-warning">Изменить</a>
                            <a href="{{ route('user.index') }}" class="btn btn-primary">Все контакты</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
