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
<!--                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>-->
                        </ul>
                        <form class="navbar-form navbar-left" method="post" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Kraj">
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#">Link</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        
          <form class="form-horizontal"  method="post" action="{{ URL::to($company. 'prices/')}}">
        {{csrf_field()}}
        <div class="col-lg-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Kraj">
                <span class="input-group-btn">
                    <button class="btn btn-outline-primary" type="submitt"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </span>
            </div>
        </div>
    </form>




    
    <div class="bs-component">
              <table class="table table-striped table-hover ">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Unique id</th>
                    <th>Rodzaj przesylki</th>
                    <th>Masa</th>
                    <th>Gabaryt</th>
                    <th>Usluga</th>
                    <th>Vat</th>
                    <th>Kraj odbiorcy</th>
                    <th>Ubezpieczenia</th>
                    <th>Koszt wysylki</th>
                  </tr>
                </thead>
                <tbody>

    

    @foreach ($raports as $raport)
                  <tr class="info">
                    <td>{{$raport->id}}</td>
                    <td>{{$raport->unique_id}}</td>
                    <td>{{$raport->rodzaj_przesylki}}</td>
                    <td>{{$raport->masa}}</td>
                    <td>{{$raport->gabaryt}}</td>
                    <td>{{$raport->usluga}}</td>
                    <td>{{$raport->stawkaVat}}</td>
                    <td>{{$raport->kraj}}</td>
                    <td>{{$raport->ubezpieczenia}}</td>
                    <td>Koszt wysylki</td>
                  </tr>
            @endforeach
                  <tr class="success">
                    <td>4</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr class="danger">
                    <td>5</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr class="warning">
                    <td>6</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr class="active">
                    <td>7</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                </tbody>
              </table> 
            <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div></div>
            <ul class="nav nav-pills">
  
</html>
 @section('content')

{{ $raports->links() }}
@stop