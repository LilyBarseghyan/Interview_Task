@extends('layout')

@section('content')
    <h1>Create a Library</h1>
    <form action="{{ route('library.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card m-3  bg-white">
            <div class="card-body">
                <div class="col-md-12 mb-4">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control @if($errors->has('name'))is-invalid @endif" id="name" name="name">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <div class="col-md-12 mb-4">
                    <label for="image" class="form-label">Image:</label>
                    <input type="file" class="form-control @if($errors->has('image'))is-invalid @endif" id="image" name="image" accept="image/*" multiple />
                    @if($errors->has('image'))
                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                    @endif
                </div>

                <div class="col-md-12 mb-4">
                    <label for="attachments" class="form-label">Attachments:</label>

                    <select class="form-control @if($errors->has('attachments'))is-invalid @endif" name="attachments[]" id="attachments" multiple>
                        @foreach ($books as $book)
                            <option value="{{$book['id']}}">{{$book['title']}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('attachments'))
                        <div class="invalid-feedback">{{ $errors->first('attachments') }}</div>
                    @endif
                </div>

                <div class="d-flex w-100 justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection
