<template>
    <Base></Base>
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <section class="educations section" id="educations">
                <div class="skills_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Educations </h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn__open--modal" @click="this.openModal">
                                New Education
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
                                <input class="table_search--input" type="text" placeholder="Search Education">
                            </div>
                        </div>

                        <div class="education_table-heading">
                            <p>Institution</p>
                            <p>Period</p>
                            <p>Degree</p>
                            <p>Department</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="education_table-items" v-if="this.educations.length > 0 " v-for="item in educations" :key="item.id">
                            <p>{{item.institution}}</p>
                            <p> {{item.period}} </p>
                            <p> {{item.degree}} </p>
                            <p> {{item.department}} </p>
                            <div>
                                <button class="btn-icon success" @click="this.editModal(item)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger" @click="this.deleteEducation(item.id)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
                <!-------------- EDUCATION MODAL --------------->
                <div class="modal main__modal " :class="{show : showModal}">
                    <div class="modal__content">
                        <span class="modal__close btn__close--modal" @click="closeModal">×</span>
                        <h3 class="modal__title" v-show="this.editMode == false">Add Education</h3>
                        <h3 class="modal__title" v-show="this.editMode == true">Update Education</h3>
                        <hr class="modal_line"><br>
                        <form @submit.prevent="this.editMode ? this.updateModal() : this.createEducation()">
                            <div>
                                <p>Institution</p>
                                <input type="text" class="input" v-model="this.form.institution"/>

                                <p>Period</p>
                                <input type="text" class="input" v-model="this.form.period"/>

                                <p>Degree</p>
                                <input type="text" class="input" v-model="this.form.degree"/>

                                <p>Department</p>
                                <input type="text" class="input" v-model="this.form.department"/>

                            </div>

                        <br><hr class="modal_line">
                        <div class="model__footer">
                            <button class="btn mr-2 btn__close--modal" @click="closeModal()">
                                Cancel
                            </button>
                            <button class="btn btn-secondary" v-show="this.editMode == false">Save</button>
                            <button class="btn btn-secondary" v-show="this.editMode == true">Update</button>
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
        data : function(){
            return {
                educations : [],
                showModal : false,
                hideModal : true,
                editMode : false ,
                form : {
                    institution : '',
                    period : '',
                    degree : '',
                    department : '',
                }
            }
        },
        methods : {
            updateModal : function () {
                axios.post('/api/update_education/'+this.form.id , this.form)
                    .then(() => {
                        this.getEducations();
                        this.closeModal();
                        toast.fire({
                            icon : 'success',
                            title : 'Education Updated Successfully',
                        });
                    })
            },
            deleteEducation : function(id) {
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
                            axios.get('/api/delete_education/'+id)
                                .then(() => {
                                    Swal.fire(
                                        'Delete',
                                        'Education Deleted Successfully',
                                        'success'
                                    )
                                    this.getEducations();
                                })
                        }
                    });
            },
            openModal : function () {
                this.showModal = !this.showModal;
            },
            editModal : function(item) {
                this.editMode = true;
                this.openModal();
                this.form = item;
            },
            createEducation : function () {
                axios.post('/api/create_education', this.form)
                    .then(response => {
                        this.getEducations();
                        this.closeModal();
                        toast.fire({
                            icon : 'success',
                            title : 'Education Created Successfully'
                        });
                    })
            },
            closeModal : function () {
                this.showModal = !this.hideModal;
                this.form = {};
                this.editMode = false;
            },
            getEducations : function () {
                axios.get('/api/get_all_educations')
                    .then(response => {
                        //console.log(response);
                        this.educations = response.data.educations;
                    })
            }
        },
        mounted() {
            this.getEducations();
        },
    }
</script>

<style scoped>

</style>
