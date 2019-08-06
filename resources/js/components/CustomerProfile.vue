<template>
  <div class="personal-details">
    <h3>Personal Information</h3>
    <hr />
    <form action="/customer/profile" method="POST">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" v-model="user.name"/>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" :value="user.email" disabled class="form-control" />
      </div>
      <div class="form-group">
        <label for="phone">Mobile Number</label>
        <input type="text" name="mobile" class="form-control" v-model="user.phone"/>
      </div>
      <div class="form-group">
        <label for="gender">Gender</label>
        <input type="text" name="gender" class="form-control" v-model="user.gender"/>
      </div>
      <div class="form-group">
        <label for="gender">Address</label>
        <textarea name="address" id="address" cols="30" rows="5" v-model="user.address" class="form-control"></textarea>
      </div>

      <button class="btn btn-info" @click.prevent="updateProfile">Save</button>
    </form>
    <br />
    <br />
    <h3>Profile Picture</h3>
    <hr />
    <div class="row">
      <div class="col-3">
        <p>Your Profile photo</p>
        <img :src="'/' + user.profile_image" alt class="img-fluid" />
      </div>
      <div class="col-9">
        <form action="/customer/update-picture" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="profile">Select a photo</label>
            <input type="file" name="photo" class="form-control-file" id="profile" @change="onFileChanged"/>
          </div>

          <button class="btn btn-info" @click.prevent="updateProfileImage">Save</button>
        </form>
      </div>
    </div>
    <!-- row -->
    <br />
    <br />
    <h3>Change Password</h3>
    <hr />
    <form action="/customer/password-change" method="POST">
      <div class="form-group">
        <label for="current">Your Current Password</label>
        <input type="password" id="current" name="current" class="form-control" />
      </div>
      <div class="form-group">
        <label for="new">New Password</label>
        <input type="password" id="new" name="newpassword" class="form-control" />
      </div>
      <div class="form-group">
        <label for="current">Confirm New Password</label>
        <input type="password" id="current" name="newpassword_confirmation" class="form-control" />
      </div>

      <button class="btn btn-info" @click.prevent="updatePassword">Save</button>
    </form>
  </div>
  <!-- personal-details -->
</template>

<script>
export default {
    data() {
        return {
            user: {},
            selectedPhoto: null
        };
    },

    methods: {
        updateProfile() {
            axios.post('/api/customer/profile', this.user)
                .then(res => {
                    if (res.data.success) {
                        this.user = res.data.user;
                    }
                })
        },

        updateProfileImage() {
            const formData = new FormData()
            formData.append('photo', this.selectedPhoto, this.selectedPhoto.name);
            axios.post('/api/customer/profile/photo', formData)
                .then(res => {
                    if (res.data.success) {
                        console.log('success');
                    }
                });
        },

        updatePassword() {

        },

        onFileChanged(event) {
            this.selectedPhoto = event.target.files[0];
        }
    },

    mounted() {
        axios.get('/api/customer/profile')
            .then(res => {
                this.user = res.data;
            });
    }
};
</script>
