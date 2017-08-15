@extends('layouts.master')
<html>


    <body>      
   <form method="post" action="/test">
  <select name="taskOption">
   <option value="0">Styczeń</option>
  <option value="1">Luty</option>
  <option value="2">Marzec</option>
  <option value="3">Kwiecień</option>
  <option value="4">Maj</option>
  <option value="5">Czerwiec</option>
  <option value="6">Lipiec</option>
  <option value="7">Sierpień</option>
  <option value="8">Wrzesień</option>
  <option value="9">Październik</option>
  <option value="10">Listopad</option>
  <option value="11">Grudzień</option>
   <input type="submit" value="Submit the form"/>
        {{csrf_field()}}
        </form>
        </select>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/calculate">Przejdź do kalkulatora</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>               <a href="/international">Przesyłki polecone zagraniczne</a></li>
                        <li>               <a href="/global">Przesyłki Global Express</a></li>
                        <li>               <a href="/krajowe">Przesylki krajowe</a></li>
                        <li>               <a href="/ems">Przesyłki Ems</a></li>
                    </ul>
                    
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
                        <th>Miesiac</th>
                        <th>Suma przesyłek Ems</th>
                        <th>Suma przesyłek krajowych</th>
                        <th>Suma przesyłek Global Expres</th>
                        <th>Suma przesyłek polecone zagraniczne</th>
                        <th>Suma wszystkich</th>
                    </tr>
                </thead>
                <tbody>

                    <tr class="info">

                        <td>Czerwiec</td>
                        <td>{{$emsPrice}}</td>
                        <td>{{$krajowePrice}}</td>
                        <td>{{$globalPrice}}</td>
                        <td>{{$internationalPrice}}</td>
                        <td>{{$allPrices}}</td>


                    </tr>

                </tbody>
            </table> 
            <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div></div>
        <ul class="nav nav-pills">
            <form class="navbar-form navbar-left" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            Wybierz plik który chcesz załadować 
                             <input type="file" name="fileToUpload" >
                             <input type="submit" value="Upload Image" name="submit">
                        </div>
                    </form>

</html>
@section('content')


@stop
