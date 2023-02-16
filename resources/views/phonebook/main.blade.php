@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="">
                        <a href="{{ route('contact.create') }}" class="btn btn-sm btn-success">Добавить контакт</a>
                    </div>
                </div>

                <div class="card-body">
                    <table id="table_id" class="display">
                        <thead>
                        <tr>
                            <th>ФИО</th>
                            <th>Телефон</th>
                            <th>Почта</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{!! $contact->phone !!}</td>
                            <td>{!! $contact->email !!}</td>
                            <td><a href="{{ route('contact.show', $contact->id) }}" class="btn btn-sm btn-warning">Посмотреть</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready( function () {
        $('#table_id').DataTable();
    });
</script>
@endsection
