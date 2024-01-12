@extends('layout')

@section('content')
    <h1>Edit a Book</h1>
    <form action="{{ route('book.update', ['id' => $book['id']]) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="card m-3  bg-white">
            <div class="card-body">
                <div class="col-md-12 mb-4">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control @if($errors->has('name'))is-invalid @endif" id="name" name="name" value="{{$book['name']}}">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <div class="col-md-12 mb-4">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" class="form-control @if($errors->has('title'))is-invalid @endif" id="title" name="title" value="{{$book['title']}}">
                    @if($errors->has('title'))
                        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                    @endif
                </div>
                <div class="col-md-12 mb-4">
                    <label for="content" class="form-label">Content:</label>
                    <textarea rows="5" class="form-control @if($errors->has('content'))is-invalid @endif" id="content" name="content">{{$book['content']}}</textarea>
                    @if($errors->has('content'))
                        <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                    @endif
                </div>

                <div class="col-md-12 mb-4">
                    <label for="image" class="form-label">Image:</label>
                    <input type="file" class="form-control @if($errors->has('image'))is-invalid @endif" id="image" name="image" accept="image/*" multiple />
                    @if($errors->has('image'))
                        <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                    @endif
                </div>


                <div class="d-flex w-100 justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection
