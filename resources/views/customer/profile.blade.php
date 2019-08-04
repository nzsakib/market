@extends('layouts.customer')

@section('content')
    <div class="personal-details">
        <h3>Personal Information</h3>
        <hr>
        <form action="/customer/profile" method="POST">
            @csrf 
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" value="{{ $user->email }}" disabled class="form-control">
            </div>
            <div class="form-group">
                <label for="phone">Mobile Number</label>
                <input type="text" name="mobile" class="form-control">
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <input type="text" name="gender" class="form-control">
            </div>

            <button class="btn btn-info">Save</button>
        </form>
<br><br>
        <h3>Profile Picture</h3>
        <hr>
        <div class="row">
            <div class="col-3">
                <p>Your Profile photo</p>
                <img src="https://placeimg.com/200/200/arch" alt="" class="img-fluid">
            </div>
            <div class="col-9">
                <form action="/customer/update-picture" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="profile">Select a photo</label>
                        <input type="file" name="profile" class="form-control-file" id="profile">
                    </div>

                    <button class="btn btn-info">Save</button>
                </form>
            </div>
        </div> <!-- row --> 
        <br><br>
        <h3>Change Password</h3>
        <hr>
        <form action="/customer/password-change" method="POST">
            @csrf
            <div class="form-group">
                <label for="current">Your Current Password</label>
                <input type="password" id="current" name="current" class="form-control">
            </div>
            <div class="form-group">
                <label for="new">New Password</label>
                <input type="password" id="new" name="newpassword" class="form-control">
            </div>
            <div class="form-group">
                <label for="current">Confirm New Password</label>
                <input type="password" id="current" name="newpassword_confirmation" class="form-control">
            </div>

            <button class="btn btn-info">Save</button>
        </form>
    </div> <!-- personal-details --> 

    <br><br><br><br><br><br>
@endsection