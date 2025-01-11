<div class="modal modal-edit fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                {{--                    <i class="ri-pencil-line icon-box"></i>--}}
                <img src="{{ asset('/theme/admin/assets/images/categories/mobile_phone.svg') }}" alt="Image"
                     class="icon-image" style="width: 30%; height: 30%">
                <h5 class="modal-title">Update Item</h5>
                <form novalidate class="theme-form theme-form-2 mega-form p-2 mt-4" enctype="multipart/form-data">

                    <div class="align-items-center g-2 mb-4 row">
                        <label class="col-sm-4 form-label-title mb-0 text-start" for="name"> Name<span
                                class="theme-color ms-2 required-dot ">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Enter Name">
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>


                    <div class="align-items-center g-2 mb-4 row">
                        <label class="col-sm-4 form-label-title mb-0 text-start" for="category"> Select
                            Parent</label>
                        <div class="col-sm-8">
                            <div>
                                <div>
                                    <div>
                                        <div>
                                            <div class="position-relative">
                                                <!-- Select Option -->
                                                <nav class="category-breadcrumb-select">
                                                    <ol class="breadcrumb">
                                                        <li class="breadcrumb-item">
                                                            <a href="javascript:void(0)"
                                                               class="toggle-dropdown">Select Option</a>
                                                        </li>
                                                    </ol>
                                                </nav>

                                                <!-- Close Button -->
                                                <a class="cateogry-close-btn d-inline-block">
                                                    <i class="ri-arrow-down-s-line down-arrow"></i>
                                                    <i class="ri-close-line close-arrow"
                                                       style="display: none;"></i>
                                                </a>

                                                <!-- Dropdown Box -->
                                                <div class="select-category-box mt-2 dropdown-open show"
                                                     style="bottom: auto; top: 100%; display:none">
                                                    <div class="category-content">
                                                        <nav aria-label="breadcrumb"
                                                             class="category-breadcrumb">
                                                            <ol class="breadcrumb">
                                                                <li class="breadcrumb-item inserted">
                                                                    <a href="javascript:void(0)">All</a>
                                                                </li>

                                                                {{-- <li class="breadcrumb-item inserted">
                                                                    <a href="javascript:void(0)">Fashion</a>
                                                                </li> --}}
                                                            </ol>
                                                        </nav>
                                                        <div class="category-listing inserted">
                                                            <ul>
                                                                {{-- Danh mục con của fashsion --}}
                                                                <li>
                                                                    Mobile
                                                                    <a href="javascript:void(0)" class="select-btn">
                                                                        Select</a>
                                                                </li>
                                                                <li>
                                                                    Music
                                                                    <a href="javascript:void(0)" class="select-btn">
                                                                        Select</a>
                                                                    <a href="javascript:void(0)"
                                                                       class="right-arrow inserted">
                                                                        <i class="ri-arrow-right-s-line"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Ordinal -->
                    <div class="align-items-center g-2 mb-4 row">
                        <label class="col-sm-4 form-label-title mb-0 text-start" for="name"> Ordinal<span
                                class="theme-color ms-2 required-dot ">*</span></label>
                        <div class="col-sm-8"><input type="text" name="name" class="form-control"
                                                     placeholder="Ordinal"></div>
                    </div>

                    <!-- Add Image Section -->
                    <div class="align-items-center g-2 mb-4 row">
                        <label class="col-sm-4 form-label-title mb-0 text-start" for="image">Icon</label>
                        <div class="col-sm-8">
                            <input type="file" name="icon" class="form-control">
                        </div>
                    </div>


                    <div class="align-items-center g-2 mb-4 row">
                        <label class="col-sm-4 form-label-title mb-0 text-start" for="status">Status</label>
                        <div class="col-sm-8 d-flex justify-content-start">
                            <div class="form-check form-switch ps-0"><label class="switch"><input type="checkbox"
                                                                                                  id="status"
                                                                                                  name="status"
                                                                                                  class="  "><span
                                        class="switch-state"></span></label></div>
                        </div>
                    </div>

                    <app-button>
                        <button class="btn btn-theme ms-auto mt-4" id="category_btn" type="submit">
                            <div> Save Category</div>
                        </button>
                    </app-button>
                </form>

            </div>
        </div>
    </div>
</div>
