@extends('layout.app')

@section('css')
@endsection

@section('content')
    <div class="container">
        <div class="d-flex row">
            @foreach ($scenes as $scene)
                <div class="flex col-3">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset('asset/1.jpg') }}" class="card-img-top" alt="{{ asset('asset.doors.jpg') }}">
                        <div class="card-body">
                            <h5 class="card-title">Last Save Point</h5>
                            <p class="card-text">Last saved node was : {{ $scene->adress }}</p>
                            <p class="card-text">Last update date :
                                {{ \Carbon\Carbon::parse($scene->updated_at)->diffForHumans() }}
                            </p>

                            <a href="{{ route('gamepage', $scene->id) }}" class="btn btn-primary">Go to Node</a>
                            <a href="{{ route('deleteNode', $scene->id) }}" class="btn btn-danger">Delete the Save</a>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>




    @if ($scenes == null)

        <div class="row">
            <div class="col text-center">
                <a class="btn btn-info " href="{{ route('new') }}">new game</a>
            </div>
        </div>
    @endif
@endsection
