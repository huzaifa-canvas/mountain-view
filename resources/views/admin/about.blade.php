@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Update About Page</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">About Page</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
<form  action="{{url('admin/edit-aboutpage/1')}}" method='post' enctype="multipart/form-data" >
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
              <h5 class="card-title">About Page Settings</h5>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Upload Type</label>
                  <div class="col-sm-10">
                    <select class="form-select" name='about_page_type'  required>
                      <option selected="" disabled>Select Type</option>
                      <option value="1">Video</option>
                      <option value="2">Image</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Upload Video</label>
                  <div class="col-sm-10">
                    <input type="file"  name='about_page_video' class="form-control">
                  </div>
                </div>

                
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Upload Image</label>
                    <div class="col-sm-10">
                      <input type="file" name='about_page_image' class="form-control" >
                    </div>
                  </div>
                  <div  class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Text</label>
                    <div class="col-sm-10">
                      <textarea name='about_page_text' class="form-control"></textarea>
                    </div>
                  </div>


                  <div class="row mb-3">
                    <div class="col-sm-10">
                        <input type="submit" value="Update About Page" class='btn btn-success'>
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