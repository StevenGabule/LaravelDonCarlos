@extends('backend.layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hotlines information and management</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold header-text small captionText">Add New Number</h6>
                    </div>
                    <div class="card-body ">
                        <form action="{{ route('hotlines.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="InputNumber">Enter a number</label>
                                <input type="text"
                                       class="form-control"
                                       id="InputNumber"
                                       value="{{ old('phone_number') }}"
                                       name="phone_number">
                            </div>
                            <div class="form-group">
                                <label for="InputCategoryId">Choose a category</label>
                                <select name="hotline_category_id" id="InputCategoryId" class="custom-select">
                                    @forelse($hotline_category as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @empty
                                        <option value="">No available</option>
                                    @endforelse
                                </select>
                            </div>
                            <input type="submit" name="submit" value="Submit" class="btn btn-sm btn-primary">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /.container-fluid -->
@stop
