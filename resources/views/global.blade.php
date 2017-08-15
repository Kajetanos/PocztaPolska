@extends('layouts.master')
<html>


    <body>      
        <h1>{{ $title }}</h1>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/calculate">Pokaż koszty wysyłek</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>               <a href="/international">Przesyłki polecone zagraniczne</a></li>
                        <li>               <a href="/global">Przesyłki Global Express</a></li>
                        <li>               <a href="/krajowe">Przesylki krajowe</a></li>
                        <li>               <a href="/ems">Przesyłki Ems</a></li>
                    </ul>
                    <form class="navbar-form navbar-left" method="post" role="search">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Kraj">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="">Link</a></li>
                    </ul>
                </div>
            </div>
        </nav>






        <div class="bs-component">
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Unique id</th>
                        <th>Masa</th>
                        <th>Kraj odbiorcy</th>
                        <th>Koszt wysylki</th>
                    </tr>
                </thead>
                <tbody>



                    @foreach ($global as $raport)
                    <tr class="info">
                        <td>{{$raport->id}}</td>
                        <td>{{$raport->unique_id}}</td>
                        <td>{{$raport->masa}}</td>
                        <td>{{$raport->kraj}}</td>
                        <td>{{$raport->cena}}</td>
                    </tr>
                    @endforeach
                    
                <table class="table table-striped table-hover ">
                    @if(!empty($bon) )
                    <thead>
                    <th>Suma wyświetlonych</th>
                    <th>Suma wszystkich {{$count}} </th>
                    <th>Suma z rabatem </th>
                    <tbody>
                        <tr class="danger">
                            <td>{{$suma}}</td>
                            <td>{{$add_all}}</td>
                            <td>{{$bon}}</td>
                    </tbody>
                   
                    @elseif (empty($bon) ) 
                    <thead>
                    <th>Suma wyświetlonych</th>
                    <th>Suma wszystkich {{$count}} </th>
                    <tbody>
                        <tr class="danger">
                            <td>{{$suma}}</td>
                            <td>{{$add_all}}</td>
                    </tbody>
                    @endif
                </table> 
                </tbody>

            </table> 
            <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div></div>
        <ul class="nav nav-pills">

            <form class="navbar-form navbar-left" method="post" >
                {{csrf_field()}}
                <div class="form-group">
                    <input type="text" class="form-control"name="rabat" placeholder="Tu mozesz podac rabat">
                </div>
                <button type="submit" class="btn btn-default">Oblicz</button>
            </form>

</html>
@section('content')

{{ $global->links() }}
@stop
