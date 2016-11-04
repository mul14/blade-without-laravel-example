@extends('template')

@section('content')

    @php
    $hello = 'Halo'
    @endphp

    <p>{{ $hello }}, {{ $name }}</p>

    <p>{{ '<button>Escaped</button>' }}</p>

    <p>{!! '<button>Button</button>' !!}</p>

@endsection
