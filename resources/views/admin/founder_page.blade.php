@include('admin.inc.header')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Update Founder Page</h1>
    <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
      <li class="breadcrumb-item active">Founder Page</li>
    </ol>
    </nav>
  </div><!-- End Page Title -->
  <form  action="{{url('admin/edit-founderpage/1')}}" method='post' enctype="multipart/form-data" >
  @csrf
  @if(session()->has('success'))
  <div class="alert alert-success">
    {{ session()->get('success') }}
  </div>
  @endif
  <section class="section">
    <div class="row">
    <div class="col-lg-12">

      <div class="card">
      <div class="card-body">
        <h5 class="card-title">Founder Page Settings</h5>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Main Img</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" name='founder_page_img'> 
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name='founder_page_name'  value="{{ $founder->founder_page_name ?? '' }}" placeholder="Write Name" > 
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Sub Text</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name='founder_page_name_sub_text' placeholder="Write Heading"   value="{{ $founder->founder_page_name_sub_text ?? '' }}"> 
          </div>
          </div>
        <div  class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
          <input type="text"  name='founder_page_description' value="{{ $founder->founder_page_description ?? '' }}" class="form-control">
          </div>
        </div>
     
          <div class="row mb-3">
          <div class="col-sm-10">
            <input type="submit" value="Update Homepage" class='btn btn-success'>
          </div>
          </div>
        </form>
      </div>
      </div>
    </div>
    </div>
  </section>



  </main><!-- End #main -->
@include('admin.inc.footer')    