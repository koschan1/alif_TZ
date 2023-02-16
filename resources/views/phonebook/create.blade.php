@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Добавить контакт
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('contact.create') }}">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <label>ФИО</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <label>День рождение</label>
                            <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <label>телефон (Введите разделяя запятой)</label>
                            <textarea type="text" name="phone_contact" id="phone_contact" rows="5" class="form-control">{{ old('phone_contact') }}</textarea>
                            <label>почта (Введите разделяя запятой)</label>
                            <textarea type="text" name="email_contact" id="email_contact" rows="5" class="form-control">{{ old('email_contact') }}</textarea>

                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">Отменить</a>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
