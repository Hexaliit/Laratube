<template>
    <Base></Base>
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <!--==================== EXPERIENCES ====================-->
            <section class="experiences section" id="experiences">
                <div class="skills_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Experiences </h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn__open--modal" @click="this.openModal">
                                New Experience
                            </div>
                        </div>
                    </div>

                    <div class="table">

                        <div class="table_filter">
                            <span class="table_filter-Btn ">
                                <i class="fas fa-ellipsis-h"></i>
                            </span>
                            <div>
                                <ul class="table_filter-list">
                                    <li>
                                        <p class="table_filter-link table_filter-link--active">
                                            All
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="table_search">
                            <div class="table_search-wrapper">
                                <select class="table_search-select" name="" id="">
                                    <option value="">Filter</option>
                                </select>
                            </div>
                            <div class="relative">
                                <i class="table_search-input--icon fas fa-search "></i>
                                <input class="table_search--input" type="text" placeholder="Search Experience">
                            </div>
                        </div>

                        <div class="experience_table-heading">
                            <p>Company</p>
                            <p>Period</p>
                            <p>Position</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="experience_table-items" v-if="this.experiences.length > 0" v-for="item in experiences" :key="item.id">
                            <p>{{item.company}}</p>
                            <p>{{item.period}}</p>
                            <p>{{item.position}}</p>
                            <div>
                                <button class="btn-icon success" @click="this.editModal(item)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger"  @click="deleteExperience(item.id)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
                <!-------------- EXPERIENCE MODAL --------------->
                <div class="modal main__modal " :class="{ show : this.showModal}">
                    <div class="modal__content">
                        <span class="modal__close btn__close--modal" @click="closeModal">×</span>
                        <h3 class="modal__title" v-if="this.editMode == false">Add Experience</h3>
                        <h3 class="modal__title" v-if="this.editMode == true">Update Experience</h3>
                        <hr class="modal_line"><br>
                        <form @submit.prevent=" this.editMode ? this.updateExperience() : this.createExperience() ">
                        <div>
                            <p>Company</p>
                            <input type="text" class="input" v-model="form.company"/>

                            <p>Period</p>
                            <input type="text" class="input" v-model="form.period"/>

                            <p>Position</p>
                            <input type="text" class="input" v-model="form.position"/>

                        </div>
                        <br><hr class="modal_line">
                        <div class="model__footer">
                            <button class="btn mr-2 btn__close--modal" @click="closeModal">
                                Cancel
                            </button>
                            <button class="btn btn-secondary" v-if="this.editMode == false">Save</button>
                            <button class="btn btn-secondary" v-if="this.editMode == true">Update</button>
                        </div>
                        </form>
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
        components: {Base},
        data : function () {
            return {
                experiences : [],
                showModal : false ,
                hideModal : true ,
                editMode : false ,
                form : {
                    'company' : '',
                    'period' : '',
                    'position' : '',
                },
            }
        },
        methods : {
            getExperiences : function () {
                axios.get('/api/get_all_experiences')
                    .then(response => {
                        this.experiences = response.data.experiences;
                    })
            },
            editModal : function (item) {
                this.editMode = true;
                this.openModal();
                this.form = item;
            },
            deleteExperience : function(id) {
                Swal.fire({
                    title : 'Are You Sure ?',
                    text : "You Can't Go Back !",
                    icon : 'warning',
                    showCancelButton : true,
                    confirmButtonColor : '#3085d6',
                    cancelButtonColor : '#d33',
                    confirmButtonText : 'Yes , Delete it !',
                })
                    .then((result) => {
                        if(result) {
                            axios.get('/api/delete_experience/'+id)
                                .then(() => {
                                    Swal.fire(
                                        'Delete',
                                        'Education Deleted Successfully',
                                        'success'
                                    )
                                    this.getExperiences();
                                })
                        }
                    });
            },
            updateExperience : function () {
                axios.post('/api/update_experience/'+this.form.id , this.form)
                    .then(() => {
                        this.getExperiences();
                        this.closeModal();
                        toast.fire({
                            icon : 'success',
                            title : 'Experience Updated Successfully',
                        });
                    })
            },

            openModal : function () {
                this.showModal = !this.showModal;
            },
            closeModal : function () {
                this.showModal = !this.hideModal;
                this.form = {};
                this.editMode = false;
            },
            createExperience : function () {
                axios.post('/api/create_experience' , this.form)
                    .then(response => {
                        this.getExperiences();
                        this.closeModal();
                        toast.fire({
                            icon : 'success',
                            title : 'Experience Created Successfully'
                        })
                    })
                    .catch(error => {


                    })
            }
        },
        mounted() {
            this.getExperiences();
        },
    }
</script>

<style scoped>

</style>
