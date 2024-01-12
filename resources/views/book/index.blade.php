@extends('layout')

@section('content')
    <h1>Books</h1>
    <div class="card bg-white">
        <div class="card-body">
            <input class="form-control me-2" id="search" type="search" placeholder="Search" aria-label="Search"
                   value="{{app('request')->input('search')}}">
            <table class="table mt-2">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">Name
                        @if(app('request')->input('sort_by') === 'name')
                            @if(app('request')->input('sort_order') === 'desc')
                                <a class="sort"
                                   href="{{ route('book.index', ['sort_by' => 'name', 'sort_order' => 'asc', 'search' => app('request')->input('search')]) }}"><i
                                        class="fs-4 bi bi-sort-up"></i></a>
                            @else
                                <a class="sort"
                                   href="{{ route('book.index', ['sort_by' => 'name', 'sort_order' => 'desc', 'search' => app('request')->input('search')]) }}"><i
                                        class="fs-4 bi bi-sort-down-alt"></i></a>
                            @endif
                        @else
                            <a class="sort"
                               href="{{ route('book.index', ['sort_by' => 'name', 'sort_order' => 'asc', 'search' => app('request')->input('search')]) }}"><i
                                    class="fs-4 bi bi-arrow-down-up"></i></a>
                        @endif
                    </th>
                    <th scope="col">Title
                        @if(app('request')->input('sort_by') === 'title')
                            @if(app('request')->input('sort_order') === 'desc')
                                <a class="sort"
                                   href="{{ route('book.index', ['sort_by' => 'title', 'sort_order' => 'asc', 'search' => app('request')->input('search')]) }}"><i
                                        class="fs-4 bi bi-sort-up"></i></a>
                            @else
                                <a class="sort"
                                   href="{{ route('book.index', ['sort_by' => 'title', 'sort_order' => 'desc', 'search' => app('request')->input('search')]) }}"><i
                                        class="fs-4 bi bi-sort-down-alt"></i></a>
                            @endif
                        @else
                            <a class="sort"
                               href="{{ route('book.index', ['sort_by' => 'title', 'sort_order' => 'asc', 'search' => app('request')->input('search')]) }}"><i
                                    class="fs-4 bi bi-arrow-down-up"></i></a>
                        @endif
                    </th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($books as $book)
                    <tr>
                        <th scope="row">{{ $book->id }}</th>
                        <td>
                            @if ($book->image)
                                <img src="{{asset('uploads/'. $book->image)}}" style="width: 100px;height: 100px;"/>
                            @endif
                        </td>
                        <td>{{ $book->name }}</td>
                        <td>{{ $book->title }}</td>
                        <td>
                            <form action="{{ route('book.destroy', ['id' => $book['id']]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <div class="btn-group">
                                    <a class="btn btn-primary" href="{{ route('book.edit', ['id' => $book['id']]) }}">Edit</a>
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No records found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        const searchURL = new URL(`{{ url()->full() }}`);
        const imageURL = `{{asset('uploads/'. 'BOOK_IMAGE')}}`;
        const deleteURL = `{{ route('book.destroy', ['id' => 'BOOK_ID']) }}`;
        const editURL = `{{ route('book.edit', ['id' => 'BOOK_ID']) }}`;

        const sortButtons = document.getElementsByClassName('sort');

        const searchInput = document.getElementById('search');
        searchInput.addEventListener('keyup', async function (evt) {
            searchURL.searchParams.set('search', evt.target.value);
            window.history.pushState('', '', searchURL);

            for (const sortButton of sortButtons) {
                const sortUrl = new URL(sortButton.href);
                sortUrl.searchParams.set('search', evt.target.value);
                sortButton.href = sortUrl;
            }

            const response = await fetch(searchURL, {headers: {'X-Requested-With': 'XMLHttpRequest'}});
            const books = await response.json();

            const tbody = this.parentElement.getElementsByTagName('tbody')[0];
            tbody.innerHTML = '';
            for (const book of books) {
                tbody.innerHTML += `
                        <tr>
                          <th scope="row">${book.id}</th>
                          <td>${book.image ? `<img src="${imageURL.replace('BOOK_IMAGE', book.image)}" style="width: 100px;height: 100px;"/>` : ''}</td>
                          <td>${book.name}</td>
                          <td>${book.title}</td>
                          <td>
                            <form action="${deleteURL.replace('BOOK_ID', book.id)}" method="POST">
                            @method('DELETE')
                            @csrf
                            <div class="btn-group">
                                <a class="btn btn-primary" href="${editURL.replace('BOOK_ID', book.id)}">Edit</a>
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </div>
                            </form>
                          </td>
                        </tr>
                          `;
            }
        });
    </script>
@endsection
