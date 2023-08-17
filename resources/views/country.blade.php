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

  </header>
  <body class="antialiased">
    <table id="table-id">
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
          <tr>
            <td><img src="{{$con->flags->png}}" alt="{{isset($con->flags->alt) ?? ''}}" width="100px"></td>
            <td>{{$con->name->official}}</td>
            <td>{{$con->cca2}}</td>
            <td>{{$con->cca3}}</td>
            <td>
              @if(isset($con->name->nativeName))
                <ul>
                @foreach($con->name->nativeName as $key => $native)
                  @if(isset($con->languages->$key))
                    <li>{{$native->official}} (<span>{{$con->languages->$key}}</span>)</li>
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
  </body>
  <script type="application/javascript">
    $(function () {
      $('#table-id').DataTable();
    });
  </script>
</html>