<template>
    <Base></Base>
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <section class="about section" id="about">
                <div class="about_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>My Profile</h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn-secondary">
                                Save Changes
                            </div>
                        </div>
                    </div>
                    <div class="card_wrapper">
                        <div class="wrapper_left">
                            <div class="card">
                                <p>Full Name</p>
                                <input type="text" class="input" v-model="this.form.name"/>

                                <p>Email</p>
                                <input type="email" class="input" v-model="this.form.email"/>

                                <p>Experience (optional)</p>
                                <textarea cols="10" rows="5"  v-model="this.form.bio"></textarea>

                                <p>Password (leave blank if you don't want to change)</p>
                                <input type="password" class="input" v-model="this.form.password"/>
                            </div>
                        </div>

                        <div class="wrapper_right ">
                            <div class="card">
                                <div class="avatar_profile">
                                    <img :src="this.getPhoto" alt="" class="avatar_profile_img">
                                </div>
                                <input type="file" id="fileimg"  @change="changePhoto"/>
                            </div>
                        </div>

                    </div>
                    <div class="titlebar">
                        <div class="titlebar_item">

                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn-secondary" @click="updateProfile">
                                Save Changes
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>
</template>

<script>
    import Base from "../layouts/Base";
    export default {
        name: "Profile",
        components: {Base},
        data : function () {
            return {
                users : [],
                showModal : false,
                hideModal : true,
                errors : {},
                editMode : false,
                form : {
                    name : '',
                    email : '',
                    password : '',
                    bio : '',
                    type : '',
                    photo : '',
                }
            }
        },
        methods : {
            changePhoto : function(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024*1024*2;
                if(file['size'] > limit) {
                    swal ({
                        icon : 'error',
                        title : 'Oooops . . .',
                        text : 'You are uploading a large file',
                    })
                    return false;
                }
                reader.onloadend = (file) => {
                    this.form.photo = reader.result
                }
                reader.readAsDataURL(file)
            },
            updateProfile : function(){
                axios.post('/api/update_profile/'+this.form.id , this.form)
                    .then(response => {
                        toast.fire({
                            icon : "success",
                            title : "Profile Updated Successfully",
                        })
                    })
            },
            getPhoto : function () {
                let photo = '/img/upload/avatar.png'
                if(this.form.photo){
                    if(this.form.photo.indexOf('base64') !== -1) {
                        photo = this.form.photo
                    } else {
                        photo = '/img/upload/' + this.form.photo
                    }
                }
                return photo;
            },
            getProfile : function () {
                axios.get('/api/profile')
                    .then(response => {
                        this.form = response.data;
                    })
            }
        },
        mounted() {
            this.getProfile();
        },
    }
</script>

<style scoped>

</style>
