@extends('layouts.petugas.table_main')
@section('content')
<main class="main-content container mx-auto">
    <div class="card">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
            <h2 class="text-3xl font-semibold text-gray-800 mb-4 md:mb-0">Petugas List</h2>
            <a href="{{ route('petugas.create') }}" class="add-button">Add New Petugas</a>
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($petugas as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('petugas.edit', $item->id) }}">Edit</a>
                                <form action="{{ route('petugas.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
