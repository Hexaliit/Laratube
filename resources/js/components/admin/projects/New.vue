<template>
    <Base></Base>
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <section class="about section" id="project">
                <div class="about_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Add Project</h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn-secondary" @click="saveProject">
                                Save Project
                            </div>
                        </div>
                    </div>
                    <div class="card_wrapper">
                        <div class="wrapper_left">
                            <div class="card">

                                <p>Title</p>
                                <input type="text" class="input" v-model="form.title"/>

                                <p>Description</p>
                                <textarea cols="10" rows="5"  v-model="form.description"></textarea>

                                <p>Link</p>
                                <input type="text" class="input" v-model="form.link"/>

                            </div>
                        </div>

                        <div class="wrapper_right ">
                            <div class="card">
                                <div class="project_img-container">
                                    <img :src="getPhoto()" class="project_img">
                                </div>
                                <br>
                                <input type="file" id="fileimg" @change="this.changePhoto"/>
                                <br><br><br>
                            </div>
                        </div>

                    </div>
                    <div class="titlebar">
                        <div class="titlebar_item">

                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn-secondary" @click="saveProject">
                                Save Project
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
        name: "New" ,
        components : {
          Base
        },
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
            saveProject : function () {
                axios.post('/api/add_project' , this.form)
                    .then(response => {
                        this.$router.push('/admin/projects')
                        toast.fire({
                            icon : 'success',
                            title : 'Project Added Successfully',
                        })
                    })
            }
        },
        data: function () {
            return {
                form : {
                    title : '',
                    description : '',
                    link : '',
                    photo : '',
                }
            }
        }
    }
</script>

<style scoped>

</style>
