@extends('layout')

@section('content')
    <h1>Libraries</h1>
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
                                   href="{{ route('library.index', ['sort_by' => 'name', 'sort_order' => 'asc', 'search' => app('request')->input('search')]) }}"><i
                                        class="fs-4 bi bi-sort-up"></i></a>
                            @else
                                <a class="sort"
                                   href="{{ route('library.index', ['sort_by' => 'name', 'sort_order' => 'desc', 'search' => app('request')->input('search')]) }}"><i
                                        class="fs-4 bi bi-sort-down-alt"></i></a>
                            @endif
                        @else
                            <a class="sort"
                               href="{{ route('library.index', ['sort_by' => 'name', 'sort_order' => 'asc', 'search' => app('request')->input('search')]) }}"><i
                                    class="fs-4 bi bi-arrow-down-up"></i></a>
                        @endif
                    </th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($libraries as $library)
                    <tr>
                        <th scope="row">{{ $library->id }}</th>
                        <td>
                            @if ($library->image)
                                <img src="{{asset('uploads/'. $library->image)}}" style="width: 100px;height: 100px;"/>
                            @endif
                        </td>
                        <td>{{ $library->name }}</td>
                        <td>
                            <form action="{{ route('library.destroy', ['id' => $library['id']]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <div class="btn-group">
                                    <a class="btn btn-primary"
                                       href="{{ route('library.edit', ['id' => $library['id']]) }}">Edit</a>
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
        const imageURL = `{{asset('uploads/'. 'LIBRARY_IMAGE')}}`;
        const deleteURL = `{{ route('library.destroy', ['id' => 'LIBRARY_ID']) }}`;
        const editURL = `{{ route('library.edit', ['id' => 'LIBRARY_ID']) }}`;

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
            const libraries = await response.json();

            const tbody = this.parentElement.getElementsByTagName('tbody')[0];
            tbody.innerHTML = '';
            for (const library of libraries) {
                tbody.innerHTML += `
                        <tr>
                          <th scope="row">${library.id}</th>
                          <td>${library.image ? `<img src="${imageURL.replace('LIBRARY_IMAGE', library.image)}" style="width: 100px;height: 100px;"/>` : ''}</td>
                          <td>${library.name}</td>
                          <td>
                            <form action="${deleteURL.replace('LIBRARY_ID', library.id)}" method="POST">
                            @method('DELETE')
                            @csrf
                            <div class="btn-group">
                                <a class="btn btn-primary" href="${editURL.replace('LIBRARY_ID', library.id)}">Edit</a>
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
