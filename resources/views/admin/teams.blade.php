@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Teams</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Teams</li>
        </ol>
      </nav>
    </div>

    <section>
    <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Team</a>
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Team Name</th>
            <th>Team Image</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($teams as $team)
          <tr>
            <td> {{$loop->iteration}}</td>
            <td> {{$team->teams_name}}</td>
            <td> <image src='{{asset('storage/team/'.$team->teams_img)}}' loading='lazy' class='img-fluid'></td>
            <td>
              <a data-id="{{$team->teams_id}}" class="btn btn-secondary edit"><i class="bi bi-pencil-square"></i></a>
                <button class="btn btn-danger" onclick="if(confirm('Are you sure you want to delete this team?')) { document.getElementById('delete-form-{{$team->teams_id}}').submit(); }"><i class="bi bi-archive"></i></button>
              <form id="delete-form-{{$team->teams_id}}" action="{{ url('admin/delete/teams/'.$team->teams_id) }}" method="POST" style="display: none;">
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