<x-mail::message>
    @foreach ($data as $day)
        <h2>{{ $day[0]['date']->getTranslatedDayName() }} {{ $day[0]['date']->format('d.m') }}</h2>
        @foreach ($day as $entry)
            <ul>
                <li>
                    <small>{{ $entry['time_start'] }} - {{ $entry['time_end'] }}</small> -
                    <strong>{{ $entry['name'] }}</strong>
                    <p>
                        <small>Õpetaja: {{ $entry['teacher'] }} - Klass:
                            <strong>{{ $entry['room'] }}</strong>
                        </small>
                    </p>
                </li>
            </ul>
        @endforeach
    @endforeach
</x-mail::message>
