@extends('layouts.app')\n@section('content')\n    <h1>Dashboard</h1>\n    @if ($data)\n        <pre>{{ $data }}</pre>\n    @else\n        <p>No resume data available.</p>\n    @endif\n@endsection
