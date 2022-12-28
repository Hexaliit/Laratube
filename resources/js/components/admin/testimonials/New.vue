<template>
    <Base></Base>
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <section class="about section" id="testimonial">
                <div class="about_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Add Testimonial</h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn-secondary" @click="this.saveTestimonial">
                                Save Testimonial
                            </div>
                        </div>
                    </div>
                    <div class="card_wrapper">
                        <div class="wrapper_left">
                            <div class="card">

                                <p>Name</p>
                                <input type="text" class="input" v-model="form.name"/>

                                <p>Function</p>
                                <input type="text" class="input" v-model="form.function"/>

                                <p>Testimony</p>
                                <textarea cols="10" rows="5"  v-model="form.testimony"></textarea>

                            </div>
                        </div>

                        <div class="wrapper_right ">
                            <div class="card">
                                <p>Photo</p>
                                <div class="testimonial_img-container">
                                    <img :src="getPhoto()" alt="" class="testimonial_img">
                                </div>
                                <input type="file" id="fileimg" @change="this.changePhoto"/>
                                <br>
                                <p>Rating ?/5</p>
                                <input type="text" class="input" v-model="form.rating"/>
                            </div>
                        </div>

                    </div>
                    <div class="titlebar">
                        <div class="titlebar_item">

                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn-secondary" @click="this.saveTestimonial">
                                Save Testimonial
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
        name: "New",
        components : {
            Base ,
        },
        data : function () {
            return {
                form : {
                    name : '',
                    function : '',
                    testimony : '',
                    rating : '',
                    photo : '',
                },
            }
        } ,
        methods : {
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
            saveTestimonial : function() {
              axios.post('/api/add_testimonial' , this.form)
                  .then(response => {
                      this.$router.push('/admin/testimonials');
                      toast.fire({
                          icon : 'success',
                          title : 'Testimonial Added Successfully',
                      })
                  })
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
    }
</script>

<style scoped>

</style>
