@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card my-5">
                    <div class="card-title">
                        <h2 class="text-center">Nuovo progetto</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.projects.store')}}" method="post" class="form-control" enctype="multipart/form-data">
                            @csrf
                            <label for="title">Titolo</label>
                            <input type="text" class="form-control mb-3" name="title" id="title">
                            @error('title')
                            <div class="alert alert-danger">
                                {{$message}}
                            </div>
                            @enderror
                            <label for="project_image"></label>
                            <input type="file" name="project_image" id="project_image" @error('project_image') is-invalid @enderror>
                            @error('project_image')
                                <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <label for="descriprion">Descrizione</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control mb-3"></textarea>
                            @error('description')
                            <div class="alert alert-danger">
                                {{$message}}
                            </div>
                            @enderror
                            <label for="end_date">Data di consena</label>
                            <input type="date" name="end_date" id="end_date" class="form-control mb-3">
                            @error('end_date')
                            <div class="alert alert-danger">
                                {{$message}}
                            </div>
                            @enderror
                            <button type="submit" class="btn btn-sm btn-success">Conferma</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection