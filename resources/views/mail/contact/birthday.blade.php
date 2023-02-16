<x-mail::message>
Сегодня день рождение празднует:<br>
    @foreach($contacts as $contact)
        <a href="http://alif.uz" target="_blank">{{ $contact->name }}</a><br>
    @endforeach
</x-mail::message>
