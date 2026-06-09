@include('admin.inc.header')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Listings</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Listings</li>
        </ol>
      </nav>
    </div>

    <section>
      <a href="{{ url('admin/listings/create') }}" class="btn btn-success mb-3">Add New Listing</a>

      @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <table class="table datatable">
        <thead>
          <tr>
            <th>S.No</th>
            <th>Name</th>
            <th>Price</th>
            <th>Persons</th>
            <th>Rooms</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($listings as $listing)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $listing->listings_name }}</td>
            <td>${{ $listing->listings_price }}</td>
            <td>{{ $listing->listings_number_of_persons }}</td>
            <td>{{ $listing->listings_number_of_rooms ?? 'N/A' }}</td>
            <td>
              @if($listing->listings_status == 1)
                <span class="badge bg-success">Active</span>
              @else
                <span class="badge bg-danger">Inactive</span>
              @endif
            </td>
            <td>
              <a href="{{ url('admin/listings/' . $listing->listings_id . '/edit') }}" class="btn btn-primary" title="Edit">
                <i class="bi bi-pencil-square"></i>
              </a>
              <form action="{{ url('admin/delete-listing/' . $listing->listings_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" title="Delete">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')
