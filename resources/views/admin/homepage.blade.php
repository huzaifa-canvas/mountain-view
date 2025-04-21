@include('admin.inc.header')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Update homepage</h1>
    <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
      <li class="breadcrumb-item active">Homepage</li>
    </ol>
    </nav>
  </div><!-- End Page Title -->
  <form  action="{{url('admin/edit-homepage/1')}}" method='post' enctype="multipart/form-data" >
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
        <h5 class="card-title">Homepage Settings</h5>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Main Video</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" name='homepage_background_video'> 
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">First Heading</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name='homepage_first_section_heading'  value="{{ $homepage->homepage_first_section_heading ?? '' }}" placeholder="Write Heading" > 
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Text</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name='homepage_first_section_text' placeholder="Write Heading"   value="{{ $homepage->homepage_first_section_text ?? '' }}"> 
          </div>
          </div>
        <div  class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Section Two Text</label>
          <div class="col-sm-10">
          <input type="text"  name='homepage_first_section_two_text' value="{{ $homepage->homepage_first_section_two_text ?? '' }}" class="form-control">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">homepage_first_section_two_heading_one</label>
          <div class="col-sm-10">
            <input type="text" name='homepage_first_section_two_heading_one' value="{{ $homepage->homepage_first_section_two_heading_one ?? '' }}" class="form-control" >
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">homepage_first_section_two_heading_two</label>
          <div class="col-sm-10">
            <input type="text" name='homepage_first_section_two_heading_two' value="{{ $homepage->homepage_first_section_two_heading_two ?? '' }}" class="form-control" >
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">homepage_first_section_two_img_one Image Three</label>
          <div class="col-sm-10">
            <input type="file" name='homepage_first_section_two_img_one' class="form-control" >
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">homepage_first_section_two_img_two Three Image</label>
          <div class="col-sm-10">
            <input type="file" name='homepage_first_section_two_img_two' class="form-control" >
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">homepage_first_section_two_img_three  Image</label>
          <div class="col-sm-10">
            <input type="file" name='homepage_first_section_two_img_three' class="form-control" >
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">homepage_first_section_two_img_four  Image</label>
          <div class="col-sm-10">
            <input type="file" name='homepage_first_section_two_img_four' class="form-control" >
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">homepage_first_section_two_bottom_text Three Heading</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name='homepage_first_section_two_bottom_text' value="{{ $homepage->homepage_first_section_two_bottom_text ?? '' }}" placeholder="Write Heading" > 
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">homepage_first_section_three_heading_one Three Text</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name='homepage_first_section_three_heading_one' value="{{ $homepage->homepage_first_section_three_heading_one ?? '' }}" placeholder="Write Heading" > 
          </div>
          </div>
          <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">homepage_first_section_three_text Three Button Text</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name='homepage_section_three_button_text' value="{{ $homepage->homepage_first_section_three_text ?? '' }}" placeholder="Write Heading" > 
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