@include('admin.inc.header')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>{{ucfirst(str_replace('_','',$db))}}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">{{ucfirst(str_replace('_','',$db))}}</li>
        </ol>
      </nav>
    </div>

    <section>
      <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#{{$db}}Modal">Add New {{ucfirst(str_replace('_','',$db))}}</a>

      <table class="table datatable">
        <thead>
          <tr>
            <th>S.No</th>
            @if(isset($collections[0]))
              @foreach(array_keys((array)$collections[0]) as $columnName)
                <th>{{ ucfirst(str_replace('_', ' ', $columnName)) }}</th>
              @endforeach
            @endif
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($collections as $collection)
          <tr>
            <td>{{ $loop->iteration }}</td>
            @foreach($collection as $columnName => $value)
              <td>{{ $value }}</td>
            @endforeach
            <td>
              <a class="btn btn-primary form_view" >
                <i class="bi bi-eye-fill"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')

