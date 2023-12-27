@extends('admin.layouts.sidebar')
@section('tittle', 'Set Notification')
@section('page', 'Set Notification')
@section('content')
    <div class="card h-auto">
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" placeholder="Title">
                </div>
            </form>
            <label class="form-label">Description</label>
            <div id="ckeditor"></div>
        </div>
    </div>
@endsection
