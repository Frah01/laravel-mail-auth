@extends('layouts.admin')
@section('content')
<div class="container">
        <div class="row">
            <div class="col-12 my-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="fs-4 text-secondary">
                            {{ __('Le tue tipologie') }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2>Aggiungi nuova Tecnologia</h2>
                    </div>
                    <div>
                        <a href="{{route('admin.technologies.create')}}" class="btn btn-small btn-primary"><i class="fa-solid fa-plus mx-1"></i><span class="mx-2" >Nuova Tecnologia</span></a> 
                    </div>
                </div>
                @if(session('message'))
                <div class="alert alert-success my-3" >
                    {{session('message')}}
                </div>
                @endif
            </div>
            <div class="col-12">
                <div class="card my-3">
                    <div class="card-body p-0">
                        <table class="table table-striped m-0" >
                            <thead>
                                <th>id</th>
                                <th>Nome</th>
                                <th>Slug</th>
                                <th class="text-center">Azioni</th>
                            </thead>
                            <tbody>
                                @foreach($technologies as $technology)
                                <tr>
                                    <td><p class="fw-semibold">{{$technology->id}}</p></td>
                                    <td><p class="fw-semibold">{{$technology->name}}</p></td>
                                    <td><p class="fw-semibold">{{$technology->slug}}</p></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{route('admin.technologies.show', $technology->slug)}}" class="btn btn-square btn-sm btn-info m-1" title="Ispeziona"><i class="fa fa-eye" ></i></a>
                                            <a  href="{{route('admin.technologies.edit', $technology->slug)}}" class="btn btn-square btn-sm btn-secondary m-1" title="Modifica"><i class="fa fa-edit"></i></a>
                                            <form class="d-inline-block" method="POST" action="{{route('admin.technologies.destroy', ['technology' => $technology['slug']])}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-square btn-danger confirm-delete-button m-1" data-title="{{$technology->name}}"><i class="fas fa-trash" ></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
@include('partials.modal_delete')
@endsection