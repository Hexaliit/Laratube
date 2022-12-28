<template>
    <Base></Base>
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <section class="about section" id="about">
                <div class="about_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>About Us</h1>
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
                                <input type="text" class="input" v-model="form.name"/>

                                <p>Email</p>
                                <input type="email" class="input" v-model="form.email"/>

                                <p>Phone</p>
                                <input type="text" class="input" v-model="form.phone"/>

                                <p>Address</p>
                                <input type="text" class="input" v-model="form.address"/>

                                <p>Description</p>
                                <textarea cols="10" rows="5"  v-model="form.description"></textarea>

                            </div>
                            <div class="card">
                                <p>Tagline</p>
                                <input type="text" class="input" v-model="form.tagline"/>
                            </div>
                        </div>

                        <div class="wrapper_right ">
                            <div class="card">
                                <div class="avatar_profile">
                                    <img :src="getPhoto()" alt="" class="avatar_profile_img">
                                </div>
                                <input type="file" id="fileimg" @change="changePhoto"/>
                            </div>
                            <div class="card">
                                <p>CV</p>
                                <input type="file" id="filecv" @change="uploadCV"/>
                            </div>
                        </div>

                    </div>
                    <div class="titlebar">
                        <div class="titlebar_item">

                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn-secondary" @click.prevent="updateAbout">
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
        name: "Index",
        components : {
            Base
        },
        data: function () {
            return {
                form : {
                    name : '',
                    photo : '',
                    email : '',
                    phone : '',
                    address : '',
                    description : '',
                    tagline : '',
                    cv : '',
                },
            }
        },

        methods : {
            getAbout : function() {
                axios.get('/api/edit_about')
                    .then(response => {
                        if (response.data == ""){
                            return
                        }
                        this.form = response.data;
                    })
            },
            updateAbout : function () {
                axios.post(`/api/update_about/${this.form.id}`, this.form)
                    .then(response => {
                        toast.fire({
                            icon : 'success',
                            title : 'Update Successfully'
                        })
                    })
            },
            getPhoto : function () {
                let photo = '/img/avatar.png'
                if(this.form.photo){
                    if(this.form.photo.indexOf('base64') !== -1) {
                        photo = this.form.photo
                    } else {
                        photo = '/img/upload/' + this.form.photo
                    }
                }
                return photo;
            },
            uploadCV : function(e){
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
                    this.form.cv = reader.result
                }
                reader.readAsDataURL(file)
            },
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
        },
        mounted() {
            this.getAbout();
        },
    }
</script>

<style scoped>

</style>
