@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Services</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Services</li>
        </ol>
      </nav>
    </div>

    <section>
    <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ServicesModal">Add New Service</a>
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Service Name</th>
            <th>Service Image</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($services as $service)
          <tr>
            <td> {{$loop->iteration}}</td>
            <td> {{$service->services_name}}</td>
            <td> <image src='{{asset('storage/service/'.$service->services_images)}}' loading='lazy' class='img-fluid'></td>
            <td><a data-id={{$service->services_id}} class="btn btn-primary edit2"><i class="bi bi-eye-fill"></i></a>
              <button class="btn btn-danger" onclick="if(confirm('Are you sure you want to delete this service?')) { document.getElementById('delete-form-{{$service->services_id}}').submit(); }"><i class="bi bi-archive"></i></button>
              <form id="delete-form-{{$service->services_id}}" action="{{ url('admin/delete/services/'.$service->services_id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')