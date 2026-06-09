@include('admin.inc.header')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Create Listing</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{url('admin/listings')}}">Listings</a></li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add New Listing</h5>
              <form action="{{ url('admin/listings') }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="listings_name" class="form-label">Listing Name</label>
                    <input type="text" class="form-control" name="listings_name" id="listings_name" placeholder="Enter Listing Name" required>
                  </div>
                  <div class="col-md-6">
                    <label for="listings_price" class="form-label">Listing Price</label>
                    <input type="number" step="0.01" class="form-control" name="listings_price" id="listings_price" placeholder="Enter Price" required>
                  </div>
                </div> 

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="listings_number_of_persons" class="form-label">Number of Persons</label>
                    <input type="number" class="form-control" name="listings_number_of_persons" id="listings_number_of_persons" placeholder="Max Persons" required>
                  </div>
                  <div class="col-md-4">
                    <label for="listings_number_of_rooms" class="form-label">Number of Rooms</label>
                    <input type="number" class="form-control" name="listings_number_of_rooms" id="listings_number_of_rooms" placeholder="Number of Rooms">
                  </div>
                  <div class="col-md-4">
                    <label for="listings_status" class="form-label">Status</label>
                    <select name="listings_status" id="listings_status" class="form-select">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Listing Images</label>
                  <div class="input-images"></div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Listing Points (Bullet points)</label>
                  <div id="answer_container">
                    <div class="input-group mb-2 answer_parent">
                      <input type="text" name="listings_points[]" class="form-control" placeholder="Enter Point" required>
                      <button type="button" class="btn btn-danger remove-btn"><i class="bi bi-x-lg"></i></button>
                    </div>
                  </div>
                  <button id="clone_btn" type="button" class="btn btn-success"><i class="bi bi-plus-lg"></i> Add Point</button>
                </div>

                @php
                $iconList = [
                    'fa-solid fa-wifi' => 'Wifi',
                    'fa-solid fa-tv' => 'TV',
                    'fa-solid fa-snowflake' => 'Air Conditioning',
                    'fa-solid fa-kitchen-set' => 'Kitchenette',
                    'fa-solid fa-toilet' => 'Bathroom / Toilet',
                    'fa-solid fa-mountain-sun' => 'Mountain View',
                    'fa-solid fa-mountain' => 'Mountain',
                    'fa-solid fa-ear-deaf' => 'Soundproof',
                    'fa-solid fa-volume-xmark' => 'Mute / Soundproof',
                    'fa-solid fa-mug-hot' => 'Coffee Machine / Tea',
                    'fa-solid fa-maximize' => 'Area / Size',
                    'fa-solid fa-ruler-combined' => 'Measurements',
                    'fa-solid fa-fan' => 'Fan',
                    'fa-solid fa-water-ladder' => 'Swimming Pool',
                    'fa-solid fa-utensils' => 'Dining/Restaurant',
                    'fa-solid fa-car' => 'Parking',
                    'fa-solid fa-bed' => 'Bed',
                    'fa-solid fa-bath' => 'Bath',
                    'fa-solid fa-fire' => 'Heating/Fireplace',
                    'fa-solid fa-dumbbell' => 'Gym',
                    'fa-solid fa-smoking-ban' => 'No Smoking',
                    'fa-solid fa-wheelchair' => 'Wheelchair Accessible',
                    'fa-solid fa-paw' => 'Pet Friendly',
                    'fa-solid fa-elevator' => 'Elevator',
                    'fa-solid fa-bell-concierge' => 'Room Service',
                    'fa-solid fa-soap' => 'Toiletries',
                    'fa-solid fa-wine-glass' => 'Bar/Lounge',
                    'fa-solid fa-hot-tub-person' => 'Hot Tub',
                    'fa-solid fa-spa' => 'Spa',
                    'fa-solid fa-desktop' => 'Workspace'
                ];
                @endphp

                <div class="mb-3">
                  <label class="form-label">Listing Extras (Text & Icon)</label>
                  <div id="answer_container2">
                    <div class="row mb-2 answer_parent2 align-items-center">
                      <div class="col-md-5 mb-2 mb-md-0">
                        <input type="text" name="listings_extras[]" class="form-control" placeholder="Extra Title (e.g. Free Wifi)" required>
                      </div>
                      <div class="col-md-5 mb-2 mb-md-0">
                        <select name="listings_icons[]" class="form-control icon-select" required style="width: 100%;">
                          <option value="">Select Icon</option>
                          @foreach($iconList as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-btn2 w-100"><i class="bi bi-x-lg"></i></button>
                      </div>
                    </div>
                  </div>
                  <button id="clone_btn2" type="button" class="btn btn-success"><i class="bi bi-plus-lg"></i> Add Extra</button>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                      <button type="submit" class="btn btn-primary">Save Listing</button>
                      <a href="{{ url('admin/listings') }}" class="btn btn-secondary">Cancel</a>
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
