<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Country information</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <!-- Jquery Table -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css"/>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <!-- BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

  </header>
  <body class="antialiased mx-4 mb-4 mt-5">
    <div class="d-flex justify-content-center mb-4"><h1>Country Information</h1></div>
    <table id="table-id" class="table table-hover display">
      <thead>
        <tr>
          <th>Flags</th>
          <th>Country Name</th>
          <th>2 Character Country</th>
          <th>3 Character Country</th>
          <th>Native Country Name</th>
          <th>Alternative Country Name</th>
          <th>Country Calling Codes</th>
        </tr>
      </thead>
      <tbody>
        @foreach($countries as $con)
          <tr class="btnModal" data-url="{{route('country.show', $loop->index)}}">
            <td><img src="{{$con->flags->png}}" alt="{{isset($con->flags->alt) ?? ''}}" width="100px"></td>
            <td>{{$con->name->official}}</td>
            <td>{{$con->cca2}}</td>
            <td>{{$con->cca3}}</td>
            <td>
              @if(isset($con->name->nativeName))
                <ul>
                @foreach($con->name->nativeName as $key => $native)
                  @if(isset($con->languages->$key))
                    <li>{{$native->official}} (<span class="fw-bold">{{$con->languages->$key}}</span>)</li>
                  @else
                    <li>{{$native->official}}</li>
                  @endif
                @endforeach
                </ul>
              @endif
            </td>
            <td>
              @if(isset($con->altSpellings))
                <ul>
                @foreach($con->altSpellings as $alt)
                  <li>{{$alt}}</li>
                @endforeach
                </ul>
              @endif
            </td>
            <td>
              @if(isset($con->idd->{'root'}))
                @if(isset($con->idd->suffixes))
                  @foreach($con->idd->suffixes as $suf)
                    {{$con->idd->root}}{{$suf}}<br>
                  @endforeach
                @else
                  {{$con->idd->root}}
                @endif
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="modal fade" id="country-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">
              <img id="country-img" src="" width="50px">
              <h5 id="country-title" class="d-inline-block ms-1 mb-0 justify-content-center"></h5>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="Container">
              <div class="row">
                <div class="col">
                  <div class="row">
                    <div class="col-4 fw-bold">Country Name</div>
                    <div id="country-name" class="col-6"></div>
                  </div>
                </div>
                <div class="col">
                  <div class="row">
                    <div class="col-4 fw-bold">Official Name</div>
                    <div id="country-official" class="col-6"></div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col">
                  <div class="row">
                    <div class="col-4 fw-bold">Region</div>
                    <div id="country-region" class="col-8"></div>
                  </div>
                </div>
                <div class="col">
                  <div class="row">
                    <div class="col-4 fw-bold">SubRegion</div>
                    <div id="country-subregion" class="col-8"></div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-2 fw-bold">Capital</div>
                <div id="country-capital" class="col-8"></div>
              </div>
              <hr>
              <div class="row">
                <div class="col-2 fw-bold">Languages</div>
                <div id="country-lang" class="col-8"></div>
              </div>
              <hr>
              <div class="row">
                <div class="col-2 fw-bold">Currencies</div>
                <div id="country-currency" class="col-8"></div>
              </div>
              <hr>
              <div class="row">
                <div class="col-2 fw-bold">Population</div>
                <div id="country-population" class="col-8"></div>
              </div>
              <hr>
              <div class="row">
                <div class="col-2 fw-bold">Timezone</div>
                <div id="country-tz" class="col-8"></div>
              </div>
              <hr>
              <div class="row">
                <div class="col-2 fw-bold">Google Maps</div>
                <div class="col-8"><a id="country-map" href="" target="_blank">Country Map</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script type="application/javascript">
    $(function () {
      $('#table-id').DataTable();

      $(document).on('click','table#table-id tbody tr.btnModal', function() {
        var url = $(this).data('url');
        $.get(url, function (data) {
          if (data != null)
          {
            $('img#country-img').attr('src',data.flags.png);
            $('#country-title').text(data.name.common);
            $('#country-name').text(data.name.common);
            $('#country-official').text(data.name.official);
            $('#country-region').text(data.region);
            $('#country-subregion').text(data.subregion);
            var capital = '';
            data.capital.forEach(function(value, index) {
              if (index == data.capital.length -1) {
                capital += value;
              }
              else {
                capital += value + ', ';
              }
            });
            $('#country-capital').text(capital);
            var lang = '';
            for (const [index, value] of Object.values(data.languages).entries()) {
              if (index == Object.keys(data.languages).length - 1) {
                lang += value;
              }
              else {
                lang += value + ', ';
              }
            }
            $('#country-lang').text(lang);
            var currency = '';
            for (const [index, value] of Object.values(data.currencies).entries()) {
              if (index == Object.keys(data.currencies).length - 1) {
                currency += value.name + '(' + value.symbol + ')';
              }
              else {
                currency += value.name + '(' + value.symbol + '), ';
              }
            }
            $('#country-currency').text(currency);
            $('#country-population').text(data.population);
            $('#country-tz').text(data.timezones);
            $('#country-map').attr('href', data.maps.googleMaps);
            $('#country-map').text(data.maps.googleMaps);
            $('#country-modal').modal('show');
          }
        });
      });
    });
  </script>
</html>