@extends('layouts.app')

@push('title', ' - Pages')

@section('content')

    <main>

        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Страницы</h1>
                </div>
            </div>
        </section>

        <div class="album py-5 bg-body-tertiary">
            <div class="container">
                {{ $pages->links() }}

                <table class="table table-dark table-striped">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($pages as $page)
                        <tr>
                            <td>{{ $page->page_id }}</td>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->description }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $pages->links() }}
            </div>
        </div>

    </main>

@endsection
