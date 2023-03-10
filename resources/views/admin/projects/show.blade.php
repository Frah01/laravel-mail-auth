@extends('layouts.admin')
@section('content')
<div class="container back-grey">
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-start p-2">
                <a class="btn btn-primary" href="{{route('admin.projects.index')}}"><i class="fa-solid fa-arrow-left mx-1"></i><span class="mx-2">Torna ai tuoi progetti</span></a>
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-8">
            <div class="d-flex  align-items-center">  
                <div class="mt-3 mx-2">
                    <div>
                        <h4 >Titolo:</h4>
                        <p class=" text-uppercase fw-semibold">{{$project['title']}}</p>
                    </div>
                    <div>
                        <h4 class="fw-semibold">Copertina</h4> 
                        <div class="d-flex my-2">
                            <img class="img-fluid shadow" src="{{asset('storage/' .$project->cover_image)}}" alt="{{$project->title}}" class="w-50"> 
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-semibold">Contenuto:</h4> 
                        <p class="fw-semibold">{{$project['content']}}</p>  
                    </div>
                     <div>
                        <h4 class="fw-semibold">Tipo:</h4> 
                        <p class="fw-semibold">{{$project->type ? $project->type->name : 'Senza Tipo'}}</p>
                    </div>
                    <div>
                        <h4 class=" fw-semibold">Technologies:</h4>
                            @forelse($project->technologies as $technology)
                            <p class="m-0  fw-semibold">{{$technology->name}}</p>
                            @empty
                            <p class="m-0  fw-semibold">Nessuna Tecnologia Associato al Project</p>
                            @endforelse
                    </div>
                </div>
            </div> 
        </div>
        <div class="col-4">
            <div class="mt-5">
        
            </div>
        </div>
    </div>
</div>
@endsection