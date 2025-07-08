<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  </head>
  <body>
    
  <h1 class="text-center">Tracking Number : {{$trackingData['metadata']['number']}}</h1>
<br>
<br>

  <h2 class="ms-4 mb-1">Locations :</h2>
  <div class="row ms-2 me-2">
  @foreach ($trackingData['locations'] as $location)
    <div class="col-md-4">
  <div class="card">
  <div class="card-body">
    <h5 class="card-title">{{$location['timezone']}}</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">{{ $location['name'] }}</h6>
    <p class="card-text">State : {{$location['state']}} , Lattitude : {{$location['lat']}} , Longitude : {{$location['lng']}}</p>
    <a href="#" class="card-link">{{$location['country_code']}}</a>
    <a href="#" class="card-link">{{$location['locode']}}</a>
  </div>
  </div>
  </div>
  @endforeach
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  </body>
</html>