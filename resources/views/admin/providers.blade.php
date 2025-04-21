@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Membership</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Membership</li>
        </ol>
      </nav>
    </div>

    <section>
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Team Name</th>
            <th>Team Image</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($provider as $providers)
          <tr>
            <td> {{$loop->iteration}}</td>
            <td> {{$providers->provider_company_name}}</td>
            <td> {{$providers->provider_email}}</td>
            <td><a  class="btn btn-primary provider_view" data-id='{{ $providers->provider_id }}'><i class="bi bi-eye-fill"></i></a></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')