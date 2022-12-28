<template>
    <Base></Base>
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <section class="services section" id="services">
                <div class="services_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Services</h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn__open--modal" @click="openModal">
                                New Service
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
                                <input class="table_search--input" type="text" placeholder="Search Service">
                            </div>
                        </div>

                        <div class="service_table-heading">
                            <p>Title</p>
                            <p>Icon</p>
                            <p>Description</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="service_table-items" v-if="services.length > 0" v-for="item in services" :key="item.id">
                            <p>{{item.name}}</p>
                            <button :class="item.icon">
                                <i class=" fas fa-pencil-alt"></i>
                            </button>
                            <p>{{item.description}}
                            </p>
                            <div>
                                <button class="btn-icon success" @click="editModal(item)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger" @click="deleteService(item.id)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <!-------------- SERVICES MODAL --------------->
                <div class="modal main__modal " :class="{ show:showModal }">
                    <div class="modal__content">
                        <span class="modal__close btn__close--modal" @click="closeModal()">×</span>
                        <h3 class="modal__title" v-show="this.editMode === false">Add Service</h3>
                        <h3 class="modal__title" v-show="this.editMode === true">Update Service</h3>
                        <hr class="modal_line"><br>

                        <form @submit.prevent=" this.editMode ?  this.updateService() : this.createService()">
                        <div>
                            <p>Service Name</p>
                            <input type="text" class="input" v-model="form.name"/>

                            <p>Icon Class</p>
                            <input type="text" class="input" v-model="form.id"/>
                            <span style="color:#006fbb;">Find your suitable icon: Font Awesome</span>

                            <p>Description</p>
                            <textarea cols="10" rows="5"  v-model="form.description"></textarea>
                        </div>
                        <br><hr class="modal_line">
                        <div class="model__footer">
                            <button class="btn mr-2 btn__close--modal" @click="closeModal()">
                                Cancel
                            </button>
                            <button class="btn btn-secondary" v-show="editMode === false">Save</button>
                            <button class="btn btn-secondary" v-show="editMode === true">Update</button>
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
        data: function () {
            return {
                services:[],
                showModal : false,
                hideModal : true,
                editMode : false,
                form : {
                    name : '',
                    icon : '',
                    description : '',
                },
            }
        },
        methods : {
            getService : function () {
                axios.get('/api/get_all_service')
                    .then(response => {
                        this.services = response.data.services;
                    })
                    .catch(error => {

                    })
            },
            createService : function () {
                axios.post('/api/create_service' , this.form)
                    .then(response => {
                        this.getService();
                        this.closeModal();
                        toast.fire({
                            icon : "success",
                            title : "Service Added Successfully",
                        });
                    })
                    .catch(error => {

                    })
            },
            updateService : function () {
                axios.post('/api/update_service/'+this.form.id , this.form)
                    .then(response => {
                        this.getService();
                        this.closeModal();
                        toast.fire({
                            icon : "success" ,
                            title : "Service Updated Successfully"
                        });
                    })
                    .catch(error => {

                    })
            },
            deleteService : function (id) {
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
                            axios.get('/api/delete_service/'+id)
                                .then(() => {
                                    Swal.fire(
                                        'Delete',
                                        'Service Deleted Successfully',
                                        'success'
                                    )
                                    this.getService();
                                })
                        }
                    });
            },
            openModal : function () {
                this.showModal = !this.showModal;
            },
            closeModal : function () {
                this.showModal = !this.hideModal;
                this.form = {};
                this.editMode = false;
            },
            editModal : function (service) {
                this.editMode = true;
                this.showModal = !this.showModal;
                this.form = service;
            }
        },
        mounted() {
            this.getService();
        },
    }
</script>

<style scoped>

</style>
