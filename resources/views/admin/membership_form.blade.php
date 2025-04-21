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
          @foreach($membership as $memberships)
          <tr class="{{ $memberships->membership_forms_read_status == 0 ? 'table-success' : '' }} classsf_{{ $memberships->membership_forms_id }}">
            <td> {{$loop->iteration}}</td>
            <td> {{$memberships->membership_forms_name}}</td>
            <td> {{$memberships->membership_forms_email}}</td>
            <td><a  class="btn btn-primary form_view" data-id='{{ $memberships->membership_forms_id }}'><i class="bi bi-eye-fill"></i></a></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')