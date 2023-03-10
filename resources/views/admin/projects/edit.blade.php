@extends('layouts.admin')
    @section('content')
    <div class="container">
        <div class="row">
            <div class="offset-3 col-6 text-center my-3">
               <h4>Modifica il tuo progetto</h4>
            </div>
        </div>
        <div class="row">
            <div class="offset-3 col">
                <div class="d-flex justify-content-start py-3">
                    <a class="btn btn-primary" href="{{route('admin.projects.index')}}"><i class="fa-solid fa-arrow-left mx-1"></i><span class="mx-2">Torna ai tuoi progetti</span></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="offset-3 col-6">
                <div class="container" >
                    <div class="row">
                        <div class="col">
                            @if ($errors->any())
                            <div class="alert alert-danger my-3" >
                                @foreach ($errors->all() as $error)
                                <ul class="list-unstyled mb-0" >
                                    <li>{{$error}}</li>
                                </ul>
                                @endforeach
                            </div>
                             @endif
                        </div>
                    </div>
                </div>
                <form action="{{route('admin.projects.update', $project->slug)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="control-label"><p class="fw-semibold">Titolo</p></label>
                        <input type="text" name="title" class="form-control" placeholder="Inserisci il titolo" value="{{old('title') ?? $project->title}}">   
                    </div>
                    <div class="form-group my-3">
                        <label class="control-label"><p class="fw-semibold mt-1">Copertina</p></label>
                        <div class="d-flex my-2">
                        <img class="shadow img-fluid"src="{{asset('storage/' .$project->cover_image)}}" class="w-50">
                        </div>
                        <input type="file" name="cover_image" id="cover_image" class="form-control
                        @error('cover_image')is-invalid @enderror">
                        @error('cover_image')
                        <div class="text-danger">
                        @enderror
                    </div>
                        <label for="floatingTextarea2"><p class="fw-semibold mt-1">Descrizione</p></label>
                        <textarea name="description" class="form-control" placeholder="Descrizione"  rows="10">{{old('content') ?? $project->content}}</textarea>
                        <div class="form-group">
                            <label class="control-label"><p class="fw-semibold mt-1">Categorie</p></label>
                                <select class="form-control" name="type_id" id="type_id">
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}" {{$type->id == old('type_id', $project->type_id) ? 'selected' : " "}}  >{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group my-3">
                                <div class="control-label"><p class="fw-semibold mt-1">Technologies</p></div>
                                @foreach($technologies as $technology)
                                <div class="form-check @error('technologies') is-invalid @enderror">
                                    @if($errors->any())
                                    <input type="checkbox" value="{{$technology->id}}" name="technologies[]"{{in_array($technology->id, old('technologies',[]))? 'checked' : ''}} class="form-check-input">
                                    <label class="form-check-label">{{$technology->name}}</label>
                                    @else
                                    <input type="checkbox" class="form-check-input" value="{{$technology->id}}" name="technologies[]" {{$project->technologies->contains($technology)? 'checked' : ''}} >
                                    <label class="form-check-label">{{$technology->name}}</label>
                                    @endif
                                </div>
                                @endforeach
                                @error('technologies')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                    <div class="form-group my-3">
                        <button type="submit" class="btn btn-success" class="form-control" >Salva le Modifiche</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection