@include('admin.inc.header')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Videos</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item active">Videos</li>
      </ol>
    </nav>
  </div>

  <section>
  <a  class="btn btn-success" data-bs-toggle="modal" data-bs-target="#videoModal">Add New Video</a>
  @if(session()->has('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}
  </div>
  @endif
    <table class="table datatable">
      <thead>
          <th>S.No</th>
          <th>Name</th>
          <th>Gallery Media</th>
          <th>Action</th>
      </thead>
      <tbody>
        @foreach($videos as $gal)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$gal->videos_name}}</td>

          <td>
              <video width="320" height="240" controls>
                <source src="{{asset('storage/video/'.$gal->videos_url)}}" type="video/{{ pathinfo($gal->videos_url, PATHINFO_EXTENSION) }}">
                Your browser does not support the video tag.
              </video>
          </td>
          <td>     
             <button class="btn btn-danger" onclick="if(confirm('Are you sure you want to delete this video?')) { document.getElementById('delete-form-{{$gal->videos_id}}').submit(); }"><i class="bi bi-archive"></i></button>
            <form id="delete-form-{{$gal->videos_id}}" action="{{ url('admin/delete/services/'.$gal->videos_id) }}" method="POST" style="display: none;">
              @csrf
              @method('DELETE')
            </form></td>
        </tr>
        @endforeach
      </tbody>
  </table>
   
      </div>
      <!-- End Left side columns -->

    
    </div>
  </section>

</main>



  
  <!-- End #main -->
@include('admin.inc.footer')    